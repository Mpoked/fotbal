<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<script>
      tinymce.init({
        selector: '#text',
        license_key: 'gpl',
        plugins: 'code link image lists table',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        promotion: false
      });
    </script>

<div class="container my-4">
    <h1>Upravit článek</h1>

    <form method="post" action="<?= base_url('update/' . $article->id) ?>" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Titulek</label>
            <input type="text" name="title" class="form-control" value="<?= old('title', $article->title) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Odkaz (link)</label>
            <div class="input-group">
                <span class="input-group-text">article/</span>
                <input type="text" name="link" class="form-control"
                       value="<?= old('link', str_replace('article/', '', $article->link)) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Datum</label>
            <input type="date" name="date" class="form-control" value="<?= old('date', $article->date) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Obrázek</label>
            <div class="input-group">
                <input type="text" name="photo_name" class="form-control" id="photoInput"
                       value="<?= old('photo_name', $article->photo) ?>" readonly>
                <button class="btn btn-outline-secondary" type="button" id="browseBtn">
                    <i class="bi bi-folder2-open"></i>
                </button>
            </div>
            <input type="file" id="filePicker" name="photo" accept="image/*" style="display:none">
        </div>

        <div class="mb-3">
            <label class="form-label">Text</label>
            <textarea name="text" class="form-control" id="text" rows="10"><?= old('text', $article->text ?? '') ?></textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="top" value="1" <?= $article->top ? 'checked' : '' ?>>
            <label class="form-check-label">Top článek</label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="published" value="1" <?= $article->published ? 'checked' : '' ?>>
            <label class="form-check-label">Publikováno</label>
        </div>

        <button type="submit" class="btn btn-primary">💾 Uložit</button>
        <a href="<?= base_url('administrace') ?>" class="btn btn-secondary">⬅ Zpět</a>
    </form>
</div>


<?= $this->endSection(); ?>
