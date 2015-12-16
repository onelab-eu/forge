<html>
	<head>
		<meta charset="utf-8">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://code.jquery.com/ui/1.10.2/themes/flick/jquery-ui.css" rel="stylesheet">
		<link href="static/css/main.css" rel="stylesheet">
	</head>
	<body role="document">
		<?php include('static/content/labContent.php'); ?>
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><?php echo $content['homeTitle']; ?></a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $content['planTitle']; ?></a>
						<ul class="dropdown-menu">
							<li>
								<a href="#congestionControl"><? echo $content['congestionControlTitle']; ?></a>
							</li>
							<li>
								<a href="#serverStudy"><?php echo $content['serverStudyTitle']; ?></a>
							</li>
							<li>
								<a href="#analysis"><?php echo $content['analysisTitle']; ?></a>
							<li>
						</ul>
					</li>
					<li class="language">
						<a href="?lang=en"><img src='static/img/en.jpg' height="30px"></a>
					</li>
					<li class="language">
						<a href="?lang=fr"><img src='static/img/fr.jpg' height="30px"></a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container" role="main">
			<div id="congestionControl-container">
				<h1 id="congestionControl"><? echo $content['congestionControlTitle']; ?></h1>
				<?php echo $content['congestionControlContent']; ?>
			</div>
			<div id="serverStudy-container">
				<h1 id="serverStudy"><?php echo $content['serverStudyTitle']; ?></h1>
				<?php echo $content['serverStudyContent']; ?>
			</div>
			<div id="analysis-container">
				<h1 id="analysis"><?php echo $content['analysisTitle']; ?></h1>
				<?php echo $content['analysisContent']; ?>
				<div class='container embed-responsive embed-responsive-16by9'>
					<iframe id="map" src="map.php"></iframe>
				</div>
				<button id='refreshWireshark'><?php echo $content['restart'] ?></button>
				<div class='container embed-responsive embed-responsive-16by9'>
					<iframe id="wiresharkFrame" src="wiresharkFrame.php" scrolling='yes'></iframe>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
		<script src="static/js/checkNumericApplication.js"></script>
		<script>
			$(document).ready(function() {
				var loc = window.location.toString();
				var params= loc.split('?')[1];
				if (params != 'undefined')
				{
					$('iframe').each(function() {
						$(this).attr('src', $(this).attr('src')+'?'+params);
					});
				}

				if (params != 'undefined')
				{
					$('#questionnaire').attr('href', $('#questionnaire').attr('href')+'?'+params);
				}

				function refreshIframeWireshark()
				{
					var ifr = document.getElementById('wiresharkFrame');
					ifr.src = ifr.src;
				}

				document.getElementById('refreshWireshark').addEventListener('click', refreshIframeWireshark, false);
			});
		</script>
	</body>
</html>
