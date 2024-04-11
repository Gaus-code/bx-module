<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Class TaskTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * <li> DESCRIPTION text mandatory
 * <li> MAX_PRICE int optional
 * <li> PRIORITY int mandatory
 * <li> CLIENT_ID int mandatory
 * <li> CONTRACTOR_ID int optional
 * <li> STATUS_ID int mandatory
 * <li> PROJECT_ID int optional
 * <li> CREATED_AT datetime mandatory
 * <li> UPDATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class TaskTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_task';
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
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('TASK_ENTITY_TITLE_FIELD')
				]
			),
			new TextField(
				'DESCRIPTION',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_DESCRIPTION_FIELD')
				]
			),
			new IntegerField(
				'MAX_PRICE',
				[
					'title' => Loc::getMessage('TASK_ENTITY_MAX_PRICE_FIELD')
				]
			),
			new IntegerField(
				'PROJECT_PRIORITY',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_PRIORITY_FIELD'),
					'default_value' => 1,
				]
			),
			new IntegerField(
				'CLIENT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_CLIENT_ID_FIELD')
				]
			),
			new Reference(
				'CLIENT',
				UserTable::class,
				Join::on('this.CLIENT_ID', 'ref.ID')
			),
			new IntegerField(
				'CONTRACTOR_ID',
				[
					'title' => Loc::getMessage('TASK_ENTITY_CONTRACTOR_ID_FIELD')
				]
			),
			new Reference(
				'CONTRACTOR',
				UserTable::class,
				Join::on('this.CONTRACTOR_ID', 'ref.ID')
			),
			new IntegerField(
				'STATUS_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_STATUS_ID_FIELD'),
					'default_value' => 1
				]
			),
			new Reference(
				'STATUS',
				StatusTable::class,
				Join::on('this.STATUS_ID', 'ref.ID')
			),
			new IntegerField(
				'PROJECT_ID',
				[
					'title' => Loc::getMessage('TASK_ENTITY_PROJECT_ID_FIELD')
				]
			),
			new Reference(
				'PROJECT',
				ProjectTable::class,
				Join::on('this.PROJECT_ID', 'ref.ID')
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('TASK_ENTITY_UPDATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new ExpressionField(
				'SEARCH_PRIORITY',
				"IF (%s='Active', 1, 0)",
				['CLIENT.SUBSCRIPTION_STATUS']
			),
			new OneToMany(
				'RESPONSES',
				ResponseTable::class,
				'TASK'
			),
			new OneToMany(
				'FEEDBACKS',
				FeedbackTable::class,
				'TASK'
			),
			new OneToMany(
				'RESPONSES',
				ResponseTable::class,
				'TASK'
			),
			(new ManyToMany(
				'TAGS',
				TagTable::class)
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