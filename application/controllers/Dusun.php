<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dusun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        if ($this->session->userdata('jabatan') != 'administrator') {
            redirect('auth/blocked');
        }
        
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Manajemen Data Dusun';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        
        $data['dusun'] = $this->db->get('dusun')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('dusun/index', $data); 
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $this->db->insert('dusun', ['nama_dusun' => $this->input->post('nama_dusun')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Dusun Berhasil Ditambahkan!</div>');
            redirect('dusun');
        }
    }

    public function hapus($id)
    {
        $this->db->delete('dusun', ['id_dusun' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Dusun Berhasil Dihapus!</div>');
        redirect('dusun');
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $this->db->where('id_dusun', $id);
            $this->db->update('dusun', ['nama_dusun' => $this->input->post('nama_dusun')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Dusun Berhasil Diubah!</div>');
            redirect('dusun');
        }
    }
}
