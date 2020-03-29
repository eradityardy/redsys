<?php
class Material_model extends CI_Model
{
    function get_material($where = '')
    {
        return $this->db->query("SELECT * FROM m_material".$where);
    }

    function add_material($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_material($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_material($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function getdataPekerjaan()
    {
		$query = $this->db->query("SELECT * FROM m_pekerjaan");
        return $query->result();
    }

    public function jointablematerial()
    {
        $this->db->select('*');
        $this->db->from('vw_material');
        return $query=$this->db->get();
    }

    public function jointablepekerjaan()
    {
        $this->db->select('*');
        $this->db->from('m_pekerjaan');
        return $query=$this->db->get();
    }

    //untuk mendapatkan kode material secara otomatis
    public function getKodematerial()
    {
        $this->db->select('RIGHT(kode,4) as nomor', FALSE);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('m_material');
        if ($query->num_rows() <> 0) {

            $data = $query->row();
            $nomor = intval($data->nomor) + 1;
        } else {
            $nomor = 1;
        }
        $nomormax = str_pad($nomor, 4, "0", STR_PAD_LEFT);
        return $nomormax;
    }
} ?>