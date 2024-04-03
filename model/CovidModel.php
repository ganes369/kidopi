<?php

class CovidModel {
    private $_url_base;
    private $_pdo;
    private $_stmt;

    public function __construct()
    {
        $this->_url_base = 'https://dev.kidopilabs.com.br/exercicio/covid.php?pais=';
        $this->_pdo = new PDO('mysql:host=localhost;dbname=kidope', 'root', '');
    }

    public function getData($country) {
        $url = $this->_url_base . urlencode($country);
        $response = file_get_contents($url);  

        $data = json_decode($response, true);

        $totalMortos = 0;
        $totalConfirmados = 0;

        // Iterar sobre cada elemento e somar o número de mortos
        foreach ($data as $item) {
            $totalMortos += $item['Mortos'];
            $totalConfirmados += $item['Confirmados'];
        }
        return $data;
        
    }

    public function getMortes($country) {
        $url = $this->_url_base . urlencode($country);
    
        $data = json_decode(file_get_contents($url), true);
    
        $totalMortos = 0;
        $totalConfirmados = 0;

        $this->_stmt = $this->_pdo->prepare("INSERT INTO acessos (data_hora, pais) VALUES (NOW(), :pais)");
        $this->_stmt->execute(array(':pais' => $country));
    
        foreach ($data as $item) {
            $totalMortos += $item['Mortos'];
            $totalConfirmados += $item['Confirmados'];
        }
        
        return array(
            'totalMortos' => $totalMortos,
            'totalConfirmados' => $totalConfirmados
        );
    }

    public function getAcesso(){
        $this->_stmt = $this->_pdo->prepare("SELECT data_hora, pais FROM acessos ORDER BY id DESC LIMIT 1");
        $this->_stmt->execute(); 
        $registro_mais_recente = $this->_stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($registro_mais_recente) {
            $data_hora_formatada = date('d/m/Y H:i', strtotime($registro_mais_recente['data_hora']));
            $registro_mais_recente['data_hora'] = $data_hora_formatada;
    
            return json_encode($registro_mais_recente);
        } else {
            return json_encode(array(
                'data_hora' => '-',
                'pais' => '-'
            ));
        }
    }
}
