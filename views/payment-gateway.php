<?php
/**
 * @var CUser $USER
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");

if (!$USER->IsAuthorized())
{
	LocalRedirect('/sign-in');
}
?>
<style>
	.haha-container {
		max-width: 500px;
        background-color: var(--color-bg-modal);
        border: 3px solid var(--color-warning-green);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
		text-align: center;
        padding: 10px;
		position: absolute;
        top: 50%;
        left: 50%;
		transform: translate(-50%, -50%);
	}
	
	.haha-title {
        color: var(--color-bg-text);
		font-size: 20px;
		line-height: 24px;
	}
</style>
<div class="haha-container">
	<h2 class="haha-title">Добрый день, огромное спасибо, что доверяете нам и нашему сайту.
		<br>
		<br>
		Мы благодарны вам за то, что вы и правда хотели оформить подписку.
		Но пока мы делали проект, мы совершенно забыли о том, что нужно будет готовить его к выгрузке на хостинг.
		<br>
		<br>
		А без хостинга платежный шлюз не подключить.
		<br>
		<br>
		Там вообще много всяких юридических штук еще нужно заполнить.
		<br>
		<br>
		Наверное...
		Мы не знаем, мы писали код и не гуглили эту информацию, но обещаем исправиться.
	</h2>
</div>

