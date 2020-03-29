<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datakaryawan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Karyawan_model', 'karyawan');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_kar', 'Nama Karyawan', 'required|trim');
        $this->form_validation->set_rules('bagian_id', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Karyawan';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['karyawan'] = $this->db->get('vw_karyawan')->result_array();
            $data['data_bag'] = $this->karyawan->getdatabag();
            
            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datakaryawan/datakaryawan_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datakaryawan/datakaryawan', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'nama_kar' => $this->input->post('nama_kar', true),
                'bagian_id' => $this->input->post('bagian_id', true),
                'hp_no' => $this->input->post('hp_no', true),
                'alamat' => $this->input->post('alamat', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_karyawan', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datakaryawan');
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
        
        $semua_bagian = $this->karyawan->jointablekarbag()->result();
        $spreadsheet = new Spreadsheet;
        //Add Karyawan to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nama')
                    ->setCellValue('C1', 'Bagian ID')
                    ->setCellValue('D1', 'Nomor HP')
                    ->setCellValue('E1', 'Alamat')
                    ->setCellValue('F1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Karyawan');

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
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Bagian Karyawan');

        $kolom2 = 2;
        foreach($semua_bagian as $bag) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $bag->id_bag)
                        ->setCellValue('B' . $kolom2, $bag->nama_bag);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Bagian Karyawan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datakaryawan_template.xlsx"');
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
            redirect('datakaryawan');
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
                                    'nama_kar' => $row['B'],
                                    'bagian_id' => $row['C'],
                                    'alamat' => $row['D'],
                                    'hp_no' => $row['E'],
                                    'keterangan' => $row['F'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_karyawan', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datakaryawan');
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

        $semua_karyawan = $this->karyawan->jointablekaryawan()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nama')
                    ->setCellValue('C1', 'Bagian')
                    ->setCellValue('D1', 'Nomor HP')
                    ->setCellValue('E1', 'Alamat')
                    ->setCellValue('F1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_karyawan as $karyawan) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $karyawan->nama_kar)
                        ->setCellValue('C' . $kolom, $karyawan->nama_bag)
                        ->setCellValue('D' . $kolom, $karyawan->hp_no)
                        ->setCellValue('E' . $kolom, $karyawan->alamat)
                        ->setCellValue('F' . $kolom, $karyawan->keterangan);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Karyawan');

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
        header('Content-Disposition: attachment;filename="Datakaryawan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editkaryawan($id_kar)
    {
        $this->form_validation->set_rules('nama_kar', 'Nama Karyawan', 'required|trim');
        $this->form_validation->set_rules('bagian_id', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Karyawan';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['karyawan'] = $this->db->get_where('m_karyawan', ['id_kar' => $id_kar])->row_array();
            $data['data_bag'] = $this->karyawan->getdatabag();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datakaryawan/datakaryawan_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_kar = $this->input->post('nama_kar');
            $bagian_id = $this->input->post('bagian_id');
            $hp_no = $this->input->post('hp_no');
            $alamat = $this->input->post('alamat');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('nama_kar', $nama_kar);
            $this->db->set('bagian_id', $bagian_id);
            $this->db->set('hp_no', $hp_no);
            $this->db->set('alamat', $alamat);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id_kar', $id_kar);
            $this->db->update('m_karyawan');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datakaryawan');
        }
    }

    public function hapuskaryawan($id_kar)
    {
        $this->db->where('id_kar', $id_kar);
        $this->db->delete('m_karyawan');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datakaryawan');
    }
}