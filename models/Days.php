<?php
namespace app\models;

use yii\db\ActiveRecord;

class Days extends ActiveRecord{

	public static function tableName(){
		return "days";
	}

	public function rules() {
		return [
			[["date"], "required"],
			//["date", "repeatDate"],
		];
	}

	public function repeatDate(){
		$allDay = Days::find()->all();
		foreach($allDay as $day){
			if($day['date'] === $this->date){
				return $this->addError('date', "Такой день уже существует");
			}
		}
	}

	public function attributeLabels() {
		return [
			'date' => 'Дата',
		];
	}

	public function getTask(){
		return $this->hasMany(Task::class, ['day_id' => 'id']);
	}

	// Получить корректное итогое время
	public static function getTotalTime($timeInSecond){
		if($timeInSecond){
			$hour = self::formatNumberOfTime(floor($timeInSecond / 60 / 60));
			$minute = self::formatNumberOfTime(floor(($timeInSecond - ($hour * 60 * 60)) / 60));
			$second = self::formatNumberOfTime($timeInSecond - ($hour * 60 * 60) - ($minute * 60));;

			return $hour . ':' . $minute .':' . $second;
		}else{
			return '00' . ':' . '00' .':' . '00';
		}
	}

	public static function formatNumberOfTime($num){
		return ($num < 10) ? $num = 0 . $num: $num;
	}

	// Получаем прошедшее время с момента запуска если время запущено
	public static function getCurrentTime($days){
		$newCountDay = 0;
		$newCountTask = 0;

		foreach($days as $day){
			if($day['status_time'] == true){
				$newCountDay = (time() + $day['total_time'] - strtotime($day['count_time']));
				foreach($day->task as $task){
					if($task['status'] == true){
						$newCountTask = (time() + $task['total_time'] - strtotime($task['count_time']));
					}
				}
			}
		}

		return [
			'newCountDay' => $newCountDay,
			'newCountTask' => $newCountTask
		];
	}
}