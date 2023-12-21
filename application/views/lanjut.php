<!--start page wrapper -->
<?php
$this->load->view('head');
$no = 1;
?>

<script>
    // Function Format Rupiah
    function removeRp(rupiah) {
        return parseInt(rupiah.replace(/[^\d]/g, ''), 10);
    }

    function bulatNom(number) {
        // Melakukan pembulatan
        var roundedValue = Math.round(number);

        // Mengonversi ke string dan menghapus desimal jika ada
        var stringValue = roundedValue.toString();
        if (stringValue.includes('.')) {
            stringValue = stringValue.split('.')[0];
        }

        return stringValue;
    }

    function addRp(integerValue) {
        var formattedValue = integerValue.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR'
        });
        if (formattedValue.includes(',')) {
            var parts = formattedValue.split(',');
            if (parts.length > 1 && parts[1].endsWith('00')) {
                formattedValue = parts[0] + ',' + parts[1].slice(0, -2);
            }
        }
        if (formattedValue.endsWith(',')) {
            formattedValue = formattedValue.slice(0, -1);
        }
        return formattedValue;
    }
</script>
<link href="<?= base_url('temp/') ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5>Nominal dari 20% : <b id="hasil20persen" class="text-success text center"></b></h5>
                        <hr>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#tambahData">Tambah Data Penerima Potongan</button>
                        <ul class="list-group mt-3">
                            <li class="list-group-item active" aria-current="true">Subsidi Silang (50%) : <b id="susil"></b></li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead class="table-info">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Penerima</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Hasil</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($susil as $row) : ?>
                                                <tr>
                                                    <th scope="row"><?= $no++ ?></th>
                                                    <td><?= $row->nama ?></td>
                                                    <td><?= $row->jumlah ?>%</td>
                                                    <td><b id="susil20bagi<?= $row->id_terima ?>"></b>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                var susilElement = document.getElementById('susil');
                                                                if (susilElement) {
                                                                    var susilText = susilElement.textContent;
                                                                    var susilPkai = removeRp(susilText)
                                                                    var potong = parseInt(<?= $row->jumlah ?>);
                                                                    var hasil = (potong / 100) * susilPkai;
                                                                    var bulatHasil = bulatNom(hasil)
                                                                    document.getElementById('susil20bagi<?= $row->id_terima ?>').textContent = addRp(parseInt(bulatHasil));
                                                                    // document.getElementById('susil20bagi<?= $row->id_terima ?>').textContent = bul;
                                                                } else {
                                                                    console.error('Element with ID "susil" not found.');
                                                                }
                                                            })
                                                        </script>
                                                    </td>
                                                    <td><a href="<?= base_url('lanjut/delPenerima/' . $row->id_terima) ?>" class="tombol-hapus">Hapus</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li class="list-group-item active" aria-current="true">Pengembangan (25%) : <b id="kembang"></b></li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead class="table-info">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Penerima</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Hasil</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($kembang as $row) : ?>
                                                <tr>
                                                    <th scope="row"><?= $no++ ?></th>
                                                    <td><?= $row->nama ?></td>
                                                    <td><?= $row->jumlah ?>%</td>
                                                    <td><b id="kembang20bagi<?= $row->id_terima ?>"></b>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                var kembangElement = document.getElementById('kembang');
                                                                if (kembangElement) {
                                                                    var kembangText = kembangElement.textContent;
                                                                    var kembangPkai = removeRp(kembangText)
                                                                    var potong = parseInt(<?= $row->jumlah ?>);
                                                                    var hasil = (potong / 100) * kembangPkai;
                                                                    var bulatHasil = bulatNom(hasil)
                                                                    document.getElementById('kembang20bagi<?= $row->id_terima ?>').textContent = addRp(parseInt(bulatHasil));
                                                                    // document.getElementById('kembang20bagi<?= $row->id_terima ?>').textContent = bul;
                                                                } else {
                                                                    console.error('Element with ID "kembang" not found.');
                                                                }
                                                            })
                                                        </script>
                                                    </td>
                                                    <td><a href="<?= base_url('lanjut/delPenerima/' . $row->id_terima) ?>" class="tombol-hapus">Hapus</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li class="list-group-item active" aria-current="true">Sarpras (25%) : <b id="sarpras"></b></li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead class="table-info">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Penerima</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Hasil</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sarpras as $row) : ?>
                                                <tr>
                                                    <th scope="row"><?= $no++ ?></th>
                                                    <td><?= $row->nama ?></td>
                                                    <td><?= $row->jumlah ?>%</td>
                                                    <td><b id="sarpras20bagi<?= $row->id_terima ?>"></b>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                var sarprasElement = document.getElementById('sarpras');
                                                                if (sarprasElement) {
                                                                    var sarprasText = sarprasElement.textContent;
                                                                    var sarprasPkai = removeRp(sarprasText)
                                                                    var potong = parseInt(<?= $row->jumlah ?>);
                                                                    var hasil = (potong / 100) * sarprasPkai;
                                                                    var bulatHasil = bulatNom(hasil)
                                                                    document.getElementById('sarpras20bagi<?= $row->id_terima ?>').textContent = addRp(parseInt(bulatHasil));
                                                                    // document.getElementById('sarpras20bagi<?= $row->id_terima ?>').textContent = bul;
                                                                } else {
                                                                    console.error('Element with ID "sarpras" not found.');
                                                                }
                                                            })
                                                        </script>
                                                    </td>
                                                    <td><a href="<?= base_url('lanjut/delPenerima/' . $row->id_terima) ?>" class="tombol-hapus">Hapus</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('lanjut/addPenerimaPotong') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Pilih Jenis Potongan</label>
                    <select name="kode_potong" id="" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="susil">Subsidi Silang</option>
                        <option value="kembang">Pengembangan</option>
                        <option value="sarpras">Sarpras</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Penerima</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="">Jumlah (%)</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php $this->load->view('foot'); ?>
<script>
    var totalBelanja = localStorage.getItem('total_potong');
    document.getElementById('hasil20persen').textContent = totalBelanja;

    // Subsidi Silang
    var susil = (50 / 100) * removeRp(totalBelanja);
    document.getElementById('susil').textContent = addRp(susil);
    // Pengembangan
    var kembang = (25 / 100) * removeRp(totalBelanja);
    document.getElementById('kembang').textContent = addRp(kembang);
    // Sarpras
    var sarpras = (25 / 100) * removeRp(totalBelanja);
    document.getElementById('sarpras').textContent = addRp(sarpras);
</script>