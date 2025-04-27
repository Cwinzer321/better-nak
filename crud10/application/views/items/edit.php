<div class="container">
    <h2>Edit Item</h2>
    <?php echo validation_errors(); ?>
    <?php echo form_open('welcome/update'); ?>
        <input type="hidden" name="id" value="<?= $item['id'] ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?= $item['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" required><?= $item['description'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url() ?>" class="btn btn-secondary">Cancel</a>
    <?php echo form_close(); ?>
</div>