<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center">
                        <img class="rounded-circle" src="<?= base_url() ?>assets/img/logo/android-icon-48x48.png" alt="...">
                        <h1 class="h4 text-gray-900 mb-4"><?= $title; ?></h1>
                    </div>
                    <div id="div_alert">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                    <form action="<?= base_url('auth'); ?>" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block" id="btn-login">
                            Login
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small link_forgotpassword" href="#" data-url="forgot_password">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small link_register" href="#" data-url="register">Create an Account!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#div_alert').html('');
            <?php $this->session->unset_userdata('message'); ?>
        }, 2000);
        $('.link_forgotpassword').on('click', function() {
            let data_link = $(this).data('url');
            // console.log(data_link);
            let url = `<?= base_url('auth') ?>/${data_link}`;
            window.location.replace(url)
        });
        $('.link_register').on('click', function() {
            let data_link = $(this).data('url');
            // console.log(data_link);
            let url = `<?= base_url('auth') ?>/${data_link}`;
            window.location.replace(url)
        });
    });
</script>