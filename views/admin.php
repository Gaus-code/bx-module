<?php
/**
 * @var CUser $USER
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");

if (!$USER->IsAdmin())
{
	LocalRedirect('/access/denied/');
}
?>
<?php $APPLICATION->IncludeComponent('up:admin', '', [
	'USER_ID' => (int)$USER->GetID(),
]); ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>