<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barangkeluar extends CI_Controller{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('grocery_CRUD');
		$this->mylib->cek_adm_login();
		//ambil url controllernya untuk hak akses
        $this->load->Model('toko/Levelmenumodel');
        $this->load->Model('toko/Produkmodel');
		$this->data['urlcontroller'] = $this->uri->segment(2);
		$this->data['hakakses'] = $this->Levelmenumodel->getAkses($this->session->userdata('level'),$this->data['urlcontroller']);
	}

    public function index(){
        $crud = new grocery_CRUD();

		$crud->set_table('barangkeluar');
		if($this->data['hakakses']['cancreate']!='1') $crud->unset_add();
		if($this->data['hakakses']['candelete']!='1') $crud->unset_delete();
		if($this->data['hakakses']['canupdate']!='1') $crud->unset_edit();
		if($this->data['hakakses']['canread']!='1') {
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_export();
			//$crud->unset_list();
		}
        //$crud->unset_edit();
        //$crud->set_subject('Customer');
        $crud->columns('tanggal','produkid','quantity');
        $crud->required_fields('tanggal','produkid','quantity');
        $crud->display_as('tanggal','Tanggal');
        $crud->display_as('produkid','Produk');
		$crud->display_as('quantity','Quantity');
        $crud->set_relation('produkid','produk','nama');
        
        //stock checking before insert
        $crud->callback_before_insert(array($this,'checkstok')); 
        //deleting record - barang masuk
        $crud->callback_before_delete(array($this, 'deleterecord'));

		$crud->unset_clone();
		
		$output = (array)$crud->render();		
        $this->load->template_adm('Barangkeluar_view',(array)$output);
        
    }

    function checkstok($post_array){
        $produkid = $post_array['produkid'];
        $quantity = $post_array['quantity'];
        
        if ($this->Produkmodel->cekstok($produkid, $quantity) == false){
            $message = 'Barang keluar lebih banyak dari jumlah stok';
            return $message;
        }

    }

    function deleterecord($barangkeluarid){
        $this->Produkmodel->deletebarangkeluar($barangkeluarid) == false;

    }
}


?>