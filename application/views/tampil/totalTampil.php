<div class="table-responsive">
    <table id="hitungTotal" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lembaga</th>
                <th>BP</th>
                <th>BOS/BPOPP</th>
                <th>Total Masuk</th>
                <th colspan="2">Potongan</th>
                <th>Sisa Pagu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($total as $riw) :
                $total = $riw->bp + $riw->bos;
                $potong = ($riw->potongan / 100) * $total;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $riw->nama ?></td>
                    <td class="amountAwal"><?= rupiah($riw->bp) ?></td>
                    <td class="amount2_bos"><?= rupiah($riw->bos) ?></td>
                    <td class="amount2_total"><?= rupiah($total) ?></td>
                    <td><?= $riw->potongan ?>%</td>
                    <td class="amount2_potong" id="amount2_potong"><?= rupiah($potong) ?></td>
                    <td class="amount2_akhir"><?= rupiah($total - $potong) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">TOTAL</th>
                <th id="totalAwal"></th>
                <th id="total_bos"></th>
                <th id="total_total"></th>
                <th></th>
                <th id="total_potong"></th>
                <th id="total_kahiran"></th>
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

    calculateTotal('hitungTotal', 'amountAwal', 'totalAwal');
    calculateTotal('hitungTotal', 'amount2_bos', 'total_bos');
    calculateTotal('hitungTotal', 'amount2_total', 'total_total');
    calculateTotal('hitungTotal', 'amount2_potong', 'total_potong');
    calculateTotal('hitungTotal', 'amount2_akhir', 'total_kahiran');


    var totalBelanja = document.getElementById('total_potong').textContent;
    localStorage.setItem('total_potong', totalBelanja);
</script>