<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rabpekerjaanbytype extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Rabpekerjaanbytype_model', 'rabpekbytype');
	}
    
    public function index()
    {
        $data['title'] = 'RAB Pekerjaan Type Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['rabpekbytype'] = $this->rabpekbytype->joinTableRabpekerjaanbytype()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/rabpekerjaanbytype/rabpekerjaanbytype', $data);
        $this->load->view('templates/footer');
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

        $semua_typerumah = $this->rabpekbytype->jointabletyperumah()->result();
        $semua_pekerjaan = $this->rabpekbytype->jointablepekerjaan()->result();
        $spreadsheet = new Spreadsheet;
        //Add Material to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Type Rumah ID')
                    ->setCellValue('C1', 'Pekerjaan ID')
                    ->setCellValue('D1', 'Harga');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('RAB Pekerjaan Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Type Rumah');

        $kolom2 = 2;
        foreach($semua_typerumah as $tyrum) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $tyrum->id_type)
                        ->setCellValue('B' . $kolom2, $tyrum->nama_type);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Pekerjaan')
                    ->setCellValue('C1', 'Harga');

        $kolom3 = 2;
        foreach($semua_pekerjaan as $pekerjaan) {
            $spreadsheet->setActiveSheetIndex(2)
                        ->setCellValue('A' . $kolom3, $pekerjaan->id)
                        ->setCellValue('B' . $kolom3, $pekerjaan->pekerjaan)
                        ->setCellValue('C' . $kolom3, $pekerjaan->std_harga);
            $kolom3++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerjaan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rabpekerjaanbytype_template.xlsx"');
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
            redirect('rabpekerjaanbytype');
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
                                    'type_id' => $row['B'],
                                    'pekerjaan_id' => $row['C'],
                                    'price' => $row['D'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_rab_pekerjaan_bytype', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('rabpekerjaanbytype');
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

        $semua_rabpekerjaan = $this->rabpekbytype->jointablerabpekerjaan()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Type Rumah')
                    ->setCellValue('C1', 'Pekerjaan')
                    ->setCellValue('D1', 'Harga');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_rabpekerjaan as $rabpek) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $rabpek->nama_type)
                        ->setCellValue('C' . $kolom, $rabpek->pekerjaan)
                        ->setCellValue('D' . $kolom, $rabpek->price);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('RAB Pekerjaan Type Rumah');

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
        header('Content-Disposition: attachment;filename="Rabpekerjaantyperumah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function detailrab($id_type)
    {
        $this->form_validation->set_rules('pekerjaan_id', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('type_id', 'Type Rumah', 'required|trim');
        $this->form_validation->set_rules('price', 'Harga Pekerjaan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'RAB Pekerjaan Type Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['detailrab'] = $this->rabpekbytype->show_pekerjaan_by_type_id($id_type)->result_array();
            $data['type_id'] = $id_type;
            $data['data_type'] = $this->rabpekbytype->getDatatype();
            $data['data_pekerjaan'] = $this->rabpekbytype->getDatapekerjaan();
            $data['typerum'] = $this->db->get_where('vw_rab_pekerjaan_by_typerumah_summary', ['id_type' => $id_type])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/rabpekerjaanbytype/rabpekerjaanbytype_lihat.php', $data);
            $this->load->view('templates/footer');
        } else {
            $type_id = $this->input->post('type_id');
            $pekerjaan_id = $this->input->post('pekerjaan_id');
            $price = $this->input->post('price');
            $data = array(
                'type_id'=>$type_id,
                'pekerjaan_id'=>$pekerjaan_id,
                'price'=>$price,
            );
            $cek = $this->db->query("SELECT * FROM m_rab_pekerjaan_bytype where type_id='".$this->input->post('type_id')."' AND pekerjaan_id='".$this->input->post('pekerjaan_id')."'")->num_rows();
            if ($cek<=0) {
                $this->rabpekbytype->add_rabpekerjaanbytype($data, 'm_rab_pekerjaan_bytype');
                $this->session->set_flashdata('message', 'Simpan data');
                redirect('rabpekerjaanbytype/detailrab/'.$type_id);
            }
            else {
                $this->session->set_flashdata('message', 'Pekerjaan sudah ada, Tidak tersimpan secara');
                redirect('rabpekerjaanbytype/detailrab/'.$type_id);
            }
        }
    }

    public function hapusrab($type_id, $id_rpbt)
    {
        $this->db->where('id_rpbt', $id_rpbt);
        $this->db->delete('m_rab_pekerjaan_bytype');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('rabpekerjaanbytype/detailrab/'.$type_id);
    }
} ?>