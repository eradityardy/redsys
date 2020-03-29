<?php
class Bank_model extends CI_Model
{
    function get_bank($where = '')
    {
        return $this->db->query("SELECT * FROM m_bank".$where);
    }

    function add_bank($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_bank($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_bank($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    function get_customerbank($where = '')
    {
        return $this->db->query("SELECT * FROM vw_bank_customer".$where);
    }

    public function jointablebank()
    {
        $this->db->select('*');
        $this->db->from('m_bank');
        return $query=$this->db->get();
    }
} ?>