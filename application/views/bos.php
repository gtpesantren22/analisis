<!--start page wrapper -->
<?php $this->load->view('head'); ?>
<link href="<?= base_url('temp/') ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div id="hasil"></div>
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
            url: "<?= base_url('masuk/bosTampil') ?>",
            success: function(data) {
                $("#hasil").html(data);
            }
        });
    });
</script>