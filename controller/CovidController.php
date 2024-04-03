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
}
