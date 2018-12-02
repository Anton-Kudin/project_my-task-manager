<?php

namespace app\models;

use Yii;
use yii\base\Model;


class LoginForm extends Model
{
	public $name;
	public $password;
	public $rememberMe = true;

	private $_user = false;

	public function rules()
	{
			return [
					[['name', 'password'], 'required'],
					['rememberMe', 'boolean'],
					['name', 'validateName'],
					['password', 'validatePassword'],
			];
	}
	// Сверка с БД логина
	public function validateName(){
		$this->_user = User::findByUsername($this->name);
		if($this->_user == null){
			$this->addError("name", "Такой логин не зарегистрирован");
		}
	}
	// Сверка с БД пароля
	public function validatePassword($attribute, $params){
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user->validatePassword($this->password)){
					$this->addError($attribute, 'Пароль введен неверно.');
			}
		}
	}

	public function login() {
		if ($this->validate()) {
			if($this->rememberMe){
				$u = $this->getUser();
				$u->generateAuthKey();
				$u->save();
			}
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
		}
		return false;
	}

	public function getUser(){
		if ($this->_user === false) {
				$this->_user = User::findByUsername($this->name);
		}
		return $this->_user;
	}

	public function attributeLabels(){
		return [
			'name' => 'Логин',
			'password' => 'Пароль',
			'rememberMe' => 'Запомнить меня',
		];
	}
}
