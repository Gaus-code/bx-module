<?php

use Up\Ukan\Service\Configuration;

class TaskDetailFooterComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchActivity();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER_ID'] = (int)$USER->getId();

		if (!$arParams['USER_ACTIVITY'] || !in_array($arParams['USER_ACTIVITY'], [
			'.default',
			'contractor_this_task',
			'another_contractor',
			'owner',
			'reject',
			'wait',
			'admin'
			], true))
		{
			$arParams['USER_ACTIVITY'] = '.default' ;
		}

		$arParams['TASK_STATUSES'] = \Up\Ukan\Service\Configuration::getOption('task_status');

		return $arParams;
	}

	public function fetchActivity()
	{
		switch ($this->arParams['USER_ACTIVITY'])
		{
			case 'owner':
				$this->fetchOwnerActivity();
				$this->fetchUserBan();
				break;
			case 'contractor_this_task':
				$this->fetchContractorActivity();
				$this->fetchUserBan();
				break;
			case 'another_contractor':
				$this->fetchContractor();
				break;
			case 'admin':
				$this->fetchContractor();
				$this->fillFeedbacks();
				break;
			case 'reject':
			case 'wait':
			default:
				break;
		}

	}

	private function fetchOwnerActivity()
	{
		if ($this->arParams['TASK']->getStatus() === $this->arParams['TASK_STATUSES']['search_contractor'] )
		{
			$this->fetchResponses();
		}
		elseif ($this->arParams['TASK']->getStatus() === $this->arParams['TASK_STATUSES']['at_work'])
		{
			$this->fetchContractor();
		}
		elseif ($this->arParams['TASK']->getStatus() === $this->arParams['TASK_STATUSES']['done'])
		{
			$this->setUserSentFeedback();
			$this->fetchLeaveFeedbackForm();
			$this->fillFeedbacks();
			$this->fetchIssetReportFeedback();
		}
	}

	private function fetchContractorActivity()
	{
		if ($this->arParams['TASK']->getStatus() !== $this->arParams['TASK_STATUSES']['done'] )
		{
			$this->fetchClient();
		}
		else
		{
			$this->setUserSentFeedback();
			$this->fetchLeaveFeedbackForm();
			$this->fillFeedbacks();
			$this->fetchIssetReportFeedback();
		}
	}
	private function fetchResponses()
	{
		$query = \Up\Ukan\Model\ResponseTable::query();
		$query->setSelect(['*', 'TASK', 'CONTRACTOR.B_USER.NAME', 'CONTRACTOR.B_USER.LAST_NAME'])
			  ->where('TASK_ID', $this->arParams['TASK']->getId())
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('response_status')['wait'])
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit(5);

		$this->arResult['RESPONSES'] = $query->fetchCollection();
	}

	private function fetchClient()
	{
		$this->arResult['CLIENT'] = $this->arParams['TASK']->getClient();
	}

	private function setUserSentFeedback()
	{
		if ($this->arParams['TASK'])
		{
			$feedback = \Up\Ukan\Model\FeedbackTable::query()
													->setSelect(['*'])
													->where('TASK_ID', $this->arParams['TASK']->getId())
													->where('FROM_USER_ID', $this->arParams['USER_ID'])
													->fetchObject();

			$this->arResult['USER_SENT_FEEDBACK'] = isset($feedback);

		}
	}
	private function fillFeedbacks()
	{
		if ($this->arParams['TASK'])
		{
			$this->arParams['TASK']->fillFeedbacks();
			$this->arParams['TASK']->getFeedbacks()->fillFromUser()->fillBUser();
			$this->arParams['TASK']->getFeedbacks()->fillToUser()->fillBUser();
		}
	}

	private function fetchContractor()
	{
		$this->arResult['CONTRACTOR'] = $this->arParams['TASK']->getContractor();
	}
	private function fetchLeaveFeedbackForm()
	{
		if (!$this->arResult['USER_SENT_FEEDBACK'])
		{
			$fromUserId = $this->arParams['USER_ID'];

			if ($this->arParams['USER_ACTIVITY']==='owner')
			{
				$toUserRole=Configuration::getOption('user_role')['contractor'];
				$toUserId=$this->arParams['TASK']->getContractorId();
			}
			elseif ($this->arParams['USER_ACTIVITY']==='contractor_this_task')
			{
				$toUserRole=Configuration::getOption('user_role')['client'];
				$toUserId=$this->arParams['TASK']->getClientId();
			}

			$this->arResult['LEAVE_FEEDBACK_FORM'] = [
				"TO_USER_ROLE"=>$toUserRole,
				"FROM_USER_ID"=>$fromUserId,
				"TO_USER_ID"=>$toUserId,
			];
		}
	}

	private function fetchIssetReportFeedback()
	{
		if ($this->arParams['TASK'])
		{
			global $USER;
			$userId = (int)$USER->getId();
			$report = \Up\Ukan\Model\ReportsTable::query()
												 ->setSelect(['ID'])
												 ->where('FROM_USER_ID', $userId)
												 ->where('TASK_ID', $this->arParams['TASK']->getId())
												 ->where('TYPE', 'feedback')
												 ->fetchObject();
			$this->arResult['ISSET_REPORT'] = (bool)$report;
		}

	}

	private function fetchUserBan()
	{
		$user = \Up\Ukan\Model\UserTable::getById($this->arParams['USER_ID'])->fetchObject();
		$this->arResult['USER_IS_BANNED'] = $user->getIsBanned();
	}
}