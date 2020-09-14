<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $db;
    
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function teste()
    {
        $db = db_connect();
        $results = $this->db->query("SELECT * FROM  users")->getResult('array');
        echo $results[0]['username']. ' - ' . $results[0]['passwrd'];
        exit();
    }
}