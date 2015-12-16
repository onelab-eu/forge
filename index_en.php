<html>
	<head>
		<meta charset="utf-8">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://code.jquery.com/ui/1.10.2/themes/flick/jquery-ui.css" rel="stylesheet">
	</head>
	<body role="document">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#">Accueil</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Course Structure</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#congestionControl">Congestion Control</a>
							</li>
							<li>
								<a href="#serverStudy">Etude de la latence d'un serveur web</a>
							</li>
							<li>
								<a href="#analysis">Analyse des mécanismes TCP</a>
							<li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container" role="main">
			<div id="congestionControl-container">
				<h1 id="congestionControl">Congestion Control</h1>
					<p>TCP is used for reliable transport of data in the Internet. We previously study connection management and TCP mechanisms. In the following exercises, we will get interest in a other fundamental behavior of TCP: the congestion control.</p>
					<h2>Congestion detection</h2>
						<p>TCP was designed at the end of the 70's. Several congestion control algorithms have been added since, mainly following the work of Van Jacobson published in 1988. They continue to evolve in different TCP variants. The exercises proposed in the following are founded on the last versions: RFC 5681 of September 2009.</p>
						<ol>
							<li>
								<p>Pour TCP, quel phénomène indique une congestion dans le réseau ?</p>
							</li>
							<li>
								<p>Que se passe-t-il dans un routeur pour susciter ce phénomène?</p>
							</li>
							<li>
								<p>Pour TCP, ce phénomène permet de déduire la congestion. Mais celui-ci peut aussi se produire quand il n'y a pas de congestion dans le réseau. Dans quels autres cas un tel phénomène peut-il apparaître ?</p>
							</li>
							<li>
								<p>Si ce phénomène n'indique pas toujours une congestion, pourquoi TCP se base-t-il sur cette inférence ? Pourquoi n'utilise-t-on pas une approche où le routeur constatant la congestion envoie un message explicite à l'émetteur ?</p>
							</li>
						</ol>
					<h2>Algorithmes de contrôle de congestion</h2>
						<p>Pour le contrôle de congestion, TCP utilise un seuil qui indique le débit au-dessus duquel la congestion risque de se produire. Ce seuil est exprimé par le paramètre <em>ssthresh</em> (en octets). Pour obtenir le débit seuil on divise <em>ssthresh</em> par le <em>RTT</em> (<em>Round Trip Time</em>). Le débit peut varier en-dessous et au-dessus du seuil <em>ssthresh</em>/<em>RTT</em>. L'émetteur maintient un second paramètre, <em>cwnd</em> (taille de la fenêtre de congestion) qui indique le nombre maximum d'octets qu'il peut envoyer avant de recevoir un acquittement. Quand <em>cwnd > ssthresh</em>, l'émetteur fait particulièrement attention à ne pas provoquer de congestion.</p>
						<ol>
							<li>
								<p>Supposons que <em>ssthresh</em> soit à 5000 octets, <em>cwnd</em> est à 6000 octets, et la taille d'un segment est de 500 octets.Un émetteur envoie douze segments de 500 octets dans une période <em>RTT</em>, et reçoit douze acquittements (un pour chaque segment). Que deviennent les valeurs de <em>ssthresh</em> et <em>cwnd</em> ? Comment s'appellent ces changements de valeurs ?</p>
							</li>
							<li>
								<p>Supposons que <em>ssthresh</em> soit toujours à 5000 octets, que <em>cwnd</em> est maintenant à 14.000 octets, que l'émetteur envoie 14.000/500 = 28 segments, et que l'émetteur reçoive une indication de congestion avant de recevoir le premier acquittement. Que deviennent les valeurs de <em>ssthresh</em> et <em>cwnd</em> ? Comment s'appellent ces changements de valeurs ?</p>
							</li>
							<li>
								<p>Nous venons de voir comment augmente et diminue <em>cwnd</em> en fonction de l'absence ou la présence d'indicateurs de congestion. Comment s'appelle cet algorithme? Sur quel principe repose cet algorithme ?</p>
							</li>
							<li>
								<p>Au démarrage, ou après avoir reçu une indication de congestion, la valeur de <em>cwnd</em> est plus petite que la valeur de <em>ssthresh</em>. Décrivez la manière permettant d'augmenter <em>cwnd</em> quand celle-ci est inférieure à <em>ssthresh</em>, en fonction de l'exemple suivant. Supposons que <em>ssthresh</em> soit égal à 3000 octets et que <em>cwnd</em> soit égal à 500 octets, la taille d'un segment. L'émetteur a plusieurs segments prêts à être envoyés. Combien de segments envoie l'émetteur pendant la première période <em>RTT</em> ? S'il reçoit des acquittements pour tous ses segments, que devient la valeur de <em>cwnd</em>? Combien de segments envoie l'émetteur pendant la deuxième période <em>RTT</em>? S'il reçoit des acquittements pour tous ses segments, que devient la valeur de <em>cwnd</em> ? En général, comment évolue la taille de <em>cwnd</em>?</p>
							</li>
							<li>
								<p>Comment s'appelle la période pendant laquelle <em>cwnd</em> est plus petit que <em>ssthresh</em> ?</p>
							</li>
							<li>
								<p>Que devient la valeur de <em>ssthresh</em> si l'émetteur reçoit une indication de congestion pendant que <em>cwnd</em> est plus petit que <em>ssthresh</em> ?</p>
							</li>
						</ol>
					<h2>Débit moyen d'une connexion TCP</h2>
						<p>Supponsons que nous souhaitions effectuer un transfert de données de taille importante à travers une connexion TCP.</p>
						<ol>
							<li>
								<p>En négligeant la période pendant laquelle <em>cwnd</em> est plus petit
  que <em>ssthresh</em>, montrez que le débit moyen </em>d</em> associé à une connexion TCP est égal à:</p>
  								<p class="text-center">
									<img class="img-responsive img-thumbnail" src="static/img/1.3.1.jpeg">
								</p>
								<p>où <em>W</em> est la taille de la fenêtre (en segment) au moment de la congestion, <em>MSS</em> la taille d'un segment (supposée maximale), et <em>RTT</em> est le délai aller-retour (supposé constant durant la période de la transmission).</p>
							</li>
							<li>
								<p>Montrez que le taux de pertes <em>p</em> est égal à:</p>
  								<p class="text-center">
									<img class="img-responsive img-thumbnail" src="static/img/1.3.2.jpeg">
								</p>
							</li>
							<li>
								<p>Montrez que si le taux de pertes observé par une connexion TCP esqt <em>p</em>, alors son débit moyen <em>d</em> peut être approximé par:</p>
  								<p class="text-center">
									<img class="img-responsive img-thumbnail" src="static/img/1.3.3.jpeg">
								</p>
							</li>
							<li>
								<p>Quels autres paramètres peuvent influer sur le débit d'une connexion TCP?</p>
							</li>
							<li>
								<p>Quelle utilité voyez-vous à la relation claculée dans la dernière formule de <em>d</em>?
							</li>
						</ol>
			</div>
			<div id="serverStudy-container">
				<h1 id="serverStudy">Etude de la latence d'un serveur web</h1>
					<p>Nous souhaitons étudier la latence liée à la réponse à une requête HTTP. Nous faisons les hypothèses simplificatrices suivantes:
					<ul>
						<li>
							<p>Le réseau n'est pas congestionné (pas de pertes ni de retransmissions);<p>
						</li>
						<li>
							<p>Le récepteur est doté de tampons de réception infinis (limitation de l'émetteur uniquement liée à la fenêtre de congestion);</p>
						</li>
						<li>
							<p>La taille de l'objet à recevoir est <em>O</em>, un multiple entier du <em>MSS</em> (<em>MSS</em> à pour taille <em>S</em> bits);</p>
						</li>
						<li>
							<p>Le débit de la liaison connectant le client au serveur est <em>R</em> (bits/s) et on néglige la taille de tous les entêtes (TCP, IP et liaison). Seuls les segments transportant des données ont un temps de transmission significatif. Le temps de transmission des segments de contrôle (ACK, SYN ...) est négligeable;</p>
						</li>
						<li>
							<p>La valeur du seuil initial du contrôle de congestion n'est jamais atteinte;</p>
						</li>
						<li>
							<p>La valeur du délai aller-retour est <em>RTT</em>.</p>
						</li>
					</ul>
					<ol>
						<li>
							<p>Dans un premier temps, nous supposons que nous n'avons pas de fenêtre de contrôle de congestion. Dans ce cas montrez que la latence <em>L</em> peut s'exprimer de la manière suivante:</p>
  							<p class="text-center">
								<img class="img-responsive img-thumbnail" src="static/img/2.1.jpeg">
							</p>
						</li>
						<li>
							<p>Nous supposon maintenant une fenêtre de congestion <strong>statique</strong> de taille fixe égale à <em>W</em>. Calculez la latence dans ce premier cas:</p>
  							<p class="text-center">
								<img class="img-responsive img-thumbnail" src="static/img/2.2.jpeg">
							</p>
						</li>
						<li>
							<p>Nous supponsons toujours une fenêtre de congestion <strong>statique</strong> de taille fixe égale à <em>W</em>. Calculez la latence dans ce second cas:</p>
  							<p class="text-center">
								<img class="img-responsive img-thumbnail" src="static/img/2.3.jpeg">
							</p>
						</li>
						<li>
							<p>Comparez la latence obtenue avec une fenêtre de contrôle de congestion <strong>dynamique</strong> (<em>slow-start</em>) avec celle sans contrôle de congestion.</p>
						</li>
						<li>
							<p>Application numérique:</p>
							<table data-toggle="table" class="table table-hover">
								<thead>
									<tr>
										<th style>
											<div class="th-inner"><em>R</em></div>
										</th>
										<th style>
											<div class="th-inner"><em>O/R</em></div>
										</th>
										<th style>
											<div class="th-inner"><em>L</em> (sans <em>slow start</em>)</div>
										</th>
										<th style>
											<div class="th-inner">K'</div>
										</th>
										<th style>
											<div class="th-inner"><em>L</em> (latence globale de TCP)</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style>56 Kbps</td>
									</tr>
									<tr>
										<td style>512 Kbps</td>
									</tr>
									<tr>
										<td style>8 Mbps</td>
									</tr>
									<tr>
										<td style>100 Mbps</td>
									</tr>
								</tbody>
							</table>
						</li>
					</ul>
			</div>
			<div id="analysis-container">
				<h1 id="analysis">Analysis of TCP mechanisms</h1>
				<p>In this part you will generate traffic to a distant server using the PlanetLab Europe testbed. For each one, draw the chronogram and study the congestion control mechanisms put-in-work. Discuss particular of the following</p>
				<ol>
					<li>
						<p>What is the average <em>RTT</em> ?</p>
					</li>
					<li>
						<p>Do you recognize the congestion control mechanismes ?</p>
					</li>
					<li>
						<p>Up to how many segments are transmitted by <em>RTT</em> ?</p>
					</li>
					<li>
						<p>Chat is the average throughput achieved then ?</p>
					</li>
					<li>
						<p>A continuous sending it appears ?</p>
					</li>
					<li>
						<p>I there any disturbances (desequencement, retransmission...)?</p>
					</li>
				</ol>
				<h2>HTT Traffic WAN Intercontinental</h2>
					<iframe src="wiresharkFrame.php" style="width: 796px; height: 400px;" scrolling='yes'></iframe>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
	</body>
</html>
