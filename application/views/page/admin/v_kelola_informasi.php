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
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <div id="div_alert">
        <?= $this->session->flashdata('message'); ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Informasi</h6>
                </div>
                <div class="card-body">
                    <form id="form_AddInformasi" method="POST" action="<?= base_url('admin') ?>/kelola_informasi/insert_data" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputJudul"><strong>Judul</strong></label>
                            <input type="text" class="form-control" id="inputJudul" name="inputJudul"></input>
                        </div>
                        <div class="form-group">
                            <label for="inputIsi"><strong>Isi Informasi</strong></label>
                            <textarea class="ckeditor" id="inputIsi" name="inputIsi"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm text-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl_data_informasi" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Pembuat</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data_informasi">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets') ?>/vendor/ckeditor/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#div_alert').html('');
            <?php $this->session->unset_userdata('message'); ?>
        }, 2000);

        $.ajax({
            url: `<?= base_url('admin') ?>/kelola_informasi/get_data`,
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
                        html += `<td>${item.judul}</td>`;
                        html += `<td>${item.pembuat}</td>`;
                        html += `<td class="text-center">`;
                        html += `<a class="btn btn-sm btn-warning btnEdit" data-id="${item.id}" style="font-size: 10px;"><i class="fas fa-pen"></i></a> | `;
                        html += `<a class="btn btn-sm btn-danger btnHapus" data-id="${item.id}" style="font-size: 10px;"><i class="fas fa-trash"></i></a>`;
                        html += `</td>`;
                        html += `</tr>`;
                        no++;
                    });
                }
                $('#tbody_data_informasi').html(html);
                $('#tbl_data_informasi').DataTable({
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
                    // var editor = CKEDITOR.instances.help_ldesc;
                    // editor.setData('');
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('admin') ?>/kelola_informasi/get_data",
                        data: {
                            id: data_id
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            let data = response.data;
                            $('input#inputJudul').val(data.judul);
                            CKEDITOR.instances['inputIsi'].setData(data.isi);
                        }
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
                                url: "<?= base_url('admin') ?>/kelola_informasi/delete_data",
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