<!--start page wrapper -->
<?php $this->load->view('head'); ?>
<link href="<?= base_url('temp/') ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="hitung" class="table table-striped table-bordered example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Lembaga</th>
                                        <th>BP</th>
                                        <th>BOS/BPOPP</th>
                                        <th>Total Masuk</th>
                                        <th>20%</th>
                                        <th>Pagu (80%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($total as $riw) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $riw->nama ?></td>
                                            <td class="amount"><?= rupiah($riw->bp) ?></td>
                                            <td class="amount2"><?= rupiah($riw->bos) ?></td>
                                            <td class="amount3"><?= rupiah($riw->bp + $riw->bos) ?></td>
                                            <td class="amount4"><?= rupiah((20 / 100) * ($riw->bp + $riw->bos)) ?></td>
                                            <td class="amount5"><?= rupiah(($riw->bp + $riw->bos) - ((20 / 100) * ($riw->bp + $riw->bos))) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">TOTAL</th>
                                        <th id="total"></th>
                                        <th id="total2"></th>
                                        <th id="total3"></th>
                                        <th id="total4"></th>
                                        <th id="total5"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<!--end page wrapper -->
<?php $this->load->view('foot'); ?>
<script src="<?= base_url('temp/') ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('temp/') ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
<script src="<?= base_url('temp/') ?>assets/js/funApp.js"></script>
<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });

    calculateTotal('hitung', 'amount', 'total');
    calculateTotal('hitung', 'amount2', 'total2');
    calculateTotal('hitung', 'amount3', 'total3');
    calculateTotal('hitung', 'amount4', 'total4');
    calculateTotal('hitung', 'amount5', 'total5');
</script>