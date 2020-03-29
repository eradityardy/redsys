<?php
class Rabpekerjaanbyunit_model extends CI_Model
{
    public function joinTableRabpekerjaanbyunit()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_pekerjaan_by_unitrumah_summary');
        return $query=$this->db->get();
    }

    public function show_pekerjaan_by_unit_id($idunit = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_rab_pekerjaan_by_unitrumah_detail');
        $this->db->where('id_unit = ',$idunit);
        return $query=$this->db->get();
    }

    function add_rabpekerjaanbyunit($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_rabpekerjaanbyunit($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function getDataunit()
    {
		$query = $this->db->query("SELECT * FROM m_unitrumah");
        return $query->result();
    }

    public function getDatapekerjaan()
    {
		$query = $this->db->query("SELECT * FROM m_pekerjaan");
        return $query->result();
    }

} ?>