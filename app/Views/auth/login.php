<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title><?= $title ?> || Laundry</title>
    <?= $this->include('partials/style'); ?>


</head>
<style>
    body {
        background-color: #f5f5f5;
        height: 100vh;
        width: 100vw;
    }

    .row {
        height: 100%;
    }

    .swal-height {
        height: 20vh !important;
    }

    .error {
        color: red;
    }
</style>

<body>
    <div class="row justify-content-center">
        <div class="col-md-4 align-content-center my-auto">
            <div class="card shadow-lg p-5">
                <div class="card-header text-center">
                    <img class="mb-4" src="<?=getenv('app.baseURL')?>assets/images/icon.jpg" alt="" style="max-width: 10vw;" >
                </div>
                <div class="card-body">
                    <form class="form-signin" id="formlogin">
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email address</label>
                            <input type="text" name="username" class="form-control" placeholder="Username or Email Address" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text h-100" id="basic-addon1"><a class="show-hide"><i class="fa fa-eye"></i></a> </span>
                                </div>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <span id="text-password"></span>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Sign in</button>
                        <p class="mt-5 mb-3 text-muted text-center">&copy; <?= date('Y') ?></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?= $this->include('partials/script'); ?>
<script>
    $(function() {
        if ($("form#formlogin").length > 0) {
            $("form#formlogin").validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    username: {
                        required: "Masukkan username atau email Anda",
                    },
                    password: {
                        required: "Masukkan password Anda",
                    },
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "password") {
                        $("#text-password").html(error[0]);
                    } else {
                        error.insertAfter(element);
                    }
                },

            })
        }
    });
    $('.show-hide').on('click', function() {
        let el = $('#password');
        if (el.attr('type') == 'password') {
            el.attr('type', 'text');
            $(this).html('<i class="fa fa-eye-slash"></i>')
        } else {
            el.attr('type', 'password');
            $(this).html('<i class="fa fa-eye"></i>')
        }
    })
    $('form#formlogin').submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let timerInterval
        if ($(this).valid()) {
            Swal.fire({
                title: 'Memeriksa data',
                html: 'Mohon tunggu proses validasi data',
                timer: 2000,
                timerProgressBar: true,
                heightAuto: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                $.ajax({
                    url: window.location.origin + '/auth',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.pesan,
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                window.location = window.location.origin;
                            })
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
        }

    });
</script>

</html>