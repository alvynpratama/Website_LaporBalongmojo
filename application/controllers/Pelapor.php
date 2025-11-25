<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelapor extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pelapor_model', 'pelmo');
		$this->load->model('PelaporPengaduan_model', 'pepemo');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->pelmo->checkLoginUser();
		$data['dataUser'] = $this->pelmo->getDataUser();
		$id_masyarakat = $data['dataUser']['id_masyarakat'];

		$data['pengaduan_belum_ditanggapi_pelapor'] = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('belum_ditanggapi', $id_masyarakat);
		$data['pengaduan_proses_pelapor']           = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('proses', $id_masyarakat);
		$data['pengaduan_valid_pelapor']            = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('valid', $id_masyarakat);
		$data['pengaduan_pengerjaan_pelapor']       = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('pengerjaan', $id_masyarakat);
		$data['pengaduan_selesai_pelapor']          = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('selesai', $id_masyarakat);
		$data['pengaduan_tolak_pelapor']            = $this->pepemo->getPengaduanByStatusPengaduanByIdMasyarakat('tidak_valid', $id_masyarakat);

		$data['title'] = 'Dasbor';
		$this->load->view('templates/header-pelapor', $data);
		$this->load->view('pelapor/index', $data);
		$this->load->view('templates/footer-pelapor', $data);
	}

	public function hapusPengaduan($id_pengaduan)
	{
		$this->pelmo->checkLoginUser();
		$this->pepemo->removePelaporPengaduan($id_pengaduan);
		redirect('pelapor');
	}

	public function editPengaduan($id_pengaduan)
	{
		$this->pelmo->checkLoginUser();
		$data['dataUser'] = $this->pelmo->getDataUser();
		$data['title'] = 'Ubah Pengaduan';
		
		$data['pengaduan'] = $this->pepemo->getPengaduanById($id_pengaduan);

		$this->form_validation->set_rules('isi_laporan', 'Isi Laporan', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header-pelapor', $data);
			$this->load->view('pelapor/edit_pengaduan', $data);
			$this->load->view('templates/footer-pelapor', $data);
		} else {
			$data_update = [
				'isi_laporan' => $this->input->post('isi_laporan')
			];

			$upload_image = $_FILES['foto']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '5048'; 
				$config['upload_path']   = './assets/img/img_pengaduan/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('foto')) {
					$old_image = $data['pengaduan']['foto'];
					if ($old_image != 'default.png') {
						@unlink(FCPATH . 'assets/img/img_pengaduan/' . $old_image);
					}
					$new_image = $this->upload->data('file_name');
					$data_update['foto'] = $new_image;
				} else {
					echo $this->upload->display_errors();
				}
			}

			$this->pepemo->editPelaporPengaduan($id_pengaduan, $data_update);
			
			redirect('pelapor');
		}
	}

	public function profile()
	{
		$this->pelmo->checkLoginUser();
		$data['dataUser'] = $this->pelmo->getDataUser();
		$data['title'] = 'Profil - ' . $data['dataUser']['username'];
		$this->load->view('templates/header-pelapor', $data);
		$this->load->view('pelapor/profile', $data);
		$this->load->view('templates/footer-pelapor', $data);
	}

	public function changePassword()
	{
		$this->pelmo->checkLoginUser();
		$data['dataUser'] = $this->pelmo->getDataUser();
		$data['title'] = 'Ganti Password - ' . $data['dataUser']['username'];
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
		$data['dataUser'] = $this->pelmo->getDataUser();
		$data['title'] = 'Ubah Profil - ' . $data['dataUser']['username'];
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
