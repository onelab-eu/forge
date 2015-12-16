<?php
try
{
	$dir = 'questionnaire.sqlite';
	$bdd = new PDO('sqlite:'.$dir);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$reqAnswer = $bdd->prepare('INSERT INTO answer(id, nbCourse, networkLevel, linuxLevel, situationQ1, situationQ2, situationQ3, labQ1, labQ2, labQ3, PLEQ1, PLEQ2, PLEQ3, comment) VALUES (:id, :nbCourse, :networkLevel, :linuxLevel, :situationQ1, :situationQ2, :situationQ3, :labQ1, :labQ2, :labQ3, :PLEQ1, :PLEQ2, :PLEQ3, :comment)');
	$reqAnswer->execute(array(
		'id' => null,
		'nbCourse' => $_POST['nbCourse'],
		'networkLevel' => $_POST['networkLevel'],
		'linuxLevel' => $_POST['linuxLevel'],
		'situationQ1' => $_POST['question1-1'],
		'situationQ2' => $_POST['question1-2'],
		'situationQ3' => $_POST['question1-3'],
		'labQ1' => $_POST['question2-1'],
		'labQ2' => $_POST['question2-2'],
		'labQ3' => $_POST['question2-3'],
		'PLEQ1' => $_POST['question3-1'],
		'PLEQ2' => $_POST['question3-2'],
		'PLEQ3' => $_POST['question3-3'],
		'globalPointQ' => $_POST['question4'],
		'comment' => $_POST['comment']
	));
}
catch(PDOException $e)
{
	echo 'Fail to execute';
	die($e->getMessage());
}
?>
<p><?php implode($_POST); ?></p>
<p>Merci d'avoir répondu à ce questionnaire</p>
