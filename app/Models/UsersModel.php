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
    private function randomPassword()
    {
        // generates a random password
        $chars = 'abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789abcdefghijklmnopqwxyzABCDEFGHIJKLMNOPQWXYZ0123456789';
        return substr(str_shuffle($chars),0,8);
    }
}