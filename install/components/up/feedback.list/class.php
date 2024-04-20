<?php

class CommentListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchSentFeedbacks();
		$this->fetchReceiveFeedbacks();
		$this->fetchFinishedTaskWithoutFeedback();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER_ID'] = (int)$USER->GetID();

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
}