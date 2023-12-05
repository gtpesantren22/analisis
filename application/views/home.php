<!--start page wrapper -->
<?php $this->load->view('head'); ?>
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="<?= base_url('temp/') ?>assets/images/avatars/avatar-2.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                            <div class="mt-3">
                                <h4>Welcome, <?= $user->nama ?></h4>
                                <p class="text-secondary mb-1">Sebagai <?= $user->level ?></p>
                                <p class="text-muted font-size-sm">Aplikasi Analisis Pagu Anggaran Lembaga Pesantren</p>
                                <!-- <button class="btn btn-primary">Follow</button>
                                <button class="btn btn-outline-primary">Message</button> -->
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- <p class="text-center"></p> -->
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<!--end page wrapper -->
<?php $this->load->view('foot'); ?>