<?php

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

		if ($arParams['TASK'])
		{
			$this->arResult['TASK'] = $arParams['TASK'];
		}


		if (!$arParams['USER_ACTIVITY'] || !in_array($arParams['USER_ACTIVITY'], [
			'.default',
			'contractor_this_task',
			'contractor_from_project',
			'owner',
			'reject',
			'wait'
			], true))
		{
			$arParams['USER_ACTIVITY'] = '.default' ;
		}

		$this->arResult['TASK_STATUSES']= \Up\Ukan\Service\Configuration::getOption('task_status');

		return $arParams;
	}

	public function fetchActivity()
	{
		switch ($this->arParams['USER_ACTIVITY'])
		{
			case 'owner':
			case 'contractor_this_task':
				$this->fetchFeedback();
				break;
			case 'contractor_from_project':
				$this->fetchContactsContractor();
				break;

			case 'reject':
			case 'wait':
			default:
				break;

		}

	}

	private function fetchFeedback()
	{
		if ($this->arResult['TASK'])
		{
			global $USER;
			$userId = (int)$USER->getId();

			$feedback = \Up\Ukan\Model\FeedbackTable::query()->setSelect(['*'])
													->where('TASK_ID', $this->arResult['TASK']->getId())
													->where('FROM_USER_ID', $userId)->fetchObject();
			if (isset($feedback))
			{
				$this->arResult['USER_FEEDBACK_FLAG'] = true;
			}
			else
			{
				$this->arResult['USER_FEEDBACK_FLAG'] = false;
			}

		}
	}

	private function fetchContactsContractor()
	{

		if ($this->arResult['TASK'] && $this->arResult['TASK']->fillContractor())
		{
			//$this->arResult['CONTACTS'] = $this->arResult['TASK']->getContractor()-> //TODO get contacts
		}
	}

}