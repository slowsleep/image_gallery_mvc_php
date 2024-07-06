<div class="container">
    <h1>Вход</h1>

    <div id="loginResult"></div>

    <form id="loginForm" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>
<script src="/app/js/login_script.js"></script>
