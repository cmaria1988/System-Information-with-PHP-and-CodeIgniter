<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->mylib->cek_adm_login();
        //ambil url controllernya untuk hak akses
        $this->load->Model('toko/Levelmenumodel');
        $this->data['urlcontroller'] = $this->uri->segment(2);
        $this->data['hakakses'] = $this->Levelmenumodel->getAkses($this->session->userdata('level'),$this->data['urlcontroller']);
    }

    public function index()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('level');
        if ($this->data['hakakses']['cancreate'] != '1') $crud->unset_add();
        if ($this->data['hakakses']['candelete'] != '1') $crud->unset_delete();
        if ($this->data['hakakses']['canupdate'] != '1') $crud->unset_edit();
        if ($this->data['hakakses']['canread'] != '1') {
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
        }
        $crud->set_subject('Level User');
        $crud->columns('namalevel');
        $crud->display_as('namalevel', 'Nama Level');
        $crud->required_fields('namalevel');

        $crud->unset_clone();
        $output = (array)$crud->render();
        $this->load->template_adm('Level_view', (array)$output);
    }
}
