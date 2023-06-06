<?php
class Penjualanmodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->tabel = "transaksi";
		$this->tabeldetail = "transaksidetail";
		$this->tabelbarang = "produk";
		$this->tabelpembayaran = "pembayaran";
	}
	
		//ambil data penjualan semuanya
		function getDataPenjualan(){
			$this->db->select($this->tabel.'.transaksiid, tanggal, pembayaran ');
			$this->db->from($this->tabel);
			$this->db->join($this->tabelpembayaran, $this->tabelpembayaran.'.pembayaranid = '.$this->tabel.'.pembayaranid');
			$query = $this->db->get();
			$row = $query->result_array();
			return $row;
		}

	//simpan ke tabel penjualan
	function save($data){
		if($this->db->insert($this->tabel,$data)){
			$msg = "Data berhasil disimpan";$num="0";$stat="success";
		}else{
			$msg = "Data gagal disimpan <br> ".$this->db->_error_message();
			$num = $this->db->_error_number();
			$stat = "danger";
		}
		return array($stat,$msg,$num);
	}
	//simpan tabel detiljual
	function saveDetail($datadetail){
		if($this->db->insert($this->tabeldetail,$datadetail)){
			return true;
		}else{
			return false;
		}
	}
	//kurangi stok
	function kuranginStok($produkid,$qty){
		$this->db->where('produkid', $produkid);
		$this->db->set('stok', "stok-$qty", FALSE);
		$this->db->update($this->tabelbarang);
	}

	function update($data,$id){
		$this->db->where('transaksiid', $id);
		if($this->db->update($this->tabel, $data)){
			$msg = "Data berhasil disimpan";$num="0";$stat="success";
		}else{
			$msg = "Data gagal disimpan <br> ".$this->db->_error_message();
			$num = $this->db->_error_number();
			$stat = "danger";
		}
		return array($stat,$msg,$num);
	}

	//ambil penjualan berdasarkan no penjualan
	function getDataById($nopenjualan){
		$this->db->select('*');
		$this->db->from($this->tabel);
		$this->db->where('transaksiid', $nopenjualan);
		$query = $this->db->get();
		$row = $query->result_array();
		return $row;
	}
	
	function getDetail($idjual){
		$this->db->select('nama,hargajual,'.$this->tabeldetail.'.*');
		$this->db->from($this->tabeldetail);
		$this->db->join($this->tabelbarang, $this->tabelbarang.'.produkid = '.$this->tabeldetail.'.produkid');
		$this->db->where('transaksiid',$idjual);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$row = $query->result_array();
		return $row;
	}
	
	function deleteDetail($id){
		//ambil dulu datanya
		$this->db->select('quantity,produkid');
		$this->db->from($this->tabeldetail);
		$this->db->where('transaksiid', $id);
		$query = $this->db->get();
		$row = $query->result_array();
		foreach($row as $index=>$value)
		{
			//print_r($value);
			$produkid = $value['produkid'];
			$qty = $value['quantity'];
			//update stok bertambah dulu
			$this->db->where('produkid', $produkid);
			$this->db->set('stok', "stok+$qty", FALSE);
			$this->db->update($this->tabelbarang);
		//	echo $this->db->last_query();
		}
		$this->db->where('transaksiid', $id);
		$this->db->delete($this->tabeldetail); 
		//echo $this->db->last_query();
		//die();
	}
	
	
}
?>
