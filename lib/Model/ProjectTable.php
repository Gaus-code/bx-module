<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class ProjectTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * <li> DESCRIPTION text mandatory
 * <li> CLIENT_ID int mandatory
 * <li> CREATED_AT datetime mandatory
 * <li> UPDATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class ProjectTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_project';
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
					'title' => Loc::getMessage('PROJECT_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('PROJECT_ENTITY_TITLE_FIELD')
				]
			),
			new TextField(
				'DESCRIPTION',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new IntegerField(
				'CLIENT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_CLIENT_ID_FIELD')
				]
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_CREATED_AT_FIELD')
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_UPDATED_AT_FIELD')
				]
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