<?php


class CovidModel {
    private $_url_base;

    public function __construct()
    {
        $this->_url_base = $_ENV['URL'];
    }

    public function getData($country) {
        $url = $this->_url_base . urlencode($country);
        $response = file_get_contents($url);  

        $data = json_decode($response, true);

        return $data;
        
    }

    public function getMortes($country) {
        $url = $this->_url_base . urlencode($country);
    
        $data = json_decode(file_get_contents($url), true);
    
        $totalMortos = 0;
        $totalConfirmados = 0;
    
        foreach ($data as $item) {
            $totalMortos += $item['Mortos'];
            $totalConfirmados += $item['Confirmados'];
        }
        
        return array(
            'totalMortos' => $totalMortos,
            'totalConfirmados' => $totalConfirmados
        );
    }

}
