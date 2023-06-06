<?php
class Generalmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	function autonumber($prefix,$table,$field,$jmlchar)
	{
		$sql = "SELECT max($field) as kode from $table";
		//echo $sql;
		$query = $this->db->query($sql);
		// echo $query->num_rows();
		if ($query->num_rows() == 0)
		{
			$next = 1;
		}else{
			$row = $query->row_array();
			$maks = $row['kode']; // J00012
			$rest = str_replace($prefix,"",$maks); //00012
			$next = intval($rest)+1; //13
		}
		$kosong = "";
		for($i=strlen($next);$i<=($jmlchar-1);$i++){
				$kosong .= "0";
		}
		$kode = $prefix.$kosong.$next;
		$data['kode'] = $kode;
		return $data;

	}
}
?>
