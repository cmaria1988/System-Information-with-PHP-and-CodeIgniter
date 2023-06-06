<?php
class Produkmodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->tabel = "produk";
        $this->barangmasuk = "barangmasuk";
        $this->barangkeluar = "barangkeluar";
    }
	
	
	function addstok($produkid, $quantity): void{
        $stok = 0;
		$this->db->select('*');
        $this->db->from('produk');
        $this->db->where('produkid',$produkid);
		$query = $this->db->get();
        $row = $query->result_array();

        if (count($row) > 0){
            $stok = $row[0]['stok'] + $quantity;
            $this->db->where('produkid', $produkid);
		    $this->db->set('stok', $stok, FALSE);
            $this->db->update($this->tabel);
        }
    }

    function deletebarangmasuk($barangmasukid){
        $continue = false;
        $stok = 0;
		$this->db->select('*');
        $this->db->from($this->barangmasuk);
        $this->db->join($this->tabel, $this->barangmasuk . '.produkid = ' . $this->tabel . '.produkid');		
        $this->db->where('barangmasukid',$barangmasukid);
		$query = $this->db->get();
        $row = $query->result_array();
        //print_r($row[0]['produkid']);exit();
        if (count($row) > 0){
            if ($row[0]['stok'] >= $row[0]['quantity'] ){
                $stok = $row[0]['stok'] - $row[0]['quantity'];
                $this->db->where('produkid', $row[0]['produkid']);
                $this->db->set('stok', $stok, FALSE);
                $this->db->update($this->tabel);
                $continue = true;
            }
        }
        return $continue;
    }

    function deletebarangkeluar($barangkeluarid): void{
        $stok = 0;
		$this->db->select('*');
        $this->db->from($this->barangkeluar);
        $this->db->join($this->tabel, $this->barangkeluar . '.produkid = ' . $this->tabel . '.produkid');		
        $this->db->where('barangkeluarid',$barangkeluarid);
		$query = $this->db->get();
        $row = $query->result_array();
        //print_r($row[0]['produkid']);exit();
        if (count($row) > 0){
            $stok = $row[0]['stok'] + $row[0]['quantity'];
            $this->db->where('produkid', $row[0]['produkid']);
		    $this->db->set('stok', $stok, FALSE);
            $this->db->update($this->tabel);
        }
    }

    function cekstok($produkid, $quantity){
        $continue = false;
		$this->db->select('*');
        $this->db->from('produk');
        $this->db->where('produkid',$produkid);
		$query = $this->db->get();
        $row = $query->result_array();
        if (count($row) > 0){
            if($quantity <= $row[0]['stok'] ){
                $this->deletestok($produkid, $quantity);
                $continue = true;
            }
        }
        return $continue;
    }

    function deletestok($produkid, $quantity){
        $stok = 0;
		$this->db->select('*');
        $this->db->from('produk');
        $this->db->where('produkid',$produkid);
		$query = $this->db->get();
        $row = $query->result_array();

        if (count($row) > 0){
                $stok = $row[0]['stok'] - $quantity;
                $this->db->where('produkid', $produkid);
                $this->db->set('stok', $stok, FALSE);
                $this->db->update($this->tabel);
        
        }    
    }

    function getData(){
		$this->db->select('*');
		$this->db->from($this->tabel);
		$this->db->order_by('nama','asc');
		$query = $this->db->get();
		$row = $query->result_array();
		return $row;
	}
	
	function getDataById($data){
		$this->db->select('*');
		$this->db->from($this->tabel);
		$this->db->where('produkid', $data);
		$query = $this->db->get();
		$row = $query->result_array();
		//echo $this->db->last_query();
		return $row;
	}
}
?>