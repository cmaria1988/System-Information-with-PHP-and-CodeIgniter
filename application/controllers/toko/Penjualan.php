<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->Model("toko/Penjualanmodel");
		$this->load->Model("toko/Generalmodel");
		$this->load->Model('toko/Produkmodel');
		$this->load->Model('toko/Pembayaranmodel');
		$this->mylib->cek_adm_login();
		$this->data['js_files'][] = asset_url().'vendors/datepicker/js/bootstrap-datepicker.min.js';
		$this->data['js_files'][] = js_url().'toko/penjualan.js';
		$this->data['css_files'][] = asset_url().'vendors/datepicker/css/bootstrap-datepicker.min.css';
		
		//$this->getData('*');

	}
	public function index($renderData=""){	
		$this->jstambahan = "";
		$this->getDataProduk();
		$this->getDataPembayaran();
		$this->getDataPenjualan();
		$this->load->template_adm('Penjualan_view',$this->data);
	}

		/* ambil semua data barang, jika ada parameter post id, ambil berdasarkan id */
		public function getDataProduk(){
		
			//cek apakah dikirim via ajax dengan memberikan $_POST['id']?
			if(isset($_POST['id'])) {
				$data['produkid'] = $_POST['id'];
				//ambil data barang berdasarkan id
				$produk = $this->Produkmodel->getDataById($data['produkid']);
				echo json_encode($produk[0]);
			}else{
				$data['produkid'] = '';
				$this->data['listproduk'] = $this->Produkmodel->getData();
			}
		}
	
	/* ambil data pelanggan */
	public function getDataPembayaran(){
		if(isset($_POST['id'])) {
			$data['pembayaranid'] = $_POST['id'];
			$brg = $this->Pembayaranmodel->getDataById($data['pembayaranid']);
			echo json_encode($brg[0]);
		}else{
			$data['pembayaranid'] = '';
			$this->data['listpembayaran'] = $this->Pembayaranmodel->getData();
		}
		$this->data['listpembayaran'] = $this->Pembayaranmodel->getData();
	}

		/* ambil data penjualan */
		public function getDataPenjualan(){
			$this->data['listdatapenjualan'] = $this->Penjualanmodel->getDataPenjualan();
		}
	
	/* ambil no penjualan terakhir, bisa via AJAX atau NOAJAX */
	public function getNoPenjualan($tipe='AJAX'){
		//generate no penjualan dimulai huruf Jxxxxx
		$data = $this->Generalmodel->autonumber('J','transaksi','transaksiid','5');

		if($tipe=='AJAX'){ echo json_encode($data);}else {return $data['kode'];}
		exit;
	}


	
	/* proses simpan ke tabel*/ 
	public function save(){
		$data['tanggal'] = $this->input->post("tanggal");
		$data['pembayaranid'] = $this->input->post("pembayaranid");
		$data['tgllog'] = date('Y-m-d H:i:s');
		$data['userlog'] = $this->session->userdata('username');
		if($this->input->post("tblsimpan")){
			//echo "kesini";
			$this->db->trans_start();
			$data['transaksiid'] = $this->input->post("transaksiid");//$this->getNoPenjualan('NO_AJAX');
			//simpan dulu ke tabel penjualan
			$this->data['message'] = $this->Penjualanmodel->save($data);	
			//kalo gak ada error, simpan ke tabel detilpenjualan
			if($this->data['message'][0]=='success'){
				//looping untuk detilpenjualan
				$qtyjual = $this->input->post("qtyjual");
				$hargajual = $this->input->post("hargajual");
				$datadetail['transaksiid'] = $data['transaksiid'];
				foreach($this->input->post("kdbrgjual") as $index=>$produk){
					$datadetail['produkid'] = $produk;
					$datadetail['quantity'] = $qtyjual[$index];
					$datadetail['hargasat'] = $hargajual[$index];
					$this->Penjualanmodel->saveDetail($datadetail);
					//kurangin stok
					$this->Penjualanmodel->kuranginStok($produk,$datadetail['quantity']);
				}			
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->data['message'] = array("danger","Transaksi gagal dibuat <br>".$this->db->_error_message());
			}
			else
			{
				$this->db->trans_commit();
				$this->data['message'] = array("success","Transaksi berhasil dibuat.",0);
			}
			$this->index();
			$this->load->template_adm('Penjualan_view',$this->data);


		}elseif($this->input->post("tblubah")){
		//die('ubah');
			$transaksiid = $this->input->post('transaksiid');
				$this->db->trans_start();
				$this->data['message'] = $this->Penjualanmodel->update($data,$transaksiid);
				//echo $this->db->last_query();
				//update detail.. hapus dulu baru insert lagi
				if($this->data['message'][0]=='success'){
					$this->Penjualanmodel->deleteDetail($transaksiid);
					//echo $this->db->last_query();
					//looping untuk 
					$qtyjual = $this->input->post("qtyjual");
					$hargajual = $this->input->post("hargajual");
					$datadetail['transaksiid'] = $transaksiid;
					foreach($this->input->post("kdbrgjual") as $index=>$produk){
						$datadetail['produkid'] = $produk;
						$datadetail['quantity'] = $qtyjual[$index];
						$datadetail['hargasat'] = $hargajual[$index];
						$this->Penjualanmodel->saveDetail($datadetail);
						//kurangin stok
						$this->Penjualanmodel->kuranginStok($produk,$datadetail['quantity']);
					}			
				}
				
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					$this->data['message'] = array("danger","Transaksi gagal disimpan <br>".$this->db->_error_message(),$this->db->_error_number());
				}
				else
				{
					$this->db->trans_commit();
					$this->data['message'] = array("success","Transaksi berhasil disimpan.",0);
				}
			$this->tampil($transaksiid);
			
		}else{
			redirect($this->uricontroller);
		}
	}
	//tampilkan penjualan untuk diubah
	public function tampil($transaksiid){
		//cek ada gak nopenjualan
		if(!isset($transaksiid)||$transaksiid==''){
			redirect('toko/Penjualan');
		}
		//buat di popup
		$this->getDataPenjualan();
		//ambil data penjualan berdasarkan nopenjualan
		$cek = $this->Penjualanmodel->getDataById($transaksiid);
		
		$cekarr = array_filter($cek);
		//kalo ada datanya, ambil data
		if(!empty($cekarr)){
			$this->data['listdatabarang'] = $this->Produkmodel->getData();
			$this->data['dataPenjualan'] = $cek[0];
			 //ambil data pelanggan
			$this->getDataPembayaran();
			$this->data['dataDetilJual'] = $this->Penjualanmodel->getDetail($transaksiid);
			$this->load->template_adm('Penjualan_view',$this->data);
		}else{
			redirect('toko/Penjualan');
		}
	}
	public function cetak($idpo){
		if(!isset($idpo)||$idpo==''){
			redirect($this->uricontroller);
		}
		$this->hasNav = false;
		$cek = $this->Pomodel->getDataById($idpo);
		$cekarr = array_filter($cek);
		if(!empty($cekarr)){
			$this->getDataProduk('');
			$this->data['dataPo'] = $cek[0];
			$tgl = $cek[0]['tgl_po'];
			$tgl1 = explode(" ",$tgl);
			$this->data['dataPo']['tgl_po'] = $tgl1[0];
			$idsup = $cek[0]['kd_supp'];
			$x = $this->Suppliermodel->getDataById($idsup);
			$this->data['dataSupplier'] = $x[0];
			$this->data['dataDetilpo'] = $this->Pomodel->getDetail($idpo);
			$this->load->view('pages/cetakpo2',$this->data);
		}else{
			redirect($this->uricontroller);
		}
	}
	
	public function getData($field){
		$this->data['listdata'] = $this->Pembayaranmodel->getData($field,'belumkirim');
	}
	public function getDataById($renderData="AJAX"){
		$a = $this->Pomodel->getDataById($_POST['id']);
		echo json_encode($a[0]);
	}
	
		
}