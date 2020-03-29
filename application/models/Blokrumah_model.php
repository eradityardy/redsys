<?php
class Blokrumah_model extends CI_Model
{
    function get_blokrumah($where = '')
    {
        return $this->db->query("SELECT * FROM m_blokrumah".$where);
    }

    function add_blokrumah($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_blokrumah($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_blokrumah($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    function joinTableblokrumah()
    {
        $this->db->select('*');
        $this->db->from('vw_blokrumah');
        return $query=$this->db->get();
    }

    public function getdataproyek()
    {
		$query = $this->db->query("SELECT * FROM m_proyek");
        return $query->result();
    }

    public function getdatatype()
    {
		$query = $this->db->query("SELECT * FROM m_typerumah");
        return $query->result();
    }

    public function jointableproyek()
    {
        $this->db->select('*');
        $this->db->from('m_proyek');
        return $query=$this->db->get();
    }

    public function jointabletyperumah()
    {
        $this->db->select('*');
        $this->db->from('m_typerumah');
        return $query=$this->db->get();
    }
} ?>