<?php
class Opnameprogress_model extends CI_Model
{
    function add_opnameprogress($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_opnameprogress($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_opnameprogress($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    function get_opnameprogress($where = '')
    {
        return $this->db->query("SELECT * FROM t_opname_progress".$where);
    }

    public function joinTableOpnameprogress()
    {
        $this->db->select('*');
        $this->db->from('vw_t_opname_progress');
        return $query=$this->db->get();
    }

    public function getDatadropdownunitrumah()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_pake_unitrumah");
        return $query->result();
    }

    public function getDatadropdownpekerjaan()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_opname_pekerjaan");
        return $query->result();
    }
} ?>