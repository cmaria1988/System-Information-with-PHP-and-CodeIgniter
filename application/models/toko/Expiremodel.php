<?php
class Expiremodel extends CI_Model{
	 function __construct()
    {
        parent::__construct();
		$this->tabelbarangmasuk = "barangmasuk";
		$this->produk = "produk";
		$this->categori = "categori";
		
    }
	function cekExpire($tglawal,$tglakhir)
	{
		$this->db->select('*');
		$this->db->from($this->tabelbarangmasuk);
		$this->db->join($this->produk, $this->produk.'.produkid='.$this->tabelbarangmasuk.'.produkid');
		$this->db->where('expire >=',$tglawal);
		$this->db->where('expire <=',$tglakhir);
		$this->db->where($this->produk.'.stok>',0);
		$query = $this->db->get();
		if($query->num_rows()==0){
			return false;
		}else{
			return true;
		}
	}
	
	function getLaporan($tglawal,$tglakhir)
	{
        $this->db->select($this->produk.'.produkid, nama, categori, expire,quantity,stok');
        $this->db->from($this->produk);	
		$this->db->join($this->tabelbarangmasuk, $this->tabelbarangmasuk . '.produkid = ' . $this->produk . '.produkid');	
		$this->db->join($this->categori, $this->produk . '.categoriid = ' . $this->categori . '.categoriid');		
		$this->db->where('expire >=',$tglawal);
		$this->db->where('expire <=',$tglakhir);
		$this->db->where($this->produk.'.stok>',0);
		$this->db->order_by($this->produk.'.produkid ' ,'asc');
		$this->db->order_by($this->tabelbarangmasuk . '.expire ' ,'desc');
		$query = $this->db->get();

		return $query->result_array();
	}
	
}
?>