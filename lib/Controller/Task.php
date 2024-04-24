<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Tag;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\ProjectStageTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Service\Configuration;
use Up\Ukan\Model\EO_Notification;

class Task extends Controller
{
	public function createAction(
		string $title,
		string $description,
		string $maxPrice,
		int $categoryId,
		string $useGPT = null,
		int    $projectId = null,
		string  $tagsString = '',
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;

			$clientId = $USER->GetID();

			if ($maxPrice && (!is_numeric($maxPrice) || (int)$maxPrice<0))
			{
				LocalRedirect("/task/".$clientId."/create/");
			}

			$task = new EO_Task();
			$task->setTitle($title)->setDescription($description)->setClientId($clientId)->setCategoryId($categoryId);

			// if ($useGPT) //TODO fix to use the great YandexGPT
			// {
			// 	$tags = YandexGPT::getTagsByTaskDescription($title.$description);
			// }
			// else
			// {
			// 	$tags = TagTable::query()->setSelect(['*'])->whereIn('ID', $tagIds)->fetchCollection();
			// }
			// foreach ($tags as $tag)
			// {
			// 	$task->addToTags($tag);
			// }

			if ($tagsString !== '')
			{
				$arrayOfTagsTitle = explode('#', $tagsString);
				array_shift($arrayOfTagsTitle);
				foreach ($arrayOfTagsTitle as $tag)
				{
					$tag = $str = str_replace(' ', '', $tag);
					$tagFromDb = TagTable::query()->setSelect(['*'])->where('TITLE', $tag)->fetchObject();
					if ($tagFromDb)
					{
						$task->addToTags($tagFromDb);
					}
					else
					{
						$newTag = new EO_Tag();
						$newTag->setTitle($tag)->setCreatedAt(new DateTime())->setUserId($clientId);

						$newTag->save();
						$task->addToTags($newTag);
					}
				}

			}

			if (isset($projectId))
			{
				$projectStage=ProjectStageTable::query()->setSelect(['ID', 'NUMBER', 'PROJECT_ID'])
														->where('PROJECT_ID', $projectId)
														->where('NUMBER', 0)
														->fetchObject();
				$projectStage->addToTasks($task);
			}

			if(isset($maxPrice))
			{
				$task->setMaxPrice($maxPrice);
			}

			$task->save();

			LocalRedirect("/task/".$task->getId()."/");
		}
	}

	public function updateAction(
		int $taskId,
		string $title,
		string $description,
		string    $maxPrice,
		int $categoryId,
		string $useGPT = null,
		int    $projectId = null,
		string  $tagsString = '',

	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$clientId = $USER->GetID();

			if ($maxPrice && (!is_numeric($maxPrice) || (int)$maxPrice<0))
			{
				LocalRedirect("/task/".$clientId."/create/");
			}

			$task = TaskTable::query()
							 ->setSelect(['*'])
							 ->where('CLIENT_ID', $clientId)
							 ->where('ID', $taskId)
							 ->fetchObject();

			if ($task)
			{
				$task->setTitle($title)->setMaxPrice($maxPrice)->setDescription($description)->setCategoryId($categoryId);

				// if ($useGPT) //TODO fix to use the great YandexGPT
				// {
				// 	$tags = YandexGPT::getTagsByTaskDescription($title.'. '.$description);
				// }
				// else
				// {
				// 	$tags = TagTable::query()->setSelect(['*'])->whereIn('ID', $tagIds)->fetchCollection();
				// }

				$task->removeAllTags();
				if ($tagsString !== '')
				{
					$arrayOfTagsTitle = explode('#', $tagsString);
					array_shift($arrayOfTagsTitle);
					foreach ($arrayOfTagsTitle as $tag)
					{
						$tag = $str = str_replace(' ', '', $tag);
						$tagFromDb = TagTable::query()->setSelect(['*'])->where('TITLE', $tag)->fetchObject();
						if ($tagFromDb)
						{
							$task->addToTags($tagFromDb);
						}
						else
						{
							$newTag = new EO_Tag();
							$newTag->setTitle($tag)->setCreatedAt(new DateTime())->setUserId($clientId);

							$newTag->save();
							$task->addToTags($newTag);
						}
					}

				}

				if (isset($projectId))
				{
					$task->setProjectId($projectId);
				}

				$task->save();

				LocalRedirect("/task/".$task->getId()."/");
			}

			LocalRedirect("/access/denied/");
		}
	}

	public function deleteAction(int $taskId)
	{
		global $USER;
		$userId = (int)$USER->GetID();
		if (check_bitrix_sessid())
		{
			$task = TaskTable::query()
							 ->setSelect(['*', 'RESPONSES', 'TAGS'])
							 ->where('ID', $taskId)
							 ->fetchObject();

			if ($userId!==$task->getClientId())
			{
				LocalRedirect("/profile/" . $USER->getId() . "/tasks/");
			}

			$tags = $task->getTags();
			$responses=$task->getResponses();

			foreach ($tags as $tag)
			{
				$task->removeFromTags($tag);
			}
			foreach ($responses as $response)
			{
				$response->delete();
			}
			$responses->save();
			$task->save();

			TaskTable::delete($taskId);

			LocalRedirect("/profile/" . $USER->getId() . "/tasks/");
		}
	}

	public function finishTaskAction(int $taskId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$clientId = (int)$USER->getId();

			$task = TaskTable::query()
							 ->setSelect(['*'])
							 ->where('ID', $taskId)
							 ->where('CLIENT_ID', $clientId)
							 ->fetchObject();

			if ($task)
			{
				$task->setStatus(Configuration::getOption('task_status')['done']);
				$task->save();

				$notification = new EO_Notification();
				$notification->setMessage(Configuration::getOption('notification_message')['task_finished'])
							 ->setFromUserId($clientId)
							 ->setToUserId($task->getContractorId())
							 ->setTaskId($taskId)
							 ->setCreatedAt(new DateTime());
				$notification->save();
			}

			LocalRedirect("/task/$taskId/");
		}
	}
}