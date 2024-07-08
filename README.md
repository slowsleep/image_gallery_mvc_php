# module50

Галерея с изображениями. Есть возможность регистарции, входа, загрузки, удаления и комментирования изображений для авторизованных пользователей и только просмотр для гостей.

Навигация по сайту:
- /?page=main - Главная
- /?page=registration - Регистрация
- /?page=login - Вход
- /?page=logout - Выход


Необходимо для запуска проекта:
- php (у меня 8.3)
- mysql

## Как запустить проект

На основе `.env.example` создайте файла `.env` с вашими настройками.

Создайте таблицы для работы с проектом

```sql
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(32) NOT NULL default '',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_unique`(`name`)
) ENGINE = InnoDB;
```

```sql
CREATE TABLE `images`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `file` varchar(255) NOT NULL,
    `user_id` int(11) NOT NULL,
    `created_at` datetime(0) NULL DEFAULT NULL,
    `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `file_unique`(`file`),
    FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB;
```

```sql
CREATE TABLE `comments`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_id` int(11) NOT NULL,
    `content` varchar(512) NOT NULL,
    `created_at` datetime(0) NULL DEFAULT NULL,
    `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (`image_id`) REFERENCES images(id) ON DELETE CASCADE
) ENGINE = InnoDB;
```
