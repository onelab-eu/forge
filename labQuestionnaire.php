<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link href="static/css/questionnaire.css" rel="stylesheet">
	</head>
	<body>
<?php
	include('static/content/questionnaireContent.php');
	// Define several variable
	$nbCourse = $networkLevel = $linuxLevel = $situationQ1 = $situationQ2 = $situationQ3 = $labQ1 = $labQ2 = $labQ3 = $PLEQ1 = $PLEQ2 = $PLEQ3 = $globalPointQ = $comment = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$nbCourse = test_input($_POST["nbCourse"]);
		$networkLevel = test_input($_POST["networkLevel"]);
		$linuxLevel = test_input($_POST["linuxLevel"]);
		$situationQ1 = test_input($_POST["question1-1"]);
		$situationQ2 = test_input($_POST["question1-2"]);
		$situationQ3 = test_input($_POST["question1-3"]);
		$labQ1 = test_input($_POST["question2-1"]);
		$labQ2 = test_input($_POST["question2-2"]);
		$labQ3 = test_input($_POST["question2-3"]);
		$PLEQ1 = test_input($_POST["question3-1"]);
		$PLEQ2 = test_input($_POST["question3-2"]);
		$PLEQ3 = test_input($_POST["question3-3"]);
		$globalPointQ = test_input($_POST["question4"]);
		$comment = test_input($_POST["comment"]);
	}

	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		echo "<form method='post' action=".$_SERVER['REQUEST_URI'].">
				<table class='table'>
					<thead>
						<tr>
							<th colspan='6'>
								<div class='th-inner'>".$content['profilTitle']."</div>
							</th>
						</tr>
					<thead>
					<tbody>
						<tr>
							<td>
								<div class='td-inner'>".$content['profilQ1']. "</div>
							</td>
							<td>
								<label>
									0 <input value='0' name='nbCourse' type='radio'>
								</label>
							</td>
							<td>
								<label>
									1 <input value='1' name='nbCourse' type='radio'>
								</label>
							</td>
							<td>
								<label>
									2 <input value='2' name='nbCourse' type='radio'>
								</label>
							</td>
							<td>
								<label>
									3 <input value='3' name='nbCourse' type='radio'>
								</label>
							</td>
							<td>
								<label>
									4 + <input value='4' name='nbCourse' type='radio'>
								</label>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>
							</th>
							<th>
								<div class='th-inner'>".$content['beginner']."</div>
							</th>
							<th>
								<div class='th-inner'>".$content['low']."</div>
							</th>
							<th>
								<div class='th-inner'>".$content['correct']."</div>
							</th>
							<th>
								<div class='th-inner'>".$content['good']."</div>
							</th>
							<th>
								<div class='th-inner'>".$content['excellent']."</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class='td-inner'>".$content['profilQ2']."</div>
							</td>
							<td>
								<div><input value='0' name='networkLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='networkLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='networkLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='networkLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='networkLevel' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='td-inner'>".$content['profilQ3']."</div>
							</td>
							<td>
								<div><input value='0' name='linuxLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='linuxLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='linuxLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='linuxLevel' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='linuxLevel' type='radio'></div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>
								<div class='th-inner'></div>
							</th>
							<th width='50px'>
								<div class='th-inner'>".$content['agree5']."</div>
							</th>
							<th width='50px'>
								<div class='th-inner'>".$content['agree4']."</div>
							</th>
							<th width='50px'>
								<div class='th-inner'>".$content['agree3']."</div>
							</th>
							<th width='50px'>
								<div class='th-inner'>".$content['agree2']."</div>
							</th>
							<th width='50px'>
								<div class='th-inner'>".$content['agree1']."</div>
							</th>
						</tr>
						<tr>
							<th colspan='6'>
								<div class='th-inner'>".$content['situationTitle']."</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class='td-inner'>".$content['situationQ1']."</div>
							</td>
							<td>
								<div><input value='0' name='question1-1' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question1-1' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question1-1' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question1-1' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question1-1' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['situationQ2']."</div>
							</td>
							<td>
								<div><input value='0' name='question1-2' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question1-2' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question1-2' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question1-2' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question1-2' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['situationQ3']."</div>
							</td>
							<td>
								<div><input value='0' name='question1-3' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question1-3' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question1-3' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question1-3' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question1-3' type='radio'></div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='6'>
								<div class='th-inner'>".$content['labPointTitle']."</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class='tr-inner'>".$content['labPointQ1']."</div>
							</td>
							<td>
								<div><input value='0' name='question2-1' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question2-1' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question2-1' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question2-1' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question2-1' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['labPointQ2']."</div>
							</td>
							<td>
								<div><input value='0' name='question2-2' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question2-2' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question2-2' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question2-2' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question2-2' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['labPointQ3']."</div>
							</td>
							<td>
								<div><input value='0' name='question2-3' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question2-3' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question2-3' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question2-3' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question2-3' type='radio'></div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='6'>
								<div class='th-inner'>".$content['PLEPointTitle']."</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class='tr-inner'>".$content['PLEPointQ1']."</div>
							</td>
							<td>
								<div><input value='0' name='question3-1' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question3-1' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question3-1' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question3-1' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question3-1' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['PLEPointQ2']."</div>
							</td>
							<td>
								<div><input value='0' name='question3-2' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question3-2' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question3-2' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question3-2' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question3-2' type='radio'></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class='tr-inner'>".$content['PLEPointQ3']."</div>
							</td>
							<td>
								<div><input value='0' name='question3-3' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question3-3' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question3-3' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question3-3' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question3-3' type='radio'></div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan='6'>
								<div class='th-inner'>".$content['GlobalPointTitle']."</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class='tr-inner'>".$content['GlobalPointQ']."</div>
							</td>
							<td>
								<div><input value='0' name='question4' type='radio'></div>
							</td>
							<td>
								<div><input value='1' name='question4' type='radio'></div>
							</td>
							<td>
								<div><input value='2' name='question4' type='radio'></div>
							</td>
							<td>
								<div><input value='3' name='question4' type='radio'></div>
							</td>
							<td>
								<div><input value='4' name='question4' type='radio'></div>
							</td>
						</tr>
					</tbody>
				</table>
				<textarea class='form-control' name='comment'></textarea>
				<input type='submit' name='submit'>
		</form>";
	}

		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$IP = '';
			if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
				$IP =  $IP.$_SERVER["HTTP_X_FORWARDED_FOR"];  
			}
			if (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
				$IP = $IP.$_SERVER["REMOTE_ADDR"]; 
			}
			if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
				$IP = $IP.$_SERVER["HTTP_CLIENT_IP"]; 
			}
			try
			{
				$dir = 'questionnaire.sqlite';
				$bdd = new PDO('sqlite:'.$dir);
				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$reqAnswer = $bdd->prepare('INSERT INTO answer(ipAddress, nbCourse, networkLevel, linuxLevel, situationQ1, situationQ2, situationQ3, labQ1, labQ2, labQ3, PLEQ1, PLEQ2, PLEQ3, globalPointQ, comment) VALUES (:remote_addr, :nbCourse, :networkLevel, :linuxLevel, :situationQ1, :situationQ2, :situationQ3, :labQ1, :labQ2, :labQ3, :PLEQ1, :PLEQ2, :PLEQ3, :globalPointQ, :comment)');
				$reqAnswer->execute(array(
					'remote_addr' => $IP,
					'nbCourse' => $nbCourse,
					'networkLevel' => $networkLevel,
					'linuxLevel' => $linuxLevel,
					'situationQ1' => $situationQ1,
					'situationQ2' => $situationQ2,
					'situationQ3' => $situationQ3,
					'labQ1' => $labQ1,
					'labQ2' => $labQ2,
					'labQ3' => $labQ3,
					'PLEQ1' => $PLEQ1,
					'PLEQ2' => $PLEQ2,
					'PLEQ3' => $PLEQ3,
					'globalPointQ' => $globalPointQ,
					'comment' => $comment
				));
			}
			catch(PDOException $e)
			{
				echo '<br>Fail to execute<br>';
				die($e->getMessage());
			}
			echo '<div class=container">
					<p>'.$content['thanks'].'</p>
				</div>';
		}
	?>
	</body>
</html>
