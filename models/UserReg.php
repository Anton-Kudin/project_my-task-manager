<?php
/**
 * Created by PhpStorm.
 * User: nirvs
 * Date: 21.11.2018
 * Time: 18:15
 */

namespace app\models;


use yii\base\Model;

class UserReg extends Model {

	public $name;
	public $email;
	public $password;

	public function rules() {
		return [
			[['name', 'email', 'password'], 'required'],
			['email', 'email'],
			["email", "errorIfEmailUsed"]
		];
	}

	// Наш метод пользовательской проверки на емаил
	public function errorIfEmailUsed(){
		// Проверяем на совпадение емайлов в базе
		if(User::existsEmail($this->email)) return;
		// Иначе добавляем ошибку
		$this->addError('email', "Такой е-маил уже зарегистрирован");
	}

	// Передаем данные активной модели
	public function setUserRecord($userRecord){
		$this->name = $userRecord->name;
		$this->email = $userRecord->email;
		$this->password = $userRecord->password;
	}

	public function attributeLabels() {
		return [
			'name' => 'Имя',
			'email' => 'Email',
			'password' => 'Пароль',
		];
	}

}