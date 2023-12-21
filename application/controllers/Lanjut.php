<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lanjut extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        }

        $this->load->model('Modeldata', 'model');

        $this->tahun = $this->session->userdata('tahun');
    }

    public function index()
    {
        $data['user'] = $this->Auth_model->current_user();
        $data['susil'] = $this->model->getBy2('penerima_potong', 'kode_potong', 'susil', 'tahun', $this->tahun)->result();
        $data['kembang'] = $this->model->getBy2('penerima_potong', 'kode_potong', 'kembang', 'tahun', $this->tahun)->result();
        $data['sarpras'] = $this->model->getBy2('penerima_potong', 'kode_potong', 'sarpras', 'tahun', $this->tahun)->result();

        $this->load->view('lanjut', $data);
    }

    public function addPenerimaPotong()
    {
        $data = [
            "nama" => htmlspecialchars($this->input->post("nama", true)),
            "jumlah" => htmlspecialchars($this->input->post("jumlah", true)),
            "kode_potong" => htmlspecialchars($this->input->post("kode_potong", true)),
            "tahun" => $this->tahun
        ];

        $this->model->simpan('penerima_potong', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data penerima berhasil ditambahkan');
            redirect('lanjut');
        } else {
            $this->session->set_flashdata('error', 'Data penerima gagal ditambahkan');
            redirect('lanjut');
        }
    }

    public function delPenerima($id)
    {
        $this->model->hapus('penerima_potong', 'id_terima', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data penerima berhasil dihapus');
            redirect('lanjut');
        } else {
            $this->session->set_flashdata('error', 'Data penerima gagal dihapus');
            redirect('lanjut');
        }
    }
}
