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
            <div class="col-md-6 mt-3 mb-0">

                <form action="<?= getenv('app.baseURL') ?>data/store" id="formakun">

                    <div class="form-floating mb-3">
                        <input type="text" name="no_akun" id="no_akun" class="form-control" placeholder="Jl. Kayu Manis" autofocus required>
                        <label for="no_akun">Nomor Akun</label>
                        <span id="text-no_akun"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama_akun" id="nama_akun" placeholder="Suheri">
                        <label for="nama_akun">Nama Akun</label>
                        <span id="text-nama_akun"></span>
                    </div>

                    <button type="submit" class="btn btn-success mb-3"><i class="mdi mdi-account-plus"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary reset mb-3"><i class="mdi mdi-close-octagon"></i> Reset Form</button>
                </form>
            </div>

            <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-services">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Akun</th>
                        <th>Nama Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>



<script>
    var url = "<?= getenv('app.baseURL') ?>";

    $(function() {
        Datatables();
        if ($("form#formakun").length > 0) {
            $("form#formakun").validate({
                rules: {
                    no_akun: {
                        required: true,

                    },
                    nama_akun: {
                        required: true,
                    },
                },
                messages: {
                    no_akun: {
                        required: "Masukkan Nomor Akun",
                    },
                    nama_akun: {
                        required: "Masukkan Nama Akun",
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
                "url": url + "data/dataakun",
                "type": "POST"
            },
            columnDefs: [{
                targets: [2, 3],
                orderable: false,
            }],

        });
    }

    $('form#formakun').submit(function(event) {
        let formData = $(this).serialize();
        event.preventDefault();
        if ($(this).valid()) {
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData + "&type=akun",
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
                        $('.reset').trigger('click');

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
                        type: 'akun'
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
        $('form#formakun input').removeClass('is-invalid is-valid');
        $('.error').hide();
        event.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: url + '/data/getdatabyid/' + id,
            type: "GET",
            data: {
                type: 'akun'
            },
            success: function(data) {
                $.each(data, function(index, value) {
                    $('input[name="' + index + '"]').val(value);
                })
                $('form#formakun').attr("action", url + 'data/store/' + id);
            }
        })
    })
    $('.reset').on('click', function() {
        $('form#formakun input').removeClass('is-invalid is-valid');
        $('.error').hide();
        $('form#formakun').attr("action", url + 'data/store');
        $('input').val('');
    })
</script>
<?= $this->endSection('content'); ?>