<?php

class TaskDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTask();
		$this->fetchUserActivity();
		$this->fetchIssetReport();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!request()->get('task_id') || (int)request()->get('task_id') <= 0)
		{
			$arParams['TASK_ID'] = null;
		}
		else
		{
			$arParams['TASK_ID'] = (int)request()->get('task_id');
		}
		return $arParams;
	}
	protected function fetchTask()
	{

		if ($this->arParams['TASK_ID'])
		{
			$this->arResult['TASK'] =  \Up\Ukan\Model\TaskTable::query()
															   ->setSelect(
																   [
																	   '*',
																	   'TAGS',
																	   'CLIENT',
																	   'CLIENT.B_USER.NAME',
																	   'CLIENT.B_USER.LAST_NAME',
																	   'CLIENT.B_USER.EMAIL',
																	   'CONTRACTOR',
																	   'CONTRACTOR.B_USER.NAME',
																	   'CONTRACTOR.B_USER.LAST_NAME',
																	   'CONTRACTOR.B_USER.EMAIL',
																   ])
															   ->where('ID', $this->arParams['TASK_ID'])
															   ->fetchObject();
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
					$this->arResult['USER_ACTIVITY'] = 'contractor_this_task';
				}
				else
				{
					$this->arResult['USER_ACTIVITY'] = 'contractor_from_project';
				}
				return ;
			}

			$response = \Up\Ukan\Model\ResponseTable::query()
													->setSelect(['*'])
													->where('TASK_ID', $this->arResult['TASK']->getId())
													->where('CONTRACTOR_ID', $userId)
													->fetchObject();
			if ($response)
			{
				if ($response->getStatus() === \Up\Ukan\Service\Configuration::getOption('response_status')['wait'])
				{
					$this->arResult['USER_ACTIVITY'] = 'wait';
					$this->arResult['RESPONSE'] = $response;
					return ;
				}

				if ($response->getStatus() === \Up\Ukan\Service\Configuration::getOption('response_status')['reject'])
				{
					$this->arResult['USER_ACTIVITY'] = 'reject';
					return ;
				}
			}


			$this->arResult['USER_ACTIVITY'] = '.default';
		}
	}

	private function fetchIssetReport()
	{
		if ($this->arResult['TASK'])
		{
			global $USER;
			$userId = (int)$USER->getId();
			$report = \Up\Ukan\Model\ReportsTable::query()
												 ->setSelect(['ID'])
												 ->where('FROM_USER_ID', $userId)
												 ->where('TO_TASK_ID', $this->arResult['TASK']->getId())
												 ->fetchObject();
			$this->arResult['ISSET_REPORT'] = (bool)$report;
		}

	}
}