<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dataunitrumah extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Unitrumah_model', 'unitrumah');
	}
    
    public function index()
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('luas_bangunan', 'Luas Bangunan', 'required|trim');
        $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'required|trim');
        $this->form_validation->set_rules('pekerja_id', 'Pekerja', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Unit Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['unitrumah'] = $this->db->get('vw_unitrumah')->result_array();
            $data['data_pro'] = $this->unitrumah->getdatapro();
            $data['data_blok'] = $this->unitrumah->getdatablok();
            $data['data_pek'] = $this->unitrumah->getdatapek();
            $data['data_pek_subkon'] = $this->unitrumah->getdatapeksubkon();
            $data['data_pek_kontraktor'] = $this->unitrumah->getdatapekkontraktor();
            $data['data_marketing'] = $this->unitrumah->getdatamarketing();
            $data['data_arsitek'] = $this->unitrumah->getdataarsitek();
            $data['data_pengawas'] = $this->unitrumah->getdatapengawas();
            
            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/dataunitrumah/dataunitrumah_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/dataunitrumah/dataunitrumah', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'proyek_id' => $this->input->post('proyek_id', true),
                'type_id' => $this->input->post('type_id', true),
                'blok_id' => $this->input->post('blok_id', true),
                'alamat' => $this->input->post('alamat', true),
                'luas_tanah' => $this->input->post('luas_tanah', true),
                'luas_bangunan' => $this->input->post('luas_bangunan', true),
                'status_pekerjaan' => $this->input->post('status_pekerjaan', true),
                'status_progress' => $this->input->post('status_progress', true),
                'status_beli' => $this->input->post('status_beli', true),
                'harga_rum' => $this->input->post('harga_rum', true),
                'mulai_bangun' => $this->input->post('mulai_bangun', true),
                'selesai_bangun' => $this->input->post('selesai_bangun', true),
                'tst_kunci' => $this->input->post('tst_kunci', true),
                'pekerja_id' => $this->input->post('pekerja_id', true),
                'marketing_id' => $this->input->post('marketing_id', true),
                'pengawas_id' => $this->input->post('pengawas_id', true),
                'arsitek_id' => $this->input->post('arsitek_id', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->db->insert('m_unitrumah', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('dataunitrumah');
        }
    }

    public function lihatunitrumah($id_unit)
    {
        $unitrumah = $this->unitrumah->get_unitrumah(" WHERE id_unit='$id_unit'")->row_array();
        $data = array(
            'title'=>'Detail Unit Rumah',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_unit'=>$unitrumah['id_unit'],
            'nama_type'=>$unitrumah['nama_type'],
            'nama_pro'=>$unitrumah['nama_pro'],
            'nama_blok'=>$unitrumah['nama_blok'],
            'alamat'=>$unitrumah['alamat'],
            'luas_tanah'=>$unitrumah['luas_tanah'],
            'luas_bangunan'=>$unitrumah['luas_bangunan'],
            'status_pekerjaan'=>$unitrumah['status_pekerjaan'],
            'status_progress'=>$unitrumah['status_progress'],
            'status_beli'=>$unitrumah['status_beli'],
            'mulai_bangun'=>$unitrumah['mulai_bangun'],
            'selesai_bangun'=>$unitrumah['selesai_bangun'],
            'tst_kunci'=>$unitrumah['tst_kunci'],
            'nama_pek'=>$unitrumah['nama_pek'],
            'keterangan'=>$unitrumah['keterangan'],
            'harga_rum'=>$unitrumah['harga_rum'],
            'status'=>$unitrumah['status'],
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/dataunitrumah/dataunitrumah_detail.php', $data);
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

        $semua_proyek = $this->unitrumah->jointableproyek()->result();
        $semua_typerumah = $this->unitrumah->jointabletyperumah()->result();
        $semua_blokrumah = $this->unitrumah->jointableblokrumah()->result();
        $semua_pekerja = $this->unitrumah->jointablepekerja()->result();
        $semua_karyawan = $this->unitrumah->jointablekaryawan()->result();
        $spreadsheet = new Spreadsheet;
        //Add Blok Rumah to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Proyek ID')
                    ->setCellValue('C1', 'Type Rumah ID')
                    ->setCellValue('D1', 'Blok Rumah ID')
                    ->setCellValue('E1', 'Pekerja ID')
                    ->setCellValue('F1', 'Marketing ID')
                    ->setCellValue('G1', 'Pengawas ID')
                    ->setCellValue('H1', 'Arsitek ID')
                    ->setCellValue('I1', 'Alamat')
                    ->setCellValue('J1', 'Luas Tanah')
                    ->setCellValue('K1', 'Luas Bangunan')
                    ->setCellValue('L1', 'Status Pekerjaan')
                    ->setCellValue('M1', 'Status Progress')
                    ->setCellValue('N1', 'Status Beli')
                    ->setCellValue('O1', 'Harga Rumah')
                    ->setCellValue('P1', 'Mulai Bangun (YYYY-MM-DD)')
                    ->setCellValue('Q1', 'Selesai Bangun (YYYY-MM-DD)')
                    ->setCellValue('R1', 'Serah Terima Kunci (YYYY-MM-DD)')
                    ->setCellValue('S1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Unit Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('L1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('N1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('O1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('P1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('Q1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('R1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('S1')->applyFromArray($styleArray);
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
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(3)
                    ->setCellValue('A1', 'ID Blok Rumah')
                    ->setCellValue('B1', 'Blok Rumah');

        $kolom4 = 2;
        foreach($semua_blokrumah as $blokrum) {
            $spreadsheet->setActiveSheetIndex(3)
                        ->setCellValue('A' . $kolom4, $blokrum->id_blok)
                        ->setCellValue('B' . $kolom4, $blokrum->nama_blok);
            $kolom4++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Blok Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(4)
                    ->setCellValue('A1', 'ID Pekerja')
                    ->setCellValue('B1', 'Nama Pekerja')
                    ->setCellValue('C1', 'Status');

        $kolom5 = 2;
        foreach($semua_pekerja as $pekerja) {
            $spreadsheet->setActiveSheetIndex(4)
                        ->setCellValue('A' . $kolom5, $pekerja->id_pek)
                        ->setCellValue('B' . $kolom5, $pekerja->nama_pek)
                        ->setCellValue('C' . $kolom5, $pekerja->status);
            $kolom5++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Pekerja');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(5)
                    ->setCellValue('A1', 'ID Karyawan')
                    ->setCellValue('B1', 'Divisi')
                    ->setCellValue('C1', 'Nama Karyawan');

        $kolom6 = 2;
        foreach($semua_karyawan as $karyawan) {
            $spreadsheet->setActiveSheetIndex(5)
                        ->setCellValue('A' . $kolom6, $karyawan->id_kar)
                        ->setCellValue('B' . $kolom6, $karyawan->nama_bag)
                        ->setCellValue('C' . $kolom6, $karyawan->nama_kar);
            $kolom6++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Karyawan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Dataunitrumah_template.xlsx"');
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
            redirect('dataunitrumah');
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
                                    'blok_id' => $row['D'],
                                    'pekerja_id' => $row['E'],
                                    'marketing_id' => $row['F'],
                                    'pengawas_id' => $row['G'],
                                    'arsitek_id' => $row['H'],
                                    'alamat' => $row['I'],
                                    'luas_tanah' => $row['J'],
                                    'luas_bangunan' => $row['K'],
                                    'status_pekerjaan' => $row['L'],
                                    'status_progress' => $row['M'],
                                    'status_beli' => $row['N'],
                                    'harga_rum' => $row['O'],
                                    'mulai_bangun' => $row['P'],
                                    'selesai_bangun' => $row['Q'],
                                    'tst_kunci' => $row['R'],
                                    'keterangan' => $row['S'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_unitrumah', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('dataunitrumah');
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

        $semua_unitrumah = $this->unitrumah->joinTableUnRum()->result();
        $semua_karyawan = $this->unitrumah->jointablekaryawan()->result();
        $spreadsheet = new Spreadsheet;
        //Add Blok Rumah to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Proyek')
                    ->setCellValue('C1', 'Type Rumah')
                    ->setCellValue('D1', 'Blok Rumah')
                    ->setCellValue('E1', 'Pekerja')
                    ->setCellValue('F1', 'Marketing ID')
                    ->setCellValue('G1', 'Pengawas ID')
                    ->setCellValue('H1', 'Arsitek ID')
                    ->setCellValue('I1', 'Alamat')
                    ->setCellValue('J1', 'Luas Tanah')
                    ->setCellValue('K1', 'Luas Bangunan')
                    ->setCellValue('L1', 'Status Pekerjaan')
                    ->setCellValue('M1', 'Status Progress')
                    ->setCellValue('N1', 'Status Beli')
                    ->setCellValue('O1', 'Harga Rumah')
                    ->setCellValue('P1', 'Mulai Bangun')
                    ->setCellValue('Q1', 'Selesai Bangun')
                    ->setCellValue('R1', 'Serah Terima Kunci')
                    ->setCellValue('S1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_unitrumah as $unit) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $unit->nama_pro)
                        ->setCellValue('C' . $kolom, $unit->nama_type)
                        ->setCellValue('D' . $kolom, $unit->nama_blok)
                        ->setCellValue('E' . $kolom, $unit->nama_pek)
                        ->setCellValue('F' . $kolom, $unit->marketing_id)
                        ->setCellValue('G' . $kolom, $unit->pengawas_id)
                        ->setCellValue('H' . $kolom, $unit->arsitek_id)
                        ->setCellValue('I' . $kolom, $unit->alamat)
                        ->setCellValue('J' . $kolom, $unit->luas_tanah)
                        ->setCellValue('K' . $kolom, $unit->luas_bangunan)
                        ->setCellValue('L' . $kolom, $unit->status_pekerjaan)
                        ->setCellValue('M' . $kolom, $unit->status_progress)
                        ->setCellValue('N' . $kolom, $unit->status_beli)
                        ->setCellValue('O' . $kolom, $unit->harga_rum)
                        ->setCellValue('P' . $kolom, date('Y m d', strtotime($unit->mulai_bangun)))
                        ->setCellValue('Q' . $kolom, date('Y m d', strtotime($unit->selesai_bangun)))
                        ->setCellValue('R' . $kolom, date('Y m d', strtotime($unit->tst_kunci)))
                        ->setCellValue('S' . $kolom, $unit->keterangan);
            $kolom++;
            $nomor++;
        }
        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Unit Rumah');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('L1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('N1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('O1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('P1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('Q1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('R1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('S1')->applyFromArray($styleArray);
        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'ID Karyawan')
                    ->setCellValue('B1', 'Divisi')
                    ->setCellValue('C1', 'Nama Karyawan');

        $kolom2 = 2;
        foreach($semua_karyawan as $karyawan) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $karyawan->id_kar)
                        ->setCellValue('B' . $kolom2, $karyawan->nama_bag)
                        ->setCellValue('C' . $kolom2, $karyawan->nama_kar);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Karyawan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Dataunitrumah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editunitrumah($id_unit)
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Unit Rumah';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['unitrumah'] = $this->db->get_where('m_unitrumah', ['id_unit' => $id_unit])->row_array();
            $data['data_pro'] = $this->unitrumah->getdatapro();
            $data['data_blok'] = $this->unitrumah->getdatablok();
            $data['data_pek'] = $this->unitrumah->getdatapek();
            $data['data_marketing'] = $this->unitrumah->getdatamarketing();
            $data['data_arsitek'] = $this->unitrumah->getdataarsitek();
            $data['data_pengawas'] = $this->unitrumah->getdatapengawas();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/dataunitrumah/dataunitrumah_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $proyek_id = $this->input->post('proyek_id');
            $type_id = $this->input->post('type_id');
            $blok_id = $this->input->post('blok_id');
            $alamat = $this->input->post('alamat');
            $luas_bangunan = $this->input->post('luas_bangunan');
            $luas_tanah = $this->input->post('luas_tanah');
            $status_pekerjaan = $this->input->post('status_pekerjaan');
            $status_progress = $this->input->post('status_progress');
            $status_beli = $this->input->post('status_beli');
            $harga_rum = $this->input->post('harga_rum');
            $mulai_bangun = $this->input->post('mulai_bangun');
            $selesai_bangun = $this->input->post('selesai_bangun');
            $tst_kunci = $this->input->post('tst_kunci');
            $pekerja_id = $this->input->post('pekerja_id');
            $pengawas_id = $this->input->post('pengawas_id');
            $arsitek_id = $this->input->post('arsitek_id');
            $marketing_id = $this->input->post('marketing_id');
            $keterangan = $this->input->post('keterangan');

            $this->db->set('proyek_id', $proyek_id);
            $this->db->set('type_id', $type_id);
            $this->db->set('blok_id', $blok_id);
            $this->db->set('alamat', $alamat);
            $this->db->set('luas_bangunan', $luas_bangunan);
            $this->db->set('luas_tanah', $luas_tanah);
            $this->db->set('status_pekerjaan', $status_pekerjaan);
            $this->db->set('status_progress', $status_progress);
            $this->db->set('status_beli', $status_beli);
            $this->db->set('harga_rum', $harga_rum);
            $this->db->set('mulai_bangun', $mulai_bangun);
            $this->db->set('selesai_bangun', $selesai_bangun);
            $this->db->set('tst_kunci', $tst_kunci);
            $this->db->set('pekerja_id', $pekerja_id);
            $this->db->set('pengawas_id', $pengawas_id);
            $this->db->set('arsitek_id', $arsitek_id);
            $this->db->set('marketing_id', $marketing_id);
            $this->db->set('keterangan', $keterangan);

            $this->db->where('id_unit', $id_unit);
            $this->db->update('m_unitrumah');
            $this->session->set_flashdata('message', 'Update data');
            redirect('dataunitrumah');
        }
    }

    public function hapusunitrumah($id_unit)
    {
        $this->db->where('id_unit', $id_unit);
        $this->db->delete('m_unitrumah');
        $this->session->set_flashdata('message', 'Hapus data');
        redirect('dataunitrumah');
    }
} ?>