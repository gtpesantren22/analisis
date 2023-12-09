 <div class="table-responsive">
     <table id="hitungBos" class="table table-striped table-bordered ">
         <thead>
             <tr>
                 <th rowspan="2" class="text-center">No.</th>
                 <th rowspan="2" class="text-center">Lembaga</th>
                 <th colspan="5" class="text-center" style="background-color: #3A4D39; color: white;">BOS</th>
                 <th colspan="5" class="text-center" style="background-color: #A75D5D; color: white;">BPOPP</th>
                 <th rowspan="2" class="text-center">SISA</th>
             </tr>
             <tr>
                 <th class="text-center" style="background-color: #3A4D39; color: white;">Real</th>
                 <th colspan="4" class="text-center" style="background-color: #3A4D39; color: white;">Fluktuasi</th>
                 <th class="text-center" style="background-color: #A75D5D; color: white;">Real</th>
                 <th colspan="4" class="text-center" style="background-color: #A75D5D; color: white;">Fluktuasi</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $no = 1;
                foreach ($bosRekap as $riw) :
                    $flBos = ($riw->fl_bos / 100) * $riw->bos;
                    $flBosSisa = ((100 - $riw->fl_bos) / 100) * $riw->bos;
                    $flBpopp = ($riw->fl_bpopp / 100) * $riw->bpopp;
                    $flBpoppSisa = ((100 - $riw->fl_bpopp) / 100) * $riw->bpopp;
                ?>
                 <tr>
                     <td><?= $no++ ?></td>
                     <td><?= $riw->lembaga ?></td>
                     <td class="amount_awal" style="background-color: #3A4D39; color: white;"><?= rupiah($riw->bos) ?></td>
                     <td class="" style="background-color: #4F6F52; color: white;"><?= ($riw->fl_bos) ?>%</td>
                     <td class="amount_flBos" style="background-color: #4F6F52; color: white;"><?= rupiah($flBos) ?></td>
                     <td class="" style="background-color: #739072; color: white;"><?= (100 - $riw->fl_bos) ?>%</td>
                     <td class="amount_flBosSisa" style="background-color: #739072; color: white;"><?= rupiah($flBosSisa) ?></td>
                     <td class="amount_bpopp" style="background-color: #A75D5D; color: white;"><?= rupiah($riw->bpopp) ?></td>
                     <td class="" style="background-color: #D3756B; color: white;"><?= ($riw->fl_bpopp) ?>%</td>
                     <td class="amount_flBpopp" style="background-color: #D3756B; color: white;"><?= rupiah($flBpopp) ?></td>
                     <td class="" style="background-color: #F0997D; color: white;"><?= (100 - $riw->fl_bpopp) ?>%</td>
                     <td class="amount_flBpoppSisa" style="background-color: #F0997D; color: white;"><?= rupiah($flBpoppSisa) ?></td>
                     <td class="amount_akhir"><?= rupiah($flBosSisa + $flBpoppSisa) ?></td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
         <tfoot>
             <tr>
                 <th colspan="2">TOTAL</th>
                 <th id="total_awal"></th>
                 <th id=""></th>
                 <th id="total_flBos"></th>
                 <th id=""></th>
                 <th id="total_flBosSisa"></th>
                 <th id="total_bpopp"></th>
                 <th id=""></th>
                 <th id="total_flBpopp"></th>
                 <th id=""></th>
                 <th id="total_flBpoppSisa"></th>
                 <th id="total_akhir"></th>
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
     calculateTotal('hitungBos', 'amount_awal', 'total_awal');
     calculateTotal('hitungBos', 'amount_flBos', 'total_flBos');
     calculateTotal('hitungBos', 'amount_flBosSisa', 'total_flBosSisa');
     calculateTotal('hitungBos', 'amount_bpopp', 'total_bpopp');
     calculateTotal('hitungBos', 'amount_flBpopp', 'total_flBpopp');
     calculateTotal('hitungBos', 'amount_flBpoppSisa', 'total_flBpoppSisa');
     calculateTotal('hitungBos', 'amount_akhir', 'total_akhir');
 </script>