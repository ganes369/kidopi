<?php
use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$action = isset($_GET['action']) ? $_GET['action'] : 'index';

include_once 'controller/CovidController.php';
include_once 'controller/PaisesController.php';

$covidController = new CovidController();
$paisesController = new PaisesController();

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
    case 'paises':
        $paisesController->index();
        break;
    case 'getPaises':
        $paisesController->getPaises();
        break;
    case 'taxa':
        $country1 = isset($_GET['country1']) ? $_GET['country1'] : '';
        $country2 = isset($_GET['country2']) ? $_GET['country2'] : '';
        $paisesController->getTaxa($country1, $country2);
        break;
    default:
        $covidController->index();
        break;
}
