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
        $this->sentral = $this->load->database('sentral', true);
    }

    public function index() {}

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
        $sql = "
            SELECT 
                lembaga AS kode_lembaga,
                SUM(CASE WHEN uraian LIKE '%BOS%' THEN nominal ELSE 0 END) AS bos,
                SUM(CASE WHEN uraian LIKE '%BOP%' THEN nominal ELSE 0 END) AS bpopp
            FROM bos
            WHERE tahun = ?
            GROUP BY lembaga
        ";

        $query = $this->sentral->query($sql, [$this->tahun]);

        // MAP hasil BOS by kode
        $rekapBos = [];
        foreach ($query->result() as $row) {
            $rekapBos[$row->kode_lembaga] = $row;
            $this->model->edit2('fluk_bos', 'kode_lembaga', $row->kode_lembaga, 'tahun', $this->tahun, ['bos' => $row->bos, 'bpopp' => $row->bpopp]);
        }

        // MASTER FLAG LEMBAGA
        $dtboses = $this->model->getBosByLembaga($this->tahun)->result();

        // MAP KODE → NAMA
        $mapLembaga = [
            '04' => 'MI',
            '05' => 'RA',
            '06' => 'MTs',
            '07' => 'SMP',
            '08' => 'MA',
            '09' => 'SMK',
        ];

        $bosrekap = [];

        foreach ($dtboses as $dtbos) {

            // cari kode berdasarkan nama
            $kode = array_search($dtbos->lembaga, $mapLembaga);

            $rekap = $rekapBos[$kode] ?? null;

            $bosrekap[] = (object)[
                'lembaga'   => $dtbos->lembaga,
                'bos'       => (float) ($rekap->bos ?? 0),
                'bpopp'     => (float) ($rekap->bpopp ?? 0),
                'fl_bos'    => $dtbos->fl_bos,
                'fl_bpopp'  => $dtbos->fl_bpopp,
            ];
        }

        $data['bosRekap'] = $bosrekap;
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
