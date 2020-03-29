<?php
class Rabmaterialbyunit_model extends CI_Model
{
    public function joinTableRabmaterialbyunit()
    {
        $this->db->select('*');
        $this->db->from('vw_rab_material_by_unitrumah_summary');
        return $query=$this->db->get();
    }

    public function show_material_by_unit_id($idunit = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_rab_material_by_unitrumah_detail');
        $this->db->where('id_unit = ',$idunit);
        return $query=$this->db->get();
    }

    function add_rabmaterialbyunit($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_rabmaterialbyunit($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function getDataunit()
    {
		$query = $this->db->query("SELECT * FROM m_unitrumah");
        return $query->result();
    }

    public function getDatamaterial()
    {
		$query = $this->db->query("SELECT * FROM m_material");
        return $query->result();
    }

} ?>