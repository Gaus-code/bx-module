# Установка Битрикс модуля 'Up.ukan'

### 0) Установка самого битрикса и нашего модуля

- после установки дистрибутива, у вас должны быть две папки: bitrix и upload, а также несколько системных файлов 
- вам необходимо создать новую папку в корне проекта: `${doc_root}/local/`
- в ней создаем еще 2 папки: `${doc_root}/local/modules/` и `${doc_root}/local/php_interface/`
- теперь нам надо клонировать проект с гит лаба: 
- В терминале заходим в нашу папку:
- - ``` cd ${абсолютный путь до папки}/local/modules/``` 
- Клонируем гит
- - ``` git clone https://up.bitrix.info/2023/module-4/team-5/finalproject.git ```
- Переименовываем склонированную папку
- - ```ren finalproject up.ukan```
- Далее уже заходим на свой домен, и продолжаем установку через панель администора

### 1) Установите модуль через админ панель

### 2) В админ панеле уставите шаблон 'UKAN main template'

## Настройка роутинга


### 3) Добавьте `web.php` в `routing` секцию файла `${doc_root}/bitrix/.settings.php`:

```php
'routing' => ['value' => [
	'config' => ['web.php']
]],
```

### 4) В файле `${doc_root}/index.php` должно быть следующее содержание:

```php
<?php

require_once __DIR__ . '/bitrix/routing_index.php';
```

### 5) Измените следующие строчки в файле `${doc_root}/.htaccess`:

```
-RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
-RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]

+RewriteCond %{REQUEST_FILENAME} !/index.php$
+RewriteRule ^(.*)$ /index.php [L]
```

### 6) Измените/создайте файл `${doc_root}/local/php_interface/init.php`:

```php
<?php

\Bitrix\Main\Loader::includeModule('up.ukan');
```
