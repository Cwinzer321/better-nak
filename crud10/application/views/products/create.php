<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Create New Product</h3>
        </div>
        <div class="card-body">
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open_multipart('welcome/create'); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Supported formats: JPG, PNG, GIF (Max 2MB)</small>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (Rupiah)</label>
                    <input type="number" step="1" min="0" class="form-control" id="price" name="price" value="<?php echo set_value('price'); ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Product
                    </button>
                    <a href="<?php echo base_url('products'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>