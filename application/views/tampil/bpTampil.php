<div class="table-responsive">
    <table id="hitung" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lembaga</th>
                <th>Total</th>
                <th>Jml Siswa</th>
                <th>Total Infak</th>
                <th>Total Nikmus</th>
                <th>Fluktuasi</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($bpRekap as $riw) :
                $fluk = ($riw->fluk / 100) * $riw->jml;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $riw->sekolah ?></td>
                    <td class="amount"><?= rupiah($riw->jml) ?></td>
                    <td class="siswa"><?= $riw->siswa ?></td>
                    <td class="amount2"><?= rupiah($riw->siswa * $riw->infak) ?></td>
                    <td class="amount3"><?= rupiah($riw->siswa * $riw->nikmus) ?></td>
                    <td class="amount"><?= rupiah($fluk) ?></td>
                    <td class="amount4"><?= rupiah($riw->jml - (($riw->siswa * $riw->infak) + ($riw->siswa * $riw->nikmus) + $fluk)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">TOTAL</th>
                <th id="total"></th>
                <th id="jml_siswa">siswa</th>
                <th id="total2"></th>
                <th id="total3"></th>
                <th id=""></th>
                <th id="total4"></th>
            </tr>
        </tfoot>
    </table>
</div>
<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('temp/') ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('temp/') ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('temp/') ?>assets/js/funApp.js"></script>
<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });

    calculateTotal('hitung', 'amount', 'total');
    calculateTotal('hitung', 'amount2', 'total2');
    calculateTotal('hitung', 'amount3', 'total3');
    calculateTotal('hitung', 'amount4', 'total4');
    calculateTotal2('hitung', 'siswa', 'jml_siswa');
</script>