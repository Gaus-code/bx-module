<?php

class UserProjectComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchProject();
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

	protected function fetchProject()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$project =  \Up\Ukan\Model\ProjectTable::query()->setSelect(['*', 'TASKS', 'TASKS.CONTRACTOR', 'TASKS.CONTRACTOR.B_USER'])
															->where('ID', $this->arParams['PROJECT_ID'])
															->addOrder('TASKS.PROJECT_PRIORITY')
															->fetchObject();

			if ($project->getClientId()===$this->arParams['USER_ID'])
			{
				$this->arParams['PROJECT']=$project;
			}
			else
			{
				LocalRedirect("/profile/".$this->arParams['USER_ID']."/projects/");
			}
		}
	}
}