<?php
namespace Up\Ukan\Model;

use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class ReportsTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TYPE string(255) mandatory
 * <li> MESSAGE string(255) optional
 * <li> FROM_USER_ID int mandatory
 * <li> TO_USER_ID int mandatory
 * <li> TO_TASK_ID int optional
 * <li> TO_FEEDBACK_ID int optional
 * <li> TO_TAG_ID int optional
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class ReportsTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_reports';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			(new IntegerField('ID',
							  []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_ID_FIELD'))
			  ->configurePrimary(true)
			  ->configureAutocomplete(true),
			(new StringField('TYPE',
							 [
								 'validation' => [__CLASS__, 'validateType']
							 ]
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_TYPE_FIELD'))
			  ->configureRequired(true),
			(new TextField('MESSAGE',
							 []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_MESSAGE_FIELD')),
			(new IntegerField('FROM_USER_ID',
							  []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_FROM_USER_ID_FIELD'))
			  ->configureRequired(true),
			new Reference(
				'FROM_USER', UserTable::class, Join::on('this.FROM_USER_ID', 'ref.ID')
			),
			(new IntegerField('TO_USER_ID',
							  []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_TO_USER_ID_FIELD'))
			  ->configureRequired(true),
			new Reference(
				'TO_USER', UserTable::class, Join::on('this.TO_USER_ID', 'ref.ID')
			),
			(new IntegerField('TO_TASK_ID',
							  []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_TO_TASK_ID_FIELD')),
			new Reference(
				'TO_TASK', TaskTable::class, Join::on('this.TO_TASK_ID', 'ref.ID')
			),
			(new IntegerField('TO_FEEDBACK_ID',
							  []
			))->configureTitle(Loc::getMessage('REPORTS_ENTITY_TO_FEEDBACK_ID_FIELD')),
			new Reference(
				'TO_FEEDBACK', FeedbackTable::class, Join::on('this.TO_FEEDBACK_ID', 'ref.ID')
			),
		];
	}

	/**
	 * Returns validators for TYPE field.
	 *
	 * @return array
	 */
	public static function validateType()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

}