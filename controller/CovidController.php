<?php

require "./model/CovidModel.php";

class CovidController {
    public function index() {
        include_once 'view/index.php';
    }

    public function getData($country) {
        $model = new CovidModel();
        $data = $model->getData($country);
        echo json_encode($data);
    }

    public function getMortos($country){
        $model = new CovidModel();
        $data = $model->getMortes($country);
        echo json_encode($data);
    }

    public function getAcesso(){
        $model = new CovidModel();
        echo json_encode($model->getAcesso());
    }
}
