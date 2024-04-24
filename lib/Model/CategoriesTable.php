<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\ORM\Fields\Relations\OneToMany;

Loc::loadMessages(__FILE__);

/**
 * Class CategoriesTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class CategoriesTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_categories';
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
					'title' => Loc::getMessage('CATEGORIES_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('CATEGORIES_ENTITY_TITLE_FIELD')
				]
			),
			new OneToMany(
				'TASKS',
				TaskTable::class,
				'CATEGORY'
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
