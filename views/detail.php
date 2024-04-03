<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<?php $APPLICATION->IncludeComponent('up:task.detail', '', [
	'TASK_ID' => (int)request()->get('task_id'),
]);
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>