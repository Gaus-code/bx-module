<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Service\Configuration;

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
			new Reference(
				'CLIENT',
				UserTable::class,
				Join::on('this.CLIENT_ID', 'ref.ID')
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('PROJECT_ENTITY_UPDATED_AT_FIELD'),
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
					'title' => Loc::getMessage('PROJECT_ENTITY_STATUS_FIELD'),
					'default_value' => Configuration::getOption('project_status')['active'],
				]
			),
			new OneToMany(
				'STAGES',
				ProjectStageTable::class,
				'PROJECT'
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
				if (in_array($value, Configuration::getOption('project_status')))
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