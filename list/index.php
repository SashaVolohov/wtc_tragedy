<?php
	date_default_timezone_set('UTC+3');
	require("../register/connect.php");
	if(time() >= 1598907600)
	{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>WTC Tragedy - список пассажиров</title>
		<link rel="stylesheet" href="/css/index.css">
		<link rel="shortcut icon" href="/images/favicon.ico?v=1">
		<meta charset="UTF-8"/>
	</head>
	<body>
		<div class="logo_div">
			<a href="/"><img src="/images/logo.png"/></a>
		</div>
		<div class="sky"></div>
		<div class="image_city">
			<p class="city"><img src="/images/city.jpg"/></p>
		</div>
		<div class="earth_under"></div>
		<div class="div_for_content_list">
			<div class="content_list">
				<?php
				$q = mysqli_query($connection, 'SELECT * FROM `users`');
				$res = array();
				while ($r = mysqli_fetch_assoc($q)) {
					$res[] = $r;
				}

				$query = "SELECT count(*) FROM `users`";
				$res_1 = mysqli_query($connection, $query);
				$row = mysqli_fetch_row($res_1);
				
				$i = 0;
				
				while($i < $row[0]) {
					$day = $res[$i]['date_birthday_day'];
					$month = $res[$i]['date_birthday_month'];
					$year = $res[$i]['date_birthday_year'];
					if($month < 9) {
						$age = 2001 - $year;
					}
					else if($month == 9 && $day <= 6) {
						$age = 2001 - $year;
					}
					else {
						$age = 2001 - $year - 1;
					}
					?>
					<div class="player_in_list">
						<div class="image_in_list">
							<img src="/images/avatars/<?php if($res[$i]["imgphoto"] != "standard") { echo $res[$i]["imgphoto"]; } else { if($res[$i]["sex"] == "mal") { echo "standard.png"; } else { echo "standard_women.png";}}?>" width="80px" height="80px">
						</div>
						<p class="name_in_list"><?php echo $res[$i]["name"] . " " . $res[$i]["secondname"];?>(<?php echo $res[$i]["type"];?>, <?php echo $age;?> лет)</p>
					</div>
					<?php
					$i++;
				}
				?>
			</div>
		</div>
	</body>
</html>
<?php
	} else if(time() <= 1598904000) {
		header('Location: http://wtc_tragedy.ru/?error=2');
	}
?>