<?php
class Mylib
{
    /* library yang berisi fungsi yang sering digunalam */

    function __construct()
    {
        $this->CI = &get_instance();
    }

    public function cek_adm_login()
    {
        //cek sudah login atau belum
        if (!$this->CI->session->userdata('username')) {
            //jika tidak ada session, kembalikan ke halaman login
            redirect(site_url('toko/Login'));
        }
    }

    public function tglIndo($tgl)
    {
        //menjadikan tgl dalam format tanggal-nama bulan-tahun
        //parameter tgl dalam format yyyy-mm-dd
        $x = explode("-", $tgl);
        $bulan = $this->bulanIndonesia($x[1]);
        return $x[2] . " " . $bulan . " " . $x[0];
    }

    public function bulanIndonesia($index)
    {
        //menjadikan bulan format indonesia,
        //butuh parameter berupa index bulan 01-12
        $bulan = "";
        switch ($index) {
            case '01':
                $bulan = "Januari";
                break;
            case '02':
                $bulan = "Februari";
                break;
            case '03':
                $bulan = "Maret";
                break;
            case '04':
                $bulan = "April";
                break;
            case '05':
                $bulan = "Mei";
                break;
            case '06':
                $bulan = "Juni";
                break;
            case '07':
                $bulan = "Juli";
                break;
            case '08':
                $bulan = "Agustus";
                break;
            case '09':
                $bulan = "September";
                break;
            case '10':
                $bulan = "Oktober";
                break;
            case '11':
                $bulan = "November";
                break;
            case "12":
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }

    public function rupiah($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}
