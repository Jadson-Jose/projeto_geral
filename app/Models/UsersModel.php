<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $db;
    
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function verifyLogin($username, $password)
    {
        $params = array(
            $username,
            $password
        );

        $query = "SELECT * FROM users WHERE username = ? AND passwrd = ?";

        $db = db_connect();
        $results = $this->db->query($query, $params)->getResult('array');

        if(\count($results) == 0){
            return false;
        } else {
            return $results[0];
        }
    }
}