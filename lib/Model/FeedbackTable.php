<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class FeedbackTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> RATING int mandatory
 * <li> FROM_USER_ID int mandatory
 * <li> TO_USER_ID int mandatory
 * <li> TASK_ID int mandatory
 * <li> FEEDBACK text optional
 * <li> CREATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class FeedbackTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_feedback';
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
					'title' => Loc::getMessage('FEEDBACK_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'RATING',
				[
					'required' => true,
					'title' => Loc::getMessage('FEEDBACK_ENTITY_RATING_FIELD')
				]
			),
			new IntegerField(
				'FROM_USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('FEEDBACK_ENTITY_FROM_USER_ID_FIELD')
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
					'title' => Loc::getMessage('FEEDBACK_ENTITY_TO_USER_ID_FIELD')
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
					'required' => true,
					'title' => Loc::getMessage('FEEDBACK_ENTITY_TASK_ID_FIELD')
				]
			),
			new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.TASK_ID', 'ref.ID')
			),
			new TextField(
				'FEEDBACK',
				[
					'title' => Loc::getMessage('FEEDBACK_ENTITY_FEEDBACK_FIELD')
				]
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('FEEDBACK_ENTITY_CREATED_AT_FIELD')
				]
			),
		];
	}
}