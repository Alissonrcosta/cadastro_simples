<?php

use Phalcon\Mvc\Model;

class Cliente extends Model {
    
    public $id;
    public $nome;
    public $email;
    public $data_nascimento;

    public function initialize(){
        $this->setSource('clientes');
    }

}