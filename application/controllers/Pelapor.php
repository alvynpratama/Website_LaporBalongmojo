<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelapor extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelapor_model', 'pelmo');
        $this->load->model('PelaporPengaduan_model', 'pepemo');
    }

    public function index()
    {
        // 1. Cek Login
        $this->pelmo->checkLoginUser();

        // 2. Ambil Data User yang sedang login
        $data['dataUser']   = $this->pelmo->getDataUser();
        $id_masyarakat      = $data['dataUser']['id_masyarakat'];

        // 3. Ambil Jumlah Data untuk Dashboard (Disesuaikan dengan teks di Database)
        // Perhatikan: Kita pakai 'count()' agar yang diambil adalah JUMLAH angka, bukan datanya.
        
        // Status: Belum ditanggapi
        $data_belum = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('Belum ditanggapi', $id_masyarakat);
        $data['pengaduan_belum_ditanggapi_pelapor'] = count($data_belum);

        // Status: Proses
        $data_proses = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('Proses', $id_masyarakat);
        $data['pengaduan_proses_pelapor'] = count($data_proses);

        // Status: Selesai
        $data_selesai = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('Selesai', $id_masyarakat);
        $data['pengaduan_selesai_pelapor'] = count($data_selesai);

        // Status: Tidak Valid / Ditolak (Sesuaikan dengan DB Anda, kadang namanya 'Ditolak' atau 'Tidak Valid')
        $data_tolak = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('Ditolak', $id_masyarakat);
        $data['pengaduan_tolak_pelapor'] = count($data_tolak);

        // 4. Load View
        $data['title']      = 'Dasbor';
        $this->load->view('templates/header-pelapor', $data);
        $this->load->view('pelapor/index', $data);
        $this->load->view('templates/footer-pelapor', $data);
    }

    // --- FUNGSI LAINNYA DI BAWAH INI BIARKAN SAMA SEPERTI SEBELUMNYA ---
    
    public function profile()
    {
        $this->pelmo->checkLoginUser();
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['title']      = 'Profil - ' . $data['dataUser']['username'];
        $this->load->view('templates/header-pelapor', $data);
        $this->load->view('pelapor/profile', $data);
        $this->load->view('templates/footer-pelapor', $data);
    }

    public function changePassword()
    {
        $this->pelmo->checkLoginUser();
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['title']      = 'Ganti Password - ' . $data['dataUser']['username'];
        $this->form_validation->set_rules('old_password', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|trim|min_length[3]|matches[verify_new_password]');
        $this->form_validation->set_rules('verify_new_password', 'Verifikasi Password Baru', 'required|trim|min_length[3]|matches[new_password]');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header-pelapor', $data);
            $this->load->view('pelapor/change_password', $data);
            $this->load->view('templates/footer-pelapor', $data);
        } else {
            $this->pelmo->changePassword();
        }
    }

    public function editProfile()
    {
        $this->pelmo->checkLoginUser();
        $data['dataUser']   = $this->pelmo->getDataUser();
        $data['title']      = 'Ubah Profil - ' . $data['dataUser']['username'];
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_telepon', 'No. Telepon', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header-pelapor', $data);
            $this->load->view('pelapor/edit_profile', $data);
            $this->load->view('templates/footer-pelapor', $data);
        } else {
            $this->pelmo->editProfile();
        }
    }
}
