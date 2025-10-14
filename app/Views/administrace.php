<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container my-4">
    <h1>Administrace</h1>

    <!-- Zprávy o úspěchu nebo chybě -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Přidat nový článek -->
    <a href="<?= base_url("create") ?>" class="btn btn-primary mb-3">+ Přidat článek</a>

    <!-- Tabulka článků -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Link</th>
                <th>Title</th>
                <th>Date</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($article as $a): ?>
            <tr>
                <td><?= $a->id ?></td>
                <td><?= $a->link ?></td>
                <td><?= $a->title ?></td>
                <td><?= date('d.m.Y', $a->date) ?></td>
                <td>
                    <!-- Upravit článek -->
                    <a href="<?= base_url("edit/").$a->id?>" class="btn btn-warning btn-sm">Upravit</a>

                    <!-- Smazat článek -->
                    <form action="<?= base_url('delete/' . $a->id) ?>" method="post" class="d-inline" onsubmit="return confirm('Opravdu chcete článek smazat?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Smazat</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
