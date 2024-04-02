<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;

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
			new IntegerField(
				'CONTRACTOR_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_CONTRACTOR_ID_FIELD')
				]
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
					'title' => Loc::getMessage('RESPONSE_ENTITY_CREATED_AT_FIELD')
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('RESPONSE_ENTITY_UPDATED_AT_FIELD')
				]
			),
		];
	}
}