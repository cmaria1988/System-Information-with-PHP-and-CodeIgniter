<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller{
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
		$crud= new grocery_CRUD();

		$crud->set_table('menuadmin');
		if($this->data['hakakses']['cancreate'] != '1') $crud->unset_add();
        if($this->data['hakakses']['candelete'] != '1') $crud->unset_delete();
        if($this->data['hakakses']['canupdate'] != '1') $crud->unset_edit();
        if($this->data['hakakses']['canread'] != '1') {
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
        }
        $crud->columns('id','name','url','parent','create','read','update','del','active');
        $crud->required_fields('name','url','parent');
        $crud->set_relation('parent','menuadmin','name');
        $crud->display_as('del','Delete');

        $crud->set_subject('Menu');
        $crud->callback_add_field('create',array($this,'create_field_callback'));
        $crud->callback_add_field('read',array($this,'read_field_callback'));
        $crud->callback_add_field('update',array($this,'update_field_callback'));
        $crud->callback_add_field('del',array($this,'delete_field_callback'));
        $crud->callback_add_field('active',array($this,'active_field_callback'));
        $crud->callback_add_field('parent',array($this,'parent_field_callback'));
        //bagian edit

        $crud->callback_edit_field('create',array($this,'create_field_callback2'));
        $crud->callback_edit_field('read',array($this,'read_field_callback2'));
        $crud->callback_edit_field('update',array($this,'update_field_callback2'));
        $crud->callback_edit_field('del',array($this,'delete_field_callback2'));
        $crud->callback_edit_field('active',array($this,'active_field_callback2'));
        $crud->callback_edit_field('parent',array($this,'parent_field_callback2'));

        $output= (array)$crud->render();

        $this->load->template_adm('Menu_view',(array)$output);

    }

    function create_field_callback()
    {
        return ' <input type="radio" name="create" value="1" checked /> Ya &nbsp;
                 <input type="radio" name="create" value="0" /> Tidak';
    }
	function read_field_callback()
    {
        return ' <input type="radio" name="read" value="1" checked /> Ya &nbsp;
                 <input type="radio" name="read" value="0" /> Tidak';
    }
	function update_field_callback()
    {
        return ' <input type="radio" name="update" value="1" checked /> Ya &nbsp;
                 <input type="radio" name="update" value="0" /> Tidak';
    }
	function delete_field_callback()
    {
        return ' <input type="radio" name="del" value="1" checked /> Ya &nbsp;
                 <input type="radio" name="del" value="0" /> Tidak';
    }
	function active_field_callback()
    {
        return ' <input type="radio" name="active" value="1" checked /> Ya &nbsp;
                 <input type="radio" name="active" value="0" /> Tidak';
    }
	function parent_field_callback()
	{
		$this->db->select('id,name');
		$this->db->from('menuadmin');
		$this->db->where('active','1');
		$this->db->where('parent','0');
		$query = $this->db->get();
		$row = $query->result_array();
		
		$x = '<select name="parent" id="parent">';
		$x.= '<option value="0">Root</option>';
		foreach($row as $index=>$value)
		{
			$x.= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		$x.= '</select>';
		return $x;
		
	}
	
	function create_field_callback2($value)
    {
		
		$x = '<input type="radio" name="create" value="1"';
		if($value=='1') $x.= 'checked';
		$x.= '/> Ya &nbsp;';
		
		$x.= '<input type="radio" name="create" value="0"';
		if($value=='0') $x.= 'checked';
		$x.= '/> Tidak';
		return $x;
        
    }
	
	function read_field_callback2($value)
    {
		$x = '<input type="radio" name="read" value="1"';
		if($value=='1') $x.= 'checked';
		$x.= '/> Ya &nbsp;';
		
		$x.= '<input type="radio" name="read" value="0"';
		if($value=='0') $x.= 'checked';
		$x.= '/> Tidak';
		return $x;
        
    }
	
	function update_field_callback2($value)
    {
		$x = '<input type="radio" name="update" value="1"';
		if($value=='1') $x.= 'checked';
		$x.= '/> Ya &nbsp;';
		
		$x.= '<input type="radio" name="update" value="0"';
		if($value=='0') $x.= 'checked';
		$x.= '/> Tidak';
		return $x;
        
    }
	
	function delete_field_callback2($value)
    {
		$x = '<input type="radio" name="del" value="1"';
		if($value=='1') $x.= 'checked';
		$x.= '/> Ya &nbsp;';
		
		$x.= '<input type="radio" name="del" value="0"';
		if($value=='0') $x.= 'checked';
		$x.= '/> Tidak';
		return $x;
        
    }
	
	function active_field_callback2($value)
    {
		$x = '<input type="radio" name="active" value="1"';
		if($value=='1') $x.= 'checked';
		$x.= '/> Ya &nbsp;';
		
		$x.= '<input type="radio" name="active" value="0"';
		if($value=='0') $x.= 'checked';
		$x.= '/> Tidak';
		return $x;
        
    }
	function parent_field_callback2($isi)
	{
		$this->db->select('id,name');
		$this->db->from('menuadmin');
		$this->db->where('active','1');
		$this->db->where('parent','0');
		$query = $this->db->get();
		$row = $query->result_array();
		
		$x = '<select name="parent" id="parent">';
		$x.= '<option value="0">Root</option>';
		foreach($row as $index=>$value)
		{
			$checked = '';
			if($value['id']==$isi){
				$checked = 'selected';
			}
			$x.= '<option value="'.$value['id'].'" '.$checked.'>'.$value['name'].'</option>';
		}
		$x.= '</select>';
		return $x;
		
	}
}
?>