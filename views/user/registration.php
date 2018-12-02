<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $model app\models\UserReg */
?>

<div class="main pb-4 mb-4 border-bottom">
	<div class="row">
		<div class="col-12 d-flex justify-content-center">
			<h2 class="display-4 mb-4">Регистрация</h2>
		</div>
		<div class="col-12 col-lg-6 offset-lg-3">
			<?php

			$form = ActiveForm::begin([
				'id' => 'user-join',
				'options' => [],
			]) ?>

			<?= $form->field($userReg, 'name')->textInput()?>
			<?= $form->field($userReg, 'email')->textInput()?>
			<?= $form->field($userReg, 'password')->textInput()?>

			<div class="form-group clearfix">
				<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success d-block float-none float-lg-left']) ?>
				<span class="float-none float-lg-right" style="line-height: 34px">
					<span>Уже есть аккунт? </span><a href="<?= Url::to('/user/login') ?>" class="text-primary" >Авторизация</a>
				</span>
			</div>
			<?php ActiveForm::end() ?>

		</div>
	</div>
</div>