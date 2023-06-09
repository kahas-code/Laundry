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

    button {
        font-size: 12px !important;
    }

    ul {
        list-style: none;
        display: table;
        margin: 0;
    }

    li {
        display: table-row;
    }

    b {
        display: table-cell;
        padding-right: 1em;
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
                        <button type="button" class="btn btn-success mt-3 cetak">Cetak</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">

                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-jurnal">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Jurnal</th>
                            <th>Nama Akun</th>
                            <th>Nomor Transaksi</th>
                            <th>Keterangan</th>
                            <th>Tanggal Jurnal</th>
                            <th>Kredit</th>
                            <th>Debit</th>
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
    var total;
    $(function() {

        Datatables();
    })

    function Datatables() {
        let tanggal = $('input[name="tanggal"]').val();
        var table = $('#tb-jurnal').DataTable({
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
                "url": url + "transaksi/datajurnal",
                "type": "POST",
                "data": {
                    "tanggal": tanggal,
                    "type": "jurnal"
                }

            },
            columnDefs: [{

                targets: [2, 3, 4, 5, 6, 7],
                orderable: false,
            }],

        });
    }
    $('.cetak').click(function() {
        Datatables();
    })
</script>
<?= $this->endSection('content'); ?>