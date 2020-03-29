<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datablokrumah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Blokrumah_model', 'blokrumah');
	}
    
    public function index()
    {
        $this->form_validation->set_rules('nama_blok', 'Blok Rumah', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Blok Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['blokrumah'] = $this->db->get('vw_blokrumah')->result_array();
            $data['data_pro'] = $this->blokrumah->getdataproyek();
            $data['data_type'] = $this->blokrumah->getdatatype();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datablokrumah/datablokrumah_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datablokrumah/datablokrumah', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'proyek_id' => $this->input->post('proyek_id', true),
                'type_id' => $this->input->post('type_id', true),
                'nama_blok' => $this->input->post('nama_blok', true),
                'status' => $this->input->post('status', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_blokrumah', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datablokrumah');
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

        $semua_proyek = $this->blokrumah->jointableproyek()->result();
        $semua_typerumah = $this->blokrumah->jointabletyperumah()->result();
        $spreadsheet = new Spreadsheet;
        //Add Blok Rumah to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Proyek ID')
                    ->setCellValue('C1', 'Type Rumah ID')
                    ->setCellValue('D1', 'Nama Blok')
                    ->setCellValue('E1', 'Status')
                    ->setCellValue('F1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Blok Rumah');

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

        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'ID Proyek')
                    ->setCellValue('B1', 'Nama Proyek');

        $kolom2 = 2;
        foreach($semua_proyek as $proyek) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $proyek->id_pro)
                        ->setCellValue('B' . $kolom2, $proyek->nama_pro);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Proyek');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);

        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('A1', 'ID Type Rumah')
                    ->setCellValue('B1', 'Type Rumah');

        $kolom3 = 2;
        foreach($semua_typerumah as $tyrum) {
            $spreadsheet->setActiveSheetIndex(2)
                        ->setCellValue('A' . $kolom3, $tyrum->id_type)
                        ->setCellValue('B' . $kolom3, $tyrum->nama_type);
            $kolom3++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datablokrumah_template.xlsx"');
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
            redirect('datablokrumah');
        } else {
            $data_upload = $this->upload->data();
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel   = $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            $data = array();

            $numrow = 1;
            foreach($sheet as $row){
                            if($numrow > 1){
                                array_push($data, array(
                                    'proyek_id' => $row['B'],
                                    'type_id' => $row['C'],
                                    'nama_blok' => $row['D'],
                                    'status' => $row['E'],
                                    'keterangan' => $row['F'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_blokrumah', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datablokrumah');
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

        $semua_blokrumah = $this->blokrumah->joinTableblokrumah()->result();
        $spreadsheet = new Spreadsheet;
        //Add Blok Rumah to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Proyek')
                    ->setCellValue('C1', 'Type Rumah')
                    ->setCellValue('D1', 'Blok Rumah')
                    ->setCellValue('E1', 'status')
                    ->setCellValue('F1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_blokrumah as $blokrum) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $blokrum->nama_pro)
                        ->setCellValue('C' . $kolom, $blokrum->nama_type)
                        ->setCellValue('D' . $kolom, $blokrum->nama_blok)
                        ->setCellValue('E' . $kolom, $blokrum->status)
                        ->setCellValue('F' . $kolom, $blokrum->keterangan);
            $kolom++;
            $nomor++;
        }
        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Blok Rumah');

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
        header('Content-Disposition: attachment;filename="Datablokrumah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editblokrumah($id_blok)
    {
        $this->form_validation->set_rules('nama_blok', 'Blok Rumah', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Blok Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['blokrumah'] = $this->db->get_where('m_blokrumah', ['id_blok' => $id_blok])->row_array();
            $data['data_pro'] = $this->blokrumah->getdataproyek();
            $data['data_type'] = $this->blokrumah->getdatatype();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datablokrumah/datablokrumah_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $proyek_id = $this->input->post('proyek_id');
            $type_id = $this->input->post('type_id');
            $nama_blok = $this->input->post('nama_blok');
            $status = $this->input->post('status');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('proyek_id', $proyek_id);
            $this->db->set('type_id', $type_id);
            $this->db->set('nama_blok', $nama_blok);
            $this->db->set('status', $status);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id_blok', $id_blok);
            $this->db->update('m_blokrumah');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datablokrumah');
        }
    }

    public function hapusblokrumah($id_blok)
    {
        $this->db->where('id_blok', $id_blok);
        $this->db->delete('m_blokrumah');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datablokrumah');
    }
} ?>