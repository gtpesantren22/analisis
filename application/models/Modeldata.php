<?php

class Modeldata extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->sentral = $this->load->database('sentral', true);
    }

    function getBpByLembaga($tahun)
    {
        return $this->sentral->query("SELECT SUM((ju_ap * 10) + (me_ju * 2)) as jml, t_formal AS sekolah, COUNT(tb_santri.nis) as siswa, nikmus, infak, fluk FROM tangg JOIN tb_santri ON tangg.nis=tb_santri.nis JOIN potong ON tb_santri.t_formal=potong.lembaga WHERE tangg.tahun = '$tahun' AND tb_santri.aktif = 'Y' AND tb_santri.t_formal != 'Mahasiswa' GROUP BY tb_santri.t_formal ");
    }

    function getBosByLembaga($tahun)
    {
        // return $this->sentral->query("SELECT SUM(nominal) as jml, nama FROM bos JOIN lembaga ON bos.lembaga=lembaga.kode WHERE bos.tahun = '$tahun' AND lembaga.tahun = '$tahun' GROUP BY bos.lembaga ");
        return $this->sentral->query("SELECT * FROM fluk_bos WHERE tahun = '$tahun' ");
    }

    function buatView($tahun)
    {

        $this->sentral->query("DROP VIEW IF EXISTS v_bptotal");
        $this->sentral->query("DROP VIEW IF EXISTS v_nikinf");
        $this->sentral->query("DROP VIEW IF EXISTS v_flbp");

        $this->sentral->query("DROP VIEW IF EXISTS v_bp");
        $this->sentral->query("DROP VIEW IF EXISTS v_bos");

        $this->sentral->query("CREATE VIEW v_bptotal AS SELECT t_formal AS lembaga, SUM((ju_ap * 10) + (me_ju * 2)) AS jml, COUNT(tb_santri.nis) AS santri FROM tangg JOIN tb_santri ON tangg.nis=tb_santri.nis WHERE tangg.tahun = '$tahun' AND tb_santri.aktif = 'Y' AND tb_santri.t_formal != 'Mahasiswa' GROUP BY tb_santri.t_formal ");

        $this->sentral->query("CREATE VIEW v_nikinf AS SELECT potong.lembaga AS lembaga, (santri * nikmus) + (santri * infak) as jml FROM potong JOIN tb_santri ON potong.lembaga=tb_santri.t_formal JOIN v_bptotal ON potong.lembaga=v_bptotal.lembaga WHERE potong.tahun = '$tahun' AND tb_santri.aktif = 'Y' AND tb_santri.t_formal != 'Mahasiswa' GROUP BY tb_santri.t_formal ");

        $this->sentral->query("CREATE VIEW v_flbp AS SELECT potong.lembaga AS lembaga, SUM((fluk/100)*v_bptotal.jml) as jml FROM potong JOIN v_bptotal ON potong.lembaga=v_bptotal.lembaga WHERE potong.tahun = '$tahun' GROUP BY potong.lembaga ");

        $this->sentral->query("CREATE VIEW v_bp AS SELECT v_bptotal.lembaga AS lembaga, SUM(v_bptotal.jml - (v_nikinf.jml + v_flbp.jml)) as jml FROM v_bptotal JOIN v_nikinf ON v_bptotal.lembaga=v_nikinf.lembaga JOIN v_flbp ON v_bptotal.lembaga=v_flbp.lembaga GROUP BY v_bptotal.lembaga ");

        $this->sentral->query("CREATE VIEW v_bos AS SELECT (((100 - fl_bos)/100) * bos) + (((100 - fl_bpopp)/100) * bpopp) AS jml, lembaga FROM fluk_bos WHERE tahun = '$tahun' ");
    }
    function buatView2($tahun)
    {
        $this->sentral->query("DROP VIEW IF EXISTS v_total");

        $this->sentral->query("CREATE VIEW v_total AS SELECT v_bos.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos LEFT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga UNION SELECT v_bp.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos RIGHT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga");

        return $this->sentral->query("SELECT * FROM v_total JOIN potong ON v_total.nama=potong.lembaga WHERE potong.tahun = '$tahun' ");
    }

    function totalMasuk()
    {
        return $this->sentral->query("SELECT v_bos.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos LEFT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga UNION SELECT v_bp.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp, potong.potongan FROM v_bos RIGHT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga LEFT JOIN potong ON v_bos.lembaga = potong.lembaga");
    }

    function hitungPagu($tahun)
    {
        return $this->sentral->query("SELECT * FROM v_total JOIN potong ON v_total.nama=potong.lembaga WHERE potong.tahun = '$tahun' ");
    }
}
