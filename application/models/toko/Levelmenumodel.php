<?php
class Levelmenumodel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->tabel = "level_menuadmin";
        $this->tabelmenu = "menuadmin";
        $this->tabellevel = "level";
    }

    function getLevel()
    {
        $this->db->select('idlevel,namalevel');
        $this->db->from($this->tabellevel);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    function simpan($level, $idmenu, $status, $pilih)
    {
        //cek apakah data sudah ada di tabel level_menuadmin
        $this->db->select('*');
        $this->db->from($this->tabel);
        $this->db->where('idlevel', $level);
        $this->db->where('idadminmenu', $idmenu);
        $query = $this->db->get();

        $jum = $query->num_rows();
        if ($jum == 0) {
            //kalo belum ada, insert
            $dt = array('idlevel' => $level, 'idadminmenu' => $idmenu, $status => $pilih);
            $this->db->insert($this->tabel, $dt);
        } else {
            //kalo sudah ada, update
            $dt = array('idlevel' => $level, 'idadminmenu' => $idmenu, $status => $pilih);
            $this->db->where('idlevel', $level);
            $this->db->where('idadminmenu', $idmenu);
            $this->db->update($this->tabel, $dt);
        }
        //detele yang semua hak nya 0
        $this->db->where('canupdate', '0');
        $this->db->where('canread', '0');
        $this->db->where('candelete', '0');
        $this->db->where('cancreate', '0');
        $this->db->delete($this->tabel);
    }

    function getAkses($idlevel, $url)
    {
        $this->db->select($this->tabel . '.*');
        $this->db->from($this->tabelmenu);
        $this->db->join($this->tabel, $this->tabel . '.idadminmenu=' . $this->tabelmenu . '.id');
        $this->db->where('idlevel', $idlevel);
        $this->db->where('url', $url);
        $query = $this->db->get();

        $jum = $query->num_rows();
        if ($jum > 0) {
            $row = $query->result_array();
            return $row[0];
        } else {
            $row = array(
                'id' => '', 'idlevel' => '', 'idadminmenu' => '', 'cancreate' => '',
                'canread' => '', 'canupdate' => '', 'candelete' => ''
            );
            return $row;
        }
    }
}
