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
<div class="row mb-3 justify-content-center">
    <div class="card shadow-lg">
        <div class="col-md-12 p-3">
            <div class="card-header">
                <h5><?= $title ?></h5>
            </div>
            <div class="card-body">
                <form action="" id="formtransaksi">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="kode_costumer">Nama Pelanggan</label>
                            <select class="form-control" name="kode_costumer" id="kode_costumer">
                                <option value="">--Pilih pelanggan--</option>
                                <option value="0">Umum</option>
                                <?php foreach ($costumers as $costumer) : ?>
                                    <option value="<?= $costumer->kode_costumer ?>"><?= $costumer->kode_costumer . ' : ' . $costumer->nama_costumer ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kode_layanan">Kode Layanan</label>
                            <select class="form-control" name="kode_layanan" id="kode_layanan">
                                <option value="">--Pilih Layanan--</option>
                                <?php foreach ($services as $service) : ?>
                                    <option value="<?= $service->kode_service ?>"><?= $service->kode_service ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="berat_pakaian">Berat Pakaian (Kg)</label>
                            <input type="text" name="berat_pakaian" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Jenis Layanan</label>
                            <input type="text" class="form-control" id="jenis" readonly>
                            <label for="">Harga Layanan</label>
                            <input type="text" class="form-control" id="harga" readonly>
                            <label for="total">Total Biaya</label>
                            <input type="text" class="form-control" name="total" readonly>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success mt-2">Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card shadow-lg">
        <div class="col-md-12 p-3">
            <div class="card-body">
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-transactions">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode Layanan</th>
                            <th>Harga Layanan</th>
                            <th>Berat Pakaian</th>
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



<script>
    var url = "<?= getenv('app.baseURL') ?>";
    var harga;
    $(function() {

        Datatables();
        if ($("form#formtransaksi").length > 0) {
            $("form#formtransaksi").validate({
                rules: {
                    kode_layanan: {
                        required: true,
                    },
                    kode_costumer: {
                        required: true,
                    },
                    berat_pakaian: {
                        required: true,
                        number: true
                    }

                },
                messages: {
                    kode_layanan: {
                        required: "Pilih layanan terlebih dahulu",

                    },
                    kode_costumer: {
                        required: "Pilih pelanggan terlebih dahulu",
                    },
                    berat_pakaian: {
                        required: 'Masukkan berat pakaian',
                        number: 'Berat pakaian harus berupa nomor, gunakan . sebagai pemisah desimal'
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo($('#text-' + element.attr("name")))
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
                "url": url + "transaksi/datatransaksi",
                "type": "POST",
                "data": {
                    "status": 0
                }
            },
            columnDefs: [{
                targets: [1, 2, 3, 4, 5, 6, 7, 8],
                orderable: false,
            }],

        });
    }
    $('#kode_layanan').change(function() {
        let kode = $(this).val();
        $.ajax({
            url: url + 'data/findservices',
            type: 'GET',
            data: {
                kode_layanan: kode
            },
            success: function(data) {
                harga = data.harga_service;
                $('#jenis').val(data.nama_service);
                $('#harga').val('Rp. ' + new Intl.NumberFormat('id-ID').format(data.harga_service));
            }
        })
    })
    $('input[name="berat_pakaian"]').on('keyup paste change', function() {
        let berat = $(this).val();
        if (berat < 0) {
            $(this).val("0");
        }
        let hasil = berat * harga;
        let success = 'Rp. ' + new Intl.NumberFormat('id-ID').format(hasil);
        let err = "Pilih layanan, berat pakaian harus nomor, gunakan . untuk desimal";
        $('input[name="total"]').val(isNaN(hasil) ? err : success);
    })
    $('form#formtransaksi').submit(function(event) {
        event.preventDefault();
        if ($(this).valid()) {
            $.ajax({
                url: url + 'transaksi/simpan',
                type: "POST",
                data: {
                    service_code: $('#kode_layanan').val(),
                    costumer_code: $('#kode_costumer').val(),
                    berat_pakaian: $('input[name="berat_pakaian"]').val(),
                    total: $('input[name="total"]').val(),
                },
                success: function(response) {

                    if (response.status == 200) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        Datatables();
                        $('#kode_layanan').val("");
                        $('#kode_costumer').val("");
                        $('input').val("");
                        $('form#formtransaksi select').removeClass('is-invalid is-valid');
                        $('form#formtransaksi input').removeClass('is-invalid is-valid');
                        $('.error').hide();

                    } else if (response.status == 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.pesan,
                        })
                    }
                }

            })
        }
    })
    $('tbody').on('click', '.delete', function(event) {
        event.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus dari database!!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + '/transaksi/hapustransaksi/' + id,
                    type: "GET",
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.pesan,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            Datatables();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.pesan,
                            })
                        }
                    }

                })
            }
        })
    })
</script>
<?= $this->endSection('content'); ?>