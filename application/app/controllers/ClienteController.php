<?php
declare(strict_types=1);

use Phalcon\Validation;
use Phalcon\Validation\Validator\Date as DateValidator;

class ClienteController extends ControllerBase
{

    public function indexAction() {
        
    }

    public function CadastrarAction() {
    $dados = $this->request->getPost();
    $email = $dados['email'];

    //verificando se usuário já está cadastrado
    $consulta = Cliente::find("email = '$email'");
    if (count($consulta) > 0) {
        echo "Usuário já cadastrado";
    }else{
        $dataNascimento = DateTime::createFromFormat('d/m/Y', $dados['data_nascimento']);
            if (!$dataNascimento || $dataNascimento->format('d/m/Y') !== $dados['data_nascimento']) {
                echo 'Data de nascimento inválida.';
            }

            //validação se data não está no futuro
    $dataAtual = new DateTime();
    
    if ($dataNascimento > $dataAtual) {
        echo 'Data de nascimento inválida(futuro).';
    }else{
    //Continuar para salvar no bando de dados
    $cliente = new Cliente();
    $cliente->nome = $dados['nome'];
    $cliente->email = $dados['email'];
    $cliente->data_nascimento = $dataNascimento->format('Y-m-d');

    $cliente->save();
    $this->response->redirect('/');
    }
    }
    
}
  
        //echo "<pre>"; print_r($dataNascimento); echo "</pre>"; exit;
    
    
    public function EditarAction() {

    }

    public function AtualizarAction() {

    }

    public function DeletarAction($id) {
        if(!isset($id)) {
            echo "Nenhum usuário selecionado";
        } else {
            $cliente = Cliente::find("id = '$id'");
            if ($cliente) {
                if ($cliente->delete() === false) {
                    echo "Erro ao deletar o cliente.";
                } else {
                    $this->response->redirect('/');
                }
            } else {
                echo "Cliente não encontrado.";
            }
        }
    }
}
    


