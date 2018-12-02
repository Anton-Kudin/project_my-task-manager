<?php
/**
 * Created by PhpStorm.
 * User: nirvs
 * Date: 26.11.2018
 * Time: 13:33
 */

namespace app\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppController extends Controller{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['login', 'registration'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
}