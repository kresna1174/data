<title>Pembelian</title>
<link rel="icon" href="<?= base_url('public/images/config/logo.png'); ?>" type="image/x-icon" />

<?php $this->template->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <h1 class="page-header">
            {{pembelian}}
        </h1>
    </div>
    <div class="col-md-6 text-right">
        <div class="form-group">
            <?= $this->action->link('create', $this->url_generator->current_url() . '/create', 'class="btn btn-primary"') ?>
        </div>
    </div>
</div>
<?php $this->template->view('layouts/partials/message') ?>
<div class="panel panel-default">
    <div class="panel-body">
        <table width="100%" id="data-table" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="150">{{tanggal}}</th>
                    <th>{{no_pembelian}}</th>
                    <th width="150">{{supplier}}</th>
                    <th width="150">{{jatuh_tempo}}</th>
                    <th width="150">{{kas_bank}}</th>
                    <th width="150">{{total}}</th>
                    <th width="1" class="text-center">{{status}}</th>
                    <td width="1"></td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php $this->template->endsection() ?>

<?php $this->template->section('page_script') ?>
<script>
    <?php if ($this->session->flashdata('print')) { ?>
        var win = window.open('<?= $this->url_generator->current_url() ?>/nota/<?= $this->session->flashdata('print') ?>');
        setTimeout(function() {
            win.close();
        }, 5000);
    <?php } ?>

    var dataTable;
    $(function() {
        dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= $this->url_generator->current_url() ?>',
            columns: [{
                    data: 'tanggal',
                    name: 'pembelian.tanggal'
                },
                {
                    data: 'no_pembelian',
                    name: 'pembelian.no_pembelian'
                },
                {
                    data: 'supplier',
                    name: 'supplier.nama'
                },
                {
                    data: 'jatuh_tempo',
                    name: 'pembelian.jatuh_tempo'
                },
                {
                    data: 'kas_bank',
                    name: 'kas_bank.nama'
                },
                {
                    data: 'total',
                    name: 'pembelian.total',
                    class: 'text-right'
                },
                {
                    data: 'batal',
                    name: 'pembelian.batal',
                    class: 'text-center'
                },
                {
                    data: '_action',
                    searchable: false,
                    orderable: false,
                    class: 'text-right nowrap'
                }
            ],
            order: [
                [0, 'DESC']
            ]
        });
    });

    function view(id) {
        $.ajax({
            url: '<?= $this->url_generator->current_url() ?>/view/' + id,
            success: function(response) {
                bootbox.dialog({
                    title: '{{view}} {{pembelian}}',
                    size: 'large',
                    message: response
                });
            }
        });
    }

    function nota(id) {
        var win = window.open('<?= $this->url_generator->current_url() ?>/nota/' + id);
        setTimeout(function() {
            win.close();
        }, 5000);
    }

    function remove(id) {
        swalConfirm('Apakah anda yakin akan menghapus data ini?', function() {
            $.ajax({
                url: '<?= $this->url_generator->current_url() ?>/delete/' + id,
                type: 'post',
                data: 'jenis_batal=cancel',
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

    function returns(id) {
        swalConfirm('Apakah anda yakin akan melakukan retur pada data ini?', function() {
            $.ajax({
                url: '<?= $this->url_generator->current_url() ?>/delete/' + id,
                type: 'post',
                data: 'jenis_batal=retur',
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
</script>
<?php $this->template->endsection() ?>

<?php $this->template->view('layouts/main') ?>