<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datatyperumah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Typerumah_model', 'typerumah');
	}
    
    public function index()
    {
        $this->form_validation->set_rules('nama_type', 'Type Rumah', 'required|trim|is_unique[m_typerumah.nama_type]', array(
            'is_unique' => 'Simpan Gagal! Type Rumah sudah ada'
        ));
        $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'required|trim');
        $this->form_validation->set_rules('luas_bangunan', 'Luas Bangunan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Type Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['typerumah'] = $this->db->get('m_typerumah')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datatyperumah/datatyperumah_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datatyperumah/datatyperumah', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'nama_type' => $this->input->post('nama_type', true),
                'luas_tanah' => $this->input->post('luas_tanah', true),
                'luas_bangunan' => $this->input->post('luas_bangunan', true),
                'harga_tyrum' => $this->input->post('harga_tyrum', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_typerumah', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datatyperumah');
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
                    ->setCellValue('B1', 'Type Rumah')
                    ->setCellValue('C1', 'Luas Tanah')
                    ->setCellValue('D1', 'Luas Bangunan')
                    ->setCellValue('E1', 'Harga')
                    ->setCellValue('F1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datatyperumah_template.xlsx"');
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
            redirect('datatyperumah');
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
                                    'nama_type' => $row['B'],
                                    'luas_tanah' => $row['C'],
                                    'luas_bangunan' => $row['D'],
                                    'harga_tyrum' => $row['E'],
                                    'keterangan' => $row['F'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_typerumah', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datatyperumah');
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

        $semua_typerumah = $this->typerumah->jointabletyperumah()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Type Rumah')
                    ->setCellValue('C1', 'Luas Tanah')
                    ->setCellValue('D1', 'Luas Bangunan')
                    ->setCellValue('E1', 'Harga')
                    ->setCellValue('F1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_typerumah as $tyrum) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $tyrum->nama_type)
                        ->setCellValue('C' . $kolom, $tyrum->luas_tanah)
                        ->setCellValue('D' . $kolom, $tyrum->luas_bangunan)
                        ->setCellValue('E' . $kolom, $tyrum->harga_tyrum)
                        ->setCellValue('F' . $kolom, $tyrum->keterangan);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datatyperumah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function edittyperumah($id_type)
    {
        $this->form_validation->set_rules('nama_type', 'Type Rumah', 'required|trim');
        $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'required|trim');
        $this->form_validation->set_rules('luas_bangunan', 'Luas Bangunan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Type Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['typerumah'] = $this->db->get_where('m_typerumah', ['id_type' => $id_type])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datatyperumah/datatyperumah_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_type = $this->input->post('nama_type');
            $luas_tanah = $this->input->post('luas_tanah');
            $luas_bangunan = $this->input->post('luas_bangunan');
            $harga_tyrum = $this->input->post('harga_tyrum');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('nama_type', $nama_type);
            $this->db->set('luas_tanah', $luas_tanah);
            $this->db->set('luas_bangunan', $luas_bangunan);
            $this->db->set('harga_tyrum', $harga_tyrum);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id_type', $id_type);
            $this->db->update('m_typerumah');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datatyperumah');
        }
    }

    public function hapustyperumah($id_type)
    {
        $this->db->where('id_type', $id_type);
        $this->db->delete('m_typerumah');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datatyperumah');
    }
} ?>