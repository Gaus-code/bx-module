<?php
namespace Up\Ukan\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\TextField,
	Bitrix\Main\ORM\Fields\DateField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Class UserTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> EMAIL string(255) mandatory
 * <li> HASH string(255) mandatory
 * <li> NAME string(255) mandatory
 * <li> SURNAME string(255) mandatory
 * <li> ROLE string(255) mandatory
 * <li> BIO text optional
 * <li> CREATED_AT datetime mandatory
 * <li> UPDATED_AT datetime mandatory
 * </ul>
 *
 * @package Bitrix\Ukan
 **/

class UserTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'up_ukan_user';
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
					'title' => Loc::getMessage('USER_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'EMAIL',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateEmail'],
					'title' => Loc::getMessage('USER_ENTITY_EMAIL_FIELD')
				]
			),
			new StringField(
				'HASH',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateHash'],
					'title' => Loc::getMessage('USER_ENTITY_HASH_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('USER_ENTITY_NAME_FIELD')
				]
			),
			new StringField(
				'SURNAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateSurname'],
					'title' => Loc::getMessage('USER_ENTITY_SURNAME_FIELD')
				]
			),
			new DateField(
				'SUBSCRIPTION_END_DATE',
				[
					'title' => Loc::getMessage('USER_ENTITY_SUBSCRIPTION_END_DATE_FIELD')
				]
			),
			// new ExpressionField(
			// 	'SUBSCRIPTION_END_DATE',
			// 	"MAX(%s)",
			// 	['HISTORY_SUBSCRIPTION.END_DATE']
			// ),
			new TextField(
				'BIO',
				[
					'title' => Loc::getMessage('USER_ENTITY_BIO_FIELD')
				]
			),
			new DatetimeField(
				'CREATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_ENTITY_CREATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new DatetimeField(
				'UPDATED_AT',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_ENTITY_UPDATED_AT_FIELD'),
					'default_value' => function () {
						return new DateTime();
					}
				]
			),
			new StringField(
				'ROLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateRole'],
					'title' => Loc::getMessage('USER_ENTITY_ROLE_FIELD')
				]
			),
			new ExpressionField(
				'SUBSCRIPTION_STATUS',
				"IF (NOW()<=%s, 'Active', 'Not active')",
				['SUBSCRIPTION_END_DATE']
			),
			new OneToMany(
				'PROJECTS',
				ProjectTable::class,
				'CLIENT'
			),
			new OneToMany(
				'HISTORY_SUBSCRIPTION',
				UserSubscriptionTable::class,
				'USER'
			),
			new OneToMany(
				'FEEDBACKS_FROM',
				FeedbackTable::class,
				'FROM_USER'
			),
			new OneToMany(
				'FEEDBACKS_TO',
				FeedbackTable::class,
				'TO_USER'
			),
			new OneToMany(
				'TASKS_CLIENT',
				TaskTable::class,
				'CLIENT'
			),
			new OneToMany(
				'TASKS_CONTRACTOR',
				TaskTable::class,
				'CONTRACTOR'
			),
			new OneToMany(
				'RESPONSES',
				ResponseTable::class,
				'CONTRACTOR'
			),
			new StringField(
				'LOGIN',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateLogin'],
					'title' => Loc::getMessage('USER_ENTITY_LOGIN_FIELD')
				]
			),
		];
	}
	/**
	 * Returns validators for EMAIL field.
	 *
	 * @return array
	 */
	public static function validateEmail()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for HASH field.
	 *
	 * @return array
	 */
	public static function validateHash()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for SURNAME field.
	 *
	 * @return array
	 */
	public static function validateSurname()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for ROLE field.
	 *
	 * @return array
	 */
	public static function validateRole()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for LOGIN field.
	 *
	 * @return array
	 */
	public static function validateLogin()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}