<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<div class="modal" id="authModal">
	<!--Sign in Form-->
	<?php $APPLICATION->IncludeComponent('up:sign.in', '', []);?>
	<!--Sign up Form-->
	<?php $APPLICATION->IncludeComponent('up:sign.up', '', []);?>
</div>
<script type="module" src="<?= SITE_TEMPLATE_PATH ?>/assets/js/login.js"></script>