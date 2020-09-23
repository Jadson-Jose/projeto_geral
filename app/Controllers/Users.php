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

    //========================================================================
    public function recover()
    {
        // shows form to recover password
        echo view ('users/recover_password');
    }

    //========================================================================
    public function reset_password()
    {
        // reset users password
        // redefines the password and sends by email

        /**
         * 1. Verifica se existe algum utilizador com registro (email inserido)
         * 2. Caso exista utlizador, altera a sua password (random)
         * 3. "Envia" uma mensagem com a nova passwoard
         */
        $request = \Config\Services::request();
        $email = $request->getPost('text_email');

        // Verifies if there is a user with this email
        $users = new UsersModel();
        $users->resetPassword($email);
    }

}
?>