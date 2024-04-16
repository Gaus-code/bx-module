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

			foreach ($tagIds as $tagId)
			{
				$tag = TagTable::getById($tagId)->fetchObject();
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
		if (check_bitrix_sessid())
		{
			TaskTable::delete($taskId);

			LocalRedirect("/client/");
		}
	}
}