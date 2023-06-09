<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
<style>
    .table-icon {
        font-size: 30px !important;
    }

    .edit:hover .table-icon {
        transform: scale(1.5);
    }

    .delete:hover .table-icon {
        transform: scale(1.5);
    }

    .change:hover .table-icon {
        transform: scale(1.5);
    }

    .error {
        color: red;
    }
</style>

<div class="row">
    <div class="card shadow-lg">
        <div class="col-md-12 p-3">
            <div class="card-header">
                <h5><?= $title ?></h5>
            </div>
            <div class="row mt-2 p-2">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Transaksi</label>
                            <input type="date" class="form-control" name="tanggal">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="kode">Kode Transaksi</label>
                            <input type="text" name="kode" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-success mt-3 cetak">Cetak</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-transactions">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode Layanan</th>
                            <th>Harga Layanan</th>
                            <th>Berat Pakaian</th>
                            <th>Total</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
    var url = "<?= getenv('app.baseURL') ?>";
    var harga;
    $(function() {
        Datatables();
    })

    function Datatables() {
        let tanggal = $('input[name="tanggal"]').val();
        let kode = $('input[name="kode"]').val();
        var table = $('#tb-transactions').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "searching": false,
            "paging": false,
            "order": [],
            "ajax": {
                "url": url + "laporan/datalaporantransaksi",
                "type": "POST",
                "data": {
                    "tanggal": tanggal,
                    "kode": kode,
                    "status": 1
                }

            },
            columnDefs: [{
                targets: [2, 3, 4, 5,6],
                orderable: false,
            }],

        });
    }
    $('.cetak').click(function() {
        Datatables();
    })
</script>
<?= $this->endSection('content'); ?>