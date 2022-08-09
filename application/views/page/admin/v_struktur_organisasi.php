<!-- Begin Page Content -->
<style>
    .ui-autocomplete {
        position: absolute;
        z-index: 2147483647;
        cursor: default;
        padding: 0;
        margin-top: 2px;
        list-style: none;
        background-color: #ffffff;
        border: 1px solid #ccc;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .ui-autocomplete>li {
        padding: 3px 20px;
    }

    .ui-autocomplete>li.ui-state-focus {
        background-color: #DDD;
    }

    .ui-helper-hidden-accessible {
        display: none;
    }

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

    #diagram_container svg {
        width: 100%;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets') ?>/vendor/bagan/diagram.css">
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div id="diagram_container"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datamaster Jabatan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" id="btnAddJabatan">Tambah Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl_data_jabatan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jabatan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data_jabatan">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Struktur Organisasi</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" id="btnAddStruktur">Tambah Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl_data_struktur" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAMA</th>
                                    <th>JABATAN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data_struktur">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddStruktur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Struktur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="form_addStruktur" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="selectJabatan">Cari Anggota</label>
                        <select class="form-control form-control-sm" id="selectJabatan" name="inputJabatan" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputUser">Cari Anggota</label>
                        <input type="text" class="form-control form-control-sm" id="inputUser" name="inputUser" placeholder="Cari data" required>
                        <span id="alert_text"></span>
                        <input type="hidden" class="form-control form-control-sm" id="inputIdUser" name="inputIdUser">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_regist">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/jquery-ui/jquery.ui.autocomplete.scroll.min.js"></script>
<script src="<?= base_url('assets'); ?>/js/autocomplete.js"></script>
<script src="<?= base_url('assets') ?>/vendor/bagan/diagram.js"></script>
<script>
    let diagram = new dhx.Diagram("diagram_container", {
        type: "org",
        defaultShapeType: "img-card",
        scale: 0.9
    });
    diagram.data.load('<?= base_url('admin') ?>/struktur_spsi/get_bagan');
</script>
<script>
    $(document).ready(function() {
        $('.modal').on('hidden.bs.modal', function(e) {
            location.reload(); // then reload the page.(3)
        })
        $('#btnAddStruktur').on('click', function() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin') ?>/struktur_spsi/get_master_jabatan",
                data: {
                    select: 1
                },
                dataType: "json",
                success: function(response) {
                    // console.log(response)
                    let data = response.data;
                    let html = ``;
                    html += `<option value="" hidden>Pilih Jabatan</option>`;
                    $.each(data, function(k, item) {
                        html += `<option value="${item.id}">${item.nama}</option>`;
                    });
                    $('#selectJabatan').append(html);
                }
            });
            $('#modalAddStruktur').modal('show');
            // Auto complete user
            $('#inputUser').autocomplete({
                maxShowItems: 5,
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: '<?= base_url('admin') ?>/struktur_spsi/cari_data_anggota',
                        type: 'post',
                        dataType: "json",
                        serverSide: true,
                        data: {
                            search: request.term
                        },
                        success: function(res) {
                            // console.log(res.data)
                            if (res.data != null) {
                                response(res.data);
                            } else {
                                $('#alert_text').html(`<small><code>Data tidak ada.</code></small>`);
                                setTimeout(function() {
                                    $('#alert_text').html('');
                                }, 2000);
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    $('#inputUser').val(ui.item.label); // display the selected text
                    $('#inputIdUser').val(ui.item.id); // save selected id to input
                    return false;
                },
                focus: function(event, ui) {
                    $('#inputUser').val(ui.item.label); // display the selected text
                    $('#inputIdUser').val(ui.item.id); // save selected id to input
                    return false;
                },
            });

            $('#form_addStruktur').submit(function(e) {
                e.preventDefault();
                let data_form = $(this).serializeArray();
                console.log(data_form)
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin') ?>/struktur_spsi/add_data_struktur",
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
        $('#btnAddJabatan').on('click', function() {
            Swal.fire({
                title: 'Tambah Jabatan',
                html: `<input type="text" id="inputJabatan" class="swal2-input" placeholder="Nama Jabatan">`,
                confirmButtonText: 'Simpan',
                showCancelButton: true,
                focusConfirm: false,
            }).then((result) => {
                const inputJabatan = Swal.getPopup().querySelector('#inputJabatan').value
                if (result.isConfirmed) {
                    // console.log(inputJabatan)
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('admin') ?>/struktur_spsi/add_master_jabatan",
                        data: {
                            'inputJabatan': inputJabatan
                        },
                        dataType: "json",
                        success: function(response) {
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
                }
            })
        });


        $.ajax({
            type: "POST",
            url: "<?= base_url('admin') ?>/struktur_spsi/get_data_struktur",
            dataType: "json",
            success: function(response) {
                let data = response.data;
                // console.log(response)
                let html = ``;
                let no = 1;
                if (data.length > 0) {
                    $.each(data, function(k, item) {
                        html += `<tr>`;
                        html += `<td>${no}</td>`;
                        html += `<td>${item.data_user.first_name} ${item.data_user.last_name}</td>`;
                        html += `<td>${item.data_jabatan.nama}</td>`;
                        html += `<td class="text-center">`;
                        html += `<a class="btn btn-sm btn-danger btnHapus" data-id="${item.id}" style="font-size: 10px;"><i class="fas fa-trash"></i></a>`;
                        html += `</td>`;
                        html += `</tr>`;
                        no++;
                    });
                }
                $('#tbody_data_struktur').html(html);
                $('.btnHapus').on('click', function() {
                    let data_id = $(this).data('id');
                    // console.log(data)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Data?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('admin') ?>/struktur_spsi/delete_data",
                                data: {
                                    id: data_id,
                                    table: 'struktur_org'
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
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    });
                });
            }
        });

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin') ?>/struktur_spsi/get_master_jabatan",
            dataType: "json",
            success: function(response) {
                // console.log(response)
                let data = response.data;
                let html = ``;
                let no = 1;
                if (data.length > 0) {
                    $.each(data, function(k, item) {
                        html += `<tr>`;
                        html += `<td>${no}</td>`;
                        html += `<td>${item.nama}</td>`;
                        html += `<td class="text-center">`;
                        html += `<a class="btn btn-sm btn-danger btnDeleteJabatan" data-id="${item.id}" style="font-size: 10px;"><i class="fas fa-trash"></i></a>`;
                        html += `</td>`;
                        html += `</tr>`;
                        no++;
                    });
                }
                $('#tbody_data_jabatan').html(html);
                $('.btnDeleteJabatan').on('click', function() {
                    let data_id = $(this).data('id');
                    // console.log(data)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Data?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('admin') ?>/struktur_spsi/delete_data",
                                data: {
                                    id: data_id,
                                    table: 'm_jabatan_org'
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
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    });
                });
                $('table').DataTable({
                    // scrollY: "200px",
                    scrollX: true,
                    scrollCollapse: true,
                    searching: false,
                    fixedColumns: {
                        heightMatch: 'none'
                    },
                    "aLengthMenu": [
                        [5, 10, 20, -1],
                        [5, 10, 20, "All"]
                    ],
                    "iDisplayLength": 5
                });
            }
        });
    });
</script>