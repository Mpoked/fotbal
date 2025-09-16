<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
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
                            <textarea class="form-control" id="text" name="text" rows="5" placeholder="Obsah článku..." required></textarea>
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
<?= $this->endSection(); ?>
