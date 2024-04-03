<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\TaskTable;

class Task extends Controller
{
	public function createAction(string $title, string $description = "", int $maxPrice = null, array $tags = [])
	{
		if (check_bitrix_sessid())
		{
			$task = new EO_Task();
			$task->setTitle($title)->setDescription($description)->setMaxPrice($maxPrice);
			$task->setClientId(1);
			$task->save();


			return $task;
		}
	}
}