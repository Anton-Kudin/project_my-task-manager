<?php

namespace app\controllers;

use app\models\Days;
use app\models\Task;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DaysController extends AppController{

	// СОЗДАЕМ НОВЫЙ ДЕНЬ
	public function actionNewDay(){
		$model = new Days();

		if($model->load(Yii::$app->request->post())){
			$model->user_id = Yii::$app->user->id;

			if($model->validate()){
				if($model->save()){
					$formatDay = Yii::$app->formatter->asDate($model['date']);

					Yii::$app->session->setFlash('success');
					Yii::$app->session->setFlash('msg', $formatDay .' успешно добавлен');
				}else{
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Не удалось добавить '. $formatDay);
				}
				return $this->redirect("/");
			}
		}
		return $this->render("new-day", ["model" => $model]);
	}


	// РЕДАКТИРУЕМ ДЕНЬ
	public function actionUpdate($id){
		$model = Days::findOne($id);

		if($model->load(Yii::$app->request->post())){
			if($model->validate()){
				$formatDay = Yii::$app->formatter->asDate($model['date']);

				if($model->save()){
					Yii::$app->session->setFlash('success');
					Yii::$app->session->setFlash('msg', $formatDay .' успешно обновлен');
				}else{
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Не удалось обновить '. $formatDay);
				}
				return $this->redirect("/");
			}
		}
		return $this->render("update", ["model" => $model]);
	}


	// УДАЛЯЕМ ДЕНЬ
	public function actionDelete($id){
		$model = Days::findOne($id);

		$formatDay = Yii::$app->formatter->asDate(strtotime($model['date']));

		if($model->delete() && Task::delTask($id)){
			Yii::$app->session->setFlash('success');
			Yii::$app->session->setFlash('msg', $formatDay .' успешно удален');
		}else{
			Yii::$app->session->setFlash('error');
			Yii::$app->session->setFlash('msg', 'Не удалось удалить '. $formatDay);
		}
		return $this->redirect(['/task/index']);
	}


	// ЗАПУСКАЕМ ВРЕМЯ
	public function actionStartTimer($id){
		$tasks = Task::findTasksOfDay($id);
		$days = Days::find()->where(['user_id' => Yii::$app->user->id])->all();

		$ourDay = '';

		foreach($days as $day){
			// Проверяем запущен ли другой день
			if($day['status_time']){
				Yii::$app->session->setFlash('error');
				Yii::$app->session->setFlash('msg', 'Время уже запущено в другом дне!');

				return $this->redirect(['/task/index']);
			}
			// Берем наш день, который хотим запустить
			if($day['id'] == $id){
				$ourDay = $day;
			}
		}

		// Находим активную задачу
		$oneTask = "";

		foreach($tasks as $task){
			if($task->status == true){
				$oneTask = $task;
				$flag = true;
			}
		}

		// Если задача найдена
		if($oneTask){

			// Устанавливаем текущую дату и сохраняем
			$ourDay->count_time = date('Y-m-d H:i:s');
			$ourDay->status_time = true;
			$oneTask->count_time = date('Y-m-d H:i:s');

			if($ourDay->save() && $oneTask->save()){
				Yii::$app->session->setFlash('success');
				Yii::$app->session->setFlash('msg', 'Время пошло!');
			} else{
				Yii::$app->session->setFlash('error');
				Yii::$app->session->setFlash('msg', 'Что-то пошло не так!');
			}

		}

		return $this->redirect(['/task/index']);
	}


	// ОСТАНАВЛИВАЕМ ВРЕМЯ
	public function actionStopTimer($id){
		$day = Days::findOne($id);
		$tasks = Task::findTasksOfDay($id);

		// Находим активную задачу и пишем в день и в задачу итогове время
		foreach($tasks as $task){
			if($task['status']){
				$howMuch = time() - strtotime($task['count_time']);
				$task['total_time'] = $task['total_time'] + $howMuch;

				$day['total_time'] = $day['total_time'] + $howMuch;
				$day['status_time'] = false;

				if($task->save()&& $day->save()){

					Yii::$app->session->setFlash('success');
					Yii::$app->session->setFlash('msg', 'Задача остановлена');
				} else{
					Yii::$app->session->setFlash('error');
					Yii::$app->session->setFlash('msg', 'Что-то пошло не так!');
				}
			}
		}
		return $this->redirect(['/task/index']);
	}


}