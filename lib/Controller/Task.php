<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;

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
			$task = TaskTable::getById($taskId)->fetchObject();
			$task->removeAllTags();
			// $task->removeAllResponses();
			$task->save();

			TaskTable::delete($taskId);

			LocalRedirect("/profile/" . $USER->getId() . "/tasks/");
		}
	}
}