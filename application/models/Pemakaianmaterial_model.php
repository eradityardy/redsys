<?php
class Pemakaianmaterial_model extends CI_Model
{
    function add_pemakaianmaterial($table, $data)
    {
		$this->db->insert($table, $data);
    }

    function delete_pemakaianmaterial($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_pemakaianmaterial($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    function get_pemakaianmaterial($where = '')
    {
        return $this->db->query("SELECT * FROM t_pakai_material".$where);
    }

    public function joinTablePemakaianmaterial()
    {
        $this->db->select('*');
        $this->db->from('vw_t_pake_material');
        return $query=$this->db->get();
    }

    public function getDatadropdowntyperumah()
    {
		$query = $this->db->query("SELECT * FROM m_typerumah");
        return $query->result();
    }

    public function getDatadropdownunitrumah()
    {
		$query = $this->db->query("SELECT * FROM vw_unitrumah");
        return $query->result();
    }

    public function getDatadropdownmaterial()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_pake_material");
        return $query->result();
    }

    public function getDataeditdropdownmaterial($where = '')
    {
        $query = $this->db->query("SELECT * FROM vw_dropdown_pake_material WHERE id_unit = ".$where);
        return $query->result();
    }

    public function getDatadropdownstock()
    {
		$query = $this->db->query("SELECT * FROM vw_dropdown_pake_stockgudang");
        return $query->result();
    }

    public function getDatadropdownproyek()
    {
		$query = $this->db->query("SELECT * FROM m_proyek");
        return $query->result();
    }

    //untuk mengambil nomor pemakaian terakhir diinput untuk load tabel material detail
    public function getNopemakaian()
    {
		$query = $this->db->query("SELECT * FROM t_pakai_detail ORDER BY id_pakedetail DESC");
        $row = $query->row(); 
        return $row->no_pemakaian;
    }

    //untuk load tabel transaksipembelian_lihat dan transaksipembelian_edit
    public function show_pemakaian_detail($no_pemakaian = 0)
    {
        $this->db->select('*');
        $this->db->from('vw_t_pake_detail');
        $this->db->where('no_pemakaian = ',$no_pemakaian);
        return $query=$this->db->get();
    }

    //untuk mendapatkan nomor pemakaian material secara otomatis
    public function getNomorpemakaian()
    {
        $this->db->select('RIGHT(no_pemakaian,4) as nomor', FALSE);
        $this->db->order_by('id_pake', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('t_pakai_material');
        if ($query->num_rows() <> 0) {

            $data = $query->row();
            $nomor = intval($data->nomor) + 1;
        } else {
            $nomor = 1;
        }
        $nomormax = str_pad($nomor, 4, "0", STR_PAD_LEFT);
        $nomorjadi = "PM" . date('ym') . "" . $nomormax;
        return $nomorjadi;
    }
} ?>