<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
global $USER;
if (!$USER->IsAuthorized())
{
	LocalRedirect('/sign-in');
}
?>

<?php $APPLICATION->IncludeComponent('up:task.create', '', [
	'USER_ID' => (int)$USER->GetID()
]);?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>