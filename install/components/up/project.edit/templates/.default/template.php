<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 */

use Up\Ukan\Service\Configuration;

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
				<a class="content__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/">Ваш проект</a>
			</article>
			<article class="content__userProject">
				<article class="content__editProject">

					<?php
					$APPLICATION->IncludeComponent('up:errors.message', '', []); ?>

				</article>
				<article class="content__tagButtons">
					<div class="content__header">
						<ul class="content__tagList">
							<li id="plan-btn" class="content__tagItem active-tag-item">
								Планирование проекта
							</li>
							<li id="addTask-btn" class="content__tagItem">
								Добавить существующую заявку
							</li>
							<li id="createTask-btn" class="content__tagItem">
								Создать заявку
							</li>
							<li id="edit-btn" class="content__tagItem">
								Основная информация
							</li>
							<li id="delete-btn" class="content__tagItem">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
								Удалить проект
							</li>
						</ul>
					</div>
				</article>
				<!-- Контейнер для планирования проекта !-->
				<div id="plan-reviews" class="content__priorityContainer tab__container">
					<div class="board">
						<div class="board__btnContainer">
							<form action="/project/add-stage/" method="post">
								<?= bitrix_sessid_post() ?>
								<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
								<button class="submitDrag" type="submit">Добавить этап</button>
							</form>
							<form action="/project/delete-stage/" method="post">
								<?= bitrix_sessid_post() ?>
								<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
								<button class="submitDrag" type="submit">Удалить этап</button>
							</form>
						</div>

						<form action="/project/edit-stages/" id="drag-form" method="post">
							<?= bitrix_sessid_post() ?>
							<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
							<button class="submitDrag" type="submit">Сохранить изменения</button>
							<div class="lanes">
								<?php
								foreach ($arResult['STAGES'] as $stage): ?>
									<div class="swim-lane" id="todo-lane" data-zone-id="<?= $stage->getId() ?>">
										<h3 class="heading">
											<div class="project__stage__header">
												<p class="stage__title"><?php
													if ($stage->getNumber() === 0)
													{
														echo "Независимые задачи";
													}
													else
													{
														echo $stage->getNumber() . " этап";
													} ?></p>
												<p class="project__stage__status"><?= $stage->getStatus() ?></p>
											</div>
											<?php
											//if ($arResult['STAGES_EXPECTED_COMPLETION_DATE'][$stage->getId()]):?>
											<!--<p>Окончание этапа: --><?php
											//=$arResult['STAGES_EXPECTED_COMPLETION_DATE'][$stage->getId()]?><!--</p>-->
											<?php
											//endif;?>

										</h3>
										<?php
										foreach ($stage->getTasks() as $task): ?>
											<div class="task" draggable="true">
												<input type="hidden" name="tasks[<?= $task->getId() ?>][zoneId]">
												<div class="task__header">
													<a href="/task/<?= $task->getId() ?>/"><?= htmlspecialcharsbx(
															$task->getTitle()
														) ?></a>
												</div>
												<div class="task__info">
													<div class="task__info_parameters">
														<p>Статус:</p><p> <?= $task->getStatus() ?></p>
													</div>
													<div class="task__info_parameters">
														<p>Исполнитель:</p> <?php
														if ($task->getContractorId()): ?>
															<a href="/profile/<?= $task->getContractorId() ?>/">
																<?= $task->getContractor()->getBUser()->getName(
																) ?> <?= $task->getContractor()->getBUser()->getLastName(
																) ?>
															</a>
														<?php
														else: ?>
															<p>-</p>
														<?php
														endif; ?>
													</div>
													<div class="task__info_parameters">
														<p>Дедлайн:</p><p><?= $task->getDeadline() ?></p>
													</div>
												</div>
												<div class="task__deleteBtb">
													<input class="projectTaskDelete" type="checkbox" name="tasks[<?= $task->getId(
													) ?>][taskDelete]">
												</div>
											</div>
										<?php
										endforeach; ?>
									</div>
								<?php
								endforeach; ?>
							</div>
						</form>
					</div>
				</div>
				<!-- Контейнер для добавления существующей заявки !-->
				<div id="addTask-reviews" class="content__nonPriorityContainer tab__container">
					<form action="/project/add-tasks/" method="post" class="addTask__form">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
						<fieldset>
							<legend>Выберите заявки для добавления в проект</legend>
							<?php
							if (isset($arResult['ADD_TASK_LIST'])): ?>
								<ul class="filter__list">
									<?php
									foreach ($arResult['ADD_TASK_LIST'] as $task): ?>
										<li class="filter__item">
											<input type="checkbox" class="filter__checkbox" name="taskIds[<?= $task->getId(
											) ?>]" value="<?= $task->getId() ?>">
											<label class="filter__label"><?= htmlspecialcharsbx(
													$task->getTitle()
												) ?></label>
										</li>
									<?php
									endforeach; ?>
								</ul>
							<?php
							else: ?>
								<p class="empty">У вас пока нет заявок</p>
							<?php
							endif; ?>
						</fieldset>
						<button type="submit">Добавить заявки</button>
					</form>
				</div>
				<!-- Контейнер для создания заявки сразу в проекте!-->
				<div id="createTask-reviews" class="content__nonPriorityContainer tab__container">
					<div class="modalResponse">
						<?php
						$APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
					</div>
					<form class="create__form" action="/task/create/project/" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
						<div class="create__text">
							<div class="create__container">
								<label class="create__textareaLabel" for="createTitle">Добавьте Название</label>
								<input name="title" id="createTitle" type="text" class="create__title" placeholder="Название заявки" required>
							</div>
							<div class="create__container">
								<label class="create__textareaLabel" for="taskDescription">Добавьте Описание</label>
								<textarea name="description" id="taskDescription" class="create__description" cols="30" rows="10" required></textarea>
							</div>
							<div class="create__container">
								<label class="create__textareaLabel" for="createMaxPrice">Добавьте максимальную стоимость</label>
								<input name="maxPrice" id="createMaxPrice" type="number" class="create__title" placeholder="Максимальная стоимость">
							</div>
							<div class="create__container">
								<label class="create__textareaLabel" for="createMaxPrice">Добавьте тэги (используя #)</label>
								<input name="tagsString" id="createMaxPrice" class="create__title" placeholder="#HTML #CSS #...">
							</div>
							<div class="create__container">
								<label class="create__textareaLabel" for="deadline">Установите крайний срок</label>
								<input name="deadline" id="deadline" type="date" class="create__title">
							</div>
						</div>
						<li class="filter__item">
							<input class="filter__checkbox" name="useGPT" type="checkbox">
							<label class="filter__label">Автоматическое проставление тегов по описанию</label>
						</li>
						<div class="create__fieldsetContainer">
							<fieldset>
								<legend>Выберите категорию</legend>
								<ul class="filter__list">
									<?php
									foreach ($arResult['CATEGORIES'] as $category): ?>
										<li class="filter__item">
											<input type="radio" class="filter__radio" name="categoryId" value="<?= $category->getId(
											) ?>">
											<label class="filter__label"><?= htmlspecialcharsbx(
													$category->getTitle()
												) ?></label>
										</li>
									<?php
									endforeach; ?>
								</ul>
							</fieldset>
						</div>
						<button class="createBtn" type="submit">Создать заявку</button>
					</form>
				</div>
				<!-- Контейнер для редактирование основной информации!-->
				<div id="edit-reviews" class="content__nonPriorityContainer tab__container">
					<form class="editForm" action="/project/edit-info/" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
						<div class="editForm__container">
							<label for="projectTitle">Редактируйте название проекта</label>
							<input id="projectTitle" type="text" name="title">
						</div>
						<div class="editForm__container">
							<label for="projectDescription">Редактируйте описание проекта</label>
							<input id="projectDescription" type="text" name="description">
						</div>
						<button type="submit">Отправить</button>
					</form>
				</div>
				<!-- Контейнер для удаления проекта(работает!) !-->
				<div id="delete-reviews" class="content__nonPriorityContainer tab__container">
					<form action="/project/delete/" method="post" class="deleteTask__form">
						<?= bitrix_sessid_post() ?>
						<h4>Вы действительно хотите удалить проект?</h4>
						<input type="hidden" name="projectId" value='<?= $arParams['PROJECT_ID'] ?>'>
						<button class="deleteProject">
							Удалить проект
						</button>
					</form>
				</div>
			</article>
		</section>
	</main>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/tabContainers.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/dragAndDrop.js");
?>