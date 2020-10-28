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
            'name' => $data['name'],
            'profile' => $data['profile']
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

        //check id user is admin
        $data = array();
        if($this->checkProfile("admin")) {
            $data['admin'] = true;
        }


        // show homepage view
        echo view ('users/homepage', $data);
    }
    
    //========================================================================
    public function logout()
    {
        // logout
        $this->session->destroy();
        return redirect()->to(site_url('users'));
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
    
        // Método 1 ==============================================================
        //    // reset users password
        //    // redefines the password and sends by email

        //     /**
        //      * 1. Verifica se existe algum utilizador com registro (email inserido)
        //      * 2. Caso exista utlizador, altera a sua password (random)
        //      * 3. "Envia" uma mensagem com a nova passwoard
        //      */
        //     $request = \Config\Services::request();
        //     $email = $request->getPost('text_email');

        //     // Verifies if there is a user with this email
        //     // if exists, change the password and send to email
        //     $users = new UsersModel();
        //     $users->resetPassword($email);
    
    
        // Método 2 ==============================================================
        /**
         * 1. Apresenta o formulário para o email > FEITO
         * 2. Vai verificar se o email está associado a uma conta > FEITO
         * 3. Caso esteja associado, cria um purl e envia com o purl 
         * 4. O link do purl permite acessar uma áre reservada para redefinir uma nova senha 
         */

        $request = \Config\Services::request();
        $email = $request->getPost('text_email');
        $users = new UsersModel();
        $result = $users->checkEmail($email);
        if(count($result) != 0) {
            // exsite o email associado
            $users->sendPurl($email, $result[0]['id_user']);
        } else {
            // não existe email
            echo 'não existe o email associado';
        }

     }

     //========================================================================
     public function redefine_password($purl)
     {  
         /**
          * 1. Verificar se veio o purl / se exite o purl na db
          * 2. Se existir, vamos apresentar o formulário para alterar a password
          *     2.1 formulário var ter 2 inputs
          *         nova password
          *     2.2 tratamento da submissão
          *     2.3 se as passwords forem iguais vai guardar na db a nova password
          *         vai eliminar o purl
          * 3. não existindo o purl, vai para a página inicial 
          */

          $users = new UsersModel();
          $results = $users->getPurl($purl);
          if(count($results) == 0){
              
            // no purl found, Redirects to main
            return redirect()->to(site_url('home'));
          } else {
              // existe purl no bd
              $data['user'] = $results[0];
              echo view ('users/redefine_password', $data);
          }
     }

     //========================================================================
     public function redefine_password_submit()
     {
        $request = \Config\Services::request();
        $id_user = $request->getPost('text_id_user');
        $nova_password = $request->getPost('text_nova_password');
        $nova_password_repetida = $request->getPost('text_repetir_password');

        $error = '';

        // Verify if both passwords match
        if ($error == '') {
            $error = 'As passwords não são iguais';
            // die($error);
        }

        // updates the new password
        if($error == ''){
            $users = new UsersModel();
            $users->redefine_password($id_user, $nova_password);
        }
    }

    
    public function teste($value) 
    {
        if($this->checkProfile($value)) {
            echo 'Existe';
        } else {
            echo 'Não existe';
        }
    }

    
    
    //========================================================================
    // PRIVATE
    //========================================================================
    private function checkSession()
    {
        // check if session exists
        return $this->session->has('id_user');
    }

    //========================================================================
    private function checkProfile($profile)
    {
        // check if the user has permission to access feature
        if( preg_match ("/$profile/", $this->session->profile)) {
            return true;
        } else {
            return false;
        }
    }

    //========================================================================
    public function op1()
    {
        echo 'op1';
    }

    //========================================================================
    public function op2()
    {
        echo 'op2';
    }

    //========================================================================
    public function admin_users()
    {
        // check if the user has permission
        if($this->checkProfile('admin') == false) {
            return redirect()->to(\site_url('users'));
        }

        // buscar lista de utilizadores registrados
        $users = new UsersModel();
        $results = $users->getUsers();
        $data['users'] = $results;
 

        echo view ('users/admin_users', $data);
    }

    //========================================================================
    public function admin_new_user()
    {
        // adds a new to the database
        $error = '';
        $data = array();


        // if there was a submission
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // redirecionar para a tabela de utilizadores
            $request = \Config\Services::request();
            $dados = $request->getPost();

            // verifica se vieram todos os dados corretos
            if(
                $dados['text_username'] == '' ||
                $dados['text_password'] == '' ||
                $dados['text_password_repetir'] == '' ||
                $dados['text_name'] == '' ||
                $dados['text_email'] == '' 
            
            ) {
                $error = 'Preencha todos os campos de texto.';
            }

            // verificar se as passwords coincidem
            if($error == '') {
                if($dados['text_password'] != $dados['text_password_repetir']) {
                    $error = 'As senhas são diferentes.';
                }
            }

            // verifica se, pelo menos, uma check de perfil foi checkada
            if(!isset($dados['check_admin']) &&
                !isset($dados['check_moderator']) &&
                !isset($dados['check_user'])) {
                    $error = 'Indique pelo menos, um tipo de perfil.';
                }
            if($error == '') {
                $model = new UsersModel();
                $model->addNewUser();
                
                return redirect()->to(site_url('users/admin'));
            }

        }

        // check if there is an error
        if($error != ''){
            $data['error'] = $error;
        }

        echo view ("users/admin_new_user", $data);
    }

 

}
?>