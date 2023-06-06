<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('toko/Login_model');
    }
    public function index(){
        $this->load->view('toko/Login_view');
        if($this->session->userdata('rememberme')=="1")
        {
            redirect(site_url('toko/Home'));
        }
    }

    public function submit(){
        if($this->input->post('Login')){
            $username = $this->security->xss_clean($this->input->post('username'));
            $password = md5($this->security->xss_clean($this->input->post('password')));
            $remember = $this->security->xss_clean($this->input->post('rememberme'));
            $cek = $this->Login_model->cek_login($username,$password);
            if($cek){
                $session = array(
                    'username'=>$username,
                    'namaadmin'=>$cek['nama'],
                    'level'=>$cek['idlevel'],
                    'nmlevel'=>$cek['namalevel'],
                    'email'=>$cek['email']
                );
                if($remember) $session['rememberme']=1;
                $this->session->set_userdata($session);
                redirect(site_url('toko/Home'));
            }else{
                $this->data['error']="Username atau password salah";
                $this->load->view('toko/Login_view',$this->data);
            }
        }else{
            redirect(site_url('toko/Login'));
        }
    }
} 
    