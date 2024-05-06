<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
CJSCore::Init(array('ajax'));
?>
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header header-border">
			<h1 id="quickCreate">Быстрое создание</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner"></span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Редактирование заявки</h2>
		</article>
		<article class="content__editTask">
			<div class="modalResponse">
				<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			</div>
			<div class="editTask__formContainer">
				<?php if ($arResult['TASK']->getStatus() === \Up\Ukan\Service\Configuration::getOption('task_status')['search_contractor']):?>
					<form action="/task/stop-search-contractor/" method="post" class="deleteTask__form">
						<?=bitrix_sessid_post()?>
						<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
						<button class="deleteTask">
							Приостановить поиск исполнителя
						</button>
					</form>
				<?php endif;?>
				<?php if ($arResult['TASK']->getStatus() === \Up\Ukan\Service\Configuration::getOption('task_status')['waiting_to_start']):?>
					<form action="/task/start-search-contractor/" method="post" class="deleteTask__form">
						<?=bitrix_sessid_post()?>
						<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
						<button class="deleteTask">
							Начать поиск исполнителя
						</button>
					</form>
				<?php endif;?>
				<form action="/task/delete/" method="post" class="deleteTask__form">
					<?=bitrix_sessid_post()?>
					<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
					<button class="deleteTask">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
						Удалить заявку
					</button>
				</form>
			</div>

			<div class="editTaskContainer">
				<form action="/task/update/" method="post" class="create__form">
					<?=bitrix_sessid_post()?>
					<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
					<div class="create__text">
						<div class="create__container">
							<label class="create__textareaLabel" for="createTitle">Название</label>
							<input name = "title" id="createTitle" type="text" class="create__title" placeholder="Название заявки" value="<?=htmlspecialcharsbx($arResult['TASK']->getTitle())?>" required>
						</div>
						<div class="create__container">
							<label class="create__textareaLabel" for="taskDescription">Описание</label>
							<textarea name="description" id="taskDescription" class="create__description" cols="30" rows="10" required><?=htmlspecialcharsbx($arResult['TASK']->getDescription())?></textarea>
						</div>
						<div class="create__containers">
							<div class="create__dateContainer">
								<label class="create__textareaLabel" for="deadline">Крайний срок</label>
								<input name="deadline" id="deadline" type="date" class="create__dateInput validate" value="<?=$arResult['TASK']->getDeadline()->format('Y-m-d')?>">
							</div>
							<div class="create__dateContainer">
								<label class="create__textareaLabel">Категория</label>
								<select class="create__category" name="categoryId" id="categorySelect">
									<option selected disabled>Категория</option>
									<?php foreach ($arResult['CATEGORIES'] as $category): ?>
										<option value="<?=$category->getId()?>" <?= ($category->getId() === $arResult['TASK']->getCategoryId()) ? 'selected' : '' ?>><?=htmlspecialcharsbx($category->getTitle())?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<h2>Дополнительные поля:</h2>

						<div class="create__tagContainers">
							<div class="create__tagCcontainer">
								<div id="gptError"></div>
								<label class="create__textareaLabel">Теги</label>
								<input name = "tagsString" id="taskTags" class="create__tags" placeholder="#HTML #CSS #...">
							</div>

							<?php if ($arResult['USER_SUBSCRIPTION_STATUS']):?>
								<div class="gptCreate">
									<div class="premium-link-tag">
										<button id="gptBtn" type="button">Автоматическое проставление тегов по описанию</button>
									</div>
								</div>
							<?php else:?>
								<a href="/subscription/" target="_blank">
									<div class="gptCreate">
										<div class="premium-link-tag">
											<button type="button">Автоматическое проставление тегов по описанию</button>
										</div>
									</div>
								</a>
							<?php endif;?>
						</div>
					</div>
					<div class="create__fieldsetContainer">
						<div class="create__containers" style="margin-left: 60px">
							<div class="create__dateContainer">
								<label class="create__textareaLabel" for="createMaxPrice">Стоимость заявки (₽)</label>
								<input name="maxPrice" id="createMaxPrice" class="create__priceInput" type="number" placeholder="Максимальная стоимость">
							</div>
							<?php if (count($arResult['PROJECTS']) > 0): ?>
								<div class="create__dateContainer">
									<label class="create__textareaLabel">Проект</label>
									<select name="projectId">
										<option selected disabled>Выберите Проект</option>
										<?php foreach ($arResult['PROJECTS'] as $project): ?>
											<option value="<?=$project->getId()?>"><?=htmlspecialcharsbx($project->getTitle())?></option>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif;?>
						</div>
					</div>
					<button id="taskLoader" class="createBtn" type="submit">Сохранить Изменения</button>
				</form>
			</div>

			<div id="loader" style="display: none">
				<div class="loader">
					<div class="ball moving"></div>
					<div class="balls">
						<div class="ball"></div>
						<div class="ball"></div>
						<div class="ball"></div>
						<div class="ball"></div>
						<div class="ball moving"></div>
					</div>
				</div>

				<svg>
					<filter id="goo">
						<feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
						<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />
					</filter>
				</svg>
				<p>подтягиваем магию...</p>
			</div>
		</article>
	</section>
</main>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/gptGeneration.js");
?>