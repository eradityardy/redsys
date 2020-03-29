<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datapekerjaan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Pekerjaan_model', 'pekerjaan');
	}

    public function index()
    {
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('std_harga', 'Harga', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Pekerjaan';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['pekerjaan'] = $this->db->get('vw_pekerjaan')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datapekerjaan/datapekerjaan_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datapekerjaan/datapekerjaan', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'pekerjaan' => $this->input->post('pekerjaan', true),
                'std_harga' => $this->input->post('std_harga', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_pekerjaan', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datapekerjaan');
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
        //Add Pekerjaan to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Pekerjaan')
                    ->setCellValue('C1', 'Harga')
                    ->setCellValue('D1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerjaan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datapekerjaan_template.xlsx"');
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
            redirect('datapekerjaan');
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
                                    'pekerjaan' => $row['B'],
                                    'std_harga' => $row['C'],
                                    'keterangan' => $row['D'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_pekerjaan', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datapekerjaan');
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

        $semua_pekerjaan = $this->pekerjaan->jointablepekerjaan()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Pekerjaan')
                    ->setCellValue('C1', 'Harga')
                    ->setCellValue('D1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_pekerjaan as $pekerjaan) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pekerjaan->pekerjaan)
                        ->setCellValue('C' . $kolom, $pekerjaan->std_harga)
                        ->setCellValue('D' . $kolom, $pekerjaan->keterangan);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerjaan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datapekerjaan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editpekerjaan($id)
    {
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('std_harga', 'Harga', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Pekerjaan';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['pekerjaan'] = $this->db->get_where('m_pekerjaan', ['id' => $id])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datapekerjaan/datapekerjaan_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $pekerjaan = $this->input->post('pekerjaan');
            $std_harga = $this->input->post('std_harga');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('pekerjaan', $pekerjaan);
            $this->db->set('std_harga', $std_harga);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id', $id);
            $this->db->update('m_pekerjaan');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datapekerjaan');
        }
    }

    public function hapuspekerjaan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_pekerjaan');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datapekerjaan');
    }
} ?>