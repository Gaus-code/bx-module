<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\EO_Notification;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\ReportsTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;
use Up\Ukan\Service\Configuration;

class Block extends Engine\Controller
{

	public function blockTaskAction(
		int    $taskId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$task = TaskTable::getById($taskId)->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$task->setIsBanned('Y');
		$task->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['task_block'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($task->getClientId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$report = ReportsTable::query()
							  ->setSelect(['*'])
							  ->where('TASK_ID', $task->getId())
							  ->where('TO_USER_ID', $task->getClientId())
							  ->where('TYPE', 'task')
							  ->fetchObject();
		if ($report)
		{
			ReportsTable::delete($report->getId());
		}

		LocalRedirect("/task/$taskId/");

	}

	public function unblockTaskAction(
		int    $taskId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$task = TaskTable::getById($taskId)->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$task->setIsBanned('N');
		$task->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['task_unblock'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($task->getClientId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		LocalRedirect("/task/$taskId/");

	}

	public function blockTagAction(
		int $taskId = null,
		array    $tagsId = [],
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$tags = TagTable::query()->setSelect(['*'])->whereIn('ID', $tagsId)->fetchCollection();

		if (!$tags)
		{
			LocalRedirect("/access/denied/");
		}

		foreach ($tags as $tag)
		{
			$tag->removeAllTasks();
			$tag->setIsBanned('Y');
			$tag->save();
		}

		$originTask = TaskTable::getById($taskId)->fetchObject();

		if (!$originTask)
		{
			LocalRedirect("/access/denied/");
		}

		$report = ReportsTable::query()
							  ->setSelect(['*'])
							  ->where('TASK_ID', $originTask->getId())
							  ->where('TO_USER_ID', $originTask->getClientId())
							  ->where('TYPE', 'task')
							  ->fetchObject();
		if ($report)
		{
			ReportsTable::delete($report->getId());
		}

		LocalRedirect("/task/$taskId/");

	}

	public function blockFeedbackAction(
		int $taskId = null,
		int $feedbackId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$feedback = FeedbackTable::query()->setSelect(['*'])
									  ->where('ID', $feedbackId)
									  ->where('TASK_ID', $taskId)
									  ->fetchObject();

		if (!$feedback)
		{
			LocalRedirect("/access/denied/");
		}

		$feedback->setComment('Комментарий удален по решению администрации')
				 ->setIsBanned('Y');
		$feedback->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['feedback_block'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($feedback->getFromUserId())
					 ->setTaskId($feedback->getTaskId())
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$report = ReportsTable::query()
							  ->setSelect(['*'])
							  ->where('TASK_ID', $feedback->getTaskId())
							  ->where('TO_USER_ID', $feedback->getFromUserId())
							  ->where('TYPE', 'feedback')
							  ->fetchObject();
		if ($report)
		{
			ReportsTable::delete($report->getId());
		}

		LocalRedirect("/task/$taskId/");

	}

	public function unblockFeedbackAction(
		int $taskId = null,
		int $feedbackId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$feedback = FeedbackTable::query()->setSelect(['*'])
								 ->where('ID', $feedbackId)
								 ->where('TASK_ID', $taskId)
								 ->fetchObject();

		if (!$feedback)
		{
			LocalRedirect("/access/denied/");
		}

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['feedback_unblock'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($feedback->getFromUserId())
					 ->setTaskId($feedback->getTaskId())
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$feedback->setComment('')
				 ->setIsBanned('N');
		$feedback->save();


		LocalRedirect("/task/$taskId/");

	}

	public function blockUserAction(
		int $userId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$user = UserTable::getById($userId)->fetchObject();

		if (!$user)
		{
			LocalRedirect("/access/denied/");
		}

		$email = $user->fillBUser()->getEmail();
		$user->setBio('Описание удалено')
			 ->setContacts($email)
			 ->setSubscriptionEndDate((new DateTime())->add("-1 day"))
			 ->setIsBanned('Y');
		$user->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['user_block'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($userId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$report = ReportsTable::query()
							  ->setSelect(['*'])
							  ->where('TO_USER_ID', $userId)
							  ->where('TYPE', 'user')
							  ->fetchObject();
		if ($report)
		{
			ReportsTable::delete($report->getId());
		}

		LocalRedirect("/profile/$userId/");

	}

	public function unblockUserAction(
		int $userId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$user = UserTable::getById($userId)->fetchObject();

		if (!$user)
		{
			LocalRedirect("/access/denied/");
		}

		$user->setIsBanned('N');
		$user->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['user_unblock'])
					 ->setFromUserId($USER->GetID())
					 ->setToUserId($userId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		LocalRedirect("/profile/$userId/");

	}

}