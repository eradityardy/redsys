<?php
class Unitrumah_model extends CI_Model
{
    function get_unitrumah($where = '')
    {
        return $this->db->query("SELECT * FROM vw_unitrumah".$where);
    }

    function add_unitrumah($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_unitrumah($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_unitrumah($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function joinTableUnRum()
    {
        $this->db->select('*');
        $this->db->from('vw_unitrumah');
        return $query=$this->db->get();
    }

    public function getdatatype()
    {
		$query = $this->db->query("SELECT * FROM m_typerumah");
        return $query->result();
    }

    public function getdatapro()
    {
		$query = $this->db->query("SELECT * FROM m_proyek");
        return $query->result();
    }

    public function getdatacus()
    {
		$query = $this->db->query("SELECT * FROM m_customer");
        return $query->result();
    }

    public function getdatapeksubkon()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_pekerja_subkon");
        return $query->result();
    }

    public function getdatapekkontraktor()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_pekerja_kontraktor");
        return $query->result();
    }

    public function getdatapek()
    {
		$query = $this->db->query("SELECT * FROM m_pekerja");
        return $query->result();
    }

    public function getdatablok()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_unit_blokrumah");
        return $query->result();
    }

    public function getdatapengawas()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_karyawanpengawas");
        return $query->result();
    }

    public function getdatamarketing()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_karyawanmarketing");
        return $query->result();
    }

    public function getdataarsitek()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_karyawanarsitek");
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

    public function jointableblokrumah()
    {
        $this->db->select('*');
        $this->db->from('m_blokrumah');
        return $query=$this->db->get();
    }

    public function jointablepekerja()
    {
        $this->db->select('*');
        $this->db->from('m_pekerja');
        return $query=$this->db->get();
    }

    public function jointablekaryawan()
    {
        $this->db->select('*');
        $this->db->from('vw_karyawan');
        return $query=$this->db->get();
    }
} ?>