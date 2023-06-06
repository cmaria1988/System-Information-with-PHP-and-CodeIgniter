<?php
class Login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "login";
        $this->table_level = "level";
    }

    function cek_login($user, $pass)
    {
        $this->db->select('username');
        $this->db->from($this->table);
        $this->db->where('username', $user, true);
        $this->db->where('password', $pass, true);
        $query = $this->db->get();
        // to check : 
        //die($this->db->last_query());
        if ($query->num_rows() == 0) {
            return false;
        } else {
            //get data for session
            $this->db->select('username, nama, email,' . $this->table . '.idlevel,namalevel');
            $this->db->from($this->table);
            $this->db->join($this->table_level, $this->table . '.idlevel=' . $this->table_level . '.idlevel');
            $this->db->where('username', $user);
            $query = $this->db->get();
            //die($this->db->last_query());
            $row = $query->result_array();
            return $row[0];
        }
    }
}
