<?php

require_once APP_ROOT . '/app/models/VehicleModel.php';
require_once APP_ROOT . '/app/models/PartModel.php';
require_once APP_ROOT . '/app/models/ServiceModel.php';
require_once APP_ROOT . '/app/models/UserModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';
require_once APP_ROOT . '/app/models/InquiryModel.php';

class DashboardController extends Controller
{
    private VehicleModel $vehicles;
    private PartModel    $parts;
    private ServiceModel $services;
    private UserModel    $users;
    private LookupModel  $lookup;

    public function __construct()
    {
        requireLogin();
        $this->vehicles = new VehicleModel();
        $this->parts    = new PartModel();
        $this->services = new ServiceModel();
        $this->users    = new UserModel();
        $this->lookup   = new LookupModel();
    }

    private function uid(): int { return (int)$_SESSION['user_id']; }

    // ─── Overview ─────────────────────────────────────────────────────────────
    public function index(): void
    {
        $this->redirect(url('dashboard/vehicles'));
    }

    // ─── Profile ──────────────────────────────────────────────────────────────
    public function profile(): void
    {
        $user      = $this->users->findById($this->uid());
        $districts = $this->lookup->getAllDistricts();
        $this->view('dashboard/profile', compact('user','districts'), 'dashboard');
    }

    public function updateProfile(): void
    {
        csrfCheck();
        $data   = [
            'name'     => sanitize($this->post('name')),
            'phone'    => sanitize($this->post('phone')),
            'district' => sanitize($this->post('district')),
            'city'     => sanitize($this->post('city')),
        ];
        $errors = [];
        if (empty($data['name'])) $errors[] = 'Name is required.';
        if ($data['phone'] && !validateSriLankaPhone($data['phone'])) $errors[] = 'Invalid phone number.';

        $newPw  = $this->post('new_password');
        $confPw = $this->post('confirm_password');

        if (!empty($newPw)) {
            if (strlen($newPw) < 8)    $errors[] = 'Password must be at least 8 characters.';
            if ($newPw !== $confPw)    $errors[] = 'Passwords do not match.';
        }

        if (empty($errors)) {
            $this->users->updateProfile($this->uid(), $data);
            if (!empty($newPw)) $this->users->updatePassword($this->uid(), $newPw);
            // Refresh session name
            $_SESSION['user_name'] = $data['name'];
            $this->flash('success', 'Profile updated successfully.');
            $this->redirect(url('dashboard/profile'));
            return;
        }

        $user      = $this->users->findById($this->uid());
        $districts = $this->lookup->getAllDistricts();
        $this->view('dashboard/profile', compact('user','districts','errors'), 'dashboard');
    }

    // ─── My Vehicles ──────────────────────────────────────────────────────────
    public function myVehicles(): void
    {
        $page     = max(1,(int)$this->get('page',1));
        $listings = $this->vehicles->getByUser($this->uid(), $page, 10);
        $total    = $this->vehicles->countByUser($this->uid());
        $pag      = paginate($total, 10, $page);
        $this->view('dashboard/vehicles/index', compact('listings','pag'), 'dashboard');
    }

    public function createVehicle(): void
    {
        $manufacturers = $this->lookup->getAllManufacturers();
        $districts     = $this->lookup->getAllDistricts();
        $this->view('dashboard/vehicles/create', compact('manufacturers','districts'), 'dashboard');
    }

    public function storeVehicle(): void
    {
        csrfCheck();
        $errors = $this->validateVehicleForm();

        if (empty($errors)) {
            $data = $this->vehicleFormData();
            $data['user_id'] = $this->uid();
            $id = $this->vehicles->create($data);

            // Handle images
            if (!empty($_FILES['images']['name'][0])) {
                $isPrimary = true;
                foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
                    $file = [
                        'tmp_name' => $tmp,
                        'name'     => $_FILES['images']['name'][$k],
                        'size'     => $_FILES['images']['size'][$k],
                        'error'    => $_FILES['images']['error'][$k],
                    ];
                    $path = uploadImage($file, 'vehicles');
                    if ($path) {
                        $this->vehicles->addImage($id, $path, $isPrimary);
                        $isPrimary = false;
                    }
                }
            }

            $this->flash('success', 'Vehicle listing submitted for review. It will appear once approved.');
            $this->redirect(url('dashboard/vehicles'));
            return;
        }

        $manufacturers = $this->lookup->getAllManufacturers();
        $districts     = $this->lookup->getAllDistricts();
        $models        = $this->lookup->getModelsByMake((int)$this->post('manufacturer_id'));
        $this->view('dashboard/vehicles/create', compact('manufacturers','models','districts','errors'), 'dashboard');
    }

    public function editVehicle(string $id): void
    {
        $listing = $this->vehicles->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);
        $images        = $this->vehicles->getImages((int)$id);
        $manufacturers = $this->lookup->getAllManufacturers();
        $models        = $this->lookup->getModelsByMake($listing['manufacturer_id']);
        $districts     = $this->lookup->getAllDistricts();
        $this->view('dashboard/vehicles/edit', compact('listing','images','manufacturers','models','districts'), 'dashboard');
    }

    public function updateVehicle(string $id): void
    {
        csrfCheck();
        $listing = $this->vehicles->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);

        $errors = $this->validateVehicleForm();
        if (empty($errors)) {
            $this->vehicles->update((int)$id, $this->uid(), $this->vehicleFormData());
            if (!empty($_FILES['images']['name'][0])) {
                $existCount = count($this->vehicles->getImages((int)$id));
                $isPrimary  = ($existCount === 0);
                foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
                    if ($existCount >= MAX_IMAGES_PER_LISTING) break;
                    $file = ['tmp_name'=>$tmp,'name'=>$_FILES['images']['name'][$k],'size'=>$_FILES['images']['size'][$k],'error'=>$_FILES['images']['error'][$k]];
                    $path = uploadImage($file, 'vehicles');
                    if ($path) { $this->vehicles->addImage((int)$id, $path, $isPrimary); $isPrimary = false; $existCount++; }
                }
            }
            $this->flash('success', 'Listing updated and re-submitted for review.');
            $this->redirect(url('dashboard/vehicles'));
            return;
        }

        $images        = $this->vehicles->getImages((int)$id);
        $manufacturers = $this->lookup->getAllManufacturers();
        $models        = $this->lookup->getModelsByMake((int)$this->post('manufacturer_id'));
        $districts     = $this->lookup->getAllDistricts();
        $this->view('dashboard/vehicles/edit', compact('listing','images','manufacturers','models','districts','errors'), 'dashboard');
    }

    public function deleteVehicle(string $id): void
    {
        csrfCheck();
        $listing = $this->vehicles->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);
        // Delete images from disk
        foreach ($this->vehicles->getImages((int)$id) as $img) {
            $fp = UPLOAD_PATH . '/' . $img['image_path'];
            if (file_exists($fp)) @unlink($fp);
        }
        $this->vehicles->delete((int)$id, $this->uid());
        $this->flash('success', 'Listing deleted.');
        $this->redirect(url('dashboard/vehicles'));
    }

    public function markVehicleSold(string $id): void
    {
        csrfCheck();
        $this->vehicles->markSold((int)$id, $this->uid());
        $this->flash('success', 'Listing marked as sold.');
        $this->redirect(url('dashboard/vehicles'));
    }

    // ─── My Parts ─────────────────────────────────────────────────────────────
    public function myParts(): void
    {
        $page     = max(1,(int)$this->get('page',1));
        $listings = $this->parts->getByUser($this->uid(), $page, 10);
        $total    = $this->parts->countByUser($this->uid());
        $pag      = paginate($total, 10, $page);
        $this->view('dashboard/parts/index', compact('listings','pag'), 'dashboard');
    }

    public function createPart(): void
    {
        $categories    = $this->lookup->getAllPartCategories();
        $districts     = $this->lookup->getAllDistricts();
        $manufacturers = $this->lookup->getAllManufacturers();
        $this->view('dashboard/parts/create', compact('categories','districts','manufacturers'), 'dashboard');
    }

    public function storePart(): void
    {
        csrfCheck();
        $errors = $this->validatePartForm();
        if (empty($errors)) {
            $data = $this->partFormData();
            $data['user_id'] = $this->uid();
            $id = $this->parts->create($data);
            if (!empty($_FILES['images']['name'][0])) {
                $isPrimary = true;
                foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
                    $file = ['tmp_name'=>$tmp,'name'=>$_FILES['images']['name'][$k],'size'=>$_FILES['images']['size'][$k],'error'=>$_FILES['images']['error'][$k]];
                    $path = uploadImage($file, 'parts');
                    if ($path) { $this->parts->addImage($id, $path, $isPrimary); $isPrimary = false; }
                }
            }
            $this->flash('success', 'Part listing submitted for review.');
            $this->redirect(url('dashboard/parts'));
            return;
        }
        $categories = $this->lookup->getAllPartCategories(); $districts = $this->lookup->getAllDistricts(); $manufacturers = $this->lookup->getAllManufacturers();
        $this->view('dashboard/parts/create', compact('categories','districts','manufacturers','errors'), 'dashboard');
    }

    public function editPart(string $id): void
    {
        $listing = $this->parts->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);
        $images = $this->parts->getImages((int)$id);
        $categories = $this->lookup->getAllPartCategories(); $districts = $this->lookup->getAllDistricts(); $manufacturers = $this->lookup->getAllManufacturers();
        $this->view('dashboard/parts/edit', compact('listing','images','categories','districts','manufacturers'), 'dashboard');
    }

    public function updatePart(string $id): void
    {
        csrfCheck();
        $listing = $this->parts->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);
        $errors = $this->validatePartForm();
        if (empty($errors)) {
            $this->parts->update((int)$id, $this->uid(), $this->partFormData());
            $this->flash('success', 'Part updated and re-submitted for review.'); $this->redirect(url('dashboard/parts')); return;
        }
        $images = $this->parts->getImages((int)$id); $categories = $this->lookup->getAllPartCategories(); $districts = $this->lookup->getAllDistricts(); $manufacturers = $this->lookup->getAllManufacturers();
        $this->view('dashboard/parts/edit', compact('listing','images','categories','districts','manufacturers','errors'), 'dashboard');
    }

    public function deletePart(string $id): void
    {
        csrfCheck();
        $listing = $this->parts->findById((int)$id);
        if (!$listing || $listing['user_id'] != $this->uid()) $this->abort(403);
        foreach ($this->parts->getImages((int)$id) as $img) { $fp=UPLOAD_PATH.'/'.$img['image_path']; if(file_exists($fp)) @unlink($fp); }
        $this->parts->delete((int)$id, $this->uid());
        $this->flash('success', 'Part listing deleted.'); $this->redirect(url('dashboard/parts'));
    }

    // ─── My Services ──────────────────────────────────────────────────────────
    public function myServices(): void
    {
        $provider   = $this->services->findProviderByUser($this->uid());
        $serviceList= $provider ? $this->services->getServicesForProvider($provider['id'], false) : [];
        foreach ($serviceList as &$s) { $s['addons'] = $this->services->getAddons($s['id']); } unset($s);
        $categories = $this->lookup->getAllServiceCategories();
        $this->view('dashboard/services/index', compact('provider','serviceList','categories'), 'dashboard');
    }

    public function editProvider(): void
    {
        $provider  = $this->services->findProviderByUser($this->uid());
        $districts = $this->lookup->getAllDistricts();
        $this->view('dashboard/services/create', compact('provider','districts'), 'dashboard');
    }

    public function updateProvider(): void
    {
        csrfCheck();
        $data = [
            'business_name' => sanitize($this->post('business_name')),
            'address'       => sanitize($this->post('address')),
            'district'      => sanitize($this->post('district')),
            'city'          => sanitize($this->post('city')),
            'contact_phone' => sanitize($this->post('contact_phone')),
            'working_hours' => sanitize($this->post('working_hours')),
            'description'   => sanitize($this->post('description')),
        ];
        if (!empty($_FILES['logo']['name'])) {
            $path = uploadImage($_FILES['logo'], 'services');
            if ($path) $data['logo_path'] = $path;
        }
        $existing = $this->services->findProviderByUser($this->uid());
        if ($existing) {
            $this->services->updateProvider($existing['id'], $data);
            $this->flash('success', 'Business profile updated.');
        } else {
            $data['user_id'] = $this->uid();
            $this->services->createProvider($data);
            $this->flash('success', 'Service provider profile created! Pending admin approval.');
        }
        $this->redirect(url('dashboard/services'));
    }

    public function createService(): void
    {
        $provider = $this->services->findProviderByUser($this->uid());
        if (!$provider) { $this->flash('error','Set up your business profile first.'); $this->redirect(url('dashboard/services')); return; }
        $categories = $this->lookup->getAllServiceCategories();
        $this->view('dashboard/services/create', compact('provider','categories'), 'dashboard');
    }

    public function storeService(): void
    {
        csrfCheck();
        $provider = $this->services->findProviderByUser($this->uid());
        if (!$provider) $this->abort(403);
        $data = ['provider_id'=>$provider['id'],'category_id'=>(int)$this->post('category_id'),'name'=>sanitize($this->post('name')),'description'=>sanitize($this->post('description')),'base_price'=>(float)$this->post('base_price')];
        $this->services->createService($data);
        $this->flash('success','Service added and pending review.'); $this->redirect(url('dashboard/services'));
    }

    public function editService(string $id): void
    {
        $provider = $this->services->findProviderByUser($this->uid());
        $service  = $this->services->findServiceById((int)$id);
        if (!$service || !$provider || $service['provider_id'] != $provider['id']) $this->abort(403);
        $categories = $this->lookup->getAllServiceCategories();
        $addons     = $this->services->getAddons((int)$id);
        $this->view('dashboard/services/edit', compact('service','categories','addons'), 'dashboard');
    }

    public function updateService(string $id): void
    {
        csrfCheck();
        $provider = $this->services->findProviderByUser($this->uid());
        $service  = $this->services->findServiceById((int)$id);
        if (!$service || !$provider || $service['provider_id'] != $provider['id']) $this->abort(403);
        $this->services->updateService((int)$id, ['category_id'=>(int)$this->post('category_id'),'name'=>sanitize($this->post('name')),'description'=>sanitize($this->post('description')),'base_price'=>(float)$this->post('base_price')]);
        $this->flash('success','Service updated.'); $this->redirect(url('dashboard/services'));
    }

    public function deleteService(string $id): void
    {
        csrfCheck();
        $provider = $this->services->findProviderByUser($this->uid());
        if (!$provider) $this->abort(403);
        $this->services->deleteService((int)$id, $provider['id']);
        $this->flash('success','Service removed.'); $this->redirect(url('dashboard/services'));
    }

    public function addAddon(string $id): void
    {
        csrfCheck();
        $provider = $this->services->findProviderByUser($this->uid());
        $service  = $this->services->findServiceById((int)$id);
        if (!$service || !$provider || $service['provider_id'] != $provider['id']) $this->abort(403);
        $this->services->addAddon((int)$id, sanitize($this->post('addon_name')), (float)$this->post('addon_price'));
        $this->flash('success','Add-on added.'); $this->redirect(url('dashboard/services/'.$id.'/edit'));
    }

    public function deleteAddon(string $id): void
    {
        csrfCheck();
        $this->services->deleteAddon((int)$id);
        $this->flash('success','Add-on removed.'); $this->redirect(url('dashboard/services'));
    }

    // ─── Inquiries ────────────────────────────────────────────────────────────
    public function inquiries(): void
    {
        $list = (new InquiryModel())->getForUser($this->uid());
        $this->view('dashboard/inquiries', ['inquiries' => $list], 'dashboard');
    }

    // ─── Private Validation Helpers ───────────────────────────────────────────

    private function validateVehicleForm(): array
    {
        $errors = [];
        if (!(int)$this->post('manufacturer_id')) $errors[] = 'Manufacturer is required.';
        if (!(int)$this->post('model_id'))         $errors[] = 'Model is required.';
        if (!(int)$this->post('model_year'))        $errors[] = 'Year is required.';
        if (!(float)$this->post('price'))           $errors[] = 'Price is required.';
        if (empty($this->post('district')))         $errors[] = 'District is required.';
        if (empty($this->post('seller_name')))      $errors[] = 'Seller name is required.';
        if (empty($this->post('seller_phone')))     $errors[] = 'Contact phone is required.';
        elseif (!validateSriLankaPhone($this->post('seller_phone'))) $errors[] = 'Invalid phone number.';
        return $errors;
    }

    private function vehicleFormData(): array
    {
        return [
            'manufacturer_id' => (int)$this->post('manufacturer_id'),
            'model_id'        => (int)$this->post('model_id'),
            'model_year'      => (int)$this->post('model_year'),
            'price'           => (float)$this->post('price'),
            'mileage'         => (int)$this->post('mileage'),
            'fuel_type'       => $this->post('fuel_type'),
            'transmission'    => $this->post('transmission'),
            'condition_type'  => $this->post('condition_type'),
            'body_type'       => $this->post('body_type'),
            'description'     => sanitize($this->post('description')),
            'district'        => sanitize($this->post('district')),
            'city'            => sanitize($this->post('city')),
            'seller_name'     => sanitize($this->post('seller_name')),
            'seller_phone'    => sanitize($this->post('seller_phone')),
            'show_email'      => $this->post('show_email') ? 1 : 0,
        ];
    }

    private function validatePartForm(): array
    {
        $errors = [];
        if (empty($this->post('part_name')))    $errors[] = 'Part name is required.';
        if (!(int)$this->post('category_id'))   $errors[] = 'Part category is required.';
        if (!(float)$this->post('price'))       $errors[] = 'Price is required.';
        if (empty($this->post('district')))     $errors[] = 'District is required.';
        if (empty($this->post('seller_phone'))) $errors[] = 'Contact phone is required.';
        return $errors;
    }

    private function partFormData(): array
    {
        return [
            'part_name'            => sanitize($this->post('part_name')),
            'part_number'          => sanitize($this->post('part_number')),
            'compatible_make'      => sanitize($this->post('compatible_make')),
            'compatible_model'     => sanitize($this->post('compatible_model')),
            'compatible_year_from' => $this->post('compatible_year_from'),
            'compatible_year_to'   => $this->post('compatible_year_to'),
            'category_id'          => (int)$this->post('category_id'),
            'price'                => (float)$this->post('price'),
            'condition_type'       => $this->post('condition_type'),
            'stock_qty'            => (int)$this->post('stock_qty') ?: null,
            'description'          => sanitize($this->post('description')),
            'district'             => sanitize($this->post('district')),
            'city'                 => sanitize($this->post('city')),
            'seller_name'          => sanitize($this->post('seller_name')),
            'seller_phone'         => sanitize($this->post('seller_phone')),
        ];
    }
}
