<?php

class TaskDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTask();
		$this->fetchUserActivity();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['TASK_ID']) || $arParams['TASK_ID'] <= 0)
		{
			$arParams['TASK_ID'] = null;
		}

		return $arParams;
	}
	protected function fetchTask()
	{

		if ($this->arParams['TASK_ID'])
		{
			$this->arResult['TASK'] =  \Up\Ukan\Model\TaskTable::query()->setSelect(['*', 'TAGS', 'CLIENT', 'STATUS'])->where('ID', $this->arParams['TASK_ID'])->fetchObject();
		}

	}

	protected function fetchUserActivity()
	{
		if ($this->arResult['TASK'])
		{
			global $USER;
			$userId = (int)$USER->getId();

			if ($this->arResult['TASK']->getClientId() === $userId)
			{
				$this->arResult['USER_ACTIVITY'] = 'owner';
				return ;
			}

			if ($this->arResult['TASK']->getContractorId() !== 0)
			{
				if ($this->arResult['TASK']->getContractorId() === $userId)
				{
					$this->arResult['USER_ACTIVITY'] = 'approved this user';
				}
				else
				{
					$this->arResult['USER_ACTIVITY'] = 'approved other user';
				}
				return ;
			}

			$response = \Up\Ukan\Model\ResponseTable::query()
													->setSelect(['ID'])
													->where('TASK_ID', $this->arResult['TASK']->getId())
													->where('CONTRACTOR_ID', $userId)
													->fetchObject();
			if ($response)
			{
				$this->arResult['USER_ACTIVITY'] = 'wait approve this user';
			}
		}


	}
}