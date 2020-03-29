<?php
class Bookingrumah_model extends CI_Model
{
    function get_book($where = '')
    {
        return $this->db->query("SELECT * FROM vw_t_booking_rumah".$where);
    }

    function add_book($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_book($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_book($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function joinTableBookingrumah()
    {
        $this->db->select('*');
        $this->db->from('vw_t_booking_rumah');
        return $query=$this->db->get();
    }

    public function getDatadropdownunitrumah()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_booking_unitrumah");
        return $query->result();
    }

    public function getDatadropdownbank()
    {
		$query = $this->db->query("SELECT * FROM m_bank");
        return $query->result();
    }

    public function getDatadropdownproyek()
    {
		$query = $this->db->query("SELECT * FROM m_proyek");
        return $query->result();
    }
} ?>