<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container my-4">


<h1>Sezóna <?= esc($sezona->start) ?> – <?= esc($sezona->finish) ?></h1>

<?php if (!empty($souteze)): ?>
    <h2>Soutěže</h2>
    <ul>
        <?php foreach ($souteze as $liga): ?>
            <li><?= esc($liga->name) ?> (ID: <?= esc($liga->id) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Pro tuto sezónu nejsou žádné soutěže.</p>
<?php endif; ?>

<p><a href="<?= site_url('/') ?>">← Zpět na seznam sezón</a></p>
</div>
<?= $this->endSection(); ?>