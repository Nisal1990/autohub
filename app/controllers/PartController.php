<?php

require_once APP_ROOT . '/app/models/PartModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';
require_once APP_ROOT . '/app/models/InquiryModel.php';

class PartController extends Controller
{
    private PartModel   $parts;
    private LookupModel $lookup;

    public function __construct()
    {
        $this->parts  = new PartModel();
        $this->lookup = new LookupModel();
    }

    public function index(): void
    {
        $filters = [
            'category_id'    => (int)$this->get('category_id'),
            'compatible_make'=> $this->get('compatible_make'),
            'condition_type' => $this->get('condition_type'),
            'price_min'      => (float)$this->get('price_min'),
            'price_max'      => (float)$this->get('price_max'),
            'district'       => $this->get('district'),
            'q'              => $this->get('q'),
        ];

        $page       = max(1, (int)$this->get('page', 1));
        $total      = $this->parts->countSearch($filters);
        $pagination = paginate($total, LISTINGS_PER_PAGE, $page);
        $listings   = $this->parts->search($filters, $page, LISTINGS_PER_PAGE);

        $categories = $this->lookup->getAllPartCategories();
        $districts  = $this->lookup->getAllDistricts();
        $makes      = $this->lookup->getAllManufacturers();

        $this->view('parts/index', compact('listings','pagination','filters','categories','districts','makes'));
    }

    public function show(string $id): void
    {
        $listing = $this->parts->findById((int)$id);
        if (!$listing || $listing['status'] !== 'approved') $this->abort(404, 'Listing not found');

        $images = $this->parts->getImages((int)$id);
        $this->view('parts/show', compact('listing','images'));
    }

    public function inquiry(string $id): void
    {
        csrfCheck();
        $listing = $this->parts->findById((int)$id);
        if (!$listing) $this->abort(404);

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
                'listing_type' => 'part',
                'listing_id'   => (int)$id,
                'sender_name'  => $name,
                'sender_phone' => $phone,
                'sender_email' => $email,
                'message'      => $msg,
            ]);
            $this->flash('success', 'Inquiry sent! The seller will contact you.');
        } else {
            $this->flash('error', implode(', ', $errors));
        }
        $this->redirect(url('parts/' . $id));
    }
}
