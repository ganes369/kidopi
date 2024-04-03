<?php


$action = isset($_GET['action']) ? $_GET['action'] : 'index';

include_once 'controller/CovidController.php';

$covidController = new CovidController();

switch ($action) {
    case 'getData':
        $country = isset($_GET['country']) ? $_GET['country'] : '';
        $covidController->getData($country);
        break;
    case 'getMortos':
        $country = isset($_GET['country']) ? $_GET['country'] : '';
        $covidController->getMortos($country);
        break;
    case 'getAcesso':
        $covidController->getAcesso();
        break;
    default:
        $covidController->index();
        break;
}
