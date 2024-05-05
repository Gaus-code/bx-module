<?php

class UserProjectComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchCategories();
		$this->fethUserSubscriptionStatus();
		$this->fetchAddTaskList();
		$this->fetchProject();
		$this->fetchStages();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!isset($arParams['PROJECT_ID']) || $arParams['PROJECT_ID'] <= 0)
		{
			$arParams['PROJECT_ID'] = null;
		}

		return $arParams;
	}

	protected function fetchStages()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$stages = \Up\Ukan\Model\ProjectStageTable::query()->setSelect([
																			   '*',
																			   // 'EXPECTED_COMPLETION_DATE',
																			   'TASKS',
																			   'TASKS.CONTRACTOR',
																			   'TASKS.CONTRACTOR.B_USER',
																		   ])
															   ->where('PROJECT_ID',$this->arParams['PROJECT_ID'])
															   ->addOrder('NUMBER')
															   ->addOrder('TASKS.DEADLINE')
															   ->fetchCollection();

			$stageExpectedCompletedDateResult = \Up\Ukan\Model\ProjectStageTable::getList([
																							  'select' => [
																								  'ID',
																								  'PROJECT_ID',
																								  'EXPECTED_COMPLETION_DATE',
																							  ],
																							  'filter' => ['=PROJECT_ID' => $this->arParams['PROJECT_ID']],
																							  'order' => ['NUMBER' => 'ASC'],
																						  ]);

			foreach ($stageExpectedCompletedDateResult as $row)
			{
				$stageExpectedCompletedDate[$row['ID']] = $row['EXPECTED_COMPLETION_DATE'];
			}
			$this->arResult['STAGES_EXPECTED_COMPLETION_DATE'] = $stageExpectedCompletedDate;
			$this->arResult['STAGES'] = $stages;

		}
	}

	protected function fetchProject()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect([
																		   '*',
																		   'STAGES',
																		   // 'STAGES.EXPECTED_COMPLETION_DATE',
																		   'STAGES.TASKS',
																		   'STAGES.TASKS.CONTRACTOR',
																		   'STAGES.TASKS.CONTRACTOR.B_USER',
																	   ])->where('ID', $this->arParams['PROJECT_ID'])
												  ->addOrder('ID')->addOrder('STAGES.NUMBER')->addOrder(
					'STAGES.TASKS.DEADLINE'
				)->fetchObject();

			if ($project->getClientId() === $this->arParams['USER_ID'])
			{
				$this->arResult['PROJECT'] = $project;
			}
			else
			{
				LocalRedirect("/profile/" . $this->arParams['USER_ID'] . "/projects/");
			}
		}
	}

	protected function fetchAddTaskList()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			global $USER;

			$this->arResult['ADD_TASK_LIST'] = \Up\Ukan\Model\TaskTable::query()->setSelect(
					['ID', 'TITLE', 'PROJECT_STAGE', 'STATUS']
				)->whereNull('PROJECT_STAGE.PROJECT_ID')->where('CLIENT_ID', $USER->GetID())
				 ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['search_contractor'])->fetchCollection();
		}
	}

	protected function fetchCategories()
	{
		$this->arResult['CATEGORIES'] = \Up\Ukan\Model\CategoriesTable::query()->setSelect(['*'])->fetchCollection();
	}

	private function fethUserSubscriptionStatus()
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$user = \Up\Ukan\Model\UserTable::query()->setSelect(['ID', 'SUBSCRIPTION_STATUS'])
			->where('ID', $userId)
			->fetchObject();

		$this->arResult['USER_SUBSCRIPTION_STATUS'] = ($user->getSubscriptionStatus()==='Active');
	}
}