<?php

class UserResponseComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchResponses();
		$this->includeComponentTemplate();
	}
	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}

		if (request()->get('show') && (request()->get('show') === 'sent' || request()->get('show') === 'receive'))
		{
			$arParams['SHOW'] = request()->get('show');
		}
		else
		{
			$arParams['SHOW'] = 'sent';
		}

		if (request()->get('filter') && (request()->get('filter') === 'wait' || request()->get('filter') === 'approve' || request()->get('filter') === 'reject'))
		{
			$arParams['FILTER'] = request()->get('filter');
		}
		else
		{
			$arParams['FILTER'] = 'wait';
		}

		if (request()->get('q'))
		{
			$arParams['TASK'] = request()->get('q');
		}
		else
		{
			$arParams['TASK'] = null;
		}

		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;
	}

	private function fetchResponses()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("response");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['responses_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\ResponseTable::query();

		if ($this->arParams['SHOW'] === 'sent')
		{
			$query->setSelect(['*', 'TASK', 'TASK.PROJECT'])
				  ->where('CONTRACTOR_ID', $userId)
				  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('response_status')[$this->arParams['FILTER']]);

		}
		else if ($this->arParams['SHOW'] === 'receive')
		{
			$query->setSelect(['*', 'TASK', 'TASK.PROJECT' , 'CONTRACTOR.B_USER'])
				  ->where('TASK.CLIENT_ID', $userId)
				  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('response_status')[$this->arParams['FILTER']]);

			if (!is_null($this->arParams['TASK']))
			{
				if (($taskIdList = $this->getTaskIdList($userId)) === [])
				{
					$this->arResult['RESPONSES'] = [];
					return ;
				}
				$query->whereIn('TASK_ID', $taskIdList);
			}
		}

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$result->fillTask()->fillTags();

		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfResponses = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfResponses);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['RESPONSES'] = $arrayOfResponses;

	}

	private function getTaskIdList(int $userId)
	{
		$query = \Up\Ukan\Model\TaskTable::query();

		$query->setSelect(['ID', 'TITLE'])
			  ->where('CLIENT_ID', $userId)->whereLike('TITLE', "%{$this->arParams['TASK']}%");

		return $query->fetchCollection()->getIdList();
	}
}