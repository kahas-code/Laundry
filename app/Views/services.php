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
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-services">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Layanan</th>
                            <th>Nama Layanan</th>
                            <th>Harga Layanan</th>
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
<div class="modal fade" id="modallayanan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="formlayanan">
                <div class="modal-body" style="padding: 1vw 2vw 1vw !important;">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama_service" id="nama_service" placeholder="Suheri">
                        <label for="nama_service">Nama Layanan</label>
                        <span id="text-nama_service"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="harga_service" id="harga_service" class="form-control" placeholder="Jl. Kayu Manis" autofocus required>
                        <label for="harga_service">Harga Layanan</label>
                        <span id="text-harga_service"></span>
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
        if ($("form#formlayanan").length > 0) {
            $("form#formlayanan").validate({
                rules: {
                    nama_service: {
                        required: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    harga_service: {
                        required: true,
                        minlength: 4,
                        maxlength: 7,
                        number: true
                    },
                },
                messages: {
                    nama_service: {
                        required: "Masukkan nama layanan",
                        minlength: "Nama layanan minimal 5 karakter",
                        maxlength: "Nama layanan maksimal 50 karakter",
                    },
                    harga_service: {
                        required: "Masukkan harga untuk layanan",
                        minlength: "Harga untuk layanan minimal ribuan",
                        maxlength: "Harga untuk layanan maksimal jutaan",
                        number: "Harga layanan harus berupa angka"
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
        var table = $('#tb-services').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [],
            "ajax": {
                "url": url + "data/datalayanan",
                "type": "POST"
            },
            columnDefs: [{
                targets: [2,3],
                orderable: false,
            }],

        });
    }
    $('.add').on('click', function(event) {
        $('input').val('');
        event.preventDefault();
        $('#modallayanan').modal('show');
        $('form#formlayanan').attr("action", url + 'data/store')
        $('form#formlayanan input').removeClass('is-invalid is-valid');
        $('.error').hide();
        $('.modal-title').text('Tambah Layanan');
    })
    $('form#formlayanan').submit(function(event) {
        let formData = $(this).serialize();
        event.preventDefault();
        if ($(this).valid()) {
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData + "&type=layanan",
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#modallayanan').modal('hide');
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
                        type: 'layanan'
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
        $('.modal-title').text('Ubah Data Layanan');
        $('form#formlayanan input').removeClass('is-invalid is-valid');
        $('.error').hide();
        $('#other').show();
        $('#passgroup').hide();
        event.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: url + '/data/getdatabyid/' + id,
            type: "GET",
            data: {
                type: 'layanan'
            },
            success: function(data) {
                console.log(data);
                $.each(data, function(index, value) {
                    $('input[name="' + index + '"]').val(value);
                })
                $('form#formlayanan').attr("action", url + 'data/store/' + id);
                $('#modallayanan').modal('show');
            }
        })
    })
</script>
<?= $this->endSection('content'); ?>