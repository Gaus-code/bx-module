<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<?php
global $USER;
if (!$USER->IsAuthorized())
{
	LocalRedirect('/sign-in');
}
?>
<?php $APPLICATION->IncludeComponent('up:client', '', [
	'USER_ID' => (int)request()->get('user_id')
]); ?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>