<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

Loc::loadMessages(__FILE__);

/**
 * Class SubscriptionTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * <li> DESCRIPTION text mandatory
 * <li> PRICE int mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class SubscriptionTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_subscription';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_TITLE_FIELD')
				]
			),
			new TextField(
				'DESCRIPTION',
				[
					'required' => true,
					'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new IntegerField(
				'PRICE',
				[
					'required' => true,
					'title' => Loc::getMessage('SUBSCRIPTION_ENTITY_PRICE_FIELD')
				]
			),
			new OneToMany(
				'HISTORY_SUBSCRIPTION',
				UserSubscriptionTable::class,
				'SUBSCRIPTION'
			),
		];
	}

	/**
	 * Returns validators for TITLE field.
	 *
	 * @return array
	 */
	public static function validateTitle()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}
