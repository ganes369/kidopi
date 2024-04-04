<?php

require "./model/CovidModel.php";
require "./model/AcessoModel.php";

class CovidController {
    public function index() {
        include_once 'view/index.php';
    }

    public function getData($country) {
        $covid_model = new CovidModel();
        $acesso_model = new AcessoModel();

        $data = $covid_model->getData($country);
        $acesso_model->insertAcess($country);

        echo json_encode($data);
    }

    public function getMortos($country){
        $model = new CovidModel();
        $data = $model->getMortes($country);
        echo json_encode($data);
    }

    public function getAcesso(){
        $model = new AcessoModel();
        echo json_encode($model->getAcesso());
    }
}
