<?php

require_once APP_ROOT . '/app/models/ServiceModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';
require_once APP_ROOT . '/app/models/InquiryModel.php';

class ServiceController extends Controller
{
    private ServiceModel $services;
    private LookupModel  $lookup;

    public function __construct()
    {
        $this->services = new ServiceModel();
        $this->lookup   = new LookupModel();
    }

    public function index(): void
    {
        $filters = [
            'category_id' => (int)$this->get('category_id'),
            'district'    => $this->get('district'),
            'q'           => $this->get('q'),
        ];

        $page       = max(1, (int)$this->get('page', 1));
        $total      = $this->services->countProviders($filters);
        $pagination = paginate($total, LISTINGS_PER_PAGE, $page);
        $providers  = $this->services->searchProviders($filters, $page, LISTINGS_PER_PAGE);

        $categories = $this->lookup->getAllServiceCategories();
        $districts  = $this->lookup->getAllDistricts();

        $this->view('services/index', compact('providers','pagination','filters','categories','districts'));
    }

    public function show(string $id): void
    {
        $provider = $this->services->findProviderById((int)$id);
        if (!$provider || $provider['status'] !== 'approved') $this->abort(404, 'Provider not found');

        $services = $this->services->getServicesForProvider((int)$id, true);
        // Attach add-ons to each service
        foreach ($services as &$svc) {
            $svc['addons'] = $this->services->getAddons($svc['id']);
        }
        unset($svc);

        $this->view('services/show', compact('provider','services'));
    }

    public function inquiry(string $id): void
    {
        csrfCheck();
        $provider = $this->services->findProviderById((int)$id);
        if (!$provider) $this->abort(404);

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
                'listing_type' => 'service',
                'listing_id'   => (int)$id,
                'sender_name'  => $name,
                'sender_phone' => $phone,
                'sender_email' => $email,
                'message'      => $msg,
            ]);
            $this->flash('success', 'Inquiry sent! The service provider will contact you.');
        } else {
            $this->flash('error', implode(', ', $errors));
        }
        $this->redirect(url('services/' . $id));
    }
}
