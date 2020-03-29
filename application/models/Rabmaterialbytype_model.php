<?php
class Rabmaterialbytype_model extends CI_Model
{
    public function joinTableRabmaterialbytype()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_material_by_typerumah_summary');
        return $query=$this->db->get();
    }
    
    public function show_material_by_type_id($idtype = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_rab_material_by_typerumah_detail');
        $this->db->where('id_type = ', $idtype);
        return $query=$this->db->get();
    }

    function add_rabmaterialbytype($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_rabmaterialbytype($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function getDatatype()
    {
		$query = $this->db->query("SELECT * FROM m_typerumah");
        return $query->result();
    }

    public function getDatamaterial()
    {
		$query = $this->db->query("SELECT * FROM m_material");
        return $query->result();
    }

    public function jointablematerial()
    {
        $this->db->select('*');
        $this->db->from('vw_material');
        return $query=$this->db->get();
    }

    public function jointabletyperumah()
    {
        $this->db->select('*');
        $this->db->from('m_typerumah');
        return $query=$this->db->get();
    }

    public function jointablerabmaterial()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_material_by_typerumah_detail');
        return $query=$this->db->get();
    }
}