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
            $this->view->funcionario['id'] = $_GET['id'];
        }

        $this->render('form');
    }
    
}

?>