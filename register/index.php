<?php
if(time() <= 1598907600)
	{
		header('Location: http://wtc_tragedy.ru/?error=1');
	}
require("connect.php");

if(isset($_POST['sex']) and isset($_POST['username']) and isset($_POST['surname']) and isset($_POST['email']) and isset($_POST['date_register_day']) and isset($_POST['date_register_month']) and isset($_POST['date_register_year']) and isset($_POST['type']) and isset($_POST['rules_done'])) {
	$name = $_POST['username'];
	$secondname = $_POST['surname'];
	$email = $_POST['email'];
	$query = "SELECT count(*) FROM `users` WHERE email = '" . $email . "'";
	$res = mysqli_query($connection, $query);
	$row = mysqli_fetch_row($res);
	if($row[0] > 0)
	{
		$fail = "Кто-то уже зарегистрировался с такой электронной почтой. Выберите другую!";
	}
	else {
		$chars = "qazxswedcvfrtgbnhyujmkiolp";
		$max = 8;
		$size = strlen($chars)-1;
		$password = null;
		while($max--)
		{
			$password.=$chars[rand(0,$size)];
		}
		
		if($_FILES['file']['name']) {
			if($_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/bmp")
			{
				if($_FILES['file']['size'] <= 10485760) {
					$unencoded = $email;
					$key = "12345";
					$string=base64_encode($unencoded);

					$arr=array();
					$x=0;
					while ($x++< strlen($string)) {
					$arr[$x-1] = md5(md5($key.$string[$x-1]).$key);
					$newstr = $newstr.$arr[$x-1][3].$arr[$x-1][6].$arr[$x-1][1].$arr[$x-1][2];
					}
					if($_FILES['file']['type'] == "image/png") $imgphoto = $newstr . ".png";
					else if($_FILES['file']['type'] == "image/jpeg") $imgphoto = $newstr . ".jpg";
					else if($_FILES['file']['type'] == "image/bmp") $imgphoto = $newstr . ".bmp";
					$tmp_name = $_FILES['file']['tmp_name'];
				} else {
					$fail = "Размер картинки не должен превышать 10 МБ!";
				}
			} else {
				$fail = "В качестве аватара можно загрузить только изображение!";
			}
		}
		else {
			$imgphoto = "standard";
		}
		
		if($fail) {} else {
		
			$sex = $_POST['sex'];
			$date_birthday_day = $_POST['date_register_day'];
			$date_birthday_month = $_POST['date_register_month'];
			$date_birthday_year = $_POST['date_register_year'];
			if($date_birthday_day < 0 || $date_birthday_day > 31 || $date_birthday_month < 0 || $date_birthday_month > 12 || $date_birthday_year < 1901 || $date_birthday_year > 2001) {
				exit();
			} else {
				$type = $_POST['type'];
				
				if($_POST['location_1']) $location = $_POST['location_1'];
				else if($_POST['location_2']) $location = $_POST['location_2'];
				else if($_POST['location_3']) $location = $_POST['location_3'];
				else if($_POST['location_4']) $location = $_POST['location_4'];
				else if($_POST['location_5']) $location = $_POST['location_5'];
				
				$description = $_POST['description'];
				
				$query = "INSERT INTO users (name, secondname, email, password, imgphoto, sex, date_birthday_day, date_birthday_month, date_birthday_year, type, location, description) VALUES ('$name', '$secondname', '$email', '$password', '$imgphoto', '$sex', '$date_birthday_day', '$date_birthday_month', '$date_birthday_year', '$type', '$location', '$description')";
				$result = mysqli_query($connection, $query);
				
				if($_FILES['file']['name']) move_uploaded_file($tmp_name, "../images/avatars/" . $imgphoto);
			}
		}
	}
	
}
if($result == NULL) {
?>

<!DOCTYPE html>
<html>
	<head>
		<title>WTC Tragedy - регистрация</title>
		<link rel="stylesheet" href="/css/index.css">
		<link rel="shortcut icon" href="/images/favicon.ico?v=1">
		<meta charset="UTF-8"/>
	</head>
	<body>
		<form class="form_register" method="POST" enctype="multipart/form-data">
			<div class="content_register">
				<div class="top_register">Добро пожаловать в WTC Tragedy. Выберите фотографию Вашего профиля.</div><hr>
				<br><br><br>
				<p>Фотография профиля: <input name="file" type="file"></input></p><hr>
				<p>Пол:</p>
				<p><input name="sex" type="radio" value="male" required>Мужской</p>
				<p><input name="sex" type="radio" value="female" required>Женский</p><hr>
				<p>Имя:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="username" name="name" required></input></p>
				<p>Фамилия:       <input name="surname" required></input></p>
				<p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="email" type="email" required></input></p><hr>
				<p>Дата рождения: &nbsp;<input id="day_register" name="date_register_day" class="date_register_day" required type="number" min = "1" max="31" value = "1" step = "1" onchange="SetBirthday()"></input>&nbsp;<input id="month_register" name="date_register_month" class="date_register_month" required type="number" value = "1" min = "1" max="12" step = "1" onchange="SetBirthday()"></input>&nbsp;<input id="year_register" name="date_register_year" class="date_register_year" required type="number" value = "1901" min = "1901" max="2001" step = "1" onchange="SetBirthday()"></input></p>
				<p>Возраст на 6 сентября: <input id="age_register" value="100" readonly></input></p><hr>
				<p>Тип персонажа: 
					<select name="type" id="type" onchange="SetSelectHTML(this.selectedIndex)">
						<option>Обычный житель</option>
						<option>Работник ВТЦ</option>
						<option>Работник пентагона</option>
						<option>Пассажир рейса 11 American Airlines</option>
						<option>Пассажир рейса 175 United Airlines</option>
						<option>Пассажир рейса 77 American Airlines</option>
						<option>Пассажир рейса 93 United Airlines</option>
						<option>Пожарный</option>
						<option>Работник скорой помощи</option>
						<option>Полицейский</option>
					</select>
				</p>
				<p>Место проживания/работы/места в самолётё:
					<select name="location_1" id="location_1" class="first_register_select">
						<option>Какой-либо из домов</option>
					</select>
					<select name="location_2" id="location_2" class="second_register_select" style="display: none;">
						<option>Здание ВТЦ №1</option>
						<option>Здание ВТЦ №2</option>
						<option>Здание ВТЦ №3</option>
						<option>Здание ВТЦ №4</option>
						<option>Здание ВТЦ №5</option>
						<option>Здание ВТЦ №6</option>
						<option>Здание ВТЦ №7</option>
					</select>
					<select name="location_3" id="location_3" class="thir_register_select" style="display: none;">
						<option>Командование Военно-морских сил США</option>
						<option>Командование Военно-воздушных сил США</option>
						<option>Командование сухопутных сил США</option>
					</select>
					<select name="location_4" id="location_4" class="planes" style="display: none;">
						<option>Эконом-класс</option>
						<option>Бизнес-класс</option>
					</select>
					<select name="location_5" id="location_5" option="work" style="display: none;">
						<option>Место работы</option>
					</select>
					<p id="can_start_game_in">С Вашими опциями Вы сможете начать игру 6 сентября 2020 года в 00:00.</p>
				</p>
				<textarea name="description" class="textarea_register" placeholder="Описание Вашего персонажа..."></textarea><br>
				<input name="rules_done" type="checkbox" required>Я согласен с <a href="/rules" target="_blank">правилами WTC Tragedy</a></input><br>
			</div>
			<div class="button_register_for_div">
				<div class="button_register_div">
					<button class="button_a" type="submit" href="/"><div class="button_register" style="text-align: center;">Зарегистрироваться</div></button>
				</div>
			</div>
		</form>
		<script>
			function SetSelectHTML(type) {
				for(var i = 1; i < 6; i++) {
					var tmp_html = "location_" + i;
					document.getElementById(tmp_html).style.display = 'none';
				}
				if(type < 3) {
					type_new = type + 1;
					var tmp_html = "location_" + type_new;
					document.getElementById(tmp_html).style.display = 'inline';
					return 1;
				}
				else if(type >= 3 && type <= 6) document.getElementById("location_4").style.display = 'inline';
				else document.getElementById("location_5").style.display = 'inline';
				
				if(type >= 0 && type <= 2 || type >= 7 && type <= 9) document.getElementById("can_start_game_in").innerHTML = "С Вашими опциями Вы сможете начать игру 6 сентября 2020 года в 00:00";
				else if(type == 3 || type >= 5 && type <= 6) document.getElementById("can_start_game_in").innerHTML = "С Вашими опциями Вы сможете начать игру 11 сентября 2020 года в 07:00";
				else if(type == 4) document.getElementById("can_start_game_in").innerHTML = "С Вашими опциями Вы сможете начать игру 11 сентября 2020 года в 06:20";
			}
			function SetBirthday() {
				var day = document.getElementById("day_register").value;
				var month = document.getElementById("month_register").value;
				var year = document.getElementById("year_register").value;
				if(month < 9) {
					var age = 2001 - year;
				}
				else if(month == 9 && day <= 6) {
					var age = 2001 - year;
				}
				else {
					var age = 2001 - year - 1;
				}
				document.getElementById("age_register").value = age;
			}
			SetSelectHTML(document.getElementById("type").selectedIndex);
			SetBirthday();
			<?php
				if($fail) {
					echo "alert('" . $fail . "');";
					$fail = NULL;
				}
			?>
		</script>
	</body>
</html>

<?php
} else {
	session_start();
	$_SESSION['password'] = $password;
	header('Location: http://wtc_tragedy.ru/?success=yes');
}
?>