<?php

require_once APP_ROOT . '/app/models/VehicleModel.php';
require_once APP_ROOT . '/app/models/PartModel.php';
require_once APP_ROOT . '/app/models/ServiceModel.php';
require_once APP_ROOT . '/app/models/StatsModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $vehicles  = (new VehicleModel())->getLatest(6);
        $featured  = (new VehicleModel())->getFeatured(8);
        $parts     = (new PartModel())->getLatest(4);
        $services  = (new ServiceModel())->getLatestProviders(4);
        $stats     = (new StatsModel())->getSiteStats();
        $districts = (new LookupModel())->getAllDistricts();

        $this->view('home/index', compact('vehicles','featured','parts','services','stats','districts'));
    }

    public function notFound(): void
    {
        $this->view('errors/404', ['title' => '404 — Page Not Found'], 'public');
    }
}
