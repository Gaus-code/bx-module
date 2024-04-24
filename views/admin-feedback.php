<?php
/**
 * @var CUser $USER
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");

if (!$USER->IsAuthorized() && !$USER->IsAdmin())
{
	LocalRedirect('/sign-in');
}
?>
<?php $APPLICATION->IncludeComponent('up:admin.feedback', '', [
	'USER_ID' => (int)$USER->GetID(),
]); ?>
<?php