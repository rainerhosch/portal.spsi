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
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody id="tbody_data_kegiatan">
                    </tbody>
                </table>
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
            }
        });
    });
</script>