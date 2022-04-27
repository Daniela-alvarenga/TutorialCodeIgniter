
<?php echo validation_errors(); ?>

<?php echo form_open("news/update/{$id}"); ?>

    <label for="title">Title</label>
    <input type="text" name="title" value="<?= $news->title ?>"/><br>
    <br>
    
    <label for="text">Text</label>
    <textarea name="text"><?= $news->text ?></textarea><br />

    <input type="submit" name="submit" value="Editar Inventario" />
    
<?php echo form_close(); ?>