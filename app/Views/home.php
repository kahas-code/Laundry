<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>

<div class="row ">
    <div class="col-md-12">
        <div class="card p-5">
            <div class="card-header text-center">
                <img class="mb-4 " src="<?= getenv('app.baseURL') ?>assets/images/icon.jpg" alt="" style="max-width: 20vw;">
                <h1 >Selamat Datang di Me Laundry</h1>
            </div>
        </div>
    </div>
</div>



<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

<!-- partial -->
<?= $this->endSection('content'); ?>