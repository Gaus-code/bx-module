<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?php if (isset($arParams['ERRORS'])) : ?>
	<div class="modal__errorContainer">
		<?php foreach ($arParams['ERRORS'] as $error): ?>
			<div class="modal__error">
				<?= $error ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
