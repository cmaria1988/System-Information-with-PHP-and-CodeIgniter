<?php
class Pembayaranmodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->tabel = "pembayaran";
    }
    
    function getData(){
		$this->db->select('*');
		$this->db->from($this->tabel);
		$this->db->order_by('pembayaran','asc');
		$query = $this->db->get();
        $row = $query->result_array();
		return $row;
    }
    

function getDataById($data){
    $this->db->select('*');
    $this->db->from($this->tabel);
    $this->db->where('pembayaranid', $data);
    $query = $this->db->get();
    $row = $query->result_array();
    //echo $this->db->last_query();
    return $row;
}

}
?>