<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
	public static function tableName() {
		return 'user';
	}

	public static function findIdentity($id){
			return static::findOne($id);
		}

	public static function findIdentityByAccessToken($token, $type = null) {}

	public static function findByUsername($name){
		return static::findOne(['name' => $name]);
	}

	public function getId(){
			return $this->id;
	}

	public function getAuthKey(){
			return $this->auth_key;
	}

	public function validateAuthKey($authKey){
			return $this->auth_key === $authKey;
	}

	public function validatePassword($password){
		return \Yii::$app->security->validatePassword($password, $this->password);
	}

	public function generateAuthKey(){
		$this->auth_key = \Yii::$app->security->generateRandomString();
	}

	// Проверка емайла в базе
	public static function existsEmail($email){
		$count = static::find()->where(['email' => $email])->count();
		return $count == 0;
	}

	// Получаем данные о новом пользователе
	public function setUserReg($userReg) {
		$this->name = $userReg->name;
		$this->email = $userReg->email;
		$this->setPass($userReg->password);
	}

	// Функция для генерации хеша пароля
	public function setPass($pass){
		$this->password = \Yii::$app->security->generatePasswordHash($pass);
	}

	public function getDays(){
		return $this->hasMany(Days::class, ['user_id' => 'id']);
	}

}
