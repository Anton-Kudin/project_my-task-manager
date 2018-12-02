<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;

?>

<div class="main pb-4 mb-4 border-bottom">
	<div class="row">
		<div class="col-12 d-flex">
			<h2 class="display-4 mb-4">Редактировать день</h2>
		</div>
		<div class="col-12">
			<?php

			$form = ActiveForm::begin([
				'id' => 'update',
				'options' => [],
			]) ?>
			<?= $form->field($model, 'date')->widget(DatePicker::class, [
				'language' => 'ru',
				'dateFormat' => 'yyyy-MM-dd',
			])->textInput(['placeholder' => "Выберите дату", "autocomplete" =>"off"])?>

			<div class="form-group">
				<div class="col-xs-12">
					<?= Html::submitButton('Редактировать день', ['class' => 'btn btn-primary']) ?>
				</div>
			</div>
			<?php ActiveForm::end() ?>
		</div>
	</div>
</div>
