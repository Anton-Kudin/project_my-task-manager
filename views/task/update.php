<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $model app\models\Task */
?>

<div class="main pb-4 mb-4 border-bottom">
	<div class="row">
		<div class="col-12 d-flex">
			<h2 class="display-4 mb-4">Редактирование задачи</h2>
		</div>
		<div class="col-12">
			<?php

			$form = ActiveForm::begin([
				'id' => 'update',
				'options' => [],
			]) ?>
			<?= $form->field($model, 'title')->textInput()?>
			<?= $form->field($model, 'descr')->widget(CKEditor::class,[
				'editorOptions' => [
					'preset' => 'basic',
					'removePlugins' => 'image,about',
					'resize_enabled' => true,
					'height' => 300,
				],
			]);

			?>
			<div class="form-group">
				<div class="col-xs-12">
					<?= Html::submitButton('Отредактировать задачу', ['class' => 'btn btn-primary']) ?>
				</div>
			</div>
			<?php ActiveForm::end() ?>
		</div>
	</div>
</div>
