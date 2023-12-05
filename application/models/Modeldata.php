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
        return $this->sentral->query("SELECT SUM((ju_ap * 10) + (me_ju * 2)) as jml, t_formal AS sekolah, COUNT(tb_santri.nis) as siswa, nikmus, infak FROM tangg JOIN tb_santri ON tangg.nis=tb_santri.nis JOIN potong ON tb_santri.t_formal=potong.lembaga WHERE tangg.tahun = '$tahun' AND tb_santri.aktif = 'Y' AND tb_santri.t_formal != 'Mahasiswa' GROUP BY tb_santri.t_formal ");
    }

    function getBosByLembaga($tahun)
    {
        return $this->sentral->query("SELECT SUM(nominal) as jml, nama FROM bos JOIN lembaga ON bos.lembaga=lembaga.kode WHERE bos.tahun = '$tahun' AND lembaga.tahun = '$tahun' GROUP BY bos.lembaga ");
    }

    function buatView($tahun)
    {
        $this->sentral->query("DROP VIEW IF EXISTS v_bp");
        $this->sentral->query("DROP VIEW IF EXISTS v_bos");

        $this->sentral->query("CREATE VIEW v_bp AS SELECT t_formal AS lembaga, SUM((ju_ap * 10) + (me_ju * 2)) - ((COUNT(tb_santri.nis) * nikmus) + (COUNT(tb_santri.nis) * infak)) as jml FROM tangg JOIN tb_santri ON tangg.nis=tb_santri.nis JOIN potong ON tb_santri.t_formal=potong.lembaga WHERE tangg.tahun = '$tahun' AND tb_santri.aktif = 'Y' AND tb_santri.t_formal != 'Mahasiswa' GROUP BY tb_santri.t_formal ");

        $this->sentral->query("CREATE VIEW v_bos AS SELECT SUM(nominal) as jml, 
        CASE 
        WHEN nama LIKE '%RA%' THEN 'RA'
        WHEN nama LIKE '%MI%' THEN 'MI'
        WHEN nama LIKE '%MTs%' THEN 'MTs'
        WHEN nama LIKE '%SMP%' THEN 'SMP'
        WHEN nama LIKE '%MA%' THEN 'MA'
        WHEN nama LIKE '%SMK%' THEN 'SMK'
        ELSE '' END AS lembaga 
        FROM bos JOIN lembaga ON bos.lembaga=lembaga.kode WHERE bos.tahun = '$tahun' AND lembaga.tahun = '$tahun' GROUP BY bos.lembaga ");
    }

    function totalMasuk()
    {
        return $this->sentral->query("SELECT v_bos.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp FROM v_bos LEFT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga UNION SELECT v_bp.lembaga as nama, v_bos.jml as bos, v_bp.jml as bp FROM v_bos RIGHT JOIN v_bp ON v_bos.lembaga = v_bp.lembaga");
    }
}
