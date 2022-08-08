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
</style>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Kegiatan</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#" id="btnAddKegiatan">Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbl_data_kegiatan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_data_kegiatan">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddKegiatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="form_AddKegiatan" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputUser">Tanggal & Waktu</label>
                        <input type="date" class="form-control form-control-sm" id="inputTgl" name="inputTgl" required>
                        <input type="time" class="form-control form-control-sm mt-3" id="inputJam" name="inputJam" required>
                    </div>
                    <div class="form-group">
                        <label for="selectJabatan">Lokasi Kegiatan Kegiatan</label>
                        <input type="text" class="form-control form-control-sm" id="inputLokasi" name="inputLokasi" required>
                    </div>
                    <div class="form-group">
                        <label for="selectJabatan">Deksripsi Kegiatan</label>
                        <textarea type="text" class="form-control form-control-sm" id="inputDescKegiatan" name="inputDescKegiatan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_regist">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditKegiatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="form_EditKegiatan" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputUser">Tanggal & Waktu</label>
                        <input type="hidden" class="form-control form-control-sm" id="editId" name="editId" required>
                        <input type="date" class="form-control form-control-sm" id="editTgl" name="editTgl" required>
                        <input type="time" class="form-control form-control-sm mt-3" id="editJam" name="editJam" required>
                    </div>
                    <div class="form-group">
                        <label for="selectJabatan">Lokasi Kegiatan Kegiatan</label>
                        <input type="text" class="form-control form-control-sm" id="editLokasi" name="editLokasi" required>
                    </div>
                    <div class="form-group">
                        <label for="selectJabatan">Deksripsi Kegiatan</label>
                        <textarea type="text" class="form-control form-control-sm" id="editDesc" name="editDesc"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-user btn-block btn_regist">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btnAddKegiatan').click(function() {
            $('#modalAddKegiatan').modal('show');
            $('#form_AddKegiatan').submit(function(e) {
                e.preventDefault();
                let data_form = $(this).serializeArray();
                // console.log(data_form)
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin') ?>/kelola_kegiatan/add_data_kegiatan",
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
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });
        });
        $.ajax({
            url: `<?= base_url('admin') ?>/kelola_kegiatan/get_data`,
            type: `POST`,
            dataType: `json`,
            success: function(response) {
                // console.log(response)
                let html = ``;
                let data = response.data;
                let no = 1;
                if (data != null) {
                    $.each(data, function(i, item) {
                        html += `<tr>`;
                        html += `<td>${no}</td>`;
                        html += `<td>${item.tgl}</td>`;
                        html += `<td>${item.jam}</td>`;
                        html += `<td>${item.desc}</td>`;
                        html += `<td>${item.lokasi}</td>`;
                        if (item.status === 1) {
                            html += `<td><span class="mr-2"><i class="fas fa-check text-success"></i></span> ${item.info}</td>`;
                        } else {
                            html += `<td><span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>${item.info} </td>`;

                        }
                        html += `<td class="text-center">`;
                        html += `<a class="btn btn-sm btn-warning btnEdit" data-id="${item.id}" data-tgl="${item.tgl}" data-jam="${item.jam}" data-desc="${item.desc}" data-lok="${item.lokasi}" style="font-size: 10px;"><i class="fas fa-pen"></i></a> | `;
                        html += `<a class="btn btn-sm btn-danger btnHapus" data-id="${item.id}" style="font-size: 10px;"><i class="fas fa-trash"></i></a>`;
                        html += `</td>`;
                        html += `</tr>`;
                        no++;
                    });
                }
                $('#tbody_data_kegiatan').html(html);
                $('#tbl_data_kegiatan').DataTable({
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
                $('.btnEdit').click(function() {
                    let data_id = $(this).data('id');
                    let tgl = $(this).data('tgl');
                    let jam = $(this).data('jam');
                    let desc = $(this).data('desc');
                    let lok = $(this).data('lok');
                    $('#editId').val(data_id);
                    $('#editTgl').val(tgl);
                    $('#editJam').val(jam);
                    $('#editDesc').val(desc);
                    $('#editLokasi').val(lok);
                    $('#modalEditKegiatan').modal('show');
                    $('#form_EditKegiatan').submit(function(e) {
                        e.preventDefault();
                        let data_form = $(this).serializeArray();
                        console.log(data_form)
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('admin') ?>/kelola_kegiatan/update_data_kegiatan",
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
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    });
                });
                $('.btnHapus').click(function() {
                    let data_id = $(this).data('id');
                    // console.log(data_id)
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Data?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('admin') ?>/kelola_kegiatan/delete_data",
                                data: {
                                    id: data_id
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
    });
</script>