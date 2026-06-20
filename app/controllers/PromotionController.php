<?php

require_once APP_ROOT . '/app/models/PromotionModel.php';
require_once APP_ROOT . '/app/models/VehicleModel.php';
require_once APP_ROOT . '/app/models/PartModel.php';

class PromotionController extends Controller
{
    public function index(): void
    {
        $promoModel  = new PromotionModel();
        $promoModel->expireOld();

        $vehiclePromos = $promoModel->getActive('vehicle', 12);
        $partPromos    = $promoModel->getActive('part', 12);

        // Hydrate with listing details
        $vehicleModel = new VehicleModel();
        $partModel    = new PartModel();

        $featuredVehicles = $vehicleModel->getFeatured(12);
        $featuredParts    = $partModel->getFeatured(12);

        $this->view('promotions/index', compact('featuredVehicles','featuredParts'));
    }
}
