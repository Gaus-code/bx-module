<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\Date;
use Up\Ukan\Model\EO_SecretOptionSite;
use Up\Ukan\Model\SecretOptionSiteTable;
use Up\Ukan\Service\Configuration;

class Setting extends Controller
{
	public function newOptionsYandexGPTAction(
		string $secretKey,
		string $directoryId,
	)
	{
		global $USER;

		if (!check_bitrix_sessid() || !$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$options = SecretOptionSiteTable::query()->setSelect(['ID', 'NAME', 'VALUE'])
												 ->whereIn('NAME', ['secret_key', 'directory_id'])
												 ->fetchCollection();
		if (count($options)!==2)
		{
			$secretKeyEO = new EO_SecretOptionSite();
			$secretKeyEO->setName('secret_key')->setValue($secretKey);
			$secretKeyEO->save();

			$directoryIdEO = new EO_SecretOptionSite();
			$directoryIdEO->setName('directory_id')->setValue($directoryId);
			$directoryIdEO->save();

			LocalRedirect("/admin/settings/");
		}
		foreach ($options as $option)
		{
			if ($option->getName()==='secret_key')
			{
				$option->setValue($secretKey);
			}
			elseif ($option->getName()==='directory_id')
			{
				$option->setValue($directoryId);
			}
			$option->save();
		}
		LocalRedirect("/admin/settings/");
	}
}