<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Users extends BaseController
{

    private $session;

    //========================================================================
    public function __construct()
    {
        $this->session = session();
    }


    //========================================================================
    public function index()
    {
        // check if there is an active session
        if($this->checkSession()){
            // active session
        }else {
            // show login form
            $this->login();
        }
    }
    
    //========================================================================
    public function login(){
       
       
        /**
         *  Verifica se houve submissão
         * 
         *  Se houve submissão:
         *      - Verifica se os campos estão preechidos
         *      - perguntar ao banco de dados se existe username e password
         *      - se existir: abrir sessão e enviar para o menu inicial
         *      - se não existir: apresentar formulário de login com erro
         * 
        */
       
       
        $error = "";
        $data = array();
        $request = \Config\Services::request();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // check fields
            $username = $request->getPost('text_username');
            $password = $request->getPost('text_password');
            if($username == '' || $password == ''){
                $error = "Erro no preenchimento dos campos.";
            }

            // check database
        }

        if($error != ''){
            $data['error'] = $error;
        }
       
       
       
       
        // Show the login page
        echo view('users/login', $data); 
    }
    
    
    
    //========================================================================
    private function checkSession()
    {
        // check if session exists
        return $this->session->has('id_user');
    }



}
?>