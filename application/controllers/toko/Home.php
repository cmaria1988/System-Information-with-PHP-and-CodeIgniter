<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->mylib->cek_adm_login();
        $this->data = array();
    }

    public function index(){
        $this->load->template_adm('Home_view',$this->data);
    }
}