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
			<h1 id="quickCreate">Быстрое создание</h1>
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
					<li id="sentResponse-btn" class="responses__tagItem active-tag-item">
						Отправленные отклики
					</li>
					<li id="receiveResponse-btn" class="responses__tagItem">
						Пришедшие отклики
					</li>
				</ul>
				<div class="responses__filterForm">
					<p>Отфильтровать по статусу отклика: </p>
					<form method="get">
						<select name="filter" class="catalog__sort" onchange="this.form.submit()">
							<option value="wait" <?= $arParams['FILTER'] === 'wait' ? 'selected' : '' ?>>
								<?= \Up\Ukan\Service\Configuration::getOption('response_status')['wait'] ?>
							</option>
							<option value="approve" <?= $arParams['FILTER'] === 'approve' ? 'selected' : '' ?>>
								<?= \Up\Ukan\Service\Configuration::getOption('response_status')['approve'] ?>
							</option>
							<option value="reject" <?= $arParams['FILTER'] === 'reject' ? 'selected' : '' ?>>
								<?= \Up\Ukan\Service\Configuration::getOption('response_status')['reject'] ?>
							</option>
						</select>
					</form>
				</div>
			</div>

			<div id="sentResponse-reviews" class="tab__container">
				<?php
				if (count($arResult['SENT_RESPONSES']) > 0): ?>
					<?php
					foreach ($arResult['SENT_RESPONSES'] as $response): ?>
						<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
							<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
								<div class="task__header">
									<?php
									foreach ($response->getTask()->getTags() as $tag): ?>
										<p class="task__tag">#<?= htmlspecialcharsbx($tag->getTitle()) ?></p>
									<?php
									endforeach; ?>
								</div>
								<div class="task__responseMain">
									<h3 class="task__responseTitle"><?= htmlspecialcharsbx(
											$response->getTask()->getTitle()
										) ?></h3>
									<p class="task__responseCreated">
										<span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
									<p class="task__responseCreated"><span>Ваша цена:</span> <?= $response->getPrice(
										) ?> </p>
									<p class="task__responseCreated"><span>Проект:</span> <?= ($response->getTask()
											->getProject())
											? htmlspecialcharsbx($response->getTask()->getProject()->getTitle())
											: 'Без проекта' ?> </p>
									<p class="task__responseCreated"><span>Статус:</span> <?= ($response->getStatus(
										)) ?> </p>
								</div>
							</a>
							<?php
							if ($response->getStatus() === \Up\Ukan\Service\Configuration::getOption('response_status')['wait']): ?>
								<div class="task__responseFooter">
									<form action="/response/delete/" class="deleteResponseForm" method="post">
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
					if (
						$arParams['CURRENT_PAGE' . '_SENT_RESPONSE'] !== 1
						|| $arParams['EXIST_NEXT_PAGE'
						. '_SENT_RESPONSE']
					)
					{
						$APPLICATION->IncludeComponent('up:pagination', '', [
							'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_SENT_RESPONSE'],
							'NAME_OF_PAGE' => '_SENT_RESPONSE',
						]);
					}
					?>
				<?php
				else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
						<p class="contractor__emptyLink">Ничего не найдено.</p>
						<p class="contractor__emptyLink">Попробуйте сменить фильтры!</p>
					</div>
				<?php
				endif; ?>
			</div>

			<div id="receiveResponse-reviews" class="tab__container nonPriority-container">
				<form method="get" class="searchForm">
					<input type="hidden" name="filter" value="<?= $arParams['FILTER'] ?>">
					<input type="text" name="q" placeholder="Поиск задачи">
					<button type="submit" class="searchBtn">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/search.svg" alt="search what you want">
					</button>
				</form>
				<?php
				if (count($arResult['RECEIVE_RESPONSES']) > 0): ?>
					<?php
					foreach ($arResult['RECEIVE_RESPONSES'] as $response): ?>
						<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
							<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
								<div class="task__header">
									<?php
									foreach ($response->getTask()->getTags() as $tag): ?>
										<p class="task__tag">#<?= htmlspecialcharsbx($tag->getTitle()) ?></p>
									<?php
									endforeach; ?>
								</div>
								<div class="task__responseMain">
									<h3 class="task__responseTitle"><?= htmlspecialcharsbx(
											$response->getTask()->getTitle()
										) ?></h3>
									<p class="task__responseCreated">
										<span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
									<p class="task__responseCreated">
										<span>Предложенная цена:</span> <?= $response->getPrice() ?> </p>
									<p class="task__responseCreated">
										<span>Исполнитель:</span> <?= htmlspecialcharsbx(
											$response->getContractor()->getBUser()->getName()
											. ' '
											. $response->getContractor()->getBUser()->getLastName()
										) ?> </p>
									<p class="task__responseCreated">
										<span>Сопроводительное письмо:</span> <?= htmlspecialcharsbx(
											$response->getDescription()
										) ?> </p>
									<p class="task__responseCreated"><span>Проект:</span> <?= ($response->getTask()
											->getProject())
											? htmlspecialcharsbx($response->getTask()->getProject()->getTitle())
											: 'Без проекта' ?> </p>
									<p class="task__responseCreated"><span>Статус:</span> <?= ($response->getStatus(
										)) ?> </p>
								</div>
							</a>
							<?php
							if (($arParams['FILTER']) === 'wait' &&  !$arResult['USER_IS_BANNED']): ?>
								<div class="task__responseFooter">
									<form action="/response/approve/" method="post">
										<?= bitrix_sessid_post() ?>
										<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
										<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId(
										) ?>">
										<button class="task__responseDelete" type="submit">Одобрить отклик</button>
									</form>
									<form action="/response/reject/" method="post">
										<?= bitrix_sessid_post() ?>
										<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
										<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId(
										) ?>">
										<button class="task__responseDelete" type="submit">Отклонить отклик</button>
									</form>
								</div>
							<?php
							endif; ?>
						</div>
					<?php
					endforeach; ?>
					<?php
					if (
						$arParams['CURRENT_PAGE' . '_RECEIVE_RESPONSE'] !== 1
						|| $arParams['EXIST_NEXT_PAGE'
						. '_RECEIVE_RESPONSE']
					)
					{
						$APPLICATION->IncludeComponent('up:pagination', '', [
							'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_RECEIVE_RESPONSE'],
							'NAME_OF_PAGE' => '_RECEIVE_RESPONSE',
						]);
					}
					?>
				<?php
				else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
						<p class="contractor__emptyLink">Ничего не найдено.</p>
						<p class="contractor__emptyLink">Попробуйте сменить фильтры!</p>
					</div>
				<?php
				endif; ?>
			</div>

		</article>
	</section>
</main>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/tabContainers.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
?>
