<title>Penjualan Barang</title>
<link rel="icon" href="<?= base_url('public/images/config/logo.png'); ?>" type="image/x-icon" />

<?php $this->template->section('content') ?>
<?= $this->form->open($this->route->name('transaksi.penjualan.store'), 'id="frm-penjualan"') ?>
<?php $this->template->view('transaksi/penjualan_cabang/form') ?>
<div class="form-group text-right">
    <a href="#modal-dialog" class="btn btn-success" data-toggle="modal">{{pembayaran}}</a>
    <a href="<?= $this->route->name('transaksi.penjualan') ?>" class="btn btn-default">{{cancel}}</a>
</div>
<?= $this->form->close() ?>
<?php $this->template->endsection() ?>

<?php $this->template->section('page_script') ?>
<?php $this->load->view('transaksi/penjualan_cabang/form_script') ?>
<?php $this->template->endsection() ?>

<?php $this->template->view('layouts/main_transaksi') ?>