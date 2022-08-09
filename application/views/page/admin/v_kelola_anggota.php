<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item btnAddAnggota" href="#" id="btnAddAnggota">Tambah Data</a>
                    <hr>
                    <a class="dropdown-item btnExportData" href="#" id="btnExportData">Export Excel</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl_data_anggota" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>No Tlp</th>
                            <th>Departemen</th>
                            <th>Status Aktif</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_data_anggota">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                        <input type="text" class="form-control form-control-user" id="inputCompany" name="departemen" placeholder="Departemen" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="inputEmail" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="inputPhone" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="viewPassword" name="view_password" placeholder="password123" disabled>
                            <input type="hidden" class="form-control form-control-user" name="password" placeholder="Password" value="password123">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_regist">
                        Simpan
                    </button>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btnExportData').click(function() {
            window.open('<?= base_url('admin/kelola_anggota/export_data_anggota') ?>')
        });
        $('.btnAddAnggota').on('click', function() {
            $('#modalAddAnggota').modal('show');
            $('#form_register').submit(function(e) {
                e.preventDefault();
                let data_form = $(this).serializeArray();

                // console.log(data_form)
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
        $.ajax({
            type: "POST",
            url: "kelola_anggota/get_data",
            dataType: "json",
            success: function(response) {
                // console.log(response)
                let data_user = response.data;
                let html = ``;
                if (data_user.length > 0) {
                    $.each(data_user, function(k, user) {
                        html += `<tr>`;
                        html += `<td>${user.first_name} ${user.last_name}</td>`;
                        html += `<td>${user.email}</td>`;
                        html += `<td>${user.phone}</td>`;
                        html += `<td>${user.departemen}</td>`;
                        if (user.active === '1') {
                            html += `<td class="text-center"><a class="btn btn-sm btn-info btnIsActive" data-id="${user.id}" data-active="${user.active}"><i class="fa fa-unlock-alt"></i></a></td>`;
                        } else {
                            html += `<td class="text-center"><a class="btn btn-sm btn-warning btnIsActive" data-id="${user.id}" data-active="${user.active}"><i class="fa fa-lock"></i></a></td>`;
                        }
                        html += `<td class="text-center">`;
                        // html += `<a class="btn btn-sm btn-success btnEdit" data-id="${user.id}"><i class="fas fa-pen"></i></a>`;
                        // html += ` | `;
                        html += `<a class="btn btn-sm btn-danger btnDelete" data-id="${user.id}"><i class="fas fa-trash"></i></a>`;
                        html += `</td>`;
                        html += `</tr>`;
                    });
                } else {

                }
                $('#tbody_data_anggota').html(html)
                $('#tbl_data_anggota').DataTable();
                $('.btnEdit').on('click', function() {
                    let data_id = $(this).data('id');
                    console.log('Edit ' + data_id)
                });

                $('.btnIsActive').on('click', function() {
                    let data_id = $(this).data('id');
                    let data_active = $(this).data('active');
                    let data_update = '';
                    let title = '';
                    if (data_active === 1) {
                        data_update = '0';
                        title = `Non aktifkan user?`;
                    } else {
                        data_update = '1';
                        title = `Aktifkan user?`;
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: title,
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "kelola_anggota/update_status_aktiv",
                                data: {
                                    id: data_id,
                                    data_update: data_update
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.status === true) {
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
                                }
                            });
                        }
                    });
                });


                $('.btnDelete').on('click', function() {
                    let data_id = $(this).data('id');
                    // console.log('Delete ' + data_id)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Data?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "kelola_anggota/delete_data",
                                data: {
                                    id: data_id,
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.status === true) {
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
                                }
                            });
                        }
                    })
                });
            }
        });
    });
</script>
<!-- /.container-fluid -->