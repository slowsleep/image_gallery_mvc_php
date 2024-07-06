<div class="container">
    <h1>Добавить изображение</h1>


    <form id="uploadImageForm" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image[]">
            <button class="btn btn-outline-secondary" type="submit">Загрузить</button>
        </div>
    </form>
    <small>
        Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
        <br>
        Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
    </small>

    <div>
        <?php if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])): ?>
            <p>картинки</p>
        <?php else: ?>
            <p>войдите в аккаунт</p>
        <?php endif; ?>
    </div>

</div>
