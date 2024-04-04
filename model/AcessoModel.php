<?php


class AcessoModel {
    private $_pdo;
    private $_stmt;

    public function __construct()
    {
        $this->_pdo = new PDO($_ENV['URL_DB'], $_ENV['USER_DB'], $_ENV['PASS_DB']);
    }


    public function insertAcess(string $country){
        $this->_stmt = $this->_pdo->prepare("INSERT INTO acessos (data_hora, pais) VALUES (NOW(), :pais)");
        $this->_stmt->execute(array(':pais' => $country));
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
