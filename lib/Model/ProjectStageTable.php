<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class ProjectStageTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> PROJECT_ID int mandatory
 * <li> STATUS string(255) mandatory
 * <li> NUMBER int mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class ProjectStageTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_project_stage';
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
					'title' => Loc::getMessage('PROJECT_STAGE_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'PROJECT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_STAGE_ENTITY_PROJECT_ID_FIELD')
				]
			),
			new Reference(
				'PROJECT',
				ProjectTable::class,
				Join::on('this.PROJECT_ID', 'ref.ID')
			),
			new StringField(
				'STATUS',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateStatus'],
					'title' => Loc::getMessage('PROJECT_STAGE_ENTITY_STATUS_FIELD')
				]
			),
			new IntegerField(
				'NUMBER',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_STAGE_ENTITY_NUMBER_FIELD')
				]
			),
			new OneToMany(
				'TASKS',
				TaskTable::class,
				'PROJECT_STAGE'
			),
			new DateField(
				'EXPECTED_COMPLETION_DATE',
				[
					'title' => Loc::getMessage('TASK_ENTITY_DEADLINE_FIELD')
				]
			),
			// new ExpressionField(
			// 	'EXPECTED_COMPLETION_DATE',
			// 	"MAX(%s)",
			// 	['TASKS.DEADLINE']
			// ),
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
		];
	}
}