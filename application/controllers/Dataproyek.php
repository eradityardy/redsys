<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dataproyek extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Proyek_model', 'proyek');
	}
    
    public function index()
    {
        $this->form_validation->set_rules('kode', 'Kode Proyek', 'required|trim');
        $this->form_validation->set_rules('nama_pro', 'Nama Proyek', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi Proyek', 'required|trim');
        $this->form_validation->set_rules('owner', 'Pemilik Proyek', 'required|trim');
        $this->form_validation->set_rules('anggaran', 'Anggaran', 'required|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('status', 'Status Proyek', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Proyek';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['proyek'] = $this->db->get('m_proyek')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/dataproyek/dataproyek_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/dataproyek/dataproyek', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'kode' => $this->input->post('kode', true),
                'nama_pro' => $this->input->post('nama_pro', true),
                'lokasi' => $this->input->post('lokasi', true),
                'owner' => $this->input->post('owner', true),
                'anggaran' => $this->input->post('anggaran', true),
                'tgl_mulai' => $this->input->post('tgl_mulai', true),
                'tgl_selesai' => $this->input->post('tgl_selesai', true),
                'status' => $this->input->post('status', true),
            ];
            $this->db->insert('m_proyek', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('dataproyek');
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
        //Add Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Proyek')
                    ->setCellValue('C1', 'Nama Proyek')
                    ->setCellValue('D1', 'Lokasi')
                    ->setCellValue('E1', 'Pemilik')
                    ->setCellValue('F1', 'Anggaran')
                    ->setCellValue('G1', 'Tanggal Mulai (yyyy-mm-dd)')
                    ->setCellValue('H1', 'Tanggal Selesai (yyyy-mm-dd)')
                    ->setCellValue('I1', 'Status');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Proyek');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Dataproyek_template.xlsx"');
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
            redirect('dataproyek');
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
                                    'kode' => $row['B'],
                                    'nama_pro' => $row['C'],
                                    'lokasi' => $row['D'],
                                    'owner' => $row['E'],
                                    'anggaran' => $row['F'],
                                    'tgl_mulai' => $row['G'],
                                    'tgl_selesai' => $row['H'],
                                    'status' => $row['I'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_proyek', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('dataproyek');
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

        $semua_proyek = $this->proyek->jointableproyek()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Proyek')
                    ->setCellValue('C1', 'Nama Proyek')
                    ->setCellValue('D1', 'Lokasi')
                    ->setCellValue('E1', 'Owner')
                    ->setCellValue('F1', 'Anggaran')
                    ->setCellValue('G1', 'Tanggal Mulai')
                    ->setCellValue('H1', 'Tanggal Selesai')
                    ->setCellValue('I1', 'Status');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_proyek as $proyek) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $proyek->kode)
                        ->setCellValue('C' . $kolom, $proyek->nama_pro)
                        ->setCellValue('D' . $kolom, $proyek->lokasi)
                        ->setCellValue('E' . $kolom, $proyek->owner)
                        ->setCellValue('F' . $kolom, $proyek->anggaran)
                        ->setCellValue('G' . $kolom, date('Y m d', strtotime($proyek->tgl_mulai)))
                        ->setCellValue('H' . $kolom, date('Y m d', strtotime($proyek->tgl_selesai)))
                        ->setCellValue('I' . $kolom, $proyek->status);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Proyek');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Dataproyek.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    
    public function editproyek($id_pro)
    {
        $this->form_validation->set_rules('kode', 'Kode Proyek', 'required|trim');
        $this->form_validation->set_rules('nama_pro', 'Nama Proyek', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi Proyek', 'required|trim');
        $this->form_validation->set_rules('owner', 'Pemilik Proyek', 'required|trim');
        $this->form_validation->set_rules('anggaran', 'Anggaran', 'required|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('status', 'Status Proyek', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Proyek';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['proyek'] = $this->db->get_where('m_proyek', ['id_pro' => $id_pro])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/dataproyek/dataproyek_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $kode = $this->input->post('kode');
            $nama_pro = $this->input->post('nama_pro');
            $lokasi = $this->input->post('lokasi');
            $owner = $this->input->post('owner');
            $anggaran = $this->input->post('anggaran');
            $tgl_mulai = $this->input->post('tgl_mulai');
            $tgl_selesai = $this->input->post('tgl_selesai');
            $status = $this->input->post('status');

            $this->db->set('kode', $kode);
            $this->db->set('nama_pro', $nama_pro);
            $this->db->set('lokasi', $lokasi);
            $this->db->set('owner', $owner);
            $this->db->set('anggaran', $anggaran);
            $this->db->set('tgl_mulai', $tgl_mulai);
            $this->db->set('tgl_selesai', $tgl_selesai);
            $this->db->set('status', $status);

            $this->db->where('id_pro', $id_pro);
            $this->db->update('m_proyek');
            $this->session->set_flashdata('message', 'Update data');
            redirect('dataproyek');
        }
    }

    public function hapusproyek($id_pro)
    {
        $this->db->where('id_pro', $id_pro);
        $this->db->delete('m_proyek');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('dataproyek');
    }
}
?>