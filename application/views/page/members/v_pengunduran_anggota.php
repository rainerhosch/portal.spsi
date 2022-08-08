<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <div id="div_alert">
        <?= $this->session->flashdata('message'); ?>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h5 class="card-title">Form Pengunduran Anggota</h5>
        </div>
        <form id="formPengunduran" enctype="multipart/form-data" method="POST" action="<?= base_url('members/input_pengunduran_diri') ?>">
            <div class="card-body">
                <div class="form-group">
                    <label for="inputAlasanPengunduran">Alasan Pengunduran</label>
                    <textarea type="text" class="form-control" id="inputAlasanPengunduran" name="inputAlasanPengunduran" placeholder="Jelaskan alasan pengunduran diri anda"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#div_alert').html('');
            <?php $this->session->unset_userdata('message'); ?>
        }, 2000);
    });
</script>