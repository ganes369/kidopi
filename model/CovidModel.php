<?php

class CovidModel {
    public function getData($country) {
        $url = 'https://dev.kidopilabs.com.br/exercicio/covid.php?pais=' . urlencode($country);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
