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
                <table class="table mt-5" style="max-width: 100%; min-width:100%" id="tb-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Tempat, Tanggal Lahir</th>
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

                    <div id="other">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Suheri">
                            <label for="nama">Nama Lengkap</label>
                            <span id="text-nama"></span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Jl. Kayu Manis" autofocus required>
                            <label for="alamat">Alamat</label>
                            <span id="text-alamat"></span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="08xxxx" autofocus required>
                            <label for="no_telp">Nomor Telepon</label>
                            <span id="text-no_telp"></span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Pekanbaru" autofocus required>
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <span id="text-tempat_lahir"></span>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="29/08/1999" autofocus required>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="username" id="username" class="form-control" placeholder="laundryyy" autofocus required>
                            <label for="username">Username</label>
                            <span id="text-username"></span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="admin@gmail.com" autofocus required>
                            <label for="email">Email</label>
                            <span id="text-email"></span>
                        </div>
                    </div>
                    <div id="passgroup">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><a class="show_hide_pass" data-name="password"><i class="fa fa-eye"></i></a></span>
                            <div class="form-floating" style="width: 90%;">
                                <input type="password" name="password" id="password" class="form-control" placeholder="123457" autofocus required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <span id="text-password"></span>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><a class="show_hide_pass" data-name="confpass"><i class="fa fa-eye"></i></a></span>
                            <div class="form-floating" style="width: 90%;">
                                <input type="password" name="confpass" id="confpass" class="form-control " placeholder="123929" autofocus required>
                                <label for="confpass">Konfirmasi Password</label>
                            </div>
                        </div>
                        <span id="text-confpass"></span>
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
                    nama: {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    alamat: {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    no_telp: {
                        required: true,
                        minlength: 11,
                        maxlength: 15,
                        number: true
                    },
                    tempat_lahir: {
                        required: true,
                        minlength: 5,
                        maxlength: 30
                    },
                    tanggal_lahir: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                    confpass: {
                        required: true,
                        equalTo: '#password'
                    },
                    email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    nama: {
                        required: "Masukkan nama user",
                        minlength: "Nama user minimal 5 karakter",
                        maxlength: "Nama user maksimal 50 karakter",
                    },
                    alamat: {
                        required: "Masukkan alamat user",
                        minlength: "Alamat user minimal 5 karakter",
                        maxlength: "Alamat user maksimal 50 karakter",
                    },
                    no_telp: {
                        required: "Masukkan nomor telepon user",
                        minlength: "Nomor telepon user minimal 11 karakter",
                        maxlength: "Nomor telepon user maksimal 15 karakter",
                        number: "Nomor telepon harus berupa angka"
                    },
                    tempat_lahir: {
                        required: "Masukkan tempat lahir telepon user",
                        minlength: "Tempat lahir user minimal 5 karakter",
                        maxlength: "Tempat lahir user maksimal 30 karakter",
                    },
                    tanggal_lahir: {
                        required: "Masukkan tanggal lahir user",
                    },
                    username: {
                        required: "Masukkan username untuk user baru",
                    },
                    email: {
                        required: "Masukkan email user baru",
                        email: "Masukkan format email yang benar"
                    },
                    password: {
                        required: "Masukkan password untuk user",
                        minlength: "Password minimal 8 karakter"
                    },
                    confpass: {
                        required: "Masukkan ulang password untuk user",
                        equalTo: "Password harus sama dengan konfirmasi password"
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
    $('.show_hide_pass').on('click', function() {
        let type = $('input[name="' + $(this).data('name') + '"]').attr('type');
        if (type == 'password') {
            $('input[name="' + $(this).data('name') + '"]').attr('type', 'text');
            $(this).html('<i class="fa fa-eye-slash"></i>');
        } else {
            $('input[name="' + $(this).data('name') + '"]').attr('type', 'password');
            $(this).html('<i class="fa fa-eye"></i>');
        }
    })

    function Datatables() {
        var table = $('#tb-user').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "order": [],
            "ajax": {
                "url": url + "data/userdata",
                "type": "POST"
            },
            columnDefs: [{
                targets: [4, 5, 6, 7],
                orderable: false,
            }],

        });
    }
    $('.add').on('click', function(event) {
        $('.modal-title').text('Tambah data User');
        $('input').val('');
        event.preventDefault();
        $('#modaluser').modal('show');
        $('form#formuser').attr("action", url + 'data/store')
        $('#passgroup').show();
        $('#other').show();
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
                data: formData + "&type=user",
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
                        type: 'user'
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
        $('.modal-title').text('Ubah data User');
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
                type: 'user'
            },
            success: function(data) { 
                console.log(data);
                $.each(data, function(index, value) {
                    $('input[name="' + index + '"]').val(value);
                })
                $('form#formuser').attr("action", url + 'data/store/' + id);
                $('#modaluser').modal('show');
            }
        })
    })
    $('tbody').on('click', '.change', function(event) {
        $('.modal-title').text('Ganti password User');
        $('input').val('');
        $('form#formuser input').removeClass('is-invalid is-valid');
        $('.error').hide();
        let id = $(this).data("id");
        $('#other').hide();
        $('#passgroup').show();
        $('form#formuser').attr("action", url + 'data/store/' + id);
        $('#modaluser').modal("show");

    })
</script>
<?= $this->endSection('content'); ?>