<!-- Topbar -->
<style>
    .input-group {
        width: 80%;
        height: auto;
        padding: 4px;
    }

    .progress {
        height: 4px;
    }

    .progress-bar {
        background-color: green;
    }
</style>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('email'); ?></span>
                <img class="img-profile rounded-circle" src="" id="profile_img">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item btnEditProfile" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Edit Profile
                </a>
                <a class="dropdown-item btnEditPassword" href="#">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ubah Password
                </a>
                <hr>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="modal fade" id="modalEditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="form_edit_profile" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="hidden" class="form-control form-control-user" id="editId" name="id" required>
                            <input type="text" class="form-control form-control-user" id="editFirstName" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="col-sm-6 text-center">
                            <input type="text" class="form-control form-control-user" id="editLastName" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="editEmail" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="editPhone" name="phone" placeholder="Phone Number" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_simpan">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="form_edit_password" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="inputPassword" name="password" placeholder="Insert New Password" required>
                        </div>
                        <div class="col-sm-6 text-center">
                            <input type="password" class="form-control form-control-user" id="inputRepeatPassword" name="password_confirm" placeholder="Repeat Password" required>
                            <small id="pwd_repeat_message"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="progress" hidden>
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_simpan">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    var percentage = 0;

    function check(n, m) {
        if (n < 6) {
            percentage = 0;
            $(".progress-bar").css("background", "#dd4b39");
        } else if (n < 8) {
            percentage = 20;
            $(".progress-bar").css("background", "#9c27b0");
        } else if (n < 10) {
            percentage = 40;
            $(".progress-bar").css("background", "#ff9800");
        } else {
            percentage = 60;
            $(".progress-bar").css("background", "#4caf50");
        }

        // Check for the character-set constraints
        // and update percentage variable as needed.
        //Lowercase Words only
        if ((m.match(/[a-z]/) != null)) {
            percentage += 10;
        }
        //Uppercase Words only
        if ((m.match(/[A-Z]/) != null)) {
            percentage += 10;
        }
        //Digits only
        if ((m.match(/0|1|2|3|4|5|6|7|8|9/) != null)) {
            percentage += 10;
        }
        //Special characters
        if ((m.match(/\W/) != null) && (m.match(/\D/) != null)) {
            percentage += 10;
        }
        // Update the width of the progress bar
        $(".progress-bar").css("width", percentage + "%");
    }
</script>

<!-- <script>
    $(document).ready(function() {
    });
</script> -->
<!-- End of Topbar -->