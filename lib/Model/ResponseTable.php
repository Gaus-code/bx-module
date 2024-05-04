<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Service\Configuration;

Loc::loadMessages(__FILE__);

/**
 * Class ResponseTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TASK_ID int mandatory
 * <li> CONTRACTOR_ID int mandatory
 * <li> PRICE int mandatory
 * <li> DESCRIPTION text optional
 * <li> CREATED_AT datetime mandatory
 * <li> UPDATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class ResponseTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_response';
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
					'title' => Loc::getMessage('RESPONSE_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'TASK_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_TASK_ID_FIELD')
				]
			),
			new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.TASK_ID', 'ref.ID')
			),
			new IntegerField(
				'CONTRACTOR_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_CONTRACTOR_ID_FIELD')
				]
			),
			new Reference(
				'CONTRACTOR',
				UserTable::class,
				Join::on('this.CONTRACTOR_ID', 'ref.ID')
			),
			new IntegerField(
				'PRICE',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_PRICE_FIELD')
				]
			),
			new TextField(
				'DESCRIPTION',
				[
					'title' => Loc::getMessage('RESPONSE_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_UPDATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new StringField(
				'STATUS',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateStatus'],
					'title' => Loc::getMessage('RESPONSE_ENTITY_STATUS_FIELD')
				]
			),
			new ExpressionField(
				'SEARCH_PRIORITY',
				"IF (%s='Active', 1, 0)",
				['CONTRACTOR.SUBSCRIPTION_STATUS']
			),
		];
	}

	/**
	 * Returns validators for STATUS field.
	 *
	 * @return array
	 */
	public static function validateStatus()
	{
		return [
			new LengthValidator(null, 255),
			function ($value) {
				if (in_array($value, Configuration::getOption('response_status')))
				{
					return true;
				}
				return 'Такого статуса не существует';
			}
		];
	}
	public static function onBeforeUpdate(Event $event)
	{
		$result = new EventResult();

		$arFields = $event->getParameter("fields");
		$now = new DateTime;
		$arFields['UPDATED_AT'] = $now;

		$result->modifyFields($arFields);

		return $result;
	}
}