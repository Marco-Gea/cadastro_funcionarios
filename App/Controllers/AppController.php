<?php
    
namespace App\Controllers;

//Use abstract class of all controllers
use MF\Controller\Action;
//Container abstraction class
use MF\Model\Container;

//The AppController's actions
class AppController extends Action{

    public function index(){
        $this->render('index');
    }

    public function form(){

        if(isset($_GET) && isset($_GET['id'])){
            $funcionario = Container::getModel('Funcionarios');
            $funcionario->__set('id', $_GET['id']);
            $this->view->funcionario = $funcionario->getFuncById();
        }

        $this->render('form');
    }

    public function create(){

        if(!isset($_POST['nome']) && !isset($_POST['email']) && !isset($_POST['cpf'])){
            header('Location: /');
        }

        /* Instânciando a classe Funcionario */
        $funcionario = Container::getModel('Funcionarios');

        /* Recuperando dados do fomulário */
        foreach ($_POST as $key => $info) {
            $funcionario->__set($key, $info); 
        }
        $funcionario->__set('foto', $_FILES['foto']['name']);
        $funcionario->__set('tmp_img', $_FILES['foto']["tmp_name"]);
                
        /* Persistindo dados no banco e salvando imagem */
        $funcionario->create();

        header('Location: /form?id=' . $funcionario->__get('id'));

    }
    
}

?>