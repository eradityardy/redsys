<?php
class Supplier_model extends CI_Model
{
    function get_supplier($where = '')
    {
        return $this->db->query("SELECT * FROM m_supplier".$where);
    }

    function add_supplier($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_supplier($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_supplier($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function jointablesupplier()
    {
        $this->db->select('*');
        $this->db->from('m_supplier');
        return $query=$this->db->get();
    }
} ?>