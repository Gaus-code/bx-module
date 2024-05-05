<?php
/**
 * @var CUser $USER
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<?php $APPLICATION->IncludeComponent('up:subscription', '', []); ?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
