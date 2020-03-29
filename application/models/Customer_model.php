<?php
class Customer_model extends CI_Model
{
    function get_customer($where = '')
    {
        return $this->db->query("SELECT * FROM vw_customer_detail".$where);
    }

    function add_customer($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_customer($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_customer($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    function getdataBank()
    {
        $query = $this->db->query("SELECT * FROM m_bank");
        return $query->result();
    }

    function getdataMarketing()
    {
        $query = $this->db->query("SELECT * FROM vw_dropdown_karyawanmarketing");
        return $query->result();
    }

    function getdataUnit()
    {
        $query = $this->db->query("SELECT * FROM m_unitrumah");
        return $query->result();
    }

    public function jointablecustomer()
    {
        $this->db->select('*');
        $this->db->from('vw_customer_detail');
        return $query=$this->db->get();
    }

    public function jointablebank()
    {
        $this->db->select('*');
        $this->db->from('m_bank');
        return $query=$this->db->get();
    }

    public function jointablemarketing()
    {
        $this->db->select('*');
        $this->db->from('vw_dropdown_karyawanmarketing');
        return $query=$this->db->get();
    }

    public function jointableunitrumah()
    {
        $this->db->select('*');
        $this->db->from('vw_unitrumah');
        return $query=$this->db->get();
    }
} ?>