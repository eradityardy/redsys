<?php
class Typerumah_model extends CI_Model
{
    function get_typerumah($where = '')
    {
        return $this->db->query("SELECT * FROM m_typerumah".$where);
    }

    function add_typerumah($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_typerumah($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_typerumah($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function jointabletyperumah()
    {
        $this->db->select('*');
        $this->db->from('m_typerumah');
        return $query=$this->db->get();
    }
} ?>