<?php


class PaisesModel {
    private $_url_base;

    public function __construct()
    {
        $this->_url_base = $_ENV['URL_PAIS'];
    }

    public function getPaises() {
        $url = $this->_url_base;
        $response = file_get_contents($url);  

        $data = json_decode($response, true);

        return $data; 
    }

}
