<?php
$images = Image_Model::getImages();
?>
<div class="container">
    <h1>Галерея</h1>

    <?php if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])): ?>
        <div class="mb-3 bg-light p-2">
        <h3>Добавить изображение</h3>
            <form id="uploadImageForm" method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="image" name="image[]" multiple required>
                    <button class="btn btn-outline-secondary" type="submit">Загрузить</button>
                </div>
            </form>
            <small>
                Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
                <br>
                Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
            </small>
        </div>
    <?php else: ?>
        <p>войдите в аккаунт, чтобы добавлять изображения</p>
    <?php endif; ?>

    <div>
        <div id="uploadResult"></div>
        <p>картинки:</p>
        <div>

            <?php if (!empty($images)): ?>
                <div id="gallery" class="image mb-3 flex-grow-1">
                    <?php foreach ($images as $image): ?>
                        <img class="img-fluid img-thumbnail rounded" src="app/uploads/<?php echo $image['file']; ?>" alt="img" width="200" height="200">
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>картинок нет</p>
            <?php endif; ?>
        </div>
    </div>

</div>
<script src="app/js/uploadImage_script.js"></script>
