<style>
    .container-fluid {
        background-color: #ffffff;
        border-radius: 8px;
        border: 1px solid lightgrey;
        padding: 16px;
        -webkit-box-shadow: 0px 0px 12px 2px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 0px 0px 12px 2px rgba(0, 0, 0, 0.75);
        box-shadow: 0px 0px 12px 2px rgba(0, 0, 0, 0.75);
    }

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
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><?= $title ?> <br><small class="text-secondary">Form Register</small></h1>
                    </div>
                    <hr>
                    <form class="user" id="form_register" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="inputFirstName" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-6 text-center">
                                <input type="text" class="form-control form-control-user" id="inputLastName" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="inputCompany" name="departemen" placeholder="Departemen/Divisi" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="inputEmail" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="inputPhone" name="phone" placeholder="Phone Number" required>
                        </div>
                        <!-- <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="inputUsername" name="" placeholder="Username" required>
                        </div> -->
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" id="inputPassword" name="password" placeholder="Password" required>
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
                        <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_regist">
                            Register Account
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small link_login" href="#" data-url="login">Already have an account? Login!</a>
                    </div>
                </div>
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
<script>
    $(document).ready(function() {
        $('.link_login').on('click', function() {
            let data_link = $(this).data('url');
            let url = `<?= base_url('auth') ?>/${data_link}`;
            window.location.replace(url)
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
                $('.btn_regist').prop('disabled', false);
            } else {
                $('#pwd_repeat_message').html('<i>password not matching</i>').css('color', 'red');
                $('.btn_regist').prop('disabled', true);
            }
            setTimeout(function() {
                $('#pwd_repeat_message').html('');
            }, 2000);
        });
        $('#form_register').submit(function(e) {
            e.preventDefault();
            let data_form = $(this).serializeArray();
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>/auth/register_new_user",
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
</script>