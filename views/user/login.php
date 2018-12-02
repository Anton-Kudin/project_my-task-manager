<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $model app\models\UserRecord */
?>

<div class="main pb-4 mb-4 border-bottom">
	<div class="row">
		<div class="col-12 d-flex justify-content-center">
			<h2 class="display-4 mb-4">Авторизация</h2>
		</div>
		<div class="col-12 col-lg-6 offset-lg-3">

			<?php

			$form = ActiveForm::begin([
				'id' => 'user-login',
				'options' => [],
			]) ?>

			<?= $form->field($login, 'name')->textInput()?>
			<?= $form->field($login, 'password')->textInput()?>
			<?= $form->field($login, 'rememberMe')->checkbox()?>

			<div class="form-group clearfix">
				<?= Html::submitButton('Войти', ['class' => 'btn btn-success d-block float-none float-lg-left']) ?>
				<span class="float-none float-lg-right" style="line-height: 34px">
					<span>Нет аккаунта? </span><a href="<?= Url::to('/user/registration') ?>" class="text-primary" >Регистрация</a>
				</span>
			</div>
			<?php ActiveForm::end() ?>

		</div>
	</div>
</div>