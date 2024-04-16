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
<?php $APPLICATION->IncludeComponent('up:response', '', [
	'USER_ID' => (int)$USER->GetID()
]); ?>
