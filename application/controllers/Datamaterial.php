<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datamaterial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Material_model', 'material');
	}

    public function index()
    {
        $this->form_validation->set_rules('kode', 'Kode', 'required|trim');
        $this->form_validation->set_rules('nama_brg', 'Material', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Material';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['material'] = $this->db->get('vw_material')->result_array();
            $data['data_pek'] = $this->material->getdataPekerjaan();
            $data['kode_mat'] = $this->material->getKodematerial();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datamaterial/datamaterial_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datamaterial/datamaterial', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'kode' => $this->input->post('kode', true),
                'nama_brg' => $this->input->post('nama_brg', true),
                'pekerjaan_id' => $this->input->post('pekerjaan_id', true),
                'satuan' => $this->input->post('satuan', true),
                'harga' => $this->input->post('harga', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_material', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datamaterial');
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

        $semua_pekerjaan = $this->material->jointablepekerjaan()->result();
        $spreadsheet = new Spreadsheet;
        //Add Material to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Material')
                    ->setCellValue('C1', 'Pekerjaan ID')
                    ->setCellValue('D1', 'Material')
                    ->setCellValue('E1', 'Satuan')
                    ->setCellValue('F1', 'Harga')
                    ->setCellValue('G1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Material');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Pekerjaan');

        $kolom2 = 2;
        foreach($semua_pekerjaan as $pekerjaan) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $pekerjaan->id)
                        ->setCellValue('B' . $kolom2, $pekerjaan->pekerjaan);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerjaan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datamaterial_template.xlsx"');
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
            redirect('datamaterial');
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
                                    'kode' => $row['B'],
                                    'pekerjaan_id' => $row['C'],
                                    'nama_brg' => $row['D'],
                                    'satuan' => $row['E'],
                                    'harga' => $row['F'],
                                    'keterangan' => $row['G'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_material', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datamaterial');
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

        $semua_material = $this->material->jointablematerial()->result();
        $spreadsheet = new Spreadsheet;
        //Add Material to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Material')
                    ->setCellValue('C1', 'Pekerjaan')
                    ->setCellValue('D1', 'Material')
                    ->setCellValue('E1', 'Satuan')
                    ->setCellValue('F1', 'Harga')
                    ->setCellValue('G1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_material as $material) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $material->kode)
                        ->setCellValue('C' . $kolom, $material->pekerjaan)
                        ->setCellValue('D' . $kolom, $material->nama_brg)
                        ->setCellValue('E' . $kolom, $material->satuan)
                        ->setCellValue('F' . $kolom, $material->harga)
                        ->setCellValue('G' . $kolom, $material->keterangan);
            $kolom++;
            $nomor++;
        }
        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Material');

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datamaterial.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editmaterial($id)
    {
        $this->form_validation->set_rules('kode', 'Kode', 'required|trim');
        $this->form_validation->set_rules('nama_brg', 'Material', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Material';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['material'] = $this->db->get_where('m_material', ['id' => $id])->row_array();
            $data['data_pek'] = $this->material->getdataPekerjaan();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datamaterial/datamaterial_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $kode = $this->input->post('kode');
            $pekerjaan_id = $this->input->post('pekerjaan_id');
            $nama_brg = $this->input->post('nama_brg');
            $satuan = $this->input->post('satuan');
            $harga = $this->input->post('harga');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('kode', $kode);
            $this->db->set('pekerjaan_id', $pekerjaan_id);
            $this->db->set('nama_brg', $nama_brg);
            $this->db->set('satuan', $satuan);
            $this->db->set('harga', $harga);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id', $id);
            $this->db->update('m_material');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datamaterial');
        }
    }

    public function hapusmaterial($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_material');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('datamaterial');
    }
}
?>