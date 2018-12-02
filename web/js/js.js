$(document).ready(function() {
	// Аккордеон у описания к задачам;
	$('.task__content-title').on('click', f_acc);

	// Запускаем время если запущено время
	if ($('.day__status-time').hasClass('day__status-time--active')) {
		timer('.day__status-time--active', '.day__total-time--active');
		timer('.task__status-time--active', '.task__total-time--active');
	}

	// Запускаем показ flash-сообщения
	if ($('.modal-flash')) {
		$('.modal-flash').fadeIn('normal', 'swing', function () {
			setTimeout(function () {
				$('.modal-flash').fadeOut('normal', 'swing');
			}, 2000);
		});
	}

	/*	$('.btn-new-day').on('click', function (e) {

			e.preventDefault();

			$.ajax({
				url: '/days/new-day',
				type: 'GET',
				success: function (res) {
					console.log(res);
					showModal(res);
				},
				error: function () {
					alert('error');
				}
			});

		});

		function showModal(res){
			$('#do-modal .modal-body').html(res);
			$('#do-modal').modal();
		}
	});*/

// Функция Аккордеон у описания к задачам
	function f_acc() {
		$('.task__content-descr').not($(this).next()).slideUp(200);
		$(this).next().slideToggle(200);
	}

// функция таймера для запущенного времени
	function timer(status_time, total_time) {

		let cur_date = $(total_time).html();
		let hour = Math.floor(cur_date / 60 / 60);
		let minute = Math.floor(((cur_date - (hour * 60 * 60)) / 60));
		let second = cur_date - (hour * 60 * 60) - (minute * 60);


		setInterval(function () {
			if (minute >= 60) {
				hour += 1;
				minute = 0;
			}
			if (second >= 60) {
				minute += 1;
				second = 0;
			}

			hour = formatNumberOfTime(hour);
			minute = formatNumberOfTime(minute);
			second = formatNumberOfTime(second);

			let date_time = hour + ':' + minute + ':' + second;

			$(status_time).html(date_time);

			hour *= 1;
			minute *= 1;
			second *= 1;
			second += 1;
		}, 1000);
	}

// Добавляет ноль если цифр одна, а не две.
	function formatNumberOfTime(num) {
		return num < 10 ? '0' + num : num;
	}
});