<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rabmaterialbytype extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper('url');
        $this->load->model('Rabmaterialbytype_model', 'rabmatbytype');
	}
    
    public function index()
    {
        $data['title'] = 'RAB Material Type Rumah';
        $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['rabmatbytype'] = $this->rabmatbytype->joinTableRabmaterialbytype()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/rabmaterialbytype/rabmaterialbytype', $data);
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

        $semua_typerumah = $this->rabmatbytype->jointabletyperumah()->result();
        $semua_material = $this->rabmatbytype->jointablematerial()->result();
        $spreadsheet = new Spreadsheet;
        //Add Material to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Type Rumah ID')
                    ->setCellValue('C1', 'Material ID')
                    ->setCellValue('D1', 'Quantity')
                    ->setCellValue('E1', 'Harga');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('RAB Material Type Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
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
                    ->setCellValue('C1', 'Material')
                    ->setCellValue('D1', 'Harga');

        $kolom3 = 2;
        foreach($semua_material as $material) {
            $spreadsheet->setActiveSheetIndex(2)
                        ->setCellValue('A' . $kolom3, $material->id)
                        ->setCellValue('B' . $kolom3, $material->pekerjaan)
                        ->setCellValue('C' . $kolom3, $material->nama_brg)
                        ->setCellValue('D' . $kolom3, $material->harga);
            $kolom3++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Material');

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
        header('Content-Disposition: attachment;filename="Rabmaterialbytype_template.xlsx"');
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
            redirect('rabmaterialbytype');
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
                                    'material_id' => $row['C'],
                                    'qty' => $row['D'],
                                    'price' => $row['E'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_rab_material_bytype', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('rabmaterialbytype');
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

        $semua_rabmaterial = $this->rabmatbytype->jointablerabmaterial()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Type Rumah')
                    ->setCellValue('C1', 'Material')
                    ->setCellValue('D1', 'Quantity')
                    ->setCellValue('E1', 'Satuan')
                    ->setCellValue('F1', 'Harga');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_rabmaterial as $rabmat) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $rabmat->nama_type)
                        ->setCellValue('C' . $kolom, $rabmat->nama_brg)
                        ->setCellValue('D' . $kolom, $rabmat->qty)
                        ->setCellValue('E' . $kolom, $rabmat->satuan)
                        ->setCellValue('F' . $kolom, $rabmat->price);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('RAB Material Type Rumah');

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
        header('Content-Disposition: attachment;filename="Rabmaterialtyperumah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function detailrab($id_type)
    {
        $this->form_validation->set_rules('type_id', 'Type Rumah', 'required|trim');
        $this->form_validation->set_rules('material_id', 'Material', 'required|trim');
        $this->form_validation->set_rules('qty', 'Quantity Material', 'required|trim');
        $this->form_validation->set_rules('price', 'Harga Material', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'RAB Material Type Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['detailrab'] = $this->rabmatbytype->show_material_by_type_id($id_type)->result_array();
            $data['type_id'] = $id_type;
            $data['data_type'] = $this->rabmatbytype->getDatatype();
            $data['data_material'] = $this->rabmatbytype->getDatamaterial();
            $data['typerum'] = $this->db->get_where('vw_rab_material_by_typerumah_summary', ['id_type' => $id_type])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/rabmaterialbytype/rabmaterialbytype_lihat.php', $data);
            $this->load->view('templates/footer');
        } else {
            $type_id = $this->input->post('type_id');
            $material_id = $this->input->post('material_id');
            $qty = $this->input->post('qty');
            $price = $this->input->post('price');
            $data = array(
                'type_id'=>$type_id,
                'material_id'=>$material_id,
                'price'=>$price,
                'qty'=>$qty,
            );
            $cek = $this->db->query("SELECT * FROM m_rab_material_bytype where type_id='".$this->input->post('type_id')."' AND material_id='".$this->input->post('material_id')."'")->num_rows();
            if ($cek<=0) {
                $this->rabmatbytype->add_rabmaterialbytype($data, 'm_rab_material_bytype');
                $this->session->set_flashdata('message', 'Simpan data');
                redirect('rabmaterialbytype/detailrab/'.$type_id);
            }
            else {
                $this->session->set_flashdata('message', 'Material sudah ada, Tidak tersimpan secara');
                redirect('rabmaterialbytype/detailrab/'.$type_id);
            }
        }
    }

    public function hapusrab($type_id, $id_rmbt)
    {
        $this->db->where('id_rmbt', $id_rmbt);
        $this->db->delete('m_rab_material_bytype');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('rabmaterialbytype/detailrab/'.$type_id);
    }
} ?>