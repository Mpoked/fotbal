<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container my-4">
<div class="row g-3">
    <?php
 
    foreach ($articles as $key => $row) {
        if ($key == 0) {
            echo html_square($row, 1);
            echo "\n<div class=\"col-6\">";
            echo "\n<div class=\"row g-3\">";
        } else {
            echo html_square($row, 2);
        }
    }
 
 
    ?>
</div>
</div>
</div>
</div>
<?= $this->endSection(); ?>