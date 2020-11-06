<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $db;
    
    //=========================================================================
    public function __construct()
    {
        $this->db = db_connect();
    }

    //=========================================================================
    public function verifyLogin($username, $password)
    {
        $params = array(
            $username,
            $password
        );

        $query = "SELECT * FROM users WHERE username = ? AND passwrd = ?";

        $db = db_connect();
        $results = $this->db->query($query, $params)->getResult('array');

        if(count($results) == 0){
            return false;
        } else {

            // update last_login in the database
            $params = array 
            (
                $results[0]['id_user']
            );
            $this->db->query("UPDATE users SET last_login = NOW() WHERE id_user = ? ", $params);
            
            // return valid login
            return $results[0];
        }
    }

    //=========================================================================
    public function resetPassword($email)
    {
        // reset the users password

        // checks if there is a user with the email
        $params = array
        (
            $email
        );
        $query = "SELECT id_user FROM users WHERE email = ?";
        $results = $this->db->query($query, $params)->getResult('array');

        if(count($results) != 0 )
        {
            // existe o email

            // change the user's password
            $newPassword = $this->randomPassword();
            $params = array
            (
                $newPassword,
                $results[0]['id_user']
            );
            $query = "UPDATE users SET passwrd = ? WHERE id_user = ?";
            $this->db->query($query,$params);

            // show the new passwords
            echo '(Mensagem de email)';
            echo 'A sua nova password é: ' . $newPassword;

            return true;
        } else 
        {
            // Não existe
            echo 'Não existe esse email registrado';
            return false; 
        }
    }

    
    //=========================================================================
    public function checkEmail($email)
    {
        // checks is the email is from a users's account
        $params = array
        (
            $email
        );
        $query = "SELECT id_user FROM users WHERE email = ?";
        return $this->db->query($query, $params)->getResult('array');
    }

    //=========================================================================
    public function sendPurl($email, $id_user)
    {
        /**
         * 1. Gerar um código purl e guardar na db > FEITO
         * 2. Envia uma mensagem com o link do purl
         */
        $purl = $this->randomPassword(6);
        $params = array (
            $purl,
            $id_user
        );
        $query = "UPDATE users SET purl = ? WHERE id_user = ?";
        $this->db->query($query, $params);

        // envio do email
        echo '(Mensagem de email) Link para redefinir a sua password: ';
        echo '<a href="'.site_url('users/redefine_password/' . $purl).'">Redefinir password</a>';
    }
    
    //=========================================================================
    public function getPurl($purl)
    {
        // returns the row with the given purl
        $params = array (
            $purl
        );
        $query = "SELECT id_user FROM users WHERE purl = ?";
        return $this->db->query($query, $params)->getResult('array');
    }

    //=========================================================================
    public function redefinePassword($id, $pass)
    {
        // update the user's password
        $params = array (
            $pass,
            $id
        );
        $query = "UPDATE users SET passwrd = ? WHERE id_user = ?";
        $this->db->query($query, $params);


        // remove the purl from the user
        $params = array(
            $id
        );
        $this->db->query("UPDATE users SET purl = '' WHERE id_user = ?", $params);
    }

    //=========================================================================
    public function getUsers()
    {
        // return all users in the database
        $query = "SELECT * FROM users";
        return $this->db->query($query)->getResult('array');
    }

    //=========================================================================
    private function randomPassword($numChars = 8)
    {
        // generates a random password
        $chars = 'abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789';
        return substr(str_shuffle($chars),0,$numChars);
    }

    
    //========================================================================
    public function checkExistingUser()
    {
        // Verify is there is already an user with the same username or email address
        $request = \Config\Services::request();
        $dados = $request->getPost();

        $params = array (
            $dados['text_username'],
            $dados['text_email']
        );

        return $this->db->query('SELECT id_user FROM users WHERE username = ? OR email = ?', $params)->getResult('array');
    }

    //========================================================================
    public function addNewUser() {
        $request = \Config\Services::request();
        $dados = $request->getPost();

        // profile
        $profileTemp = array();
        if(!isset($dados['check_admin'])) {
            array_push($profileTemp, 'admin');
        }

        if(!isset($dados['check_moderator'])) {
            array_push($profileTemp, 'moderator');
        }

        if(!isset($dados['check_user'])) {
            array_push($profileTemp, 'user');
        }

        $profile = implode(',', $profileTemp);
        
        $params = array(
            $dados['text_username'],
            $dados['text_email'],
            $dados['text_name'],
            $dados['text_password'],
            $profile
        );

        $this->db->query("INSERT INTO users(username, email, name, passwrd, profile )VALUES(?,?,?,?,?)", $params);
    }
}


// http://localhost/projeto_geral/public/index.php/users/redefine_password/Odp1I3