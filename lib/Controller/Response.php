<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Up\Ukan\Model\EO_Response;
use Up\Ukan\Model\ResponseTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Service\Configuration;

class Response extends Engine\Controller
{
	public function createAction(
		int $taskId,
		string $price = '',
		string $coverLetter = '',
	)
	{

		if (check_bitrix_sessid())
		{
			global $USER;

			$contractorId = $USER->GetID();

			$response = new EO_Response();

			if ($price === '' || !is_numeric($price) || (int)$price<0)
			{
				LocalRedirect("/task/$taskId/");
			}

			$response->setContractorId($contractorId)->setTaskId($taskId)->setPrice($price);

			if ($coverLetter !== '')
			{
				$response->setDescription($coverLetter);
			}

			$response->save();

			LocalRedirect("/task/$taskId/");
		}
	}

	public function deleteAction(int $responseId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;

			$contractorId = $USER->GetID();

			ResponseTable::delete($responseId);

			LocalRedirect("/profile/$contractorId/responses/");
		}
	}

	public function approveAction(int $taskId, int $contractorId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId = (int)$USER->getId();

			$task = TaskTable::query()->setSelect(['*'])->where('ID', $taskId)->where('CLIENT_ID', $userId)
							 ->fetchObject();
			if ($task)
			{
				$task->setContractorId($contractorId);
				$task->setStatus(Configuration::getOption('task_status')['at_work']);
				$task->save();

				//TODO sent notify contractor that him approved

				$responseIdList = ResponseTable::query()->setSelect(['ID'])->where('TASK_ID', $taskId)->fetchCollection(
					)->getIdList();
				foreach ($responseIdList as $responseId)
				{
					//TODO sent notify other users who response that they rejected

					ResponseTable::delete($responseId);
				}
			}

			LocalRedirect("/profile/$userId/notifications/");
		}
	}

	public function rejectAction(int $taskId, int $contractorId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId = (int)$USER->getId();

			$task = TaskTable::query()->setSelect(['*'])->where('ID', $taskId)->where('CLIENT_ID', $userId)
							 ->fetchObject();
			if ($task)
			{
				//TODO sent notify other users who response that they rejected

				$responseId = ResponseTable::query()->setSelect(['ID'])->where('CONTRACTOR_ID', $contractorId)->where(
						'TASK_ID',
						$taskId
					)->fetchObject()->getId();

				ResponseTable::delete($responseId);
			}

			LocalRedirect("/profile/$userId/notifications/");
		}
	}
}