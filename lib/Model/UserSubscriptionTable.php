<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DateField,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class UserSubscriptionTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> USER_ID int mandatory
 * <li> SUBSCRIPTION_ID int mandatory
 * <li> PAYMENT_AT datetime mandatory
 * <li> PRICE int mandatory
 * <li> START_DATE date mandatory
 * <li> END_DATE date mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class UserSubscriptionTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_user_subscription';
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
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_USER_ID_FIELD')
				]
			),
			new Reference(
				'USER',
				UserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new Reference(
				'SUBSCRIPTION',
				SubscriptionTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new DatetimeField(
				'PAYMENT_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_PAYMENT_AT_FIELD')
				]
			),
			new IntegerField(
				'PRICE',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_PRICE_FIELD')
				]
			),
			new DateField(
				'START_DATE',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_START_DATE_FIELD')
				]
			),
			new DateField(
				'END_DATE',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_SUBSCRIPTION_ENTITY_END_DATE_FIELD')
				]
			),
		];
	}
}