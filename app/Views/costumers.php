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
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-costumers">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode Pelanggan</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
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
<div class="modal fade" id="modalpelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="formpelanggan">
                <div class="modal-body" style="padding: 1vw 2vw 1vw !important;">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama_costumer" id="nama_costumer" placeholder="Suheri">
                        <label for="nama_costumer">Nama Pelanggan</label>
                        <span id="text-nama_costumer"></span>
                    </div>
                    <!-- <div class="form-floating mb-3">
                        <input type="text" name="kode_costumer" id="kode_costumer" class="form-control" placeholder="Jl. Kayu Manis" autofocus required>
                        <label for="kode_costumer">Kode Pelanggan</label>
                        <span id="text-kode_costumer"></span>
                    </div> -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Suheri">
                        <label for="alamat">Alamat</label>
                        <span id="text-alamat"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Jl. Kayu Manis" autofocus required>
                        <label for="no_telp">Nomor Telepon</label>
                        <span id="text-no_telp"></span>
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

    $(function() {

        Datatables();
        if ($("form#formpelanggan").length > 0) {
            $("form#formpelanggan").validate({
                rules: {
                    nama_costumer: {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    alamat: {
                        required: true,
                        minlength: 5,
                        maxlength: 30,
                    },
                    no_telp: {
                        required: true,
                        minlength: 11,
                        maxlength: 15,
                        number: true
                    },

                },
                messages: {
                    nama_costumer: {
                        required: "Masukkan nama pelanggan",
                        minlength: "Nama pelanggan minimal 5 karakter",
                        maxlength: "Nama pelanggan maksimal 50 karakter",
                    },
                    alamat: {
                        required: "Masukkan alamat pelanggan",
                        minlength: "Alamat pelanggan minimal 5 karakter",
                        maxlength: "Alamat pelanggan maksimal 50 karakter",
                    },
                    no_telp: {
                        required: "Masukkan nomor telepon pelanggan",
                        minlength: "Nomor telepon pelanggan minimal 11 karakter",
                        maxlength: "Nomor telepon pelanggan maksimal 15 karakter",
                        number: "Nomor telepon pelanggan harus berupa angka"
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

    })

    function Datatables() {
        var table = $('#tb-costumers').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [],
            "ajax": {
                "url": url + "data/datapelanggan",
                "type": "POST"
            },
            columnDefs: [{
                targets: [2, 3, 4, 5],
                orderable: false,
            }],

        });
    }
    $('.add').on('click', function(event) {
        $('.modal-title').text('Tambah Data Pelanggan');
        $('input').val('');
        event.preventDefault();
        $('#modalpelanggan').modal('show');
        $('form#formpelanggan').attr("action", url + 'data/store')
        $('form#formpelanggan input').removeClass('is-invalid is-valid');
        $('.error').hide();
    })
    $('form#formpelanggan').submit(function(event) {
        let formData = $(this).serialize();
        event.preventDefault();
        if ($(this).valid()) {
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData + "&type=pelanggan",
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#modalpelanggan').modal('hide');
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
                        type: 'pelanggan'
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
        $('.modal-title').text('Ubah Data Pelanggan');
        $('form#formpelanggan input').removeClass('is-invalid is-valid');
        $('.error').hide();
        $('#other').show();
        $('#passgroup').hide();
        event.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: url + '/data/getdatabyid/' + id,
            type: "GET",
            data: {
                type: 'pelanggan'
            },
            success: function(data) {
                $.each(data, function(index, value) {
                    $('input[name="' + index + '"]').val(value);
                })
                $('form#formpelanggan').attr("action", url + 'data/store/' + id);
                $('#modalpelanggan').modal('show');
            }
        })
    })
</script>
<?= $this->endSection('content'); ?>