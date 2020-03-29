<?php
class Transaksipembelian_model extends CI_Model
{
    public function simpan($tabel, $data)
    {
        return $this->db->insert($tabel, $data);
    }

    public function hapus($tabel, $where)
    {
        return $this->db->delete($tabel, $where);
    }

    public function update($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function joinTableTransaksibeli()
    {
        $this->db->order_by('tgl_beli', 'ASC');
        $this->db->select('*');
        $this->db->from('vw_t_beli_master');
        return $query=$this->db->get();
    }

    //untuk header transaksipembelian_lihat
    public function joinTablebelidetail($where = '')
    {
        return $this->db->query("SELECT * FROM vw_t_beli_masterdetail".$where);
    }

    //untuk load tabel transaksipembelian_lihat dan transaksipembelian_edit
    public function show_transaksipembelian_detail($nofaktur = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_t_beli_detail');
        $this->db->where('no_faktur = ',$nofaktur);
        return $query=$this->db->get();
    }

    //untuk get variabel transaksipembelian_edit
    public function getTbelimaster($where = '')
    {
        return $this->db->query("SELECT * FROM t_beli_master".$where);
    }

    public function getDatasupplier()
    {
		$query = $this->db->query("SELECT * FROM m_supplier");
        return $query->result();
    }

    public function getDatagudang()
    {
		$query = $this->db->query("SELECT * FROM m_gudang");
        return $query->result();
    }

    public function getDatamaterial()
    {
		$query = $this->db->query("SELECT * FROM m_material");
        return $query->result();
    }

    public function getDatamaster()
    {
		$query = $this->db->query("SELECT * FROM t_beli_master");
        return $query->result();
    }

    public function checkNoFaktur($nofaktur)
    {
		$query = $this->db->query("SELECT * FROM t_beli_master Where no_faktur = '".$nofaktur."'");
        return $query->num_rows();
    }

    public function getNofaktur()
    {
		$query = $this->db->query("SELECT * FROM t_beli_detail ORDER BY id_tbd DESC");
        $row = $query->row(); 
        return $row->no_faktur;
    }

    public function jointablepembelian()
    {
        $this->db->select('*');
        $this->db->from('vw_transaksipembelian_material');
        return $query=$this->db->get();
    }
} ?>