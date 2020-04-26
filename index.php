<?php
	session_start();
	date_default_timezone_set('UTC+3');
	if(time() <= 1598907600)
	{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>WTC Tragedy</title>
		<link rel="stylesheet" href="css/index.css">
		<link rel="shortcut icon" href="images/favicon.ico?v=1">
		<meta charset="UTF-8"/>
	</head>
	<body>
		<div class="content">
			<div class="logo_div">
				<a href="/"><img src="images/logo.png"/></a>
			</div>
			<div class="sky"></div>
			<div class="image_city">
				<p class="city"><img src="images/city.jpg"/></p>
			</div>
			<div class="earth_under"></div>
			<div class="timer_container">
				<h1 class="timer_h1">Регистрация на WTC Tragedy будет доступна через:</h1><br><br>
				<p id="timer"></p>
			</div>
		</div>
		<div id="footer">
			<div>
				&copy; Саша Волохов, Никита Афанасьев
			</div>
		</div>
	</body>
	<script>
		var countDownDate = new Date("Sep 1, 2020 00:00:00").getTime();
		
		var countDownFunction = setInterval(function() {
			var now = new Date().getTime();
			var distance = countDownDate - now;
			var days = Math.floor(distance / (1000*60*60*24));
			var hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
			var minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
			var seconds = Math.floor((distance % (1000*60)) / 1000);
			
			document.getElementById("timer").innerHTML = days + "д. " + hours + "ч. " + minutes + "м. " + seconds + "с.";
			
			if(distance <= 0) location.href=location.href;
		}, 1000)
		
		<?php
		if($_GET['error'] == "1") {
			echo 'alert("Регистрация открывается 1 сентября 2020 года");';
		} else if($_GET['error'] == "2") {
			echo 'alert("Игра будет доступна 1 сентября 2020 года");';
		}
		?>
	</script>
</html>
<?php
	}
	else if(time() >= 1598904000 and time() <= 1599339600)
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>WTC Tragedy - зарегиструйтесь сейчас!</title>
		<link rel="stylesheet" href="css/index.css">
		<link rel="shortcut icon" href="images/favicon.ico?v=1">
		<meta charset="UTF-8"/>
	</head>
	<body>
		<div class="content">
			<div class="logo_div">
				<a href="/"><img src="images/logo.png"/></a>
			</div>
			<div class="sky"></div>
			<div class="image_city">
				<p class="city"><img src="images/city.jpg"/></p>
			</div>
			<div class="earth_under"></div>
			<div class="timer_container">
				<h1 class="timer_h1">WTC Tragedy стартует через:</h1><br><br>
				<p id="timer"></p>
			</div>
			<a class="button_a" href="/register"><div class="button" style="left: 30%;">Зарегистрироваться</div></a>
			<a class="button_a" href="/list"><div class="button" style="left: 60%;">Список игроков</div></a>
		</div>
		<div id="footer">
			<div>
				&copy; Саша Волохов, Никита Афанасьев
			</div>
		</div>
	</body>
	<script>
		var countDownDate = new Date("Sep 6, 2020 00:00:00").getTime();
		
		var countDownFunction = setInterval(function() {
			var now = new Date().getTime();
			var distance = countDownDate - now;
			var days = Math.floor(distance / (1000*60*60*24));
			var hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
			var minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
			var seconds = Math.floor((distance % (1000*60)) / 1000);
			
			document.getElementById("timer").innerHTML = days + "д. " + hours + "ч. " + minutes + "м. " + seconds + "с.";
			
			if(distance <= 0) location.href=location.href;
		}, 1000)
		
		<?php
		if($_GET['success']) {
			$password = $_SESSION['password'];
			echo 'alert("Вы успешно зарегистрированы! Ваш пароль: ' . $password . '");';
			unset($_SESSION['password']);
		}
		?>
	</script>
</html>
<?php
	} else if(time() >= 1599339600) {
?>

<!DOCTYPE html>
<html>
	<head>
		<title>WTC Tragedy</title>
		<link rel="stylesheet" href="css/index.css">
		<link rel="shortcut icon" href="images/favicon.ico?v=1">
		<meta charset="UTF-8"/>
	</head>
	<body>
		<div class="content">
			<div class="logo_div">
				<a href="/"><img src="images/logo.png"/></a>
			</div>
			<div class="sky"></div>
			<div class="image_city">
				<p class="city"><img src="images/city.jpg"/></p>
			</div>
			<div class="earth_under"></div>
			<div class="timer_container">
				<h1 id="events" class="timer_h1"></h1>
			</div>
			<a class="button_a" href="/game"><div class="button" style="left: 30%;">Войти в игру</div></a>
			<a class="button_a" href="/register"><div class="button" style="left: 60%;">Зарегистрироваться</div></a>
		</div>
		<div id="footer">
			<div>
				&copy; Саша Волохов, Никита Афанасьев
			</div>
		</div>
		<script>
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'events.php', false);
			xhr.send();
			if (xhr.status != 200) {
			  alert("Упс! У нас проблемы");
			} else {
				document.getElementById("events").innerHTML = xhr.responseText;
			}
			var countDownFunction = setInterval(function() {
				var xhr = new XMLHttpRequest();
				xhr.open('GET', 'http://wtc_tragedy.ru/events.php', false);
				xhr.send();
				if (xhr.status != 200) {
				  alert("Упс! У нас проблемы");
				} else {
					document.getElementById("events").innerHTML = xhr.responseText;
				}
			}, 1000)
		</script>
	</body>
</html>

<?php
	}
	
?>