<?php

class CommentListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->preparePaginationParams();
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

	private function preparePaginationParams()
	{
		$nameOfPageAreas = [
			'_SENT_FEEDBACK',
			'_RECEIVE_FEEDBACK',
			'_LEFT_FEEDBACK',
		];
		foreach ($nameOfPageAreas as $nameOfPageArea)
		{
			if (!request()->get('PAGEN_1' . $nameOfPageArea) || !is_numeric(request()->get('PAGEN_1' . $nameOfPageArea)) || (int)request()->get('PAGEN_1' . $nameOfPageArea) < 1)
			{
				$this->arParams['CURRENT_PAGE' . $nameOfPageArea] = 1;
			}
			else
			{
				$this->arParams['CURRENT_PAGE' . $nameOfPageArea] = (int)request()->get('PAGEN_1' . $nameOfPageArea);
			}
		}

	}
	protected function fetchSentFeedbacks()
	{

		$nav = new \Bitrix\Main\UI\PageNavigation("feedback.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['feedback_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE' . '_SENT_FEEDBACK']);

		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'TO_USER.B_USER.NAME', 'TO_USER.B_USER.LAST_NAME', 'TASK']);
		$query->where('FROM_USER_ID', $this->arParams['USER_ID'])
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset());

		$sentFeedback = $query->fetchCollection()->getAll();

		$nav->setRecordCount($nav->getOffset() + count($sentFeedback));

		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE' . '_SENT_FEEDBACK'])
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_SENT_FEEDBACK'] = true;
			array_pop($sentFeedback);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_SENT_FEEDBACK'] = false;
		}

		$this->arResult['SENT_FEEDBACKS'] = $sentFeedback;

	}

	protected function fetchReceiveFeedbacks()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("feedback.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['feedback_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE' . '_RECEIVE_FEEDBACK']);

		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'FROM_USER.B_USER.NAME', 'FROM_USER.B_USER.LAST_NAME', 'TASK']);
		$query->where('TO_USER_ID', $this->arParams['USER_ID'])
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset());

		$receiveFeedback = $query->fetchCollection()->getAll();

		$nav->setRecordCount($nav->getOffset() + count($receiveFeedback));

		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE' . '_RECEIVE_FEEDBACK'])
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_RECEIVE_FEEDBACK'] = true;
			array_pop($receiveFeedback);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_RECEIVE_FEEDBACK'] = false;
		}

		$this->arResult['RECEIVE_FEEDBACKS'] = $receiveFeedback;

	}

	protected function fetchFinishedTaskWithoutFeedback()
	{
		$taskIdListWithFeedback = [];
		foreach ($this->arResult['SENT_FEEDBACKS'] as $feedback)
		{
			$taskIdListWithFeedback [] = $feedback->getTaskId();
		}

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*'])->where(
			\Bitrix\Main\ORM\Query\Query::filter()->logic('or')->where('CLIENT_ID', $this->arParams['USER_ID'])->where(
					'CONTRACTOR_ID',
					$this->arParams['USER_ID']
				)
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