<?php
    
namespace App\Controllers;

//Use abstract class of all controllers
use MF\Controller\Action;
//Container abstraction class
use MF\Model\Container;

//The AppController's actions
class AppController extends Action{

    // Página inicial - Listagem de dados cadastrados
    public function index(){
        $funcionario = Container::getModel('Funcionarios');
        $this->view->funcionarios = $funcionario->getAll();
        $this->render('index');
    }

    // Página que contém formulário para cadastrar, alterar ou excluir os dados 
    public function form(){

        // Resgatando o funcionário, se existir, a partir de seu ID
        if(isset($_GET['id'])){
            $funcionario = Container::getModel('Funcionarios');
            $funcionario->__set('id', $_GET['id']);
            $this->view->funcionario = $funcionario->getFuncById();
        }

        // Carrega a página do funcomulário
        $this->render('form');
    }

    // Adicionar um funcionário
    public function create(){

        // Verificação para evitar o acesso inadequado a essa página
        if(!isset($_POST['nome']) && !isset($_POST['email']) && !isset($_POST['cpf'])){
            header('Location: /');
        }

        // Instânciando a classe funcionário 
        $funcionario = Container::getModel('Funcionarios');

        // Recuperando dados do fomulário 
        foreach ($_POST as $key => $info) {
            $funcionario->__set($key, $info); 
        }
        $funcionario->__set('foto', $_FILES['foto']['name']);
        $funcionario->__set('tmp_img', $_FILES['foto']["tmp_name"]);
                
        // Persistindo dados no banco e salvando imagem 
        $funcionario->create();

        // Redireciona o usuário para a página onde os dados poderão ser visualizados
        header('Location: /funcionario?id=' . $funcionario->__get('id'));

    }

    // Ver informações de umm funcionário cadastrado
    public function funcionario(){

        // Verificação para inpedir o acesso indevido a essa página
        if(!isset($_GET['id'])){
            header('Location: /');
        }

        // Resgata os dados do funcionário a partir do ID
        $funcionario = Container::getModel('Funcionarios');
        $funcionario->__set('id', $_GET['id']);
        $this->view->funcionario = $funcionario->getFuncById();

        // Carrega a página para visualização dos dados de um funcionário
        $this->render('funcionario');
    }
    
}

?>