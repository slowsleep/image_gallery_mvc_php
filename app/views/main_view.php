<?php
$images = Image_Model::getImages();
$user = User_Model::check();
?>
<div class="container">
    <h1>Галерея</h1>

    <?php if ($user) : ?>
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
    <?php else : ?>
        <p>Войдите в аккаунт, чтобы добавлять изображения</p>
    <?php endif; ?>

    <div>
        <div id="uploadResult"></div>
        <div>

            <?php if (!empty($images)) : ?>
                <div id="gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">

                    <?php foreach ($images as $image) : ?>
                        <div class="d-flex flex-column position-relative m-2 p-2">

                            <?php if ($user) : ?>
                                <?php if ($image['user_id'] == $_COOKIE['id']) : ?>
                                    <button class="position-absolute top-0 end-0 btn btn-danger" id="deleteImageButton" title="Удалить" data-id="<?php echo $image['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img class="img-thumbnail rounded" src="app/uploads/<?php echo $image['file']; ?>" alt="img" width="200" height="200">

                            <button type="button" class="btn btn-primary" id="commentsButton" data-id="<?php echo $image['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalComments">
                                Комментарии
                            </button>

                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else : ?>
                <p class="text-center">- изображений нет -</p>
            <?php endif; ?>
        </div>
    </div>

</div>


<div class="modal" id="modalComments" tabindex="-1" aria-labelledby="modalCommentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCommentsLabel">Комментарии</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="comments">
                    <div class="mb-3 shadow rounded p-2 m-1">
                        <div class="d-flex justify-content-between">
                            <p class="small">username: </p>
                            <p class="small">time: </p>
                        </div>
                        <p class="m-0">comment: </p>
                    </div>
                </div>
                <?php if ($user) : ?>
                    <form id="commentsForm" method="post">
                        <div class="mb-3">
                            <input type="hidden" id="image_id" name="image_id">
                            <label for="comment" class="form-label">Ваш комментарий:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($user) : ?>
    <script src="app/js/uploadImage_script.js"></script>
    <script src="app/js/deleteImage_script.js"></script>
<?php endif; ?>

<script src="app/js/comments_script.js"></script>