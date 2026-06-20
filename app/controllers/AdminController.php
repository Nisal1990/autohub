<?php

require_once APP_ROOT . '/app/models/UserModel.php';
require_once APP_ROOT . '/app/models/VehicleModel.php';
require_once APP_ROOT . '/app/models/PartModel.php';
require_once APP_ROOT . '/app/models/ServiceModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';
require_once APP_ROOT . '/app/models/InquiryModel.php';
require_once APP_ROOT . '/app/models/PromotionModel.php';
require_once APP_ROOT . '/app/models/StatsModel.php';

class AdminController extends Controller
{
    private UserModel     $users;
    private VehicleModel  $vehicles;
    private PartModel     $parts;
    private ServiceModel  $services;
    private LookupModel   $lookup;
    private InquiryModel  $inquiries;
    private PromotionModel $promos;
    private StatsModel    $stats;

    public function __construct()
    {
        $this->users     = new UserModel();
        $this->vehicles  = new VehicleModel();
        $this->parts     = new PartModel();
        $this->services  = new ServiceModel();
        $this->lookup    = new LookupModel();
        $this->inquiries = new InquiryModel();
        $this->promos    = new PromotionModel();
        $this->stats     = new StatsModel();
    }

    private function requireAdminSession(): void { requireAdmin(); }

    // ─── Admin Login ──────────────────────────────────────────────────────────
    public function showLogin(): void
    {
        if (isAdmin()) $this->redirect(url('admin/dashboard'));
        $this->view('admin/login', ['title' => 'Admin Login'], 'admin_login');
    }

    public function login(): void
    {
        csrfCheck();
        $email    = $this->post('email');
        $password = $this->post('password');
        $user     = $this->users->findByEmail($email);
        if ($user && $user['role'] === 'admin' && $this->users->verifyPassword($password, $user['password_hash'])) {
            loginUser($user);
            $this->redirect(url('admin/dashboard'));
            return;
        }
        $this->view('admin/login', ['title' => 'Admin Login', 'error' => 'Invalid credentials.'], 'admin_login');
    }

    public function logout(): void
    {
        logoutUser();
        $this->redirect(url('admin/login'));
    }

    // ─── Dashboard ────────────────────────────────────────────────────────────
    public function dashboard(): void
    {
        $this->requireAdminSession();
        $data = $this->stats->getAdminDashboardStats();
        $recent = $this->stats->getRecentActivity(10);
        $this->view('admin/dashboard', compact('data','recent'), 'admin');
    }

    // ─── Users ────────────────────────────────────────────────────────────────
    public function users(): void
    {
        $this->requireAdminSession();
        $page   = max(1,(int)$this->get('page',1));
        $search = $this->get('q','');
        $list   = $this->users->listAll($page, ADMIN_ROWS_PER_PAGE, $search);
        $total  = $this->users->countAll($search);
        $pag    = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/users/index', compact('list','pag','search'), 'admin');
    }

    public function suspendUser(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->users->suspend((int)$id);
        $this->flash('success','User suspended.'); $this->redirect(url('admin/users'));
    }

    public function activateUser(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->users->activate((int)$id);
        $this->flash('success','User activated.'); $this->redirect(url('admin/users'));
    }

    public function deleteUser(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->users->delete((int)$id);
        $this->flash('success','User deleted.'); $this->redirect(url('admin/users'));
    }

    // ─── Vehicles ─────────────────────────────────────────────────────────────
    public function vehicles(): void
    {
        $this->requireAdminSession();
        $page   = max(1,(int)$this->get('page',1));
        $status = $this->get('status','');
        $search = $this->get('q','');
        $list   = $this->vehicles->adminList($page, ADMIN_ROWS_PER_PAGE, $status, $search);
        $total  = $this->vehicles->adminCount($status, $search);
        $pag    = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/vehicles/index', compact('list','pag','status','search'), 'admin');
    }

    public function approveVehicle(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->vehicles->approve((int)$id);
        $this->flash('success','Vehicle listing approved.'); $this->redirect(url('admin/vehicles'));
    }

    public function rejectVehicle(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $reason = sanitize($this->post('reason'));
        $this->vehicles->reject((int)$id, $reason);
        $this->flash('success','Listing rejected.'); $this->redirect(url('admin/vehicles'));
    }

    public function featureVehicle(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $val = (int)$this->post('featured');
        $this->vehicles->setFeatured((int)$id, $val);
        $this->flash('success','Featured status updated.'); $this->redirect(url('admin/vehicles'));
    }

    public function deleteVehicle(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        foreach ($this->vehicles->getImages((int)$id) as $img) { $fp=UPLOAD_PATH.'/'.$img['image_path']; if(file_exists($fp)) @unlink($fp); }
        $this->vehicles->adminDelete((int)$id);
        $this->flash('success','Listing deleted.'); $this->redirect(url('admin/vehicles'));
    }

    // ─── Parts ────────────────────────────────────────────────────────────────
    public function parts(): void
    {
        $this->requireAdminSession();
        $page   = max(1,(int)$this->get('page',1));
        $status = $this->get('status','');
        $search = $this->get('q','');
        $list   = $this->parts->adminList($page, ADMIN_ROWS_PER_PAGE, $status, $search);
        $total  = $this->parts->adminCount($status, $search);
        $pag    = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/parts/index', compact('list','pag','status','search'), 'admin');
    }

    public function approvePart(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->parts->approve((int)$id); $this->flash('success','Part approved.'); $this->redirect(url('admin/parts')); }
    public function rejectPart(string $id): void  { $this->requireAdminSession(); csrfCheck(); $this->parts->reject((int)$id, sanitize($this->post('reason'))); $this->flash('success','Part rejected.'); $this->redirect(url('admin/parts')); }
    public function featurePart(string $id): void  { $this->requireAdminSession(); csrfCheck(); $this->parts->setFeatured((int)$id,(int)$this->post('featured')); $this->flash('success','Updated.'); $this->redirect(url('admin/parts')); }
    public function deletePart(string $id): void   { $this->requireAdminSession(); csrfCheck(); $this->parts->adminDelete((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/parts')); }

    // ─── Services ─────────────────────────────────────────────────────────────
    public function services(): void
    {
        $this->requireAdminSession();
        $page   = max(1,(int)$this->get('page',1));
        $status = $this->get('status','');
        $list   = $this->services->adminListProviders($page, ADMIN_ROWS_PER_PAGE, $status);
        $total  = $this->services->adminCountProviders($status);
        $pag    = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/services/index', compact('list','pag','status'), 'admin');
    }

    public function approveService(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->services->approveProvider((int)$id); $this->flash('success','Provider approved.'); $this->redirect(url('admin/services')); }
    public function rejectService(string $id): void  { $this->requireAdminSession(); csrfCheck(); $this->services->rejectProvider((int)$id, sanitize($this->post('reason'))); $this->flash('success','Rejected.'); $this->redirect(url('admin/services')); }
    public function deleteService(string $id): void  { $this->requireAdminSession(); csrfCheck(); $this->services->adminDeleteProvider((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/services')); }

    // ─── Lookup Data ──────────────────────────────────────────────────────────
    public function lookup(): void
    {
        $this->requireAdminSession();
        $manufacturers   = $this->lookup->getAllManufacturers();
        $models          = $this->lookup->getAllModels();
        $partCategories  = $this->lookup->getAllPartCategories();
        $serviceCategories = $this->lookup->getAllServiceCategories();
        $districts       = $this->lookup->getAllDistricts();
        $cities          = $this->lookup->getAllCities();
        $this->view('admin/lookup/index', compact('manufacturers','models','partCategories','serviceCategories','districts','cities'), 'admin');
    }

    public function saveManufacturer(): void   { $this->requireAdminSession(); csrfCheck(); $this->lookup->createManufacturer(sanitize($this->post('name'))); $this->flash('success','Manufacturer added.'); $this->redirect(url('admin/lookup#manufacturers')); }
    public function deleteManufacturer(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->deleteManufacturer((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/lookup#manufacturers')); }
    public function saveModel(): void          { $this->requireAdminSession(); csrfCheck(); $this->lookup->createModel((int)$this->post('manufacturer_id'), sanitize($this->post('name'))); $this->flash('success','Model added.'); $this->redirect(url('admin/lookup#models')); }
    public function deleteModel(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->deleteModel((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/lookup#models')); }
    public function savePartCategory(): void   { $this->requireAdminSession(); csrfCheck(); $this->lookup->createPartCategory(sanitize($this->post('name'))); $this->flash('success','Category added.'); $this->redirect(url('admin/lookup#part-cats')); }
    public function deletePartCategory(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->deletePartCategory((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/lookup#part-cats')); }
    public function saveServiceCategory(): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->createServiceCategory(sanitize($this->post('name'))); $this->flash('success','Category added.'); $this->redirect(url('admin/lookup#service-cats')); }
    public function deleteServiceCategory(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->deleteServiceCategory((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/lookup#service-cats')); }
    public function saveDistrict(): void       { $this->requireAdminSession(); csrfCheck(); $this->lookup->createDistrict(sanitize($this->post('name'))); $this->flash('success','District added.'); $this->redirect(url('admin/lookup#districts')); }
    public function saveCity(): void           { $this->requireAdminSession(); csrfCheck(); $this->lookup->createCity((int)$this->post('district_id'), sanitize($this->post('name'))); $this->flash('success','City added.'); $this->redirect(url('admin/lookup#cities')); }
    public function deleteCity(string $id): void { $this->requireAdminSession(); csrfCheck(); $this->lookup->deleteCity((int)$id); $this->flash('success','Deleted.'); $this->redirect(url('admin/lookup#cities')); }

    // ─── Promotions ───────────────────────────────────────────────────────────
    public function promotions(): void
    {
        $this->requireAdminSession();
        $page  = max(1,(int)$this->get('page',1));
        $list  = $this->promos->adminList($page, ADMIN_ROWS_PER_PAGE);
        $total = $this->promos->adminCount();
        $pag   = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/promotions/index', compact('list','pag'), 'admin');
    }

    public function addPromotion(): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->promos->add(
            $this->post('listing_type'),
            (int)$this->post('listing_id'),
            $this->post('start_date'),
            $this->post('end_date')
        );
        $this->flash('success','Promotion added.'); $this->redirect(url('admin/promotions'));
    }

    public function removePromotion(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->promos->remove((int)$id);
        $this->flash('success','Promotion removed.'); $this->redirect(url('admin/promotions'));
    }

    // ─── Inquiries ────────────────────────────────────────────────────────────
    public function inquiries(): void
    {
        $this->requireAdminSession();
        $page  = max(1,(int)$this->get('page',1));
        $type  = $this->get('type','');
        $list  = $this->inquiries->adminList($page, ADMIN_ROWS_PER_PAGE, $type);
        $total = $this->inquiries->adminCount($type);
        $pag   = paginate($total, ADMIN_ROWS_PER_PAGE, $page);
        $this->view('admin/inquiries/index', compact('list','pag','type'), 'admin');
    }

    public function viewInquiry(string $id): void
    {
        $this->requireAdminSession();
        $inquiry = $this->inquiries->findById((int)$id);
        if (!$inquiry) $this->abort(404);
        $this->inquiries->markRead((int)$id);
        $this->view('admin/inquiries/index', ['inquiry'=>$inquiry,'list'=>[],'pag'=>[],'type'=>''], 'admin');
    }

    public function deleteInquiry(string $id): void
    {
        $this->requireAdminSession(); csrfCheck();
        $this->inquiries->delete((int)$id);
        $this->flash('success','Inquiry deleted.'); $this->redirect(url('admin/inquiries'));
    }

    // ─── Reports ──────────────────────────────────────────────────────────────
    public function reports(): void
    {
        $this->requireAdminSession();
        $statsData = $this->stats->getAdminDashboardStats();
        $byDistrict= $this->stats->getListingsByDistrict();
        $trend     = $this->stats->getListingsTrend();
        $this->view('admin/reports/index', compact('statsData','byDistrict','trend'), 'admin');
    }
}
