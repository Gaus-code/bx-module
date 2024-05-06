<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\AI\AI;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Notification;
use Up\Ukan\Model\EO_Tag;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\ProjectStageTable;
use Up\Ukan\Model\ProjectTable;
use Up\Ukan\Model\ResponseTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;
use Up\Ukan\Service\Configuration;

class Task extends Controller
{
	public function createAction(
		string $title = null,
		string $description = null,
		string $maxPrice = null,
		string $tagsString = null,
		string $useGPT = null,
		string $deadline = null,
		int    $categoryId = null,
		int    $projectId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$clientId = $USER->GetID();

		$errors = $this->validateData(
			$title,
			$description,
			$maxPrice,
			$tagsString,
			$useGPT,
			$deadline,
			$categoryId,
			$projectId,
			$clientId,
		);

		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $clientId . "/create/");
		}

		if (!(AI::censorshipCheck($title." ".$description." ".$tagsString)))
		{
			$errors[]='Заявка не прошла цензуру';
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $clientId . "/create/");
		}

		$task = $this->createTask(
			$clientId,
			$projectId,
			$title,
			$description,
			$categoryId,
			$tagsString,
			$useGPT,
			$maxPrice,
			$deadline
		);
		$task->save();

		LocalRedirect("/task/" . $task->getId() . "/");

	}

	public function updateAction(
		int    $taskId,
		string $title = null,
		string $description = null,
		string $maxPrice = null,
		string $tagsString = null,
		string $useGPT = null,
		string $deadline = null,
		int    $categoryId = null,
		int    $projectId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$clientId = $USER->GetID();

		$errors = $this->validateData(
			$title,
			$description,
			$maxPrice,
			$tagsString,
			$useGPT,
			$deadline,
			$categoryId,
			$projectId,
			$clientId,
		);

		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $taskId . "/edit/");
		}

		if ($projectId)
		{
			$project = ProjectTable::query()
								   ->setSelect(['ID'])
								   ->where('ID', $projectId)
								   ->where('CLIENT_ID', $clientId)
								   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}
		}

		$task = TaskTable::query()
						 ->setSelect(['*', 'PROJECT.ID'])
						 ->where('CLIENT_ID', $clientId)
						 ->where('ID', $taskId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		if (!(AI::censorshipCheck($title." ".$description." ".$tagsString)))
		{
			$errors[]='Заявка не прошла цензуру';
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $clientId . "/create/");
		}

		$task->setTitle($title)
			 ->setMaxPrice($maxPrice)
			 ->setDescription($description)
			 ->setCategoryId($categoryId)
			 ->setDeadline(DateTime::createFromPhp(new \DateTime($deadline)))
			 ->setUpdatedAt(new DateTime());


		$task->removeAllTags();

		if ($useGPT)
		{
			$tagsFromGPT = AI::getTagsByTaskDescription($title.$description);
			foreach ($tagsFromGPT as $tag)
			{
				$task->addToTags($tag);
			}
		}

		if ($tagsString !== '')
		{
			$tagsString = str_replace(' ', '', $tagsString);
			$arrayOfTagsTitle = explode('#', $tagsString);
			array_shift($arrayOfTagsTitle);
			foreach ($arrayOfTagsTitle as $tag)
			{
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

		if (isset($projectId) && (!$task->getProject() || $projectId!==$task->getProject()->getId()))
		{
			$task->setStatus(Configuration::getOption('task_status')['waiting_to_start']);
			$projectStage = ProjectStageTable::query()
											 ->setSelect(['ID', 'NUMBER', 'PROJECT_ID'])
											 ->where('PROJECT_ID', $projectId)
											 ->where('NUMBER', 0)
											 ->fetchObject();
			$projectStage->addToTasks($task);
		}

		$task->save();

		LocalRedirect("/task/" . $task->getId() . "/");

	}

	public function createAtProjectAction(
		string $title = null,
		string $description = null,
		string $maxPrice = null,
		string $tagsString = null,
		string $useGPT = null,
		string $deadline = null,
		int    $categoryId = null,
		int    $projectId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$clientId = $USER->GetID();

		$errors = $this->validateData(
			$title,
			$description,
			$maxPrice,
			$tagsString,
			$useGPT,
			$deadline,
			$categoryId,
			$projectId,
			$clientId,
		);

		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/$projectId/edit/");
		}
		if (!(AI::censorshipCheck($title." ".$description." ".$tagsString)))
		{
			$errors[]='Заявка не прошла цензуру';
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $clientId . "/create/");
		}

		$task = $this->createTask(
			$clientId,
			$projectId,
			$title,
			$description,
			$categoryId,
			$tagsString,
			$useGPT,
			$maxPrice,
			$deadline,
		);
		$task->setStatus(Configuration::getOption('task_status')['waiting_to_start']);
		$task->save();

		LocalRedirect("/project/$projectId/edit/");

	}

	public function deleteAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = (int)$USER->GetID();

		$task = TaskTable::query()
						 ->setSelect(['*', 'RESPONSES', 'TAGS'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		if ($task->getStatus()===Configuration::getOption('task_status')['active']
			|| $task->getStatus()===Configuration::getOption('task_status')['completed'])
		{
			$errors = ['Задачу нельзя удалить, поскольку она находится в процессе выполнения или уже успешно завершена'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/$taskId/edit/");
		}

		$tags = $task->getTags();
		$responses = $task->getResponses();

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

		if (!TaskTable::delete($taskId))
		{
			$errors = ['Что-то пошло не так, не удалось удалить задание'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/$taskId/edit/");
		}

		LocalRedirect("/profile/" . $USER->getId() . "/tasks/");

	}

	public function stopSearchContractorAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = (int)$USER->GetID();

		$task = TaskTable::query()
						 ->setSelect(['*', 'RESPONSES', 'TAGS'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		if ($task->getStatus()!==Configuration::getOption('task_status')['search_contractor'])
		{
			$errors = ['По данной заявке нельзя прекратить поиск исполнителя'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/$taskId/edit/");
		}

		$task->setStatus(Configuration::getOption('task_status')['waiting_to_start']);
		$task->save();
		LocalRedirect("/task/$taskId/");

	}
	public function startSearchContractorAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = (int)$USER->GetID();

		$task = TaskTable::query()
						 ->setSelect(['*', 'RESPONSES', 'TAGS'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		if ($task->getStatus()!==Configuration::getOption('task_status')['waiting_to_start'])
		{
			$errors = ['По данной заявке нельзя начать поиск исполнителя'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/$taskId/edit/");
		}

		$task->setStatus(Configuration::getOption('task_status')['search_contractor']);
		$task->save();

		LocalRedirect("/task/$taskId/");

	}
	public function finishTaskAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$clientId = (int)$USER->getId();

		$task = TaskTable::query()
						 ->setSelect(['*'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $clientId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$task->setStatus(Configuration::getOption('task_status')['done']);
		$task->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['task_finished'])
					 ->setFromUserId($clientId)
					 ->setToUserId($task->getContractorId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		LocalRedirect("/task/$taskId/");

	}

	public function unassignContractorAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$clientId = (int)$USER->getId();

		$task = TaskTable::query()
						 ->setSelect(['*'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $clientId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['drop_contractor'])
					 ->setFromUserId($clientId)
					 ->setToUserId($task->getContractorId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$rejectedResponses = ResponseTable::query()
										  ->setSelect(['*'])
										  ->where('TASK_ID', $taskId)
										  ->where('STATUS', Configuration::getOption('response_status')['reject'])
										  ->fetchCollection();

		foreach ($rejectedResponses as $response)
		{
			$response->setStatus(Configuration::getOption('response_status')['wait']);
			$response->save();

			$notification = new EO_Notification();
			$notification->setMessage(Configuration::getOption('notification_message')['reconsideration'])
						 ->setFromUserId($clientId)
						 ->setToUserId($response->getContractorId())
						 ->setTaskId($taskId)
						 ->setCreatedAt(new DateTime());
			$notification->save();
		}

		$task->setStatus(Configuration::getOption('task_status')['search_contractor']);
		$task->setContractorId(null);

		$task->save();


		LocalRedirect("/task/$taskId/");

	}

	public function withdrawAction(int $taskId)
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
						 ->where('CONTRACTOR_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['drop_client'])
					 ->setFromUserId($userId)
					 ->setToUserId($task->getClientId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		$rejectedResponses = ResponseTable::query()
										  ->setSelect(['*'])
										  ->where('TASK_ID', $taskId)
										  ->where('STATUS', Configuration::getOption('response_status')['reject'])
										  ->fetchCollection();

		foreach ($rejectedResponses as $response)
		{
			$response->setStatus(Configuration::getOption('response_status')['wait']);
			$response->save();

			$notification = new EO_Notification();
			$notification->setMessage(Configuration::getOption('notification_message')['reconsideration'])
						 ->setFromUserId($userId)
						 ->setToUserId($response->getContractorId())
						 ->setTaskId($taskId)
						 ->setCreatedAt(new DateTime());
			$notification->save();
		}

		$task->setStatus(Configuration::getOption('task_status')['search_contractor']);
		$task->setContractorId(null);

		$task->save();


		LocalRedirect("/task/$taskId/");

	}

	private function validateData(
		?string $title,
		?string $description,
		?string $maxPrice,
		?string $tagsString,
		?string $useGPT,
		?string $deadline,
		?int    $categoryId,
		?int    $projectId,
		int     $clientId,
	): ?array
	{
		$errors = [];

		$user = UserTable::getById($clientId)->fetchObject();
		if ($user && $user->getIsBanned())
		{
			$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			return $errors;
		}

		if (!$title)
		{
			$errors [] = 'Название не может быть пустым';
		}
		else
		{

			if (mb_strlen($title) < 3 || mb_strlen($title) > 255)
			{
				$errors[] = 'Название должно быть от 3 до 255 символов';
			}
		}

		if (!$description)
		{
			$errors [] = 'Описание не может быть пустым';
		}
		else
		{

			if (mb_strlen($description) < 3)
			{
				$errors[] = 'Описание должно быть от 3 символов';
			}
		}

		if ($maxPrice && (!is_numeric($maxPrice) || (int)$maxPrice < 0))
		{
			$errors [] = 'Неправильная стоимость';
		}

		if ($tagsString !== '' && !preg_match('/^[a-zA-Zа-яА-Я0-9_# ]+$/u', $tagsString))
		{
			$errors [] = 'Заполняя тэги, вы можете использовать только буквы, цифры, подчеркивание (_) и решетку (#)';
		}

		if ($useGPT)
		{
			$user = UserTable::query()->setSelect(['*'])->where('ID', $clientId)->where('SUBSCRIPTION_STATUS', 'Active')
							 ->fetchObject();
			if (!$user)
			{
				$errors [] = 'Чтобы использовать автоматическую генерацию, оформите <a href="/subscription/"> подписку </a>';
			}
		}

		if (!$deadline || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline))
		{
			$errors [] = 'Установите дедлайн';
		}
		else
		{
			$deadlineDateTime = new \DateTime($deadline);
			$now = new \DateTime('now');
			$maxDeadlineDateTime = clone $now;
			$maxDeadlineDateTime->add(new \DateInterval('P50Y'));

			if ($deadlineDateTime->format('U') <= $now->format('U') )
			{
				$errors [] = 'Дедлайн не может быть прошедшей датой';
			}

			if ($deadlineDateTime->format('U') > $maxDeadlineDateTime->format('U') )
			{
				$errors [] = 'Дедлайн не может быть больше 50 лет';
			}
		}

		if (!$categoryId)
		{
			$errors [] = 'Выберите категорию';
		}
		elseif (!is_numeric($categoryId) || (int)$categoryId < 0)
		{
			$errors [] = 'Похоже, что-то не так с категорией';
		}

		if ($projectId && (!is_numeric($projectId) || (int)$projectId < 0))
		{
			$errors [] = 'Похоже, что-то не так с проектом';
		}

		return $errors;
	}

	/**
	 * @param int|null $projectId
	 * @param mixed $clientId
	 * @param string|null $title
	 * @param string|null $description
	 * @param int|null $categoryId
	 * @param string|null $tagsString
	 * @param string|null $maxPrice
	 *
	 * @return EO_Task
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 * @throws \Bitrix\Main\SystemException
	 */
	private function createTask(
		mixed   $clientId,
		?int    $projectId,
		?string $title,
		?string $description,
		?int    $categoryId,
		?string $tagsString,
		?string $useGPT,
		?string $maxPrice,
		?string $deadline,
	): EO_Task
	{
		if ($projectId)
		{
			$project = ProjectTable::query()->setSelect(['ID'])->where('ID', $projectId)->where('CLIENT_ID', $clientId)
								   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}
		}

		$task = new EO_Task();
		$task->setTitle($title)
			 ->setDescription($description)
			 ->setClientId($clientId)
			 ->setCategoryId($categoryId)
			 ->setDeadline(DateTime::createFromPhp(new \DateTime($deadline)));

		if ($useGPT)
		{
			$tagsFromGPT = AI::getTagsByTaskDescription($title.$description);
			foreach ($tagsFromGPT as $tag)
			{
				$task->addToTags($tag);
			}
		}

		if ($tagsString !== '')
		{
			$tagsString = str_replace(' ', '', $tagsString);
			$arrayOfTagsTitle = explode('#', $tagsString);
			array_shift($arrayOfTagsTitle);
			foreach ($arrayOfTagsTitle as $tag)
			{
				$tagFromDb = TagTable::query()->setSelect(['*'])->where('TITLE', $tag)->fetchObject();
				if ($tagFromDb)
				{
					if (!$tagFromDb->getIsBanned())
					{
						$task->addToTags($tagFromDb);
					}
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
			$projectStage = ProjectStageTable::query()->setSelect(['ID', 'NUMBER', 'PROJECT_ID'])->where(
				'PROJECT_ID',
				$projectId
			)->where('NUMBER', 0)->fetchObject();
			$projectStage->addToTasks($task);
		}

		if (isset($maxPrice))
		{
			$task->setMaxPrice($maxPrice);
		}

		return $task;
	}

	public function generateGptTagsAction()
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = (int)$USER->GetID();

		$user = \Up\Ukan\Model\UserTable::query()->setSelect(['ID', 'SUBSCRIPTION_STATUS'])
										->where('ID', $userId)
										->fetchObject();

		if ($user->getSubscriptionStatus()!=='Active')
		{
			$result['error'] = 'Чтобы Воспользоваться данной функцией, приобретите подписку!';
			return json_encode($result);
		}

		header("Content-type: application/json; charset=utf-8");

		$title = $_POST['title'];
		$description = $_POST['description'];
		$tagsFromGPT = AI::getTagsByTaskDescription($title.$description);

		$result = [];
		foreach ($tagsFromGPT as $tag)
		{
			$result[] = $tag->getTitle();
		}

		return json_encode($result);
	}
}