<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barangmasuk extends CI_Controller{
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
		$crud->set_table('barangmasuk');
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
        $crud->columns('tanggal','produkid','quantity', 'expire','hargabeli');
        $crud->required_fields('tanggal','produkid','quantity', 'expire','hargabeli');
        $crud->display_as('tanggal','Tanggal');
        $crud->display_as('produkid','Produk');
		$crud->display_as('quantity','Quantity');
        $crud->display_as('hargabeli','Harga Beli');
        $crud->set_relation('produkid','produk','nama');
        
        //update tabel produk
        $crud->callback_before_insert(array($this,'updatestok'));
        $crud->callback_before_delete(array($this,'deleterecord'));

		$crud->unset_clone();
		
		$output = (array)$crud->render();
		
        $this->load->template_adm('Barangmasuk_view',(array)$output);
        
    }

    function updatestok($post_array):void{
        $produkid = $post_array['produkid'];
        $quantity = $post_array['quantity'];
        $this->Produkmodel->addstok($produkid, $quantity);
    }

    function deleterecord($barangmasukid){
        if ($this->Produkmodel->deletebarangmasuk($barangmasukid) == false){
            $message = 'Stok akan kurang dari 0';
            return $message;
        }
    }
}

?>