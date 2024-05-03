<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Class TagTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class TagTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_tag';
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
					'title' => Loc::getMessage('TAG_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('TAG_ENTITY_TITLE_FIELD')
				]
			),
			new IntegerField(
				'USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('TAG_ENTITY_USER_ID_FIELD')
				]
			),
			new Reference(
				'USER',
				UserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('TAG_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new BooleanField(
				'IS_BANNED', [
				'values' => ['N', 'Y'],
				'default_value' => 'N',
			]),
			(new ManyToMany(
				'TASKS',
				TaskTable::class)
			)->configureTableName('up_ukan_tag_task'),
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