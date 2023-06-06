<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->mylib->cek_adm_login();
        //ambil url controllernya untuk hak akses
        $this->load->Model('toko/Levelmenumodel');
        $this->data['urlcontroller']=$this->uri->segment(2);
        $this->data['hakakses']=$this->Levelmenumodel->getAkses($this->session->userdata('level'),$this->data['urlcontroller']);
    }

    public function index(){
        $crud = new grocery_CRUD();

        $crud->set_table('login');
        if($this->data['hakakses']['cancreate'] != '1') $crud->unset_add();
        if($this->data['hakakses']['candelete'] != '1') $crud->unset_delete();
        if($this->data['hakakses']['canupdate'] != '1') $crud->unset_edit();
        if($this->data['hakakses']['canread'] != '1') {
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
        }
        $crud->set_subject('Login User');
        $crud->columns('username','nama','email','idlevel');
        $crud->required_fields('username', 'password','nama','email','idlevel');
        $crud->display_as('idlevel','Level');
        $crud->change_field_type('password','password');
        $crud->set_relation('idlevel','level','namalevel');

        //ganti password jadi md5
        $crud->callback_before_insert(array($this,'encrypt_password'));
        $crud->callback_before_update(array($this,'encrypt_password'));

        $crud->unset_clone();
        $output= $crud->render();

        $this->load->template_adm('User_view',(array)$output);
    }

    function encrypt_password($post_array){
        //die (print_r($post_array))
        $post_array['password']= md5($post_array['password']);
        return $post_array;
    }

}

