<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Expire extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->mylib->cek_adm_login();
		$this->load->library('pdf');
		$this->load->model('toko/Expiremodel');
		//datepicker
		$this->data['js_files'][] = asset_url() . 'vendors/datepicker/js/bootstrap-datepicker.min.js';
		$this->data['css_files'][] = asset_url() . 'vendors/datepicker/css/bootstrap-datepicker.min.css';
		$this->data['js_files'][] = js_url() . 'toko/lapinventory.js';
	}

	public function index()
	{
		//pilih tgl awal dan tanggal akhir
		$this->load->template_adm('Expire_view', $this->data);
	}
	function cetak()
	{

		if ($this->input->post('tblcetak')) {

			$tglawal = $this->input->post('tglawal');
			$tglakhir = $this->input->post('tglakhir');
			$format = $this->input->post('format');
			//cek dulu ada datanya gak? kalo gak ada munculin error_get_last
			$cekdata = $this->Expiremodel->cekExpire($tglawal, $tglakhir);

			if ($cekdata) {
				if ($format == 'pdf') {
					$this->laporanpdf($tglawal, $tglakhir);
				} elseif ($format == 'xls') {
					$this->laporanxls($tglawal, $tglakhir);
				}
			} else {
				$this->data['error'] = "Data is not exist.";
				$this->load->template_adm('Expire_view', $this->data);
			}
		} else {
			redirect('tokocahayaterang/Expire/index');
		}
	}

	function laporanpdf($tglawal, $tglakhir)
	{
		$tglAwalIndo = $this->mylib->tglIndo($tglawal);
		$tglAkhirIndo = $this->mylib->tglIndo($tglakhir);
		//ambil data laporan
		$dtlaporan = $this->Expiremodel->getLaporan($tglawal, $tglakhir);


		//buat objek berdasarkan class fpdf
		$pdf = new FPDF();
		$pdf->AddPage();
		//font arial tebal ukuran 16
		$pdf->SetFont('Arial', 'B', 16);
		//cetak, lebar 190, tinggi 7, border 0, tidak ada enter setelahnya, rata Center
		$pdf->Cell(190, 7, 'LAPORAN TANGGAL KADALUARSA BARANG', 0, 0, 'C');
		//enter
		$pdf->Ln();
		$pdf->Cell(190, 7, $tglAwalIndo . ' - ' . $tglAkhirIndo, 0, 1, 'C');
		$pdf->Ln();
		//buat header table data, tentukan label, panjang kolom dan perataan
		$header = array(
			array("label" => "KODE", "length" => 20, "align" => "C"),
			array("label" => "NAMA BARANG", "length" => 50, "align" => "C"),
			array("label" => "KATEGORI", "length" => 40, "align" => "C"),
			array("label" => "TANGGAL KADALUARSA", "length" => 50, "align" => "C"),
			array("label" => "QUANTITY", "length" => 20, "align" => "C")
			
		);
		$pdf->SetFont('Arial', '', '10');
		//latar belakang warna hitam
		$pdf->SetFillColor(0, 0, 0);
		//text warna putih
		$pdf->SetTextColor(255, 255, 255);
		//warna border/garis tepi kolom
		$pdf->SetDrawColor(128, 0, 0);
		//print header
		foreach ($header as $kolom) {
			//parameter terakhir, jika true berarti menggunakan warna latar belakang
			$pdf->Cell($kolom['length'], 6, $kolom['label'], 1, '0', 'C', true);
		}
		$pdf->Ln();
		#tampilkan data tabelnya
		$pdf->SetFillColor(224, 235, 255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial', '', '9');
		$fill = false;
		//$total = 0;
		//looping tampilkan data laporan
		$produkid = null;
		$sisastok = null;

		foreach ($dtlaporan as $id => $detil) {
			$i = 0;   
			$detil['expire'] = $this->mylib->tglIndo($detil['expire']);
			
			if($produkid == $detil['produkid']){

				if (($sisastok - $detil['quantity']) < 0 ){
					$detil['quantity'] = $sisastok;
				}

			}else{
				$sisastok = $detil['stok']-$detil['quantity'];
				if($sisastok >= 0){
					$produkid = $detil['produkid'];
				}else{
					$detil['quantity'] = $detil['stok'];
				}
			}

			array_pop($detil);
			foreach ($detil as $cell) {
				$pdf->Cell($header[$i]['length'], 6, $cell, 1, '0', $header[$i]['align'], $fill);
				$i++;
			}
			$fill = !$fill;

			$pdf->Ln();
		}
		//munculin total
		$pdf->SetFont('Arial', 'B', '10');
		//$pdf->Cell(140, 5, 'Total', 1, '0', 'C', true);
		//$pdf->Cell(40, 5, $this->mylib->rupiah($total), 1, '0', 'R', true);
		//download dengan nama laporan.pdf
		$pdf->Output('D', 'laporankadaluarsabarang.pdf');
	}
	function laporanxls($tglawal, $tglakhir)
	{
		$tglAwalIndo = $this->mylib->tglIndo($tglawal);
		$tglAkhirIndo = $this->mylib->tglIndo($tglakhir);
		//ambil data laporan
		$dtinventory = $this->Expiremodel->getLaporan($tglawal, $tglakhir);
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'LAPORAN TANGGAL KADALUARSA BARANG')
			->setCellValue('A2', $tglAwalIndo . ' - ' . $tglAkhirIndo);
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A4', 'KODE BARANG')
			->setCellValue('B4', 'NAMA BARANG')
			->setCellValue('C4', 'KATEGORI')
			->setCellValue('D4', 'TANGGAL KADALUARSA')
			->setCellValue('E4', 'QUANTITY');

		//looping data
		$i = 5;
		$total = 0;
		$produkid = null;
		$sisastok = null;
		foreach ($dtinventory as $id => $dt) {
			//$subTotal = $dt['orderTotal'];
			//$total = $total + $subTotal;

			if($produkid == $dt['produkid']){

				if (($sisastok - $dt['quantity']) < 0 ){
					$detil['quantity'] = $sisastok;
				}

			}else{
				$sisastok = $dt['stok']-$dt['quantity'];
				if($sisastok >= 0){
					$produkid = $dt['produkid'];
				}else{
					$dt['quantity'] = $dt['stok'];
				}
			}


			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $dt['produkid'])
				->setCellValue('B' . $i, $dt['nama'])
				->setCellValue('C' . $i, $dt['categori'])
				->setCellValue('D' . $i, $this->mylib->tglIndo($dt['expire']))
				->setCellValue('E' . $i, $dt['quantity'])
			;
			$i++;
		}
		//$spreadsheet->setActiveSheetIndex(0)
		//			->setCellValue('A'.$i, 'Total')	
		//			->setCellValue('D'.$i, $total);	

		$spreadsheet->getActiveSheet()->setTitle('Laporan kadaluarsa' . date('d-m-Y'));

		$writer = new Xlsx($spreadsheet);
		$filename = 'laporankadaluarsa';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output'); // download file 
	}
}
