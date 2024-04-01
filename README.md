# Установка Битрикс модуля 'Up.ukan'

#### 1) Установите модуль через админ панель

#### 2) В админ панеле уставите шаблон 'UKAN main template'

### Настройка роутинга


#### 3) Добавьте `web.php` в `routing` секцию файла `${doc_root}/bitrix/.settings.php`:

```php
'routing' => ['value' => [
	'config' => ['web.php']
]],
```

#### 4) В файле `${doc_root}/index.php` должно быть следующее содержание:

```php
<?php

require_once __DIR__ . '/bitrix/routing_index.php';
```

#### 5) Измените следующие строчки в файле `${doc_root}/.htaccess`:

```
-RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
-RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]

+RewriteCond %{REQUEST_FILENAME} !/index.php$
+RewriteRule ^(.*)$ /index.php [L]
```

#### 6) Измените/создайте файл `${doc_root}/local/php_interface/init.php`:

```php
<?php

\Bitrix\Main\Loader::includeModule('up.ucan');
```
