<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\Date;

class Subscription extends Controller
{
	public function getTrialVersionAction()
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$userId = $USER->GetID();

		$user = \Up\Ukan\Model\UserTable::getById($userId)->fetchObject();

		if (!empty($user->get('SUBSCRIPTION_END_DATE')))
		{
			LocalRedirect("/subscription/");
		}

		$subscriptionEndDate = new Date;
		$subscriptionEndDate->add('7d');

		$user->set('SUBSCRIPTION_END_DATE', $subscriptionEndDate);
		$user->save();

		LocalRedirect("/profile/".$userId."/");
	}
}