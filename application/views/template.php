<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo/favicon-32x32.png">
    <title><?= $title; ?> | <?= $subpage ?></title>
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <?php if ($page != 'Auth') : ?>
        <link href="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <?php else : ?>
        <?php $this->load->view('layout/script'); ?>
    <?php endif; ?>
</head>
<?php if ($page != 'Auth') : ?>

    <body id="page-top">
        <div id="wrapper">
            <!-- Content Wrapper -->
            <?php $this->load->view('layout/sidebar'); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php $this->load->view('layout/topbar'); ?>
                    <?php $this->load->view('layout/script'); ?>
                    <?php $this->load->view($content); ?>
                </div>
                <!-- End of Main Content -->
                <?php $this->load->view('layout/footer'); ?>
            </div>
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?= base_url() ?>/auth/logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.modal').on('hidden.bs.modal', function(e) {
                    location.reload(); // then reload the page.(3)
                });
                $('inputPassword, #inputRepeatPassword').on('keyup', function() {
                    $('.progress').prop('hidden', false);
                    var m = $(this).val();
                    var n = m.length;
                    // Function for checking
                    check(n, m);
                    let pwd = $('#inputPassword').val();
                    let pwd2 = $(this).val();
                    if ($('#inputPassword').val() == $('#inputRepeatPassword').val()) {
                        $('#pwd_repeat_message').html('<i>password matching</i>').css('color', 'green');
                        $('.btn_simpan').prop('disabled', false);
                    } else {
                        $('#pwd_repeat_message').html('<i>password not matching</i>').css('color', 'red');
                        $('.btn_simpan').prop('disabled', true);
                    }
                    setTimeout(function() {
                        $('#pwd_repeat_message').html('');
                    }, 2000);
                });

                $('.btnEditPassword').click(function() {
                    $('#modalEditPassword').modal('show');
                    $('#form_edit_password').submit(function(e) {
                        e.preventDefault();
                        let data_form = $(this).serializeArray();
                        console.log(data_form)
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('members') ?>/update_password",
                            data: data_form,
                            dataType: "json",
                            success: function(response) {
                                // console.log(response)
                                Swal.fire({
                                    icon: response.icon,
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                                setTimeout(function() { // wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                                }, 1000);
                            }
                        });
                    });
                });
                $('.btnEditProfile').click(function() {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('admin') ?>/kelola_anggota/get_data",
                        data: {
                            id: <?= $this->session->userdata('user_id') ?>
                        },
                        dataType: "json",
                        success: function(response) {
                            // console.log(response);
                            let user = response.data;
                            $('#editId').val(user.id);
                            $('#editFirstName').val(user.first_name);
                            $('#editLastName').val(user.last_name);
                            $('#editEmail').val(user.email);
                            $('#editPhone').val(user.phone);
                        }
                    });
                    $('#modalEditProfile').modal('show');
                    $('#form_edit_profile').submit(function(e) {
                        e.preventDefault();
                        let data_form = $(this).serializeArray();
                        console.log(data_form)
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('members') ?>/update_profile",
                            data: data_form,
                            dataType: "json",
                            success: function(response) {
                                // console.log(response)
                                Swal.fire({
                                    icon: response.icon,
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                                setTimeout(function() { // wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                                }, 1000);
                            }
                        });
                    });
                })
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin') ?>/kelola_anggota/get_data",
                    data: {
                        id: <?= $this->session->userdata('user_id') ?>
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response)
                        $("#profile_img").attr(`src`, `<?= base_url('assets') ?>/img/${response.data.user_img}`);
                    }
                });
            });
        </script>
    <?php else : ?>

        <body class="bg-gradient-primary">
            <div class="container">
                <?php $this->load->view($content); ?>
            </div>
        <?php endif; ?>
        </body>

</html>