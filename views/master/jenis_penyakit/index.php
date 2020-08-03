<title>Jenis Penyakit</title>
<link rel="icon" href="<?= base_url('public/images/config/logo.png'); ?>" type="image/x-icon" />

<?php $this->template->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <h1 class="page-header">
            {{jenis_penyakit}}
        </h1>
    </div>
    <div class="col-md-6 text-right">
        <div class="form-group">
            <?= $this->action->button('create', 'class="btn btn-primary" onclick="create()"') ?>
        </div>
    </div>
</div>
<?php $this->template->view('layouts/partials/message') ?>
<div class="panel panel-default">
    <div class="panel-body">
        <table width="100%" id="data-table" class="table table-bordered table-condensed ">
            <thead>
                <tr>
                    <th width="150">{{kode_jenis_penyakit}}</th>
                    <th>{{jenis_penyakit}}</th>
                    <td width="1"></td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php $this->template->endsection() ?>

<?php $this->template->section('page_script') ?>
<script>
    var dataTable;
    $(function() {
        dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= $this->url_generator->current_url() ?>',
            columns: [{
                    data: 'kode_jenis_penyakit',
                    name: 'jenis_penyakit.kode_jenis_penyakit'
                },
                {
                    data: 'jenis_penyakit',
                    name: 'jenis_penyakit.jenis_penyakit'
                },
                {
                    data: '_action',
                    searchable: false,
                    orderable: false,
                    class: 'text-right nowrap'
                }
            ]
        });
    });

    function view(id) {
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/view/' + id,
            success: function(response) {
                bootbox.dialog({
                    title: '{{view}} {{jenis_penyakit}}',
                    message: response
                });
            }
        });
    }

    function create() {
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/create',
            success: function(response) {
                bootbox.dialog({
                    title: '{{create}} {{jenis_penyakit}}',
                    message: response
                });
            }
        });
    }

    function store() {
        $('.validation-message').remove();
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/store',
            type: 'post',
            data: $('#frm-create').serialize(),
            success: function(response) {
                if (response.success) {
                    $.growl.notice({
                        message: response.message
                    });
                    bootbox.hideAll();
                    dataTable.ajax.reload();
                } else {
                    $.growl.error({
                        message: response.message
                    });
                    $.each(response.validation, function(key, message) {
                        $('#' + key).closest('.form-group').append('<p class="text-danger validation-message">' + message + '</p>');
                    });
                }
            }
        });
    }

    function edit(id) {
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/edit/' + id,
            success: function(response) {
                bootbox.dialog({
                    title: '{{edit}} {{jenis_penyakit}}',
                    message: response
                });
            }
        });
    }

    function update(id) {
        $('.validation-message').remove();
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/update/' + id,
            type: 'post',
            data: $('#frm-edit').serialize(),
            success: function(response) {
                if (response.success) {
                    $.growl.notice({
                        message: response.message
                    });
                    bootbox.hideAll();
                    dataTable.ajax.reload();
                } else {
                    $.growl.error({
                        message: response.message
                    });
                    $.each(response.validation, function(key, message) {
                        $('#' + key).closest('.form-group').append('<p class="text-danger validation-message">' + message + '</p>');
                    });
                }
            }
        });
    }

    function remove(id) {
        swalConfirm('Apakah anda yakin akan menghapus data ini?', function() {
            $.ajax({
                url: '<?= $this->url_generator->current_url() ?>/delete/' + id,
                success: function(response) {
                    if (response.success) {
                        $.growl.notice({
                            message: response.message
                        });
                        dataTable.ajax.reload();
                    } else {
                        $.growl.error({
                            message: response.message
                        });
                    }
                }
            });
        });
    }

    function cancel() {
        bootbox.hideAll();
    }
</script>
<?php $this->template->endsection() ?>

<?php $this->template->view('layouts/main') ?>