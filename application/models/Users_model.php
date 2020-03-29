<?php
class Users_model extends CI_Model
{
    function get($username)
    {
        $this->db->where('username', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('users')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

    function get_users($where = '')
    {
        return $this->db->query("SELECT * FROM users".$where);
    }

    function add_users($data, $table)
    {
		$this->db->insert($table, $data);
    }
    
    function delete_users($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    function edit_users($tabel, $data, $where)
    {
        $this->db->update($tabel, $data, $where);
    }

    public function countUsersAktif()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_users) as user_aktif
            FROM users
            WHERE is_active = 1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->user_aktif;
        } else {
            return 0;
        }
    }

    public function countJmlPekerja()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_pek) as jml_pekerja
            FROM m_pekerja"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_pekerja;
        } else {
            return 0;
        }
    }

    public function countJmlKaryawan()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_kar) as jml_karyawan
            FROM m_karyawan"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->jml_karyawan;
        } else {
            return 0;
        }
    }

    public function countUnitRumah()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_unit) as unit_rumah
            FROM m_unitrumah"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->unit_rumah;
        } else {
            return 0;
        }
    }

    public function countProyek()
    {
        $query = $this->db->query(
            "SELECT COUNT(id_pro) as proyek
            FROM m_proyek"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->proyek;
        } else {
            return 0;
        }
    }
} ?>