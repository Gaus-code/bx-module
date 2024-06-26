<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\EO_Notification;
use Up\Ukan\Model\EO_Response;
use Up\Ukan\Model\NotificationTable;
use Up\Ukan\Model\ResponseTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;
use Up\Ukan\Service\Configuration;

class Response extends Engine\Controller
{
	public function createAction(
		int    $taskId = null,
		string $price = null,
		string $coverLetter = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$userId = $USER->GetID();

		[$errors, $task] = $this->validateDataCreate(
			$userId,
			$taskId,
			$price,
			$coverLetter
		);
		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/$taskId/");
		}

		$response = new EO_Response();

		$response->setContractorId($userId)
				 ->setTaskId($taskId)
				 ->setPrice($price)
				 ->setStatus(Configuration::getOption('response_status')['wait']);

		if ($coverLetter)
		{
			$response->setDescription($coverLetter);
		}

		$response->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['new_response'])
					 ->setFromUserId($userId)
					 ->setToUserId($task->getClientId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());

		$notification->save();

		LocalRedirect("/task/$taskId/");
	}

	public function deleteAction(int $responseId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$contractorId = (int)$USER->GetID();

		$response = ResponseTable::query()
								 ->setSelect(['*', 'TASK.CLIENT_ID'])
								 ->where('ID', $responseId)
								 ->where('CONTRACTOR_ID',	$contractorId)
								 ->fetchObject();

		if (!$response)
		{
			LocalRedirect("/access/denied/");
		}

		$clientId = $response->getTask()->getClientId();
		$taskId = $response->getTaskId();

		$notification = NotificationTable::query()->setSelect(['ID'])
												  ->where('MESSAGE',Configuration::getOption('notification_message'	)['new_response'])
												  ->where('FROM_USER_ID', $contractorId)
												  ->where('TO_USER_ID', $clientId)
												  ->where('TASK_ID', $taskId)
												  ->fetchObject();

		if ($notification && !NotificationTable::delete($notification->getId()))
		{
			LocalRedirect("/access/denied/");
		}

		if (ResponseTable::delete($responseId))
		{
			LocalRedirect("/task/$taskId/");
		}

		LocalRedirect("/access/denied/");

	}

	public function approveAction(
		int $taskId = null,
		int $contractorId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = (int)$USER->getId();

		$task = TaskTable::query()
						 ->setSelect(['*'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->where('STATUS', Configuration::getOption('task_status')['search_contractor'])
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$user = UserTable::getById($userId)->fetchObject();
		if ($user && $user->getIsBanned())
		{
			LocalRedirect("/access/denied/");
		}

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

		$response = ResponseTable::query()
								 ->setSelect(['ID'])
								 ->where('TASK_ID', $taskId)
								 ->where('CONTRACTOR_ID',	$contractorId)
								 ->fetchObject();
		$response->setStatus(Configuration::getOption('response_status')['approve']);
		$response->save();

		$responses = ResponseTable::query()
								  ->setSelect(['ID', 'CONTRACTOR_ID'])
								  ->where('TASK_ID', $taskId)
								  ->where('STATUS', Configuration::getOption('response_status')['wait'])
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

			$response->setStatus(Configuration::getOption('response_status')['reject']);
			$response->save();
		}

		LocalRedirect("/task/$taskId/");

	}

	public function rejectAction(int $taskId, int $contractorId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = (int)$USER->getId();

		$task = TaskTable::query()
						 ->setSelect(['*'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();
		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['reject'])
					 ->setFromUserId($userId)
					 ->setToUserId($contractorId)
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$response = ResponseTable::query()
								 ->setSelect(['ID'])
								 ->where('TASK_ID', $taskId)
								 ->where('CONTRACTOR_ID',	$contractorId)
								 ->fetchObject();
		$response->setStatus(Configuration::getOption('response_status')['reject']);
		$response->save();

		LocalRedirect("/profile/$userId/responses/?show=receive&filter=approve");
	}

	private function validateDataCreate(
		int $userId,
		?int    $taskId,
		?string $price = '',
		?string $coverLetter = ''
	): array
	{
		$errors = [];

		$task = TaskTable::query()
						 ->setSelect(['*'])
						 ->where('ID', $taskId)
						 ->whereNot('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!isset($task))
		{
			LocalRedirect("/access/denied/");
		}

		$user = UserTable::getById($userId)->fetchObject();
		if ($user && $user->getIsBanned())
		{
			//$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			LocalRedirect("/access/denied/");
		}

		if ($task->getStatus() !== Configuration::getOption('task_status')['search_contractor'])
		{
			$errors[] = "По данной задаче исполнитель уже найден, либо он не требуется";
		}

		if (!$price || !is_numeric($price) || (int)$price < 0)
		{
			$errors [] = 'Неправильная цена';
		}

		return [$errors, $task];
	}

}