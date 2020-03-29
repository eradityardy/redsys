<?php
class Stockrumah_model extends CI_Model
{
    public function joinTableStockrumah()
    {
        $this->db->select('*');
        $this->db->from('vw_stock_rumah');
        return $query=$this->db->get();
    }
} ?>