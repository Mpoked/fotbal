<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container my-4">
<h1>Přehled sezón</h1>

    <?php foreach ($poDekadach as $dekada => $sezony): ?>
<h3><?= $dekada ?>s</h3>
<div class="row mb-3">
<?php foreach ($sezony as $s): ?>
<div class="col-md-2 col-4 mb-2">
<a href="<?= site_url('main/sezona/'.$s->id) ?>" class="btn btn-outline-primary w-100">
<?= $s->start ?>/<?= $s->finish ?>
</a>
</div>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
</div>
<?= $this->endSection(); ?>