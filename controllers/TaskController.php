<?php

namespace app\controllers;

use app\models\Days;
use app\models\Task;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class TaskController extends AppController{

	// ГЛАВНАЯ СТРАНИЦА
	public function actionIndex(){
		$days = Days::find()->with('task')->where(['user_id' => Yii::$app->user->id])->orderBy(['date' => SORT_DESC])->all();

		// Получаем прошедшее время с момента запуска если время запущено
		$newCurrentTime = Days::getCurrentTime($days);

		return $this->render("index", ['days' => $days, 'newCurrentTime' => $newCurrentTime]);
	}


	// НОВАЯ ЗАДАЧА
	public function actionNewTask($id){
		$model = new Task();

		$model->day_id = $id;

		if($model->load(Yii::$app->request->post())){
			if($model->validate()){
				if($model->save()){
					Yii::$app->session->setFlash('success');
					Yii::$app->session->setFlash('msg', ' Задача успешно добавлена');
				}else{
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Не удалось добавить задачу');
				}
				return $this->redirect("/");
			}
		}
		return $this->render("new-task", ["model" => $model]);
	}


	// РЕДАКТИРУЕМ ЗАДАЧУ
	public function actionUpdate($id){
		$model = Task::findOne($id);

		if($model->load(Yii::$app->request->post())){
			if($model->validate()){
				if($model->save()){
					Yii::$app->session->setFlash('success');
					Yii::$app->session->setFlash('msg', ' Задача успешно обновлена');
				}else{
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Не удалось обновить задачу');
				}
				return $this->redirect("/");
			}
		}
		return $this->render("update", ["model" => $model]);
	}


	// УДАЛЕНИЕ ЗАДАЧИ
	public function actionDelete($id){
		$model = Task::findOne($id);

		if($model->delete()){
			Yii::$app->session->setFlash('success');
			Yii::$app->session->setFlash('msg', 'Задача успешно удалена');
		}else{
			Yii::$app->session->setFlash('error');
			Yii::$app->session->setFlash('msg', 'Не удалось удалить задачу');
		}
		return $this->redirect(['/task/index']);
	}


	// ВЫБОР ИЛИ СНЯТИЕ ВЫБОРА У ЗАДАЧИ
	public function actionSelect($id){
		$days = Days::find()->where(['user_id' => Yii::$app->user->id])->with('task')->all();
		$oneTask = '';
		$ourDay = '';
		// Проверка, выбрана ли другая задача среди всех дней
		foreach($days as $day){
			foreach($day->task as $task){
				if($task->id != $id && $task->status == true){
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Уже выбрана другая задача.');
					return $this->redirect(['/task/index']);
				}
				// Выбираем наш день, к которому принадлежит задача и задачу
				if($task['id'] == $id && $task['day_id'] == $day['id']){
					$ourDay = $day;
					$oneTask = $task;
				}
			}
		}
		// Если мы хотим деактивировать задачу, то сначала надо остановить время
		if($ourDay->status_time) {
			Yii::$app->session->setFlash('error');
			Yii::$app->session->setFlash('msg', 'Сначала остановите время!');

			return $this->redirect(['/task/index']);
		}
		// Устанавливаем статус активировать или деактивировать и сохраняем
		$oneTask->status ? $oneTask->status = false : $oneTask->status = true;
		$oneTask->save();

		return $this->redirect(['/task/index']);
	}


	// ЗАВЕРШЕНИЕ ИЛИ АКТИВИРОВАНИЕ ЗАДАЧИ
	public function actionComplete($id){
		$task = Task::findOne($id);
		$day = Days::findOne(['id' => $task->day_id]);

		// Проверка что время запущено и значит завершать нельзя
		if($day->status_time){
			Yii::$app->session->setFlash('error');
			Yii::$app->session->setFlash('msg', 'Сначала остановите время!');

			return $this->redirect(['/task/index']);
		}

		$task->status ? $task->status = false : $task->status = false;
		$task->complete ? $task->complete = false : $task->complete = true;
		$task->save();

		return $this->redirect(['/task/index']);
	}
}