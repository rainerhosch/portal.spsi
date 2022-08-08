<!-- Begin Page Content -->
<style>
    @media screen and (max-width: 767px) {

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: right;
        }
    }

    @media screen and (min-width: 520px) {
        .container-fluid {
            font-size: 11px;
        }

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            margin: 0 auto;
        }

        div.dataTables_wrapper div.dataTables_length select {
            font-size: 8px;
        }

        div.dataTables_wrapper div.dataTables_filter {
            font-size: 8px;
            text-align: right;
        }

        tr {
            height: -50px;
        }

        .table td,
        .table th {
            padding: 0.50rem;
            vertical-align: top;
            border-top: 1px solid #e3e6f0;
        }
    }

    .tombol {
        padding: 8px 15px;
        border-radius: 3px;
        background: #ECF0F1;
        border: none;
        color: #232323;
        font-size: 12pt;
    }

    .kotak {
        margin: 20px auto;
        background: #1ABC9C;
        width: 900px;
        padding: 20px 50px 50px 50px;
        border-radius: 3px;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl_data_pengunduran" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tlp</th>
                            <th>Departemen</th>
                            <th>Alasan Pengunduran</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_data_pengunduran">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "kelola_pengunduran/get_data",
            dataType: "json",
            success: function(response) {
                // console.log(response)
                let data_user = response.data;
                let html = ``;
                if (data_user != null) {
                    $.each(data_user, function(k, user) {
                        html += `<tr>`;
                        html += `<td>${user.nama_lengkap}</td>`;
                        html += `<td>${user.email}</td>`;
                        html += `<td>${user.phone}</td>`;
                        html += `<td>${user.departemen}</td>`;
                        html += `<td>${user.alasan_pengunduran_diri}</td>`;
                        html += `<td class="text-center">`;
                        if (user.status === '1') {
                            html += `<i class="fa fa-check"></i>`;
                        } else {
                            html += `<a class="btn btn-sm btn-info btnApprove" data-id="${user.id}" data-user_id="${user.user_id}">Approve</a>`;
                        }
                        html += `</td>`;
                        html += `</tr>`;
                    });
                } else {

                }
                $('#tbody_data_pengunduran').html(html)
                $('#tbl_data_pengunduran').DataTable({
                    // scrollY: "200px",
                    scrollX: true,
                    scrollCollapse: true,
                    // searching: false,
                    fixedColumns: {
                        heightMatch: 'none'
                    },
                    "aLengthMenu": [
                        [5, 10, 20, -1],
                        [5, 10, 20, "All"]
                    ],
                    "iDisplayLength": 5
                });
                $('.btnEdit').on('click', function() {
                    let data_id = $(this).data('id');
                    console.log('Edit ' + data_id)
                });

                $('.btnApprove').on('click', function() {
                    let id_pengunduran = $(this).data('id');
                    let user_id = $(this).data('user_id');

                    console.log(user_id)

                    Swal.fire({
                        icon: 'warning',
                        title: 'Setujui pengunduran ini?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "kelola_pengunduran/approve",
                                data: {
                                    id: id_pengunduran,
                                    user_id: user_id
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
            }
        });

    });
</script>