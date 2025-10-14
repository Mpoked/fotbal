<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<script>
tinymce.init({
    license_key: "gpl",
    selector: '#mytextarea',
    plugins: 'image code',
    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',
    promotion: false,
    height: 500,

    relative_urls: false,
        remove_script_host: false,
        convert_urls: true,

    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_url: '<?= base_url('upload-image') ?>',
    image_title: true,

    file_picker_callback: function (cb, value, meta) {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            const file = this.files[0];
            const formData = new FormData();
            formData.append('file', file);

            fetch('<?= base_url('upload-image') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.location) {
                    cb(result.location, { title: file.name });
                } else {
                    alert(result.error || 'Nahrání obrázku selhalo.');
                }
            })
            .catch(() => alert('Chyba při odesílání požadavku.'));
        };
        input.click();
    },

    // Volitelné: umožní drag & drop nahrávání
    images_upload_handler: function (blobInfo, success, failure) {
        const formData = new FormData();
        formData.append('file', blobInfo.blob());

        fetch('<?= base_url('upload-image') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.location) {
                success(result.location);
            } else {
                failure(result.error || 'Chyba při nahrávání.');
            }
        })
        .catch(() => failure('Chyba při odesílání požadavku.'));
    }
});
</script>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Přidat nový článek</h3>
                </div>
                
                <div class="card-body">
                    <form action="<?= base_url('store') ?>" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="link" class="form-label">Odkaz</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="https://..." required>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Titulek</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Název článku" required>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Obrázek</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                            <div class="form-text">Max. velikost 2MB (JPG, PNG)</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Datum</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="top" name="top" value="1">
                                    <label for="top" class="form-check-label">Top článek?</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Text článku</label>
                            <textarea class="form-control" id="mytextarea" name="text" rows="10" placeholder="Obsah článku..."></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('administrace') ?>" class="btn btn-secondary me-md-2">Zpět</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Uložit článek
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('articleForm').addEventListener('submit', function() {
    tinymce.triggerSave(); // uloží obsah TinyMCE zpět do textarea
});
</script>
<?= $this->endSection(); ?>
