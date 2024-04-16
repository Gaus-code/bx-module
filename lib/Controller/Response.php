<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\EO_Response;
use Up\Ukan\Model\EO_Notification;
use Up\Ukan\Model\ResponseTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Service\Configuration;

class Response extends Engine\Controller
{
	public function createAction(
		int    $taskId,
		int    $clientId,
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

			$notification = new EO_Notification();
			$notification->setMessage(Configuration::getOption('notification_message')['new_response'])
						 ->setFromUserId($contractorId)
						 ->setToUserId($clientId)
						 ->setTaskId($taskId)
						 ->setCreatedAt(new DateTime());

			$notification->save();

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

			$task = TaskTable::query()
							 ->setSelect(['*'])
							 ->where('ID', $taskId)
							 ->where('CLIENT_ID', $userId)
							 ->fetchObject();
			if ($task)
			{
				$task->setContractorId($contractorId);
				$task->setStatus(Configuration::getOption('task_status')['at_work']);
				$task->save();

				$notification = new EO_Notification();
				$notification->setMessage(Configuration::getOption('notification_message')['approve'])
							 ->setFromUserId($userId)
							 ->setToUserId($contractorId)
							 ->setTaskId($taskId)
							 ->setCreatedAt(new DateTime());
				$notification->save();

				$responses = ResponseTable::query()
										  ->setSelect(['ID', 'CONTRACTOR_ID'])
										  ->where('TASK_ID', $taskId)
										  ->fetchCollection();
				foreach ($responses as $response)
				{
					$notification = new EO_Notification();
					$notification->setMessage(Configuration::getOption('notification_message')['reject'])
								 ->setFromUserId($userId)
								 ->setToUserId($response->getContractorId())
								 ->setTaskId($taskId)
								 ->setCreatedAt(new DateTime());
					$notification->save();


					ResponseTable::delete($response->getId());
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
				$notification = new EO_Notification();
				$notification->setMessage(Configuration::getOption('notification_message')['reject'])
							 ->setFromUserId($userId)
							 ->setToUserId($contractorId)
							 ->setTaskId($taskId)
							 ->setCreatedAt(new DateTime());
				$notification->save();

				$responseId = ResponseTable::query()
										   ->setSelect(['ID'])
										   ->where('CONTRACTOR_ID', $contractorId)
										   ->where('TASK_ID',	$taskId)
										   ->fetchObject()
										   ->getId();

				ResponseTable::delete($responseId);
			}

			LocalRedirect("/profile/$userId/notifications/");
		}
	}
}