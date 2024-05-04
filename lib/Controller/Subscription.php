<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\EO_UserSubscription;
use Up\Ukan\Service\Configuration;

class Subscription extends Controller
{
	public function getTrialVersionAction()
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$userId = (int)$USER->GetID();

		$user = \Up\Ukan\Model\UserTable::getById($userId)->fetchObject();

		if (!empty($user->get('SUBSCRIPTION_END_DATE')))
		{
			$errors = ['Вы не можете получить пробную подписку тк вы уже пользовались подпиской'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/subscription/");
		}

		$nowDateTime = new DateTime;
		$nowDate = new Date;
		$subscriptionEndDate = new Date;
		$trialSubscriptionPeriod = Configuration::getOption('subscription')['trial_subscription_period_in_days'].'d';
		$subscriptionEndDate->add($trialSubscriptionPeriod);

		$userSubscription = new EO_UserSubscription();
		$userSubscription->setUserId($userId)
						 ->setPrice(0)
						 ->setEndDate($subscriptionEndDate)
						 ->setPaymentAt($nowDateTime)
						 ->setStartDate($nowDate);

		$userSubscription->save();
		$user->setSubscriptionEndDate($subscriptionEndDate);
		$user->save();

		LocalRedirect("/profile/".$userId."/");
	}
}