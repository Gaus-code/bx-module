<?php
/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - Super Service");
if ($USER->IsAuthorized())
{
	LocalRedirect('/profile/' . $USER->GetID() . '/');
}
$APPLICATION->IncludeComponent('up:sign.in', '', []);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>