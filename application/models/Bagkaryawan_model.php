<?php
class Bagkaryawan_model extends CI_Model
{
    function get_bagkaryawan()
    {
        return $this->db->query("SELECT * FROM m_bagian_pekerjaan");
    }

    function add_bagkaryawan($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_bagkaryawan($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_bagkaryawan($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function getEditBagian($id_bag)
    {
        $query = $this->db->get_where('m_bagian_pekerjaan', ['id_bag' => $id_bag])->row_array();
        return $query;
    }
} ?>