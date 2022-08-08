<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $subpage ?></h1>
    <!-- <hr class="my-5"> -->
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

        <!--Controls-->
        <div class="controls-top text-center">
            <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
            <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fas fa-chevron-right"></i></a>
        </div>
        <!--/.Controls-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
        </div>
        <!--/.Slides-->

    </div>
    <!--/.Carousel Wrapper-->
</div>
<script>
    $.ajax({
        url: `<?= base_url('admin') ?>/kelola_informasi/get_data`,
        type: `POST`,
        dataType: `json`,
        success: function(response) {
            let html = ``;
            let data = response.data;
            let active = `active`;
            console.log(data)
            if (data != null) {
                // html += `<ul class="list-group">`;
                $.each(data, function(i, item) {
                    console.log(i + '-' + item.id)
                    if (i != 0) {
                        active = ``;
                    }
                    html += `<div class="carousel-item ${active}">
                <div class="col-md-12" style="float:left">
                    <div class="card mb-2">
                        <div class="card-body">
                            <h4 class="card-title">${item.judul}</h4>
                            <hr>
                            ${item.isi}
                        </div>
                    </div>
                </div>
            </div>`;
                });
            }
            $('.carousel-inner').html(html);
        }
    })
</script>