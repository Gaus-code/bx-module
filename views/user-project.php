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
var_dump('hello from user 1 project');
?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>