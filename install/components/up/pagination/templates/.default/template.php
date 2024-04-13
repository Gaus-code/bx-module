
<?php

/**
 * @var array $arResult
 * @var array $arParams
 */


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="pagination">
	<?php if ($arParams['CURRENT_PAGE'] !== 1): ?>
		<a href="<?=$arParams['NEW_URI'] . ($arParams['CURRENT_PAGE'] - 1)?>" class="pagination__btn">
			Предыдущая
		</a>
	<?php else: ?>
		<p>	Предыдущая </p>
	<?php endif; ?>
	<p class="page-item"><?= $arParams['CURRENT_PAGE'] ?></p>
	<?php if ($arParams['EXIST_NEXT_PAGE']):?>
		<a href="<?=$arParams['NEW_URI'] . ($arParams['CURRENT_PAGE'] + 1)?>" class="pagination__btn">
			Следующая
		</a>
	<?php else: ?>
		<p>	Следующая </p>
	<?php endif; ?>
</div>
