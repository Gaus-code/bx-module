<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>

<?php $APPLICATION->IncludeComponent('up:catalog', '', []); ?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
