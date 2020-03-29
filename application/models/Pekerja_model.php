<?php
class Pekerja_model extends CI_Model
{
    function get_pekerja($where = '')
    {
        return $this->db->query("SELECT * FROM m_pekerja".$where);
    }

    function add_pekerja($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_pekerja($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_pekerja($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function jointablepekerja()
    {
        $this->db->select('*');
        $this->db->from('m_pekerja');
        return $query=$this->db->get();
    }
} ?>