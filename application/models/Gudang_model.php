<?php
class Gudang_model extends CI_Model
{
    function get_gudang($where = '')
    {
        return $this->db->query("SELECT * FROM m_gudang".$where);
    }

    function add_gudang($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_gudang($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_gudang($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function getEditGudang($id_gud)
    {
        $query = $this->db->get_where('m_gudang', ['id_gud' => $id_gud])->row_array();
        return $query;
    }
} ?>