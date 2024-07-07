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
        <div>

            <?php if (!empty($images)): ?>
                <div id="gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">

                    <?php foreach ($images as $image): ?>
                        <div class="d-flex flex-column position-relative m-2 p-2">

                            <?php if ( User_Model::check()): ?>
                                <?php if ($image['user_id'] == $_COOKIE['id']): ?>
                                    <button class="position-absolute top-0 end-0 btn btn-danger" id="deleteImageButton" title="Удалить" data-id="<?php echo $image['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img class="img-thumbnail rounded" src="app/uploads/<?php echo $image['file']; ?>" alt="img" width="200" height="200">

                            <?php if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])): ?>
                                <button class="btn btn-primary">Комментарии</button>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>
                <p>картинок нет</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php if ($user): ?>
    <script src="app/js/uploadImage_script.js"></script>
    <script src="app/js/deleteImage_script.js"></script>
<?php endif; ?>
