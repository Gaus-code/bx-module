<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Service\Configuration;

class Task extends Controller
{
	public function createAction(
		string $title,
		string $description,
		string $maxPrice,
		string $useGPT = null,
		int    $projectId = null,
		array  $tagIds = [],
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
			$task->setTitle($title)->setDescription($description)->setClientId($clientId);

			if ($useGPT)
			{
				$tags = YandexGPT::getTagsByTaskDescription($title.$description);
			}
			else
			{
				$tags = TagTable::query()->setSelect(['*'])->whereIn('ID', $tagIds)->fetchCollection();
			}
			foreach ($tags as $tag)
			{
				$task->addToTags($tag);
			}

			if (isset($projectId))
			{
				$task->setProjectId($projectId);
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
		string $useGPT = null,
		int    $projectId = null,
		array  $tagIds = [],

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

			$task = TaskTable::getById($taskId)->fetchObject();

			$task->setTitle($title)->setMaxPrice($maxPrice)->setDescription($description);

			if ($useGPT)
			{
				$tags = YandexGPT::getTagsByTaskDescription($title.'. '.$description);
			}
			else
			{
				$tags = TagTable::query()->setSelect(['*'])->whereIn('ID', $tagIds)->fetchCollection();
			}

			$task->removeAllTags();
			foreach ($tags as $tag)
			{
				$task->addToTags($tag);
			}

			if (isset($projectId))
			{
				$task->setProjectId($projectId);
			}

			$task->save();

			LocalRedirect("/task/".$task->getId()."/");
		}
	}

	public function deleteAction(int $taskId)
	{
		global $USER;
		if (check_bitrix_sessid())
		{
			$task = TaskTable::query()->setSelect(['*', 'RESPONSES', 'TAGS'])->fetchObject();
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
			}

			LocalRedirect("/task/$taskId/");
		}
	}
}