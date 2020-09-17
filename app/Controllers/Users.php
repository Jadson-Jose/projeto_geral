<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class Users extends BaseController
{

    protected $session;

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
            $this->homePage();
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

        // check if session exists (if yes go to homepage)
        if($this->checkSession())
        {
            $this->homePage();
            return;
        }
       
       
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
            if($error == '')
            {
                $model = new UsersModel();
                $result = $model->verifyLogin($username, $password);

                if(is_array($result)){
                    // valid login
                    $this->setSession($result);
                    $this->homePage();
                    return;
                } else {
                    // invalid login
                    $error = 'Login iválido';
                }
            }

        }

        if($error != ''){
            $data['error'] = $error;
        }
       
       
       
       
        // Show the login page
        echo view('users/login', $data); 
    }
    
    
    //========================================================================
    private function setSession($data)
    {
        // init session
        $session_data = array
        (
            'id_user' => $data['id_user'],
            'name' => $data['name']
        );

        $this->session->set($session_data);

    }

    //========================================================================
    public function homePage()
    {
        // check if session exists
        if(!$this->checkSession())
        {
            $this->login();
            return;
        }

        // show homepage view
        echo view ('users/homepage');
    }
    
    //========================================================================
    public function logout()
    {
        // logout
        $this->session->destroy();
        return redirect()->to(site_url('users'));
    } 
   
   
    //========================================================================
    private function checkSession()
    {
        // check if session exists
        return $this->session->has('id_user');
    }



}
?>