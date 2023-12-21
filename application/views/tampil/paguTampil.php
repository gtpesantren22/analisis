 <div class="table-responsive">
     <table id="hitungBos" class="table table-striped table-bordered ">
         <thead>
             <tr>
                 <th rowspan="2" class="text-center">No.</th>
                 <th rowspan="2" class="text-center">Lembaga</th>
                 <th rowspan="2" class="text-center">Sisa Pagu</th>
                 <th colspan="4" class="text-center" style="background-color: #3A4D39; color: white;">Listrik (1 Thn)</th>
                 <th colspan="4" class="text-center" style="background-color: #A75D5D; color: white;">WIFI (1 Thn)</th>
                 <th colspan="4" class="text-center" style="background-color: #A75D5D; color: white;">Honor (1 Thn)</th>
                 <th rowspan="2" class="text-center">Pagu Final</th>
             </tr>
             <tr>
                 <th class="text-center" style="background-color: #3A4D39; color: white;">Real</th>
                 <th colspan="2" class="text-center" style="background-color: #3A4D39; color: white;">Fluktuasi</th>
                 <th class="text-center" style="background-color: #3A4D39; color: white;">Total</th>
                 <th class="text-center" style="background-color: #A75D5D; color: white;">Real</th>
                 <th colspan="2" class="text-center" style="background-color: #A75D5D; color: white;">Fluktuasi</th>
                 <th class="text-center" style="background-color: #A75D5D; color: white;">Total</th>
                 <th class="text-center" style="background-color: #A75D5D; color: white;">Real</th>
                 <th colspan="2" class="text-center" style="background-color: #A75D5D; color: white;">Fluktuasi</th>
                 <th class="text-center" style="background-color: #A75D5D; color: white;">Total</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $no = 1;
                foreach ($hasil as $riw) :
                    $totalSisa = ($riw->bos + $riw->bp) - (($riw->potongan / 100) * ($riw->bos + $riw->bp));

                    $flListrik = ($riw->fluk_listrik / 100) * ($riw->listrik * 12);
                    $flListrikSisa = $flListrik + ($riw->listrik * 12);

                    $flWifi = ($riw->fluk_wifi / 100) * ($riw->wifi * 12);
                    $flWifiSisa = $flWifi + ($riw->wifi * 12);

                    $flHonor = ($riw->fluk_honor / 100) * ($riw->honor * 12);
                    $flHonorSisa = $flHonor + ($riw->honor * 12);
                ?>
                 <tr>
                     <td><?= $no++ ?></td>
                     <td><?= $riw->lembaga ?></td>
                     <td><?= rupiah($totalSisa) ?></td>
                     <td class="amount_awal" style="background-color: #3A4D39; color: white;"><?= rupiah($riw->listrik * 12) ?></td>
                     <td class="" style="background-color: #4F6F52; color: white;">+<?= ($riw->fluk_listrik) ?>%</td>
                     <td class="amount_flListrik" style="background-color: #4F6F52; color: white;"><?= rupiah($flListrik) ?></td>
                     <td class="amount_flListrik" style="background-color: #4F6F52; color: white;"><?= rupiah($flListrikSisa) ?></td>

                     <td class="amount_bpopp" style="background-color: #A75D5D; color: white;"><?= rupiah($riw->wifi * 12) ?></td>
                     <td class="" style="background-color: #D3756B; color: white;">+<?= ($riw->fluk_wifi) ?>%</td>
                     <td class="amount_flWifi" style="background-color: #D3756B; color: white;"><?= rupiah($flWifi) ?></td>
                     <td class="amount_flWifi" style="background-color: #D3756B; color: white;"><?= rupiah($flWifiSisa) ?></td>

                     <td class="amount_bpopp" style="background-color: #A75D5D; color: white;"><?= rupiah($riw->honor * 12) ?></td>
                     <td class="" style="background-color: #D3756B; color: white;">+<?= ($riw->fluk_honor) ?>%</td>
                     <td class="amount_flWifi" style="background-color: #D3756B; color: white;"><?= rupiah($flHonor) ?></td>
                     <td class="amount_flWifi" style="background-color: #D3756B; color: white;"><?= rupiah($flHonorSisa) ?></td>

                     <td class="amount_akhir"><?= rupiah($totalSisa - ($flWifiSisa + $flListrikSisa + $flHonorSisa)) ?></td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
         <tfoot>
             <tr>
                 <th colspan="2">TOTAL</th>
                 <th id="total_awal"></th>
                 <th id=""></th>
                 <th id="total_flListrik"></th>
                 <th id=""></th>
                 <th id=""></th>
                 <th id="total_flListrikSisa"></th>
                 <th id="total_bpopp"></th>
                 <th id=""></th>
                 <th id="total_flWifi"></th>
                 <th id=""></th>
                 <th id="total_flWifiSisa"></th>
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
     calculateTotal('hitungBos', 'amount_flListrik', 'total_flListrik');
     calculateTotal('hitungBos', 'amount_flListrikSisa', 'total_flListrikSisa');
     calculateTotal('hitungBos', 'amount_bpopp', 'total_bpopp');
     calculateTotal('hitungBos', 'amount_flWifi', 'total_flWifi');
     calculateTotal('hitungBos', 'amount_flWifiSisa', 'total_flWifiSisa');
     calculateTotal('hitungBos', 'amount_akhir', 'total_akhir');
 </script>