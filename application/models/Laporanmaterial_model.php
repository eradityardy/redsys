<?php
class Laporanmaterial_model extends CI_Model
{
    public function joinTableLaporanmaterialbyunit()
    {
        $this->db->select('*');
        $this->db->from('vw_laporanmaterial_unit_summary_real');
        return $query=$this->db->get();
    }
    
    public function show_laporanmaterial_by_idunit($id_unit = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_laporanmaterial_unit_detail');
        $this->db->where('id_unit = ', $id_unit);
        return $query=$this->db->get();
    }

    public function joinTableLaporanmaterialbypro()
    {
        $this->db->select('*');
        $this->db->from('vw_laporanmaterial_proyek_summary');
        return $query=$this->db->get();
    }
    
    public function show_laporanmaterial_by_idpro($id_pro = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_laporanmaterial_proyek_detail');
        $this->db->where('id_pro = ', $id_pro);
        return $query=$this->db->get();
    }
}