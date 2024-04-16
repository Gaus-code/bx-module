<?php
/**
 * @var CUser $USER
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>

<?php

if (!$USER->IsAuthorized())
{
	LocalRedirect('/sign-in');
}
?>

<?php $APPLICATION->IncludeComponent('up:project.edit', '', [
	'USER_ID' => (int)$USER->GetID(),
	'PROJECT_ID' => (int)request()->get('project_id'),
]);
?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>