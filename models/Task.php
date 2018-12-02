<?php
namespace app\models;

use yii\db\ActiveRecord;

class Task extends ActiveRecord{

	public static function tableName(){
		return "task";
	}

	public function rules() {
		return [
			[["title"], "required"],
			['descr', 'string']
		];
	}

	public function attributeLabels() {
		return [
			'title' => 'Заголовок',
			'descr' => 'Описание'
		];
	}

	public static function findTasksOfDay($id){
		return self::find()->where(["day_id"=>$id])->all();
	}

	public static function delTask($id){
		if(self::findTasksOfDay($id)){
			self::deleteAll(['day_id' => $id]);
		}
		return true;
	}

}