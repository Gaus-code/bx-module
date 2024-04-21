<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>
<main class="profile__main">
	<?php
	$APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Отклики</h2>
		</article>
		<article class="content__responses">
			<div class="responses__header">
				<ul class="responses__tagList">
					<li class="responses__tagItem <?= ($arParams['SHOW'] === 'sent') ? 'active-responses-link' : '' ?>">
						<a href="/profile/<?= $arParams['USER_ID'] ?>/responses/?show=sent" class="responses__tag">Отправленные отклики</a>
					</li>
					<li class="responses__tagItem <?= ($arParams['SHOW'] === 'receive') ? 'active-responses-link' : '' ?>">
						<a href="/profile/<?= $arParams['USER_ID'] ?>/responses/?show=receive" class="responses__tag">Пришедшие отклики</a>
					</li>
				</ul>
			</div>

			<p>Отфильтровать по статусу отклика: </p>
			<form method="get">
				<input type="hidden" name="show" value="<?= $arParams['SHOW'] ?>">
				<select name="filter" class="catalog__sort">
					<option value="wait" <?= $arParams['FILTER'] === 'wait' ? 'selected'
						: '' ?>><?= \Up\Ukan\Service\Configuration::getOption('response_status')['wait'] ?></option>
					<option value="approve" <?= $arParams['FILTER'] === 'approve' ? 'selected'
						: '' ?>><?= \Up\Ukan\Service\Configuration::getOption('response_status')['approve'] ?></option>
					<option value="reject" <?= $arParams['FILTER'] === 'reject' ? 'selected'
						: '' ?>><?= \Up\Ukan\Service\Configuration::getOption('response_status')['reject'] ?></option>
				</select>
				<button class="task__responseDelete" type="submit">Отфильтровать</button>
			</form>


			<?php
			if ($arParams['SHOW'] === 'sent'): ?>
				<?php
				if (count($arResult['RESPONSES']) > 0): ?>
					<?php
					foreach ($arResult['RESPONSES'] as $response): ?>
						<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
							<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
								<div class="task__header">
									<?php
									foreach ($response->getTask()->getTags() as $tag): ?>
										<p class="task__tag"><?= htmlspecialcharsbx($tag->getTitle()) ?></p>
									<?php
									endforeach; ?>
								</div>
								<div class="task__responseMain">
									<h3 class="task__responseTitle"><?= htmlspecialcharsbx($response->getTask()->getTitle()) ?></h3>
									<p class="task__responseCreated">
										<span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
									<p class="task__responseCreated"><span>Ваша цена:</span> <?= $response->getPrice() ?> </p>
									<p class="task__responseCreated"><span>Проект:</span> <?= ($response->getTask()->getProject())
											? htmlspecialcharsbx($response->getTask()->getProject()->getTitle()) : 'Без проекта' ?> </p>
									<p class="task__responseCreated"><span>Статус:</span> <?= ($response->getStatus(
										)) ?> </p>
								</div>
							</a>
							<?php
							if (
								$response->getTask()->getStatus() === \Up\Ukan\Service\Configuration::getOption(
									'response_status'
								)['wait']
							): ?>
								<div class="task__responseFooter">
									<form action="/response/delete/" method="post">
										<?= bitrix_sessid_post() ?>
										<input hidden="hidden" name="responseId" value="<?= $response->getId() ?>">
										<button class="task__responseDelete" type="submit">Отменить отклик</button>
									</form>
								</div>
							<?php
							endif; ?>
						</div>
					<?php
					endforeach; ?>
				<?php
				else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
						<p class="contractor__emptyLink">Ничего не найдено.</p>
						<p class="contractor__emptyLink">Попробуйте сменить фильтры!</p>
					</div>
				<?php
				endif; ?>
			<?php
			endif; ?>


			<?php
			if ($arParams['SHOW'] === 'receive'): ?>
				<form method="get" class="searchForm">
					<input type="hidden" name="show" value="<?= $arParams['SHOW'] ?>">
					<input type="hidden" name="filter" value="<?= $arParams['FILTER'] ?>">
					<input type="text" name="q" placeholder="Поиск задачи">
					<button type="submit" class="searchBtn">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/search.svg" alt="search what you want">
					</button>
				</form>
				<?php
				if (count($arResult['RESPONSES']) > 0): ?>
					<?php
					foreach ($arResult['RESPONSES'] as $response): ?>
						<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
							<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
								<div class="task__header">
									<?php
									foreach ($response->getTask()->getTags() as $tag): ?>
										<p class="task__tag"><?= htmlspecialcharsbx($tag->getTitle() )?></p>
									<?php
									endforeach; ?>
								</div>
								<div class="task__responseMain">
									<h3 class="task__responseTitle"><?=htmlspecialcharsbx($response->getTask()->getTitle())  ?></h3>
									<p class="task__responseCreated">
										<span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
									<p class="task__responseCreated">
										<span>Предложенная цена:</span> <?= $response->getPrice() ?> </p>
									<p class="task__responseCreated">
										<span>Исполнитель:</span> <?= htmlspecialcharsbx($response->getContractor()->getBUser()->getName()
																						 . ' ' . $response->getContractor()->getBUser()->getLastName()) ?> </p>
									<p class="task__responseCreated">
										<span>Сопроводительное письмо:</span> <?= htmlspecialcharsbx($response->getDescription()) ?> </p>
									<p class="task__responseCreated"><span>Проект:</span> <?= ($response->getTask()
																										->getProject())
											? htmlspecialcharsbx($response->getTask()->getProject()->getTitle()) : 'Без проекта' ?> </p>
									<p class="task__responseCreated"><span>Статус:</span> <?= ($response->getStatus()) ?> </p>
								</div>
							</a>
							<?php if (($arParams['FILTER']) === 'wait'): ?>
								<div class="task__responseFooter">
									<form action="/response/approve/" method="post">
										<?= bitrix_sessid_post() ?>
										<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
										<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
										<button class="task__responseDelete" type="submit">Одобрить отклик</button>
									</form>
									<form action="/response/reject/" method="post">
										<?= bitrix_sessid_post() ?>
										<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
										<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
										<button class="task__responseDelete" type="submit">Отклонить отклик</button>
									</form>
								</div>
							<?php endif; ?>
						</div>
					<?php
					endforeach; ?>
				<?php
				else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
						<p class="contractor__emptyLink">Ничего не найдено.</p>
						<p class="contractor__emptyLink">Попробуйте сменить фильтры!</p>
					</div>
				<?php
				endif; ?>
			<?php
			endif; ?>


			<?php
			if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
				]);
			}
			?>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
