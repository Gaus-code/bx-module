<?php
/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 */
?>
<!doctype html>
<html lang="<?= LANGUAGE_ID; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php $APPLICATION->ShowTitle(); ?></title>
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/css/index.css">
	<?php
	$APPLICATION->ShowHead();
	?>
</head>
<body>

<?php $APPLICATION->ShowPanel(); ?>
<header class="header wrapper">
	<div class="header__logoContainer">
		<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo.svg" alt="logo" class="logo">
		<a href="/" class="header__logoName">UKAN</a>
		<nav class="header__nav">
			<a href="/" class="header__link" id="mainLink">Главная</a>
			<a href="/catalog/" class="header__link" id="catalogLink">Каталог</a>
			<?php if ($USER->IsAdmin()):?>
				<a href="/admin/" class="header__link" id="catalogLink">Администрирование</a>
			<?php endif;?>
			<button id="styleModeBtn">Сменить тему</button>
		</nav>
	</div>
	<?php if (!$USER->IsAuthorized()): ?>
		<div class="header__registerContainer">
			<a href="/sign-in" class="header__btn">Войти</a>
		</div>
	<?php else:?>
		<div class="header__registerContainer">
			<button type="button" class="header__userBtn">
				<?= htmlspecialcharsbx($USER->GetLogin()) ?>
			</button>
		</div>
		<div class="header__modal">
			<ul class="header__modalList">
				<li class="header__modalItem">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerMiniUser.svg" alt="logout image">
					<a href="/profile/<?= $USER->GetID() ?>/" class="header__modalLink">Аккаунт</a>
				</li>
				<li class="header__modalItem">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logout.svg" alt="logout image">
					<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="header__modalLink">Выход</a>
				</li>
			</ul>
		</div>
	<?php endif; ?>
</header>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/headerAnchorLinks.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/header.js");
?>


