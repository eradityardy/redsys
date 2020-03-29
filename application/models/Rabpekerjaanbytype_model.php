<?php
class Rabpekerjaanbytype_model extends CI_Model
{
    public function joinTableRabpekerjaanbytype()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_pekerjaan_by_typerumah_summary');
        return $query=$this->db->get();
    }

    public function show_pekerjaan_by_type_id($idtype = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_rab_pekerjaan_by_typerumah_detail');
        $this->db->where('id_type = ',$idtype);
        return $query=$this->db->get();
    }

    function add_rabpekerjaanbytype($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_rabpekerjaanbytype($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function getDatatype()
    {
		$query = $this->db->query("SELECT * FROM m_typerumah");
        return $query->result();
    }

    public function getDatapekerjaan()
    {
		$query = $this->db->query("SELECT * FROM m_pekerjaan");
        return $query->result();
    }

    public function jointablepekerjaan()
    {
        $this->db->select('*');
        $this->db->from('m_pekerjaan');
        return $query=$this->db->get();
    }

    public function jointabletyperumah()
    {
        $this->db->select('*');
        $this->db->from('m_typerumah');
        return $query=$this->db->get();
    }

    public function jointablerabpekerjaan()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_pekerjaan_by_typerumah_detail');
        return $query=$this->db->get();
    }
}