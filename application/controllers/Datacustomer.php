<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datacustomer extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        
        is_logged_in();
        $this->load->helper('tglindo');
        $this->load->helper('rupiah');
        $this->load->helper(array('url', 'download'));
        $this->load->model('Customer_model', 'customer');
	}

    public function index()
    {
        $this->form_validation->set_rules('nama_cus', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Customer';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['customer'] = $this->db->get('m_customer')->result_array();
            $data['data_bank'] = $this->customer->getdataBank();
            $data['data_mark'] = $this->customer->getdataMarketing();
            $data['data_unit'] = $this->customer->getdataUnit();

            if($this->session->userdata('role') == 'operator'){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datacustomer/datacustomer_operator', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('masters/datacustomer/datacustomer', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $data = [
                'nama_cus' => $this->input->post('nama_cus', true),
                'hp_no' => $this->input->post('hp_no', true),
                'telp_no' => $this->input->post('telp_no', true),
                'alamat' => $this->input->post('alamat', true),
                'no_ktp' => $this->input->post('no_ktp', true),
                'no_npwp' => $this->input->post('no_npwp', true),
                'tmpt_kerja' => $this->input->post('tmpt_kerja', true),
                'nama_pasangan' => $this->input->post('nama_pasangan', true),
                'hp_no_pasangan' => $this->input->post('hp_no_pasangan', true),
                'no_ktp_pasangan' => $this->input->post('no_ktp_pasangan', true),
                'no_kk' => $this->input->post('no_kk', true),
                'keterangan' => $this->input->post('keterangan', true),
                'alamat_kerja' => $this->input->post('alamat_kerja', true),
                'unitrumah_id' => $this->input->post('unitrumah_id', true),
                'bank_id' => $this->input->post('bank_id', true),
                'marketing_id' => $this->input->post('marketing_id', true),
            ];
            $this->db->insert('m_customer', $data);
            $this->session->set_flashdata('message', 'Simpan data');
            redirect('datacustomer');
        }
    }

    public function lihatcustomer($id_cus)
    {
        $customer = $this->customer->get_customer(" WHERE id_cus='$id_cus'")->row_array();
        $data = array(
            'title'=>'Detail Customer',
            'users'=>$this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array(),
            'id_cus'=>$customer['id_cus'],
            'nama_cus'=>$customer['nama_cus'],
            'alamat_tinggal'=>$customer['alamat_tinggal'],
            'no_ktp'=>$customer['no_ktp'],
            'no_npwp'=>$customer['no_npwp'],
            'hp_no'=>$customer['hp_no'],
            'telp_no'=>$customer['telp_no'],
            'keterangan'=>$customer['keterangan'],
            'tmpt_kerja'=>$customer['tmpt_kerja'],
            'alamat_kerja'=>$customer['alamat_kerja'],
            'nama_pasangan'=>$customer['nama_pasangan'],
            'no_ktp_pasangan'=>$customer['no_ktp_pasangan'],
            'hp_no_pasangan'=>$customer['hp_no_pasangan'],
            'no_kk'=>$customer['no_kk'],
            'nama_bank'=>$customer['nama_bank'],
            'alamat'=>$customer['alamat'],
            'nama_kar'=>$customer['nama_kar'],
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('masters/datacustomer/datacustomer_detail.php', $data);
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
        
        $semua_bank = $this->customer->jointablebank()->result();
        $semua_marketing = $this->customer->jointablemarketing()->result();
        $semua_unitrumah = $this->customer->jointableunitrumah()->result();
        $spreadsheet = new Spreadsheet;
        //Add Customer to Sheet
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Bank ID')
                    ->setCellValue('C1', 'Unit Rumah ID')
                    ->setCellValue('D1', 'Marketing ID')
                    ->setCellValue('E1', 'Nama Customer')
                    ->setCellValue('F1', 'Alamat')
                    ->setCellValue('G1', 'Nomor KTP')
                    ->setCellValue('H1', 'Nomor NPWP')
                    ->setCellValue('I1', 'Nomor HP')
                    ->setCellValue('J1', 'Nomor Telephone')
                    ->setCellValue('K1', 'Tempat Kerja')
                    ->setCellValue('L1', 'Alamat Kantor')
                    ->setCellValue('M1', 'Nama Pasangan')
                    ->setCellValue('N1', 'Nomor KTP Pasangan')
                    ->setCellValue('O1', 'Nomor HP Pasangan')
                    ->setCellValue('P1', 'Nomor KK')
                    ->setCellValue('Q1', 'Keterangan');

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Customer');

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

        //------------------------------------------------------------------------------------------------------------//
        // Buat Sheet
        $spreadsheet->createSheet();
        // Add data
        $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'ID Bank')
                    ->setCellValue('B1', 'Kode Bank')
                    ->setCellValue('C1', 'Bank');

        $kolom2 = 2;
        foreach($semua_bank as $bank) {
            $spreadsheet->setActiveSheetIndex(1)
                        ->setCellValue('A' . $kolom2, $bank->id_bank)
                        ->setCellValue('B' . $kolom2, $bank->kode_bank)
                        ->setCellValue('C' . $kolom2, $bank->nama_bank);
            $kolom2++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Bank');

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
        $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('A1', 'ID Unit Rumah')
                    ->setCellValue('B1', 'Proyek')
                    ->setCellValue('C1', 'Type Rumah')
                    ->setCellValue('D1', 'Blok Rumah')
                    ->setCellValue('E1', 'Unit Rumah');

        $kolom3 = 2;
        foreach($semua_unitrumah as $unit) {
            $spreadsheet->setActiveSheetIndex(2)
                        ->setCellValue('A' . $kolom3, $unit->id_unit)
                        ->setCellValue('B' . $kolom3, $unit->nama_pro)
                        ->setCellValue('C' . $kolom3, $unit->nama_type)
                        ->setCellValue('D' . $kolom3, $unit->nama_blok)
                        ->setCellValue('E' . $kolom3, $unit->alamat);
            $kolom3++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Unit Rumah');

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
        $spreadsheet->setActiveSheetIndex(3)
                    ->setCellValue('A1', 'ID Marketing')
                    ->setCellValue('B1', 'Nama Marketing');

        $kolom4 = 2;
        foreach($semua_marketing as $marketing) {
            $spreadsheet->setActiveSheetIndex(3)
                        ->setCellValue('A' . $kolom4, $marketing->id_kar)
                        ->setCellValue('B' . $kolom4, $marketing->nama_kar);
            $kolom4++;
        }
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Data Marketing');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datacustomer_template.xlsx"');
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
            redirect('datacustomer');
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
                                    'bank_id' => $row['B'],
                                    'unitrumah_id' => $row['C'],
                                    'marketing_id' => $row['D'],
                                    'nama_cus' => $row['E'],
                                    'alamat' => $row['F'],
                                    'no_ktp' => $row['G'],
                                    'no_npwp' => $row['H'],
                                    'hp_no' => $row['I'],
                                    'telp_no' => $row['J'],
                                    'tmpt_kerja' => $row['K'],
                                    'alamat_kerja' => $row['L'],
                                    'nama_pasangan' => $row['M'],
                                    'no_ktp_pasangan' => $row['N'],
                                    'hp_no_pasangan' => $row['O'],
                                    'no_kk' => $row['P'],
                                    'keterangan' => $row['Q'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('m_customer', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('datacustomer');
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

        $semua_customer = $this->customer->jointablecustomer()->result();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Bank')
                    ->setCellValue('C1', 'Unit Rumah')
                    ->setCellValue('D1', 'Nama Marketing')
                    ->setCellValue('E1', 'Nama Customer')
                    ->setCellValue('F1', 'Alamat')
                    ->setCellValue('G1', 'Nomor KTP')
                    ->setCellValue('H1', 'Nomor NPWP')
                    ->setCellValue('I1', 'Nomor HP')
                    ->setCellValue('J1', 'Nomor Telephone')
                    ->setCellValue('K1', 'Tempat Kerja')
                    ->setCellValue('L1', 'Alamat Kantor')
                    ->setCellValue('M1', 'Nama Pasangan')
                    ->setCellValue('N1', 'Nomor KTP Pasangan')
                    ->setCellValue('O1', 'Nomor HP Pasangan')
                    ->setCellValue('P1', 'Nomor KK')
                    ->setCellValue('Q1', 'Keterangan');

        $kolom = 2;
        $nomor = 1;
        foreach($semua_customer as $customer) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $customer->nama_bank)
                        ->setCellValue('C' . $kolom, $customer->alamat)
                        ->setCellValue('D' . $kolom, $customer->nama_kar)
                        ->setCellValue('E' . $kolom, $customer->nama_cus)
                        ->setCellValue('F' . $kolom, $customer->alamat_tinggal)
                        ->setCellValue('G' . $kolom, $customer->no_ktp)
                        ->setCellValue('H' . $kolom, $customer->no_npwp)
                        ->setCellValue('I' . $kolom, $customer->hp_no)
                        ->setCellValue('J' . $kolom, $customer->telp_no)
                        ->setCellValue('K' . $kolom, $customer->tmpt_kerja)
                        ->setCellValue('L' . $kolom, $customer->alamat_kerja)
                        ->setCellValue('M' . $kolom, $customer->nama_pasangan)
                        ->setCellValue('N' . $kolom, $customer->no_ktp_pasangan)
                        ->setCellValue('O' . $kolom, $customer->hp_no_pasangan)
                        ->setCellValue('P' . $kolom, $customer->no_kk)
                        ->setCellValue('Q' . $kolom, $customer->keterangan);
            $kolom++;
            $nomor++;
        }

        // Rename Sheet
        $spreadsheet->getActiveSheet()->setTitle('Data Customer');

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
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Datacustomer.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function editcustomer($id_cus)
    {
        $this->form_validation->set_rules('nama_cus', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('hp_no', 'Nomor HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Customer';
            $data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
            $data['customer'] = $this->db->get_where('m_customer', ['id_cus' => $id_cus])->row_array();
            $data['data_bank'] = $this->customer->getdataBank();
            $data['data_mark'] = $this->customer->getdataMarketing();
            $data['data_unit'] = $this->customer->getdataUnit();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('masters/datacustomer/datacustomer_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_cus = $this->input->post('nama_cus');
            $hp_no = $this->input->post('hp_no');
            $telp_no = $this->input->post('telp_no');
            $no_ktp = $this->input->post('no_ktp');
            $no_npwp = $this->input->post('no_npwp');
            $tmpt_kerja = $this->input->post('tmpt_kerja');
            $nama_pasangan = $this->input->post('nama_pasangan');
            $hp_no_pasangan = $this->input->post('hp_no_pasangan');
            $no_ktp_pasangan = $this->input->post('no_ktp_pasangan');
            $no_kk = $this->input->post('no_kk');
            $alamat = $this->input->post('alamat');
            $keterangan = $this->input->post('keterangan');
            $alamat_kerja = $this->input->post('alamat_kerja');
            $unitrumah_id = $this->input->post('unitrumah_id');
            $marketing_id = $this->input->post('marketing_id');
            $bank_id = $this->input->post('bank_id');

            $this->db->set('nama_cus', $nama_cus);
            $this->db->set('hp_no', $hp_no);
            $this->db->set('telp_no', $telp_no);
            $this->db->set('no_ktp', $no_ktp);
            $this->db->set('no_npwp', $no_npwp);
            $this->db->set('tmpt_kerja', $tmpt_kerja);
            $this->db->set('nama_pasangan', $nama_pasangan);
            $this->db->set('hp_no_pasangan', $hp_no_pasangan);
            $this->db->set('no_ktp_pasangan', $no_ktp_pasangan);
            $this->db->set('no_kk', $no_kk);
            $this->db->set('alamat', $alamat);
            $this->db->set('keterangan', $keterangan);
            $this->db->set('alamat_kerja', $alamat_kerja);
            $this->db->set('unitrumah_id', $unitrumah_id);
            $this->db->set('marketing_id', $marketing_id);
            $this->db->set('bank_id', $bank_id);

            $this->db->where('id_cus', $id_cus);
            $this->db->update('m_customer');
            $this->session->set_flashdata('message', 'Update data');
            redirect('datacustomer');
        }
    }

    public function hapuscustomer($id_cus)
    {
        $this->db->where('id_cus', $id_cus);
        $this->db->delete('m_customer');
        $this->session->set_flashdata('message', 'Hapus customer');
        redirect('datacustomer');
    }
}