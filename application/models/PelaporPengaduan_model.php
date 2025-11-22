<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelaporPengaduan_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelapor_model', 'pelmo');
        $this->load->model('Log_model', 'lomo');
    }

    public function getPengaduanByIdMasyarakat($id_masyarakat)
    {
        $this->db->select('*, dusun.nama_dusun');
        $this->db->join('masyarakat', 'pengaduan.id_masyarakat=masyarakat.id_masyarakat');
        $this->db->join('dusun', 'pengaduan.id_dusun=dusun.id_dusun', 'left');
        $this->db->order_by('id_pengaduan', 'desc');
        return $this->db->get_where('pengaduan', ['pengaduan.id_masyarakat' => $id_masyarakat])->result_array();    
    }

    public function getPengaduanFilterByIdMasyarakat($dari_tgl, $sampai_tgl, $status_pengaduan, $id_masyarakat)
    {
        $dari_tgl = date("Y-m-d\T00:00:01", strtotime($dari_tgl));
        $sampai_tgl = date("Y-m-d\T23:59:59", strtotime($sampai_tgl));
        $this->db->select('*, dusun.nama_dusun');
        $this->db->join('masyarakat', 'pengaduan.id_masyarakat=masyarakat.id_masyarakat');
        $this->db->join('dusun', 'pengaduan.id_dusun=dusun.id_dusun', 'left');
        $this->db->order_by('id_pengaduan', 'desc');
        if ($status_pengaduan == 'semua') {
            return $this->db->get_where('pengaduan', ['tgl_pengaduan >=' => $dari_tgl, 'tgl_pengaduan <=' => $sampai_tgl, 'pengaduan.id_masyarakat' => $id_masyarakat])->result_array();
        } else {
            return $this->db->get_where('pengaduan', ['tgl_pengaduan >=' => $dari_tgl, 'tgl_pengaduan <=' => $sampai_tgl, 'status_pengaduan' => $status_pengaduan, 'pengaduan.id_masyarakat' => $id_masyarakat])->result_array();
        }
    }

    public function getPengaduanByStatusPengaduanByIdMasyarakat($status_pengaduan, $id_masyarakat)
    {
        $this->db->select('*, dusun.nama_dusun');
        $this->db->join('masyarakat', 'pengaduan.id_masyarakat=masyarakat.id_masyarakat');
        $this->db->join('dusun', 'pengaduan.id_dusun=dusun.id_dusun', 'left');
        $this->db->order_by('id_pengaduan', 'desc');
        if ($status_pengaduan) {
            return $this->db->get_where('pengaduan', ['pengaduan.status_pengaduan' => $status_pengaduan, 'pengaduan.id_masyarakat' => $id_masyarakat])->result_array();
        } else {
            return $this->db->get_where('pengaduan', ['pengaduan.id_masyarakat' => $id_masyarakat])->result_array();
        }
    }

    public function getPengaduanById($id_pengaduan)
    {
        $this->db->select('*, dusun.nama_dusun');
        $this->db->join('masyarakat', 'pengaduan.id_masyarakat=masyarakat.id_masyarakat');
        $this->db->join('dusun', 'pengaduan.id_dusun=dusun.id_dusun', 'left');
        return $this->db->get_where('pengaduan', ['pengaduan.id_pengaduan' => $id_pengaduan])->row_array();    
    }

    public function addPelaporPengaduan($data)
    {
        $this->db->insert('pengaduan', $data);
        $isi_log = 'Pengaduan ' . $data['isi_laporan'] . ' berhasil ditambahkan';
        $this->session->set_flashdata('message-success', $isi_log);
    }

    public function editPelaporPengaduan($id_pengaduan, $data_to_update)
    {
        $this->db->update('pengaduan', $data_to_update, ['id_pengaduan' => $id_pengaduan]);
        $isi_log = 'Pengaduan ' . $data_to_update['isi_laporan'] . ' berhasil diubah';
        $this->session->set_flashdata('message-success', $isi_log);
    }

    public function removePelaporPengaduan($id_pengaduan)
    {
        $data_pengaduan = $this->getPengaduanById($id_pengaduan);
        $pengaduan  = $data_pengaduan['isi_laporan'];
        
        $old_foto = $data_pengaduan['foto'];
        if ($old_foto != 'default.png') {
            unlink(FCPATH . 'assets/img/img_pengaduan/' . $data_pengaduan['foto']);
        }
        
        $this->db->delete('tanggapan', ['id_pengaduan' => $id_pengaduan]);
        $this->db->delete('pengaduan', ['id_pengaduan' => $id_pengaduan]);
        
        $isi_log = 'Pengaduan ' . $pengaduan . ' berhasil dihapus';
        $this->session->set_flashdata('message-success', $isi_log);
        redirect('pelaporPengaduan'); 
    }
}