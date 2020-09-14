<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model 
{
    public function teste()
    {
        $db = db_connect();
        echo 'AQUI';
        exit();
    }
}