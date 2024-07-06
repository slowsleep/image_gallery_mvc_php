<div class="container">
    <h1>Регистрация</h1>

    <div id="registrationResult"></div>

    <form id="registrationForm" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="repeat-password" class="form-label">Повторение пароля</label>
            <input type="password" class="form-control" id="repeat-password" name="repeat-password">
        </div>
        <button type="submit" class="btn btn-primary">Зарегестрироваться</button>
    </form>
</div>
<script src="/app/js/registration_script.js"></script>
