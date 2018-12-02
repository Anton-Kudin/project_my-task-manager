<?php

use app\assets\MainAsset;
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerMetaTag(['name' => 'keywords', 'content' => "Task Manager, Таск Менеджер"]);
$this->registerMetaTag(['name' => 'description', 'content' => "Task Manager для удобной постановки задач и учета времени"]);
$this->title = 'Task Manager v1.0';
MainAsset::register($this);
?>
<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="UTF-8">
		<?= Html::csrfMetaTags() ?>
		<title>MyTaskManager - Tasks</title>
		<?php $this->head() ?>
	</head>
	<body>
	<?php $this->beginBody() ?>
	<div class="container">
		<div class="header pt-3 mb-2">
			<div class="row align-items-center pb-3 mb-3 border-bottom">
				<div class="col-6 logo header__logo">
					<p class="h4">MyTaskManager v1.0</p>
				</div>
			</div>
		</div>

		<?= $content ?>

		<div class="footer pb-3">
			<div class="row d-flex align-items-start">
				<div class="col-6">
					<ul>
						<li>Copyright @2018</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Flash сообщение -->
	<?php if(Yii::$app->session->hasFlash('msg')): ?>
		<div class="alert modal-flash <?= (Yii::$app->session->hasFlash('error'))?"alert-danger":"alert-success"?> text-center" role="alert">
			<?= Yii::$app->session->getFlash('msg') ?>
		</div>
	<?php endif; ?>
	<?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>