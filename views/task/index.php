<?php

use app\models\Days;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;

?>
<div class="main pb-4 mb-4 border-bottom">
	<div class="row">
		<div class="col-12 d-flex flex-column flex-sm-row align-items-center ">
			<h2 class="display-4 mb-4">Список задач</h2>
			<?= Html::a('Новый день', Url::to(['days/new-day']), ['class' => 'btn-new-day btn btn-warning text-white ml-sm-auto mb-4 mb-sm-0']) ?>
		</div>

		<!-- Если нет созданных дней -->
		<?php if(!$days): ?>
			<div class="col-12 pt-4">
				<div class="alert alert-info text-center p-4" role="alert">
					У вас ещё нет задач, начните с создания дня!
				</div>
			</div>
		<?php endif; ?>

		<!-- Выводим дни в цикле -->
		<?php foreach($days as $day): ?>
			<div class="col-12 day bg-white shadow rounded p-3 mb-5">
				<div class="day__title-and-control-day d-flex align-items-start border-bottom pb-2">
					<!-- Заголовок-->
					<p class="h4 day__title"><?= Yii::$app->formatter->asDate(strtotime($day['date'])); ?></p>
					<!-- Кнопки для дня-->
					<div class="day__buttons d-flex align-items-center ml-auto">
						<!-- Выводим кнопку старта или паузы для таймера-->
						<?php
							if(isset($day->task)){
								$flagBtn = false;
								foreach($day->task as $task){
									if(!$task['complete'] && $task['status']) $flagBtn = true;
								}
								if($flagBtn){
									print($day['status_time']) ?
										Html::a('', Url::to(['days/stop-timer', 'id'=>$day['id']]), ['class' => 'oi oi-media-pause ml-2 text-success', 'aria-hidden' => "true", 'title' => 'pause'])
										:
										Html::a('', Url::to(['days/start-timer', 'id'=>$day['id']]), ['class' => 'oi oi-caret-right ml-2 text-success', 'aria-hidden' => "true", 'title' => 'start']);
								}
							}
						?>
					<!--Время у карточки дня-->
						<div id="foo" class="day__time day__status-time ml-2 <?= ($day['status_time']) ? "day__status-time--active" : "" ?>"><?= Days::getTotalTime(($day['status_time']) ? $newCurrentTime['newCountDay'] : $day['total_time']) ?></div>
						<div class="d-none <?= ($day['status_time']) ? "day__total-time--active" : "" ?>"><?= $day['status_time'] ? $newCurrentTime['newCountDay'] : "" ?></div>
					<!--Управление днем-->
						<div class="day__control ml-4 dropdown">
							<span class="oi oi-menu day__control-btn text-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
								<?= Html::a('Новая задача', Url::to(['task/new-task', 'id'=>$day['id']]), ['class' => 'dropdown-item btn-new-task']) ?>
								<div class="dropdown-divider"></div>
								<?= Html::a('Изменить дату', Url::to(['days/update', 'id'=>$day['id']]), ['class' => 'dropdown-item']) ?>
								<?= Html::a('Удалить день', Url::to(['days/delete', 'id'=>$day['id']]), ['class' => 'dropdown-item']) ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Начало блока задач-->
				<!-- Если нет созданных задач -->
				<?php if(!$day->task): ?>
					<div class="alert alert-default text-center p-4" role="alert">
						Создайте задачу!
					</div>
				<!-- Иначе задачи есть-->
				<?php else: ?>
					<ol>
						<?php foreach($day->task as $task): ?>
							<li class="day__task task border-bottom p-2">
								<div class="d-flex  align-items-start flex-nowrap">
									<!-- Контент задач-->
									<div class="task__content d-flex flex-column flex-grow-1">
										<div class="d-flex align-items-center <?= ($task["descr"])?"task__content-title":"" ?> pb-1">
											<?= ($task["descr"])?"<span class=\"oi oi-arrow-bottom text-secondary mr-1\"></span>":"" ?>
											<div><?= $task["title"] ?></div>
										</div>
										<div class="task__content-descr">
											<div class="p-2 bg-light">
												<?= $task["descr"] ?>
											</div>
										</div>
									</div>
									<!-- Управление задачами-->
									<div class="task__buttons d-flex flex-column flex-sm-row align-items-center ml-auto">
										<!-- значок завершенной задачи-->
										<?php if($task['complete']): ?>
											<span class="oi oi-circle-check text-success ml-auto ml-sm-0 mr-1"></span>
										<?php endif; ?>
										<!-- значок выбранной задачи-->
										<?php if($task['status']):?>
											<span class="oi oi-timer text-info ml-auto ml-sm-0 mr-1"></span>
										<?php endif; ?>
										<!-- время у задачи-->
										<div class="task__time mb-1 mb-sm-0 ml-auto ml-sm-0 <?= ($task['status']) ? "task__status-time--active" : "" ?>"><?=Days::getTotalTime(($task['status'] && $day['status_time']) ? $newCurrentTime['newCountTask'] : $task['total_time'])?></div>
										<div class="d-none <?= ($task['status']) ? "task__total-time--active" : "" ?>"><?php echo $newCurrentTime['newCountTask'] ?></div>

										<!-- кнопка активирования задачи-->
										<?php if($task['complete']): ?>
											<?= Html::a('Активировать', Url::to(['task/complete', 'id'=>$task['id']]), ['class' => 'btn btn-outline-secondary btn-sm ml-2']) ?>

										<!-- кнопки управления задачей-->
										<?php else: ?>
											<div class="task_control ml-2 dropdown">
												<button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Управление
												</button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
													<?= Html::a('Изменить', Url::to(['task/update', 'id'=>$task['id']]), ['class' => 'dropdown-item']) ?>
													<?= Html::a('Удалить', Url::to(['task/delete', 'id'=>$task['id']]), ['class' => 'dropdown-item']) ?>
													<div class="dropdown-divider"></div>
													<?= Html::a(($task['status'])?'Снять выбор':'Выбрать', Url::to(['task/select', 'id'=>$task['id']]), ['class' => 'dropdown-item choose-task']) ?>
													<?= Html::a('Заврешить', Url::to(['task/complete', 'id'=>$task['id']]), ['class' => 'dropdown-item']) ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</li>
							<?php endforeach; ?>
						</ol>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
