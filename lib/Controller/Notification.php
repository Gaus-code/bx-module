<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Up\Ukan\Model\NotificationTable;

class Notification extends Engine\Controller
{

	public function deleteAction(int $notificationId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$userId = $USER->GetID();

		$query = NotificationTable::query()
								  ->setSelect(['ID'])
								  ->where('ID', $notificationId)
								  ->where('TO_USER_ID', $userId)
								  ->fetchObject();
		if ($query)
		{
			NotificationTable::delete($notificationId);
		}

		LocalRedirect("/profile/$userId/notifications/");
	}

}