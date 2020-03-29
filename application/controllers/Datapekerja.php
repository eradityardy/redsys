<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datapekerja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Pekerja_model', 'pekerja');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_pek', 'Nama Pekerja', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Pekerja';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['pekerja'] = $this->db->get('m_pekerja')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datapekerja/datapekerja_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datapekerja/datapekerja', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'nama_pek' => $this->input->post('nama_pek', true),
                'hp_no' => $this->input->post('hp_no', true),
                'status' => $this->input->post('status', true),
                'perusahaan_pek' => $this->input->post('perusahaan_pek', true),
                'pemilik_perusahaan' => $this->input->post('pemilik_perusahaan', true),
                'alamat' => $this->input->post('alamat', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_pekerja', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datapekerja');
        }
    }

    public function downloadtemplate()
    {
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '0e1111'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'color' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];
        
        $spreadsheet = new Spreadsheet;
        //Add Pekerja to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nama Pekerja')
                    ->setCellValue('C1', 'Alamat')
                    ->setCellValue('D1', 'Nomor HP')
                    ->setCellValue('E1', 'Status')
                    ->setCellValue('F1', 'Perusahaan')
                    ->setCellValue('G1', 'Pemilik')
                    ->setCellValue('H1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerja');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datapekerja_template.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function importexcel()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect('datapekerja');
        } else {
            $data_upload = $this->upload->data();
            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            $data = array();

            $numrow = 1;
            foreach($sheet as $row){
                            if($numrow > 1){
                                array_push($data, array(
                                    'nama_pek' => $row['B'],
                                    'alamat' => $row['C'],
                                    'hp_no' => $row['D'],
                                    'status' => $row['E'],
                                    'perusahaan_pek' => $row['F'],
                                    'pemilik_perusahaan' => $row['G'],
                                    'keterangan' => $row['H'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_pekerja', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datapekerja');
        }
    }

    public function exportexcel()
    {
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '0e1111'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'color' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];

        $semua_pekerja = $this->pekerja->jointablepekerja()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nama Pekerja')
                    ->setCellValue('C1', 'Alamat')
                    ->setCellValue('D1', 'Nomor HP')
                    ->setCellValue('E1', 'Status')
                    ->setCellValue('F1', 'Perusahaan')
                    ->setCellValue('G1', 'Pemilik')
                    ->setCellValue('H1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_pekerja as $pekerja) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pekerja->nama_pek)
                        ->setCellValue('C' . $kolom, $pekerja->alamat)
                        ->setCellValue('D' . $kolom, $pekerja->hp_no)
                        ->setCellValue('E' . $kolom, $pekerja->status)
                        ->setCellValue('F' . $kolom, $pekerja->perusahaan_pek)
                        ->setCellValue('G' . $kolom, $pekerja->pemilik_perusahaan)
                        ->setCellValue('H' . $kolom, $pekerja->keterangan);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerja');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datapekerja.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editpekerja($id_pek)
    {
        $this->form_validation->set_rules('nama_pek', 'Nama Pekerja', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Pekerja';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['pekerja'] = $this->db->get_where('m_pekerja', ['id_pek' => $id_pek])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datapekerja/datapekerja_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_pek = $this->input->post('nama_pek');
            $hp_no = $this->input->post('hp_no');
            $status = $this->input->post('status');
            $perusahaan_pek = $this->input->post('perusahaan_pek');
            $pemilik_perusahaan = $this->input->post('pemilik_perusahaan');
            $alamat = $this->input->post('alamat');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('nama_pek', $nama_pek);
            $this->db->set('hp_no', $hp_no);
            $this->db->set('status', $status);
            $this->db->set('perusahaan_pek', $perusahaan_pek);
            $this->db->set('pemilik_perusahaan', $pemilik_perusahaan);
            $this->db->set('alamat', $alamat);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id_pek', $id_pek);
            $this->db->update('m_pekerja');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datapekerja');
        }
    }

    public function hapuspekerja($id_pek)
    {
        $this->db->where('id_pek', $id_pek);
        $this->db->delete('m_pekerja');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datapekerja');
    }
}