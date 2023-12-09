<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
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
    }

    public function bp()
    {
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('bp', $data);
    }
    public function bpTampil()
    {
        $data['bpRekap'] = $this->model->getBpByLembaga($this->tahun)->result();
        $this->load->view('tampil/bpTampil', $data);
    }

    public function bos()
    {
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('bos', $data);
    }
    public function bosTampil()
    {
        $data['bosRekap'] = $this->model->getBosByLembaga($this->tahun)->result();
        $this->load->view('tampil/bosTampil', $data);
    }

    public function total()
    {
        $data['user'] = $this->Auth_model->current_user();
        $this->load->view('total', $data);
    }
    public function totalTampil()
    {
        $data['bosRekap'] = $this->model->buatView($this->tahun);
        $data['total'] = $this->model->totalMasuk()->result();
        $this->load->view('tampil/totalTampil', $data);
    }

    public function pagu()
    {
        $data['user'] = $this->Auth_model->current_user();

        $this->load->view('pagu', $data);
    }
    public function paguTampil()
    {
        $data['bosRekap'] = $this->model->buatView($this->tahun);
        $data['view2'] = $this->model->buatView2($this->tahun);
        $data['hasil'] = $this->model->hitungPagu($this->tahun)->result();

        $this->load->view('tampil/paguTampil', $data);
    }
}
