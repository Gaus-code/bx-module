<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Service\Configuration;

Loc::loadMessages(__FILE__);

/**
 * Class NotificationTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TYPE string(255) mandatory
 * <li> USER_ID int mandatory
 * <li> TASK_ID int mandatory
 * <li> CREATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class NotificationTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_notification';
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
					'title' => Loc::getMessage('TASK_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'MESSAGE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateMessage'],
					'title' => Loc::getMessage('NOTIFICATION_ENTITY_MESSAGE_FIELD')
				]
			),
			new IntegerField(
				'FROM_USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_ENTITY_FROM_USER_ID_FIELD')
				]
			),
			new Reference(
				'FROM_USER',
				UserTable::class,
				Join::on('this.FROM_USER_ID', 'ref.ID')
			),
			new IntegerField(
				'TO_USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_ENTITY_TO_USER_ID_FIELD')
				]
			),
			new Reference(
				'TO_USER',
				UserTable::class,
				Join::on('this.TO_USER_ID', 'ref.ID')
			),
			new IntegerField(
				'TASK_ID',
				[
					'title' => Loc::getMessage('NOTIFICATION_ENTITY_TASK_ID_FIELD')
				]
			),
			new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.TASK_ID', 'ref.ID')
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
		];
	}

	/**
	 * Returns validators for MESSAGE field.
	 *
	 * @return array
	 */
	public static function validateMessage()
	{
		return [
			new LengthValidator(null, 255),
			function ($value) {
				if (in_array($value, Configuration::getOption('notification_message')))
				{
					return true;
				}
				return 'Такого сообщения не существует';
			}
		];
	}
}