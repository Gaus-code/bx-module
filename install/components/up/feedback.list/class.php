<?php

class CommentListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUserActivity();
		$this->fetchSentFeedbacks();
		$this->fetchReceiveFeedbacks();
		$this->fetchFinishedTaskWithoutFeedback();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;
	}

	protected function fetchSentFeedbacks()
	{

		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'TO_USER.B_USER', 'TASK']);
		$query->where('FROM_USER_ID', $this->arParams['USER_ID']);

		$this->arResult['SENT_FEEDBACKS'] = $query->fetchCollection();

	}

	protected function fetchReceiveFeedbacks()
	{
		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'FROM_USER.B_USER', 'TO_USER.B_USER', 'TASK']);
		$query->where('TO_USER_ID', $this->arParams['USER_ID']);

		$this->arResult['RECEIVE_FEEDBACKS'] = $query->fetchCollection();

	}

	protected function fetchFinishedTaskWithoutFeedback()
	{
		$taskIdListWithFeedback = $this->arResult['SENT_FEEDBACKS']->getTaskIdList();

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*'])->where(
				\Bitrix\Main\ORM\Query\Query::filter()->logic('or')->where('CLIENT_ID', $this->arParams['USER_ID'])
											->where('CONTRACTOR_ID', $this->arParams['USER_ID'])
			)->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['done']);
		$finishedTask = $query->fetchCollection();

		foreach ($taskIdListWithFeedback as $taskId)
		{
			$finishedTask->removeByPrimary($taskId);
		}

		$this->arResult['TASKS_WITHOUT_FEEDBACKS'] = $finishedTask;

	}

	protected function fetchUserActivity()
	{
		global $USER;
		$userId = (int)$USER->getId();


		if ($this->arParams['USER_ID'] === $userId)
		{
			$this->arResult['USER_ACTIVITY'] = 'owner';
		}
		else
		{
			$this->arResult['USER_ACTIVITY'] = 'other_user';
		}
	}
}