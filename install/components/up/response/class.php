<?php

class UserResponseComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->preparePaginationParams();
		$this->fetchSentResponses();
		$this->fetchReceiveResponses();
		$this->includeComponentTemplate();
	}
	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
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

	private function preparePaginationParams()
	{
		$nameOfPageAreas = [
			'_SENT_RESPONSE',
			'_RECEIVE_RESPONSE',
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

	private function fetchSentResponses()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("response");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['responses_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE' . '_SENT_RESPONSE']);

		$userId = $this->arParams['USER_ID'];

		$query = \Up\Ukan\Model\ResponseTable::query();

		$query->setSelect(['*', 'TASK', 'TASK.PROJECT'])
			  ->where('CONTRACTOR_ID', $userId)
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('response_status')[$this->arParams['FILTER']]);

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$result->getTaskCollection()->fillTags();

		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfResponses = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE' . '_SENT_RESPONSE'])
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_SENT_RESPONSE'] = true;
			array_pop($arrayOfResponses);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_SENT_RESPONSE'] = false;
		}

		$this->arResult['SENT_RESPONSES'] = $arrayOfResponses;

	}

	private function fetchReceiveResponses()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("response");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['responses_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE' . '_RECEIVE_RESPONSE']);

		$userId = $this->arParams['USER_ID'];

		$query = \Up\Ukan\Model\ResponseTable::query();


		$query->setSelect(['*', 'TASK', 'TASK.PROJECT' , 'CONTRACTOR.B_USER.NAME', 'CONTRACTOR.B_USER.LAST_NAME'])
			  ->where('TASK.CLIENT_ID', $userId)
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('response_status')[$this->arParams['FILTER']]);

		if (!is_null($this->arParams['TASK']))
		{
			if (($taskIdList = $this->getTaskIdList($userId)) === [])
			{
				$this->arResult['RECEIVE_RESPONSES'] = [];
				return ;
			}
			$query->whereIn('TASK_ID', $taskIdList);
		}


		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$result->getTaskCollection()->fillTags();

		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfResponses = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE' . '_RECEIVE_RESPONSE'])
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_RECEIVE_RESPONSE'] = true;
			array_pop($arrayOfResponses);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE' . '_RECEIVE_RESPONSE'] = false;
		}

		$this->arResult['RECEIVE_RESPONSES'] = $arrayOfResponses;
	}

	private function getTaskIdList(int $userId)
	{
		$query = \Up\Ukan\Model\TaskTable::query();

		$query->setSelect(['ID', 'TITLE'])
			  ->where('CLIENT_ID', $userId)
			  ->whereLike('TITLE', "%{$this->arParams['TASK']}%");

		return $query->fetchCollection()->getIdList();
	}
}