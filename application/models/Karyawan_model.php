<?php
class Karyawan_model extends CI_Model
{
    function get_karyawan($where = '')
    {
        return $this->db->query("SELECT * FROM m_karyawan".$where);
    }

    function add_karyawan($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_karyawan($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_karyawan($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function getdatabag()
    {
		$query = $this->db->query("SELECT * FROM m_bagian_pekerjaan");
        return $query->result();
	}

    public function jointablekarbag()
    {
        $this->db->select('*');
        $this->db->from('m_bagian_pekerjaan');
        $this->db->join('m_karyawan', 'bagian_id = id_bag');

        return $query=$this->db->get();
    }

    public function jointablekaryawan()
    {
        $this->db->select('*');
        $this->db->from('vw_karyawan');
        return $query=$this->db->get();
    }
} ?>