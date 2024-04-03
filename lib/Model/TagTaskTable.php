<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

/**
 * Class TagTaskTable
 *
 * Fields:
 * <ul>
 * <li> TASK_ID int mandatory
 * <li> TAG_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class TagTaskTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_tag_task';
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
				'TASK_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('TAG_TASK_ENTITY_TASK_ID_FIELD')
				]
			),
			new IntegerField(
				'TAG_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('TAG_TASK_ENTITY_TAG_ID_FIELD')
				]
			),
			new Reference(
				'TASK',
				TaskTable::class,
				Join::on('this.TASK_ID', 'ref.ID')
			),
			new Reference(
				'TAG',
				TagTable::class,
				Join::on('this.TAG_ID', 'ref.ID')
			),
		];
	}
}