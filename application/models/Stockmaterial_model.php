<?php
class Stockmaterial_model extends CI_Model
{
    public function simpan($tabel, $data)
    {
        $result = $this->db->insert($tabel, $data);
        if ($result == 1){
            return $this->db->insert_id();
        }else{
            return $result;
        }
    }

    public function hapus($tabel, $where)
    {
        return $this->db->delete($tabel, $where);
    }

    public function update($tabel, $data, $where)
    {
        return $this->db->update($tabel, $data, $where);
    }

    public function joinTableStockmaterial()
    {
        $this->db->order_by('nama_gud', 'ASC');
        $this->db->select('*');
        $this->db->from('vw_stock_material');
        return $query=$this->db->get();
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

    public function getStockId($gudangId = 0, $materialId = 0)
    {
		$query = $this->db->query("SELECT id_stomat FROM t_stock_material Where gudang_id = $gudangId And material_id = $materialId");
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->id_stomat;
        }else{
            return 0;
        }
    }

    public function getStockCard($stockId = 0){
        //fungsi untuk menggenerate kartu stock
        //1. Ambil data material dan gudang
        $gudangId = null;
        $materialId = null;
        $sql = "SELECT gudang_id, material_id FROM t_stock_material Where id_stomat = $stockId";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            $gudangId = $row->gudang_id;
            $materialId = $row->material_id;
            //2. Buat table sementara
            $sql = "Create Temporary Table xtblKartuStock
            (
                idx int(11) not null default 0,
                tanggal date,
                relasi varchar(50),
                no_document varchar(5),
                masuk int(5) default 0,
                keluar int(5) default 0,
                saldo int(5) default 0
            )";
            $query = $this->db->query($sql);
            //3. Isi barang masuk
            $sql = "Insert Into xtblKartuStock (idx,tanggal,relasi,no_document,masuk)";
            $sql.= " Select 1,a.tgl_beli,a.nama,a.no_faktur,b.qty From vw_t_beli_master a JOIN t_beli_detail b ON a.no_faktur = b.no_faktur";
            $sql.= " Where b.stock_id = $stockId Order By a.tgl_beli,a.no_faktur";
            //$sql.= " Where a.gudang_id = $gudangId And b.material_id = $materialId Order By a.tgl_beli,a.no_faktur";
            $query = $this->db->query($sql);
            //4. Isi barang keluar
            $sql = "Insert Into xtblKartuStock (idx,tanggal,relasi,no_document,keluar)";
            $sql.= " Select 2,a.tgl_pake,a.alamat,'-',b.qty";
            $sql.= " From vw_t_pake_material a join vw_t_pake_detail b on a.no_pemakaian = b.no_pemakaian Where b.stock_id = $stockId";
            $query = $this->db->query($sql);
            //5. Kirim ke view
            $sql = "Select a.* From xtblKartuStock a Order By a.tanggal,a.idx";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                return $query;//->result();
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
} ?>