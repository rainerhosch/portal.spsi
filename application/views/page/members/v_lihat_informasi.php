<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
</div>
<script>
    $.ajax({
        url: `<?= base_url('admin') ?>/kelola_informasi/get_data`,
        type: `POST`,
        dataType: `json`,
        success: function(response) {
            let html = ``;
            let data = response.data;
            console.log(data)
            if (data != null) {
                $.each(data, function(i, item) {
                    html = `<div class="row id${item.id}">
                    <div class="col-lg-12 mb-4">
                    <div class="card bg-secondary text-white shadow">
                    <div class="card-body">${item.judul}<div class="text-white-50 small">${item.isi}</div></div>
                    </div>
                    </div>`;
                });
            }
            $('.container-fluid').html(html);
        }
    })
</script>