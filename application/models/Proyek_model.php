<?php
class Proyek_model extends CI_Model
{
    // GET ALL PRODUCT
    function get_proyek($where = '')
    {
        return $this->db->query("SELECT * FROM m_proyek ORDER BY kode ASC".$where);
    }

    function add_proyek($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_proyek($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function edit_proyek($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function jointableproyek()
    {
        $this->db->select('*');
        $this->db->from('m_proyek');
        return $query=$this->db->get();
    }
} ?>