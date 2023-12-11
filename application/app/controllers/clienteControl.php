<?php

declare(strict_types=1);

use Phalcon\Validation;
use Phalcon\Validation\Validator\Date as DateValidator;

class ClienteController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function CadastrarAction()
    {
        $dados = $this->request->getPost();
        $email = $dados['email'];
        $numero_1 = $dados['numero_1'];
        $numero_2 = $dados['numero_2'];

        //verificando se usuário já está cadastrado
        $consulta = Cliente::find("email = '$email'");
        if (count($consulta) > 0) {
            echo "Usuário já cadastrado";
        } else {
            $dataNascimento = DateTime::createFromFormat('d/m/Y', $dados['data_nascimento']);
            if (!$dataNascimento || $dataNascimento->format('d/m/Y') !== $dados['data_nascimento']) {
                echo 'Data de nascimento inválida.';
            }

            //validação se data não está no "futuro"
            $dataAtual = new DateTime();

            if ($dataNascimento > $dataAtual) {
                echo 'Data de nascimento inválida.';
            } else {
                //Continuar para salvar no bando de dados
                $cliente = new Cliente();
                $cliente->setNome($dados['nome']);
                $cliente->setEmail($dados['email']);
                $cliente->setDataNascimento($dataNascimento->format('Y-m-d'));

                $cliente->save();

                $telefone_1 = new Telefone();
                $telefone_1->setClienteId($cliente->getId());
                $telefone_1->setNumero($numero_1);
                $telefone_1->setTipo("PRINCIPAL");
                $telefone_1->save();

                if ($numero_2 != "") {
                    $telefone_2 = new Telefone();
                    $telefone_2->setClienteId($cliente->getId());
                    $telefone_2->setNumero($numero_2);
                    $telefone_2->setTipo("SECUNDARIO");
                    $telefone_2->save();
                }else{
                    $telefone_2 = "";
                }

                $this->response->redirect('/');
            }
        }
    }

    public function EditarAction($id)
    {
        $dados = Cliente::find("id = '$id'");
        if ($dados->count() > 0) {
            $this->view->cliente = $dados;
        } else {
            $this->response->redirect('/');
        }
    }

    public function AtualizarAction($id)
    {
        
        $cliente = Cliente::findFirst("id = '$id'");
        //Verifica se o cliente foi encontrado se sim, obtém os dados do formulário se não, redireciona para '/';
        $cliente ? $dados = $this->request->getPost() : $this->response->redirect('/');

        $dataNascimento = DateTime::createFromFormat('d/m/Y', $dados['data_nascimento']);


        //verificar se o email foi alterado
        if ($dados['email'] !== $cliente->email) {

            //se o email foi alterado, verificar se já existe outro cliente com o novo email, procurando pelo primeiro retorno que vem de getpost
            $consulta = Cliente::findFirst("email = '{$dados['email']}'");

            if ($consulta) {

                echo "Usuário já cadastrado";
            } else {

                //Atualizando os valores com os dados fornecidos
                $cliente->setNome($dados['nome']);
                $cliente->setEmail($dados['email']);
                $cliente->setDataNascimento($dataNascimento->format('Y-m-d'));
                $cliente->telefones = $dados['telefones'];
                $cliente->save();

                $this->response->redirect('/');
            }
        } else {
            //"Senão", caso email mão tenha sido alterado continua com processo de e inserir.

            // Telefone::find("cliente_id = '$id'")->delete();
            /*foreach ($dados['telefones'] as $numero) {
                $telefone = new Telefone();
                $telefone->setClienteId($cliente->getId());
                $telefone->setNumero($numero);
                $telefone->setTipo("PRINCIPAL");
                $telefone->save();
            }*/

            $cliente->setNome($dados['nome']);
            $cliente->setEmail($dados['email']);
            $cliente->setDataNascimento($dataNascimento->format('Y-m-d'));

           
            $cliente->save();

            $this->response->redirect('/');
        }
    }

    public function DeletarAction($id)
    {
        if (!isset($id) || !is_numeric($id)) {
            echo "Nenhum usuário selecionado";
        } else {
            $cliente = Cliente::find("id = '$id'");
            if ($cliente) {
                if ($cliente->delete() === false) {
                    echo "Erro ao deletar o cliente.";
                } else {
                    $telefone = Telefone::find("cliente_id = '$id'");
                    $telefone->delete();
                    $this->response->redirect('/');
                }
            } else {
                echo "Cliente não encontrado.";
            }
        }
    }
}
