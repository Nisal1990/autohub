<?php

require_once APP_ROOT . '/app/models/VehicleModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';
require_once APP_ROOT . '/app/models/InquiryModel.php';

class VehicleController extends Controller
{
    private VehicleModel $vehicles;
    private LookupModel  $lookup;

    public function __construct()
    {
        $this->vehicles = new VehicleModel();
        $this->lookup   = new LookupModel();
    }

    public function index(): void
    {
        $filters = [
            'manufacturer_id' => (int)$this->get('manufacturer_id'),
            'model_id'        => (int)$this->get('model_id'),
            'year_from'       => (int)$this->get('year_from'),
            'year_to'         => (int)$this->get('year_to'),
            'price_min'       => (float)$this->get('price_min'),
            'price_max'       => (float)$this->get('price_max'),
            'district'        => $this->get('district'),
            'fuel_type'       => $this->get('fuel_type'),
            'transmission'    => $this->get('transmission'),
            'condition_type'  => $this->get('condition_type'),
            'body_type'       => $this->get('body_type'),
            'sort'            => $this->get('sort'),
            'q'               => $this->get('q'),
        ];

        $page       = max(1, (int)$this->get('page', 1));
        $total      = $this->vehicles->countSearch($filters);
        $pagination = paginate($total, LISTINGS_PER_PAGE, $page);
        $listings   = $this->vehicles->search($filters, $page, LISTINGS_PER_PAGE);

        $manufacturers = $this->lookup->getAllManufacturers();
        $models        = $filters['manufacturer_id'] ? $this->lookup->getModelsByMake($filters['manufacturer_id']) : [];
        $districts     = $this->lookup->getAllDistricts();

        $this->view('vehicles/index', compact('listings','pagination','filters','manufacturers','models','districts'));
    }

    public function show(string $id): void
    {
        $listing = $this->vehicles->findById((int)$id);
        if (!$listing || $listing['status'] !== 'approved') $this->abort(404, 'Listing not found');

        $images  = $this->vehicles->getImages((int)$id);
        $this->view('vehicles/show', compact('listing','images'));
    }

    public function inquiry(string $id): void
    {
        csrfCheck();
        $listing = $this->vehicles->findById((int)$id);
        if (!$listing) $this->json(['error' => 'Not found'], 404);

        $errors = [];
        $name   = sanitize($this->post('sender_name'));
        $phone  = sanitize($this->post('sender_phone'));
        $email  = sanitize($this->post('sender_email'));
        $msg    = sanitize($this->post('message'));

        if (empty($name))  $errors[] = 'Name required';
        if (empty($phone)) $errors[] = 'Phone required';
        if (empty($msg))   $errors[] = 'Message required';

        if (empty($errors)) {
            (new InquiryModel())->create([
                'listing_type' => 'vehicle',
                'listing_id'   => (int)$id,
                'sender_name'  => $name,
                'sender_phone' => $phone,
                'sender_email' => $email,
                'message'      => $msg,
            ]);
            $this->flash('success', 'Your inquiry has been sent! The seller will contact you.');
        } else {
            $this->flash('error', implode(', ', $errors));
        }
        $this->redirect(url('vehicles/' . $id));
    }

    public function ajaxModels(): void
    {
        $makeId = (int)$this->get('manufacturer_id');
        $models = $makeId ? $this->lookup->getModelsByMake($makeId) : [];
        $this->json($models);
    }
}
