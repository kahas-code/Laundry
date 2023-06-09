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

    .dt-button {
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
            border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        color: #000;
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .dt-button:hover {
        color: #000;
        background-color: #31d2f2;
        border-color: #25cff2;

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
                        <button type="button" class="btn btn-success mt-3 cetak">Filter</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table mt-5 " style="max-width: 100%; min-width:100%" id="tb-transactions">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Transaksi</th>
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
                targets: [1,2, 3, 4, 5, 6, 7],
                orderable: false,
            }],
            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    text: 'Export PDF',
                    title: 'Laporan Transaksi',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7] // Column index which needs to export
                    }
                },

            ]

        });
    }
    $('.cetak').click(function() {
        Datatables();
    })
</script>
<?= $this->endSection('content'); ?>