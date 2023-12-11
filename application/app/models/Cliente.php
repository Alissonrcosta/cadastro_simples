<?php

use Phalcon\Mvc\Model;

class Cliente extends Model {
    
    private $id;
    private $nome;
    private $email;
    private $data_nascimento;

    public function initialize(){
        $this->setSource('clientes');
    }

    //Encapsulamento//
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function getTelefones()
    {
       //obtém uma coleção de telefones associados ao cliente específico,
        // e o modelo Telefone tenha a propriedade "id_cliente" para representar a chave estrangeira.
        $telefones = Telefone::find(
            [
                'conditions' => 'cliente_id = :cliente_id:',
                'bind' => ['cliente_id' => $this->id],
            ]
        );

        return $telefones;
    }

   
}