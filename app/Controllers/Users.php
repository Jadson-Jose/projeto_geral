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
        // Show the login page
        echo view('users/login'); 
    }
    
    
    
    //========================================================================
    private function checkSession()
    {
        // check if session exists
        return $this->session->has('id_user');
    }



}
?>