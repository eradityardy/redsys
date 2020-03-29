<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Databank extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Bank_model', 'bank');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_bank', 'Bank', 'required|trim|is_unique[m_bank.nama_bank]', array(
            'is_unique' => 'Simpan Gagal! Bank sudah ada'
        ));
        $this->form_validation->set_rules('kode_bank', 'Kode Bank', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Bank';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['bank'] = $this->db->get('m_bank')->result_array();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/databank/databank_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/databank/databank', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'kode_bank' => $this->input->post('kode_bank', true),
                'nama_bank' => $this->input->post('nama_bank', true),
                'plafond_kredit' => $this->input->post('plafond_kredit', true),
                'dana_jaminan' => $this->input->post('dana_jaminan', true),
                'jangka_waktu' => $this->input->post('jangka_waktu', true),
            ];
            $this->db->insert('m_bank', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('databank');
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
                    ->setCellValue('B1', 'Kode Bank')
                    ->setCellValue('C1', 'Bank')
                    ->setCellValue('D1', 'Plafond Kredit')
                    ->setCellValue('E1', 'Dana Jaminan')
                    ->setCellValue('F1', 'Jangka Waktu (Hari)');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Bank');

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
        header('Content-Disposition: attachment;filename="Databank_template.xlsx"');
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
            redirect('databank');
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
                                    'kode_bank' => $row['B'],
                                    'nama_bank' => $row['C'],
                                    'plafond_kredit' => $row['D'],
                                    'dana_jaminan' => $row['E'],
                                    'jangka_waktu' => $row['F'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_bank', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('databank');
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

        $semua_bank = $this->bank->jointablebank()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Bank')
                    ->setCellValue('C1', 'Nama Bank')
                    ->setCellValue('D1', 'Plafond Kredit')
                    ->setCellValue('E1', 'Dana Jaminan')
                    ->setCellValue('F1', 'Jangka Waktu (Hari)');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_bank as $bank) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $bank->kode_bank)
                        ->setCellValue('C' . $kolom, $bank->nama_bank)
                        ->setCellValue('D' . $kolom, $bank->plafond_kredit)
                        ->setCellValue('E' . $kolom, $bank->dana_jaminan)
                        ->setCellValue('F' . $kolom, $bank->jangka_waktu);
            $kolom++;
            $nomor++;
        }
        $spreadsheet->getActiveSheet()->setTitle('Data Bank');

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
        header('Content-Disposition: attachment;filename="Databank.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function lihatbank($id_bank)
    {
        $cusbank = $this->bank->get_customerbank(" WHERE id_bank='$id_bank'")->row_array();
        $bank_id = $id_bank;
        $data = array(
            'title'=>'Detail Data Customer',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_bank'=>$cusbank['id_bank'],
            'kode_bank'=>$cusbank['kode_bank'],
            'nama_bank'=>$cusbank['nama_bank'],
            'detailcustomer'=>$this->bank->get_customerbank(" WHERE bank_id='$bank_id'")->result_array(),
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/databank/databank_detail.php', $data);
        $this->load->view('templates/footer');
    }

    public function editbank($id_bank)
    {
        $this->form_validation->set_rules('nama_bank', 'Bank', 'required|trim');
        $this->form_validation->set_rules('kode_bank', 'Kode Bank', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Bank';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['bank'] = $this->db->get_where('m_bank', ['id_bank' => $id_bank])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/databank/databank_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_bank = $this->input->post('nama_bank');
            $kode_bank = $this->input->post('kode_bank');
            $plafond_kredit = $this->input->post('plafond_kredit');
            $dana_jaminan = $this->input->post('dana_jaminan');
            $jangka_waktu = $this->input->post('jangka_waktu');

            $this->db->set('nama_bank', $nama_bank);
            $this->db->set('kode_bank', $kode_bank);
            $this->db->set('plafond_kredit', $plafond_kredit);
            $this->db->set('dana_jaminan', $dana_jaminan);
            $this->db->set('jangka_waktu', $jangka_waktu);

            $this->db->where('id_bank', $id_bank);
            $this->db->update('m_bank');
            $this->session->set_flashdata('message', 'Update data');
            redirect('databank');
        }
    }

    public function hapusbank($id_bank)
    {
        $this->db->where('id_bank', $id_bank);
        $this->db->delete('m_bank');
        $this->session->set_flashdata('message', 'Hapus bank');
        redirect('databank');
    }
}
?>