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
        background-color: #6c6c6c00;
        width: 100%;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets') ?>/vendor/bagan/diagram.css">
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <h5 class="text-center">STRUKTUR ORGANISASI</h5>
                <div id="diagram_container"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets') ?>/vendor/bagan/diagram.js"></script>
<script>
    let diagram = new dhx.Diagram("diagram_container", {
        type: "org",
        defaultShapeType: "img-card",
        scale: 0.9
    });
    diagram.data.load('<?= base_url('assets/data-file') ?>/struktur_organisasi.json');
</script>