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
<h1>USER TASK INFO </h1>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>