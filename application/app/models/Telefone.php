<?php

use Phalcon\Mvc\Model;

class Telefone extends Model {
    private $id;
    private $numero;
    private $cliente_id;
    private $tipo;

    public function initialize()
    {

        $this->setSource('telefones');
        $this->hasMany(
            'id', // A chave primária do modelo Cliente
            'Telefone', // O modelo relacionado (presumivelmente o modelo de telefone)
            'cliente_id', // A chave estrangeira no modelo Telefone
            [
                'alias' => 'Telefones',
                'reusable' => true,
            ]
        );
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }

    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}