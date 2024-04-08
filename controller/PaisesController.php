<?php

require "./model/PaisesModel.php";

class PaisesController {
    public function index() {
        include_once 'view/media.php';
    }

    public function getPaises() {
        $paises = new PaisesModel();

        $data = $paises->getPaises();

        echo json_encode($data);
    }

    public function getTaxa($coutry1, $coutry2) {
        $model = new CovidModel();
        $data1 = $model->getMortes($coutry1);
        $data2 = $model->getMortes($coutry2);
    
        if ($data1['totalConfirmados'] != 0) {
            $taxa1 = $data1['totalMortos'] / $data1['totalConfirmados'];
        } else {
            $taxa1 = 0;
        }

        if ($data2['totalConfirmados'] != 0) {
            $taxa2 = $data2['totalMortos'] / $data2['totalConfirmados'];
        } else {
            $taxa2 = 0;
        }

        $diferenca_taxa = $taxa1 - $taxa2;
        $formatted_diferenca_taxa = sprintf("%.5f", $diferenca_taxa);

        echo json_encode($formatted_diferenca_taxa);
    }
}
