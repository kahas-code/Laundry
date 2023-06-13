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
            <div class="card-body">
                <a class="btn btn-success add mb-3"><i class="mdi mdi-account-plus"></i> Tambah Data</a>
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


<!-- Modal -->
<div class="modal fade" id="modaluser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="formuser">
                <div class="modal-body" style="padding: 1vw 2vw 1vw !important;">
                    <div class=" mb-3">
                        <label for="no_akun" class="form-label">Nama Akun</label>
                        <select name="no_akun" id="no_akun" class="form-select select2">
                            <option value="">--Pilh Akun--</option>
                            <?php foreach ($akuns as $akun) {
                                echo '<option value="' . $akun->no_akun . '">' . $akun->nama_akun . '</option>';
                            } ?>
                        </select>
                        <span id="text-no_akun"></span>
                    </div>
                    <div class=" mb-3">
                        <label for="no_trx" class="form-label">Nomor Transaksi</label>
                        <select name="no_trx" id="no_trx" class="form-select select2">
                            <option value="">--Pilh Transaksi--</option>
                            <?php foreach ($transactions as $transaction) {
                                echo '<option value="' . $transaction->transaction_number . '">' . $transaction->transaction_number . '</option>';
                            } ?>
                        </select>
                        <span id="text-no_trx"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Pekanbaru" autofocus required>
                        <label for="keterangan">Keterangan</label>
                        <span id="text-keterangan"></span>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_jurnal" class="form-label">Tanggal Jurnal</label>
                        <input type="date" name="tanggal_jurnal" id="tanggal_jurnal" class="form-control" placeholder="29/08/1999" autofocus required>
                        <span id="text-tanggal_jurnal"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="kredit" id="kredit" class="form-control debit-kredit" placeholder="29/08/1999" autofocus required>
                        <label for="kredit">Kredit</label>
                        <span id="text-kredit"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="debit" id="debit" class="form-control debit-kredit" placeholder="29/08/1999" autofocus required>
                        <label for="debit">Debit</label>
                        <span id="text-debit"></span>
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

<script>
    var url = "<?= getenv('app.baseURL') ?>";
    let data;
    $(function() {

        Datatables();
        if ($("form#formuser").length > 0) {
            $("form#formuser").validate({
                rules: {
                    no_akun: {
                        required: true,
                    },
                    no_trx: {
                        required: true,

                    },
                    keterangan: {
                        required: true,
                    },
                    tanggal_jurnal: {
                        required: true,
                    },
                    kredit: {
                        required: function(element) {
                            return (!$('#debit').hasClass('is-valid'));
                        }
                    },
                    debit: {
                        required: function(element) {
                            return (!$('#kredit').hasClass('is-valid'));
                        }

                    },
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
        $('.select2').select2({
            dropdownParent: $('#modaluser'),
            width: '100%',

        });
    })

    function Datatables() {
        var table = $('#tb-jurnal').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [],
            "ajax": {
                "url": url + "transaksi/datajurnal",
                "type": "POST"
            },
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8],
                orderable: false,
            }],

        });
    }
    $('.add').on('click', function(event) {
        $('#no_trx').val("").trigger('change');
        $('#no_akun').val("").trigger('change');
        $('.modal-title').text('Tambah data Jurnal');
        $('input').val('');
        event.preventDefault();
        $('#modaluser').modal('show');
        $('form#formuser').attr("action", url + 'transaksi/storejurnal')
        $('form#formuser input').removeClass('is-invalid is-valid');
        $('.error').hide();
    })
    $('form#formuser').submit(function(event) {
        let formData = $(this).serialize();
        event.preventDefault();
        if ($(this).valid()) {
            $.ajax({
                url: $(this).attr("action"),
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
                        $('#modaluser').modal('hide');
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
                    url: url + '/data/delete/' + id,
                    type: "GET",
                    data: {
                        type: 'jurnal'
                    },
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        Datatables();
                    }

                })
            }
        })
    })
    $('tbody').on('click', '.edit', function(event) {
        $('.modal-title').text('Ubah data jurnal');
        $('form#formuser input').removeClass('is-invalid is-valid');
        $('.error').hide();
        $('#other').show();
        $('#passgroup').hide();
        event.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: url + '/data/getdatabyid/' + id,
            type: "GET",
            data: {
                type: 'jurnal'
            },
            success: function(data) {
                $.each(data, function(index, value) {
                    $('input[name="' + index + '"]').val(value);
                })
                $('#no_trx').val(data.no_trx).trigger('change');
                $('#no_akun').val(data.no_akun).trigger('change');
                $('form#formuser').attr("action", url + 'transaksi/storejurnal/' + id);
                $('#modaluser').modal('show');
            }
        })
    })
</script>
<?= $this->endSection('content'); ?>