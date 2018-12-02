<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use app\models\UserLogin;
use app\models\UserRecord;
use app\models\UserReg;
use Yii;

class UserController extends AppController {

	public $layout = 'reg-layout';

	public function actionRegistration() {
		if(!Yii::$app->user->isGuest){
			return $this->redirect("/");
		}
		$userRecord = new User();
		$userReg = new UserReg();

		if ($userReg->load(Yii::$app->request->post())) {
			// проверяем на валидность
			if ($userReg->validate()) {
				// Передаем данные в активную запись
				$userRecord->setUserReg($userReg);
				// Сохраняем в базу нового юзера
				$userRecord->save();
				Yii::$app->session->setFlash('success');
				Yii::$app->session->setFlash('msg', 'Вы успешно зарегистрировались.');
				// Редиректим на какую страницу авторизации
				return $this->redirect("/user/login");
			}
		}

		return $this->render('registration', ['userReg' => $userReg]);
	}

	public function actionLogin()
	{
		if(!Yii::$app->user->isGuest){
			return $this->redirect("/");
		}

		$login = new LoginForm();
		if ($login->load(Yii::$app->request->post()) && $login->login()) {
			return $this->goBack();
		}

		return $this->render('login', [
			'login' => $login,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}