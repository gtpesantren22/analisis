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
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($bosRekap as $riw) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $riw->nama ?></td>
                                            <td class="amount"><?= rupiah($riw->jml) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">TOTAL</th>
                                        <th id="total"></th>
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
</script>