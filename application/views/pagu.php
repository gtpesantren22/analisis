<!--start page wrapper -->
<?php $this->load->view('head'); ?>
<link href="<?= base_url('temp/') ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Analisis Pemasukan BP</h5>
                    </div>
                    <div class="card-body">
                        <div id="hasilBp"></div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Analisis Pemasukan BOS&BPOPP</h5>
                    </div>
                    <div class="card-body">
                        <div id="hasilBos"></div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Analisis Total Pemasukan (BP + BOS&BPOPP)</h5>
                    </div>
                    <div class="card-body">
                        <div id="hasilTotal"></div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Analisis Pembagian Pagu Akhir</h5>
                    </div>
                    <div class="card-body">
                        <div id="hasilPagu"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<!--end page wrapper -->
<?php $this->load->view('foot'); ?>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= base_url('masuk/bpTampil') ?>",
            success: function(data) {
                $("#hasilBp").html(data);
            }
        });

        $.ajax({
            url: "<?= base_url('masuk/bosTampil') ?>",
            success: function(data) {
                $("#hasilBos").html(data);
            }
        });
        $.ajax({
            url: "<?= base_url('masuk/totalTampil') ?>",
            success: function(data) {
                $("#hasilTotal").html(data);
            }
        });
        $.ajax({
            url: "<?= base_url('masuk/paguTampil') ?>",
            success: function(data) {
                $("#hasilPagu").html(data);
            }
        });
    });
</script>