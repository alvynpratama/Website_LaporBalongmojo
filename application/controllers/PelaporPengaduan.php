<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_DB_query_builder $db
 * @property Pelapor_model $pelmo
 * @property PelaporPengaduan_model $pepemo
 */

class PelaporPengaduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelapor_model', 'pelmo');
        $this->load->model('PelaporPengaduan_model', 'pepemo');
        $this->pelmo->checkLoginUser();
    }

    public function index($status_pengaduan = '')
    {
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['title']      = 'Pengaduan';
        $data['pengaduan']  = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat($status_pengaduan, $data['dataUser']['id_masyarakat']);

        $this->load->view('templates/header-pelapor', $data);
        $this->load->view('pelapor_pengaduan/index', $data);
        $this->load->view('templates/footer-pelapor', $data);
    }

    public function addPelaporPengaduan()
    {
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['dusun']      = $this->db->get('dusun')->result_array();
        $data['title']      = 'Tambah Pengaduan';
        $data['validation_errors'] = ''; 

        $this->form_validation->set_rules('id_dusun', 'Dusun', 'required|trim|numeric');
        $this->form_validation->set_rules('isi_laporan', 'Isi Laporan', 'required|trim');

        if (!empty($_FILES['foto']['name'])) {
            $this->form_validation->set_rules('foto', 'Foto', 'callback__file_check');
        }

        if ($this->form_validation->run() == false) {
            $data['validation_errors'] = validation_errors(); 
            
            $this->load->view('templates/header-pelapor', $data);
            $this->load->view('pelapor_pengaduan/add_pelapor_pengaduan', $data);
            $this->load->view('templates/footer-pelapor', $data);
        } else {
            $foto_name = 'default.png';
            if (!empty($_FILES['foto']['name'])) {
                $foto_name = $this->upload->data('file_name');
            }

            $data_insert = [
                'isi_laporan'   => $this->input->post('isi_laporan', true),
                'id_dusun'      => $this->input->post('id_dusun', true),
                'id_masyarakat' => $data['dataUser']['id_masyarakat'],
                'tgl_pengaduan' => date('Y-m-d H:i:s'),
                'foto'          => $foto_name,
                'status_pengaduan' => 'belum_ditanggapi'
            ];
            
            $this->pepemo->addPelaporPengaduan($data_insert);
            
            $this->session->set_flashdata('message-success', 'Pengaduan berhasil ditambahkan!');
            redirect('pelaporPengaduan');
        }
    }

    public function _file_check()
    {
        $config['upload_path'] = './assets/img/img_pengaduan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
        $config['max_size'] = 2048; 

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            return true;
        } else {
            $this->form_validation->set_message('_file_check', $this->upload->display_errors('', ''));
            return false;
        }
    }


    public function editPelaporPengaduan($id_pengaduan)
    {
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['dusun']      = $this->db->get('dusun')->result_array();
        $data['pengaduan']  = $this->pepemo->getPengaduanById($id_pengaduan);
        $data['title']      = 'Ubah Pengaduan - ' . $data['pengaduan']['isi_laporan'];
        $data['validation_errors'] = ''; 

        if ($data['pengaduan']['status_pengaduan'] != 'belum_ditanggapi') {
            $this->session->set_flashdata('message-failed', 'Pengaduan tidak dapat diubah');
            redirect('pelaporPengaduan');
        }

        $this->form_validation->set_rules('id_dusun', 'Dusun', 'required|trim|numeric');
        $this->form_validation->set_rules('isi_laporan', 'Isi Laporan', 'required|trim');

        if (!empty($_FILES['foto']['name'])) {
            $this->form_validation->set_rules('foto', 'Foto', 'callback__file_check');
        }

        if ($this->form_validation->run() == false) {
            $data['validation_errors'] = validation_errors();
            $this->load->view('templates/header-pelapor', $data);
            $this->load->view('pelapor_pengaduan/edit_pelapor_pengaduan', $data);
            $this->load->view('templates/footer-pelapor', $data);
        } else {
            $data_update = [
                'isi_laporan' => $this->input->post('isi_laporan', true),
                'id_dusun'    => $this->input->post('id_dusun', true),
            ];

            if (!empty($_FILES['foto']['name'])) {
                $data_update['foto'] = $this->upload->data('file_name');
                $old_foto = $data['pengaduan']['foto'];
                if ($old_foto != 'default.png') {
                    unlink(FCPATH . 'assets/img/img_pengaduan/' . $old_foto);
                }
            }
            
            $this->pepemo->editPelaporPengaduan($id_pengaduan, $data_update);
            $this->session->set_flashdata('message-success', 'Pengaduan berhasil diubah!');
            redirect('pelaporPengaduan');
        }
    }

    public function removePelaporPengaduan($id_pengaduan)
    {
        $data['pengaduan']  = $this->pepemo->getPengaduanById($id_pengaduan);
        if ($tanggapan = $this->db->get_where('tanggapan', ['id_pengaduan' => $id_pengaduan])->row_array()) {
            if ($tanggapan['status_tanggapan'] != null) {
                $this->session->set_flashdata('message-failed', 'Pengaduan tidak dapat dihapus');
                redirect('pelaporPengaduan');
            }
        }
        $this->pepemo->removePelaporPengaduan($id_pengaduan);
    }
}