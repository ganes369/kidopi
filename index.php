<?php

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

include_once 'controller/CovidController.php';

$covidController = new CovidController();

switch ($action) {
    case 'getData':
        $country = isset($_GET['country']) ? $_GET['country'] : '';
        $covidController->getData($country);
        break;
    default:
        $covidController->index();
        break;
}
