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
            <div class="card-body">
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-transactions">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pembayaran-->
<div class="modal fade" id="modalpembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bayar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formbayar">

                <div class="modal-body p-5">
                    <div class="row shadow-lg p-3">
                        <div class="col-md-6">
                            <p>Nomor Transaksi: <br><span id="transaction_number">TRX1090432</span></p>
                            <p>Nama Pelanggan: <br><span id="costumer_name">Umum</span></p>
                            <p>Nama Layanan: <br><span id="nama_service">Umum</span></p>
                        </div>
                        <div class="col-md-6">
                            <p>Harga Layanan: <br><span id="harga_service">Umum</span></p>
                            <p>Berat Pakaian: <br id="berat_pakaian"><span>Umum</span></p>
                            <p>Total Harus dibayar: <br><span id="total">Umum</span></p>
                        </div>
                    </div>
                    <div class="row shadow-lg p-3 mt-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" name="jumlah_bayar" class="form-control jumlah" id="jumlah_bayar">
                                <input type="hidden" id="idtrx">
                            </div>
                            <div class="mb-3">
                                <label for="kembalian">Kembalian</label>
                                <input type="text" name="kembalian" class="form-control kembalian" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal Pembayaran-->
<div class="modal fade" id="modallihat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Lihat Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="struk">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    var url = "<?= getenv('app.baseURL') ?>";
    var total;
    $(function() {

        Datatables();
        if ($("form#formbayar").length > 0) {
            $("form#formbayar").validate({
                rules: {
                    jumlah_bayar: {
                        required: true,
                        number: true,
                        minimal: true,
                    },

                },
                messages: {
                    jumlah_bayar: {
                        required: "Masukkan jumlah pembayaran",
                        number: "Jumlah Bayar harus berupa angka"
                    },
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },

            })
        }
    })

    function Datatables() {
        var table = $('#tb-transactions').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [],
            "ajax": {
                "url": url + "transaksi/datapembayaran",
                "type": "POST",
               
            },
            columnDefs: [{
                targets: [2, 3, 4],
                orderable: false,
            }],

        });
    }
    $('tbody').on('click', '.bayar', function() {
        let id = $(this).data("id");
        $('#idtrx').val(id);
        $.ajax({
            url: url + 'transaksi/getdata/' + id,
            type: "GET",
            success: function(data) {
                total = data.total.replace('Rp. ', '').replace('.', '').replace(',00', '');
                $.each(data, function(index, value) {
                    $('#' + index).html(value);
                })
                jQuery.validator.addMethod("minimal", function(value, element) {
                    return this.optional(element) || value > total - 1;
                }, "Pelanggan harus membayar sebesar Rp. " + total);
                $('#modalpembayaran').modal('show');
            }

        })
    })
    $('tbody').on('click', '.lihat', function() {
        let id = $(this).data("id");
        $.ajax({
            url: url + "/transaksi/struk/" + id,
            type: "GET",
            success: function(data) {
                $('#struk').html(data);
                $('#modallihat').modal('show');
            }
        })

    })
    $('.jumlah').keyup(function() {
        let val = $(this).val();
        if (!isNaN(val)) {
            let kembalian = val - total;
            $('.kembalian').val('Rp. ' + kembalian.toLocaleString('id-ID'));
        }
    })
    $('form#formbayar').submit(function(event) {
        let id = $('#idtrx').val();
        event.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: url + '/transaksi/bayar/' + id,
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.pesan,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#modalpembayaran').modal('hide');
                    Datatables();

                } else if (response.status == 400) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.pesan,
                    })
                }

            }
        })

    })
</script>
<?= $this->endSection('content'); ?>