<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Up\Ukan\Model\EO_Response;
use Up\Ukan\Model\ResponseTable;

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
}