<?php

class Modeldata extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->kasir = $this->load->database('kasir', true);
        $this->santri = $this->load->database('santri', true);
    }

    function getBpByLembaga($tahun)
    {
        $kasir = $this->kasir->database;
        $santri = $this->santri->database;

        $this->db->query("DROP VIEW IF EXISTS v_bpSaja");

        $this->db->query("CREATE VIEW v_bpSaja AS SELECT SUM(tagihan.nominal) as jml, t_formal AS sekolah FROM {$kasir}.tagihan JOIN {$santri}.tb_santri ON {$kasir}.tagihan.nis={$santri}.tb_santri.nis JOIN {$kasir}.jenis_tagihan ON {$kasir}.tagihan.id_jenis={$kasir}.jenis_tagihan.id_jenis WHERE {$kasir}.tagihan.tahun = '$tahun' AND {$kasir}.jenis_tagihan.tahun = '$tahun' AND {$kasir}.jenis_tagihan.id_pos = 'POS002' AND {$santri}.tb_santri.aktif = 'Y' AND {$santri}.tb_santri.t_formal != 'Mahasiswa' GROUP BY {$santri}.tb_santri.t_formal");

        return $this->db->query("SELECT jml, t_formal AS sekolah, COUNT(tb_santri.nis) as siswa, nikmus, infak, fluk FROM v_bpSaja JOIN {$santri}.tb_santri ON v_bpSaja.sekolah={$santri}.tb_santri.t_formal JOIN potong ON {$santri}.tb_santri.t_formal=potong.lembaga WHERE {$santri}.tb_santri.aktif = 'Y' AND {$santri}.tb_santri.t_formal != 'Mahasiswa' GROUP BY {$santri}.tb_santri.t_formal ");
    }

    function getBosByLembaga($tahun)
    {
        // return $this->sentral->query("SELECT SUM(nominal) as jml, nama FROM bos JOIN lembaga ON bos.lembaga=lembaga.kode WHERE bos.tahun = '$tahun' AND lembaga.tahun = '$tahun' GROUP BY bos.lembaga ");
        return $this->db->query("SELECT * FROM fluk_bos WHERE tahun = '$tahun' ");
    }

    function buatView($tahun)
    {
        $kasir = $this->kasir->database;
        $santri = $this->santri->database;

        $this->db->query("DROP VIEW IF EXISTS v_bpSaja");
        $this->db->query("DROP VIEW IF EXISTS v_bptotal");
        $this->db->query("DROP VIEW IF EXISTS v_nikinf");
        $this->db->query("DROP VIEW IF EXISTS v_flbp");
        $this->db->query("DROP VIEW IF EXISTS v_bp");
        $this->db->query("DROP VIEW IF EXISTS v_bos");


        $this->db->query("CREATE VIEW v_bpSaja AS SELECT SUM(tagihan.nominal) as jml, t_formal AS sekolah FROM {$kasir}.tagihan JOIN {$santri}.tb_santri ON {$kasir}.tagihan.nis={$santri}.tb_santri.nis JOIN {$kasir}.jenis_tagihan ON {$kasir}.tagihan.id_jenis={$kasir}.jenis_tagihan.id_jenis WHERE {$kasir}.tagihan.tahun = '$tahun' AND {$kasir}.jenis_tagihan.tahun = '$tahun' AND {$kasir}.jenis_tagihan.id_pos = 'POS002' AND {$santri}.tb_santri.aktif = 'Y' AND {$santri}.tb_santri.t_formal != 'Mahasiswa' GROUP BY {$santri}.tb_santri.t_formal");

        $this->db->query("CREATE VIEW v_bptotal AS SELECT t_formal AS lembaga, jml, COUNT(tb_santri.nis) AS santri FROM v_bpSaja JOIN {$santri}.tb_santri ON v_bpSaja.sekolah={$santri}.tb_santri.t_formal JOIN potong ON {$santri}.tb_santri.t_formal=potong.lembaga WHERE {$santri}.tb_santri.aktif = 'Y' AND {$santri}.tb_santri.t_formal != 'Mahasiswa' GROUP BY {$santri}.tb_santri.t_formal ");

        $this->db->query("CREATE VIEW v_nikinf AS SELECT potong.lembaga AS lembaga, (santri * nikmus) + (santri * infak) as jml FROM potong JOIN {$santri}.tb_santri ON potong.lembaga={$santri}.tb_santri.t_formal JOIN v_bptotal ON potong.lembaga=v_bptotal.lembaga WHERE potong.tahun = '$tahun' AND {$santri}.tb_santri.aktif = 'Y' AND {$santri}.tb_santri.t_formal != 'Mahasiswa' GROUP BY {$santri}.tb_santri.t_formal ");

        $this->db->query("CREATE VIEW v_flbp AS SELECT potong.lembaga AS lembaga, SUM((fluk/100)*v_bptotal.jml) as jml FROM potong JOIN v_bptotal ON potong.lembaga=v_bptotal.lembaga WHERE potong.tahun = '$tahun' GROUP BY potong.lembaga ");

        $this->db->query("CREATE VIEW v_bp AS SELECT v_bptotal.lembaga AS lembaga, SUM(v_bptotal.jml - (v_nikinf.jml + v_flbp.jml)) as jml FROM v_bptotal JOIN v_nikinf ON v_bptotal.lembaga=v_nikinf.lembaga JOIN v_flbp ON v_bptotal.lembaga=v_flbp.lembaga GROUP BY v_bptotal.lembaga ");

        $this->db->query("CREATE VIEW v_bos AS SELECT (((100 - fl_bos)/100) * bos) + (((100 - fl_bpopp)/100) * bpopp) AS jml, lembaga FROM fluk_bos WHERE tahun = '$tahun' ");
    }
    function buatView2($tahun)
    {
        $this->db->query("DROP VIEW IF EXISTS v_total");

        $this->db->query("CREATE VIEW v_total AS SELECT v_bos.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos LEFT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga UNION SELECT v_bp.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos RIGHT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga");

        return $this->db->query("SELECT * FROM v_total JOIN potong ON v_total.nama=potong.lembaga WHERE potong.tahun = '$tahun' ");
    }

    function totalMasuk()
    {
        return $this->db->query("SELECT v_bos.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos LEFT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga UNION SELECT v_bp.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos RIGHT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga");
    }

    function hitungPagu($tahun)
    {
        return $this->db->query("SELECT * FROM v_total JOIN potong ON v_total.nama=potong.lembaga WHERE potong.tahun = '$tahun' ");
    }

    // CRUD Models
    function simpan($tbl, $data)
    {
        $this->db->insert($tbl, $data);
    }
    function getBy($table, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        return $this->db->get($table);
    }
    function getBy2($table, $where, $dtwhere, $where2, $dtwhere2)
    {
        $this->db->where($where, $dtwhere);
        $this->db->where($where2, $dtwhere2);
        return $this->db->get($table);
    }

    function hapus($tbl, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        $this->db->delete($tbl);
    }
    function edit($tbl, $where, $dtwhere, $data)
    {
        $this->db->where($where, $dtwhere);
        $this->db->update($tbl, $data);
    }
    function edit2($tbl, $where, $dtwhere, $where2, $dtwhere2, $data)
    {
        $this->db->where($where, $dtwhere);
        $this->db->where($where2, $dtwhere2);
        $this->db->update($tbl, $data);
    }
}
