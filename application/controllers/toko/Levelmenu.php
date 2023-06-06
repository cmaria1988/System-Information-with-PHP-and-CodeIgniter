 <?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
class Levelmenu extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->mylib->cek_adm_login();
		$this->load->Model('toko/Levelmenumodel');
		$this->data['js_files'][] = js_url().'toko/levelmenu.js';
		//ambil url controllernya untuk hak akses
		$this->data['urlcontroller'] = $this->uri->segment(2);
		$this->data['hakakses'] = $this->Levelmenumodel->getAkses($this->session->userdata('level'),$this->data['urlcontroller']);
    }

	public function index()
	{
		$this->data['levelpilihan'] = '';
		$this->data['level'] = $this->Levelmenumodel->getLevel();
		$this->load->template_adm('Levelmenu_view',$this->data);
	}

    function level($idlevel = ''){
        if($idlevel==''){
            redirect('adm/Levelmenu/');
        }
        $this->data['level']=$this->Levelmenumodel->getLevel();
        $this->data['levelpilihan']=$idlevel;

        $this->load->template_adm('Levelmenu_view',$this->data);
    }

    public function simpan(){
        $data = $this->input->post();
        $name = explode("_",$data['name']);

        $idmenu = $name[1];
        $status = $name[0];
        $level = $data['level'];
        $pilih = $data['pilih'];
        $this->Levelmenumodel->simpan($level, $idmenu,$status,$pilih);
    }
}


?>

