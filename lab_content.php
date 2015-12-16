<?php

$content_fr = array(
	'homeTitle' => 'Accueil',
	'planTitle' => 'Plan du cours',
	'congestionControlTitle' => "Controle de congestion",
	'serverStudyTitle' => "Etude de la latence d'un serveur web",
	'analysisTitle' => "Analyse des mécanismes TCP",

	'congestionControlContent' => "<p>TCP est utilisé pour le transport fiable de données dans l'Internet. Nous avons précédemment étudié la gestion des connexions et les mécanismes TCP. Dans les exercices suivants, nous allons nous intéresser à un autre comportement fondamental de TCP: le contrôle de congestion.</p>
					<h2>Détection de la congestion</h2>
						<p>La conception de TCP date de la fin des années 70. Plusieurs algoritmes de contrôle de congestion ont été intégrés depuis, principalement suite aux travaux de Van Jacobson publiés en 1988. Ces derniers continuent à évoluer dans les différentes variantes de TCP. Les exercices proposés dans la suite sont fondés sur les dernières mises à jour: le RFC 5681 de septembre 2009.</p>
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
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.1.jpeg'>
								</p>
								<p>où <em>W</em> est la taille de la fenêtre (en segment) au moment de la congestion, <em>MSS</em> la taille d'un segment (supposée maximale), et <em>RTT</em> est le délai aller-retour (supposé constant durant la période de la transmission).</p>
							</li>
							<li>
								<p>Montrez que le taux de pertes <em>p</em> est égal à:</p>
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.2.jpeg'>
								</p>
							</li>
							<li>
								<p>Montrez que si le taux de pertes observé par une connexion TCP esqt <em>p</em>, alors son débit moyen <em>d</em> peut être approximé par:</p>
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.3.jpeg'>
								</p>
							</li>
							<li>
								<p>Quels autres paramètres peuvent influer sur le débit d'une connexion TCP?</p>
							</li>
							<li>
								<p>Quelle utilité voyez-vous à la relation claculée dans la dernière formule de <em>d</em>?
							</li>
						</ol>",
	'serverStudyContent' => "<p>Nous souhaitons étudier la latence liée à la réponse à une requête HTTP. Nous faisons les hypothèses simplificatrices suivantes:
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
  							<p class='text-center'>
								<img class='img-responsive img-thumbnail' src='static/img/2.1.jpeg'>
							</p>
						</li>
						<li>
							<p>Nous supposon maintenant une fenêtre de congestion <strong>statique</strong> de taille fixe égale à <em>W</em>. Calculez la latence dans ce premier cas:</p>
  							<p class='text-center'>
								<img class='img-responsive img-thumbnail' src='static/img/2.2.jpeg'>
							</p>
						</li>
						<li>
							<p>Nous supponsons toujours une fenêtre de congestion <strong>statique</strong> de taille fixe égale à <em>W</em>. Calculez la latence dans ce second cas:</p>
  							<p class='text-center'>
								<img class='img-responsive img-thumbnail' src='static/img/2.3.jpeg'>
							</p>
						</li>
						<li>
							<p>Comparez la latence obtenue avec une fenêtre de contrôle de congestion <strong>dynamique</strong> (<em>slow-start</em>) avec celle sans contrôle de congestion.</p>
						</li>
						<li>
							<p>Application numérique:</p>
							<table data-toggle='table' class='table table-bordered'>
								<thead>
									<tr>
										<th style>
											<div class='th-inner'><em>R</em></div>
										</th>
										<th style>
											<div class='th-inner'><em>O/R</em></div>
										</th>
										<th style>
											<div class='th-inner'><em>L</em> (sans <em>slow start</em>)</div>
										</th>
										<th style>
											<div class='th-inner'>K'</div>
										</th>
										<th style>
											<div class='th-inner'><em>L</em> (latence globale de TCP)</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style>56 Kbps</td>
										<td><input id='1-1' type='text' class='form-control'></td>
										<td><input id='1-2' type='text' class='form-control'></td>
										<td><input id='1-3' type='text' class='form-control'></td>
										<td><input id='1-4' type='text' class='form-control'></td>
									</tr>
									<tr>
										<td style>512 Kbps</td>
										<td><input id='2-1' type='text' class='form-control'></td>
										<td><input id='2-2' type='text' class='form-control'></td>
										<td><input id='2-3' type='text' class='form-control'></td>
										<td><input id='2-4' type='text' class='form-control'></td>
									</tr>
									<tr>
										<td style>8 Mbps</td>
										<td><input id='3-1' type='text' class='form-control'></td>
										<td><input id='3-2' type='text' class='form-control'></td>
										<td><input id='3-3' type='text' class='form-control'></td>
										<td><input id='3-4' type='text' class='form-control'></td>
									</tr>
									<tr>
										<td style>100 Mbps</td>
										<td><input id='4-1' type='text' class='form-control'></td>
										<td><input id='4-2' type='text' class='form-control'></td>
										<td><input id='4-3' type='text' class='form-control'></td>
										<td><input id='4-4' type='text' class='form-control'></td>
									</tr>
								</tbody>
							</table>
						</li>
					</ul>",
	'analysisContent' => "<p>Dans cette partie vous générerez des captures de traffic vers un serveur plus ou moins éloigné grâce à la plateforme d'experimentation PlanetLab Europe. Pour chacune d'elles, tracez précisément le chronogamme et étudiez les mécanismes de contrôle de congestion mis-en-oeuvre. Discuter en particulier les points suivants:
				<ol>
					<li>
						<p>Quel est le <em>RTT</em> moyen ?</p>
					</li>
					<li>
						<p>Reconnaissez-vous les mécanismes de contrôle de congestion ?</p>
					</li>
					<li>
						<p>Jusqu'à combien de segments sont transmis par <em>RTT</em> ?</p>
					</li>
					<li>
						<p>Quels est le débit moyen alors atteint ?</p>
					</li>
					<li>
						<p>Un envoi continu apparaît-il ?</p>
					</li>
					<li>
						<p>Des perturbations sont-elles présentes (déséquencement, retransmission...)?</p>
					</li>
				</ol>
			<h2>Trafic HTTP WAN Intercontinental</h2>
			"
);

$content_en = array(
	'homeTitle' => 'Homepage',
	'planTitle' => 'Plan of the course',
	'congestionControlTitle' => 'Congestion control',
	'serverStudyTitle' => 'Study of the latency of a web server',
	'analysisTitle' => 'Analysis of TCP mechanisms',
	'congestionControlContent' => "<p>TCP is used for reliable transport of data in the Internet. We previously study connection management and TCP mechanisms.	In the following exercises, we will get interest in a other	fundamental behavior of TCP: the congestion control.</p>
					<h2>Congestion detection</h2>
						<p>TCP was designed at the end of the 70's. Several congestion control algorithms have been added since, mainly following the work of Van Jacobson published in 1988. They continue to evolve in different TCP variants. The exercises proposed in the following are founded on the last versions: RFC 5681 of September 2009. </p>
						<ol>
							<li>
								<p>For TCP, which phenomenon indicates congestion in the network?</p>
							</li>
							<li>
								<p>What's going on inside a router to generate this phenomenon?</p>
							</li>
							<li>
								<p>For TCP, this phenomenon can infer congestion. But it can also occur when there is no congestion in the network.	In which other cases in which case such a phenomenon may occur?</p>
							</li>
							<li>
								<p>If this phenomenon does not always indicate congestion, why is TCP based on this inference? Why don't we use an approach where the router notify explicitly the congestion by sending a message to the sender?</p>
							</li>
						</ol>
					<h2>Congestion control algorithms</h2>
						<p>For congestion control, TCP uses a threshold that indicates the flow rate above which congestion may occur. This threshold is expressed by the parameter <em>ssthresh</em> (in bytes). To get the flow rate threshold, <em>ssthresh</em> is divided by the  <em>RTT</em> (Round Trip Time). The flow rate can vary from below and above the threshold <em>ssthresh</em>/<em>RTT</em>. The issuer maintains an other parameter, <em>cwnd</em> (Size of the congestion window), which indicates the maximum number of bytes it can send before receiving an acknowledgment. When <em>cwnd > ssthresh</em>, the sender take care particularly to not cause congestion.</p>
						<ol>
							<li>
								<p>Suppose <em>ssthresh</em> is at 5000 bytes, <em>cwnd</em> is at 6000 bytes, and segment size is 500 bytes. The sender sends twelve segments of 500 bytes in one <em>RTT</em> period,	and receives twelve acknowledgements (one for each segments). What happens to the values ?<em>ssthresh</em> and  <em>cwnd</em>? How these values changes are called? </p>
							</li>
							<li>
								<p>Suppose <em>ssthresh</em> is still at 5000~bytes, <em>cwnd</em> is now at 14,000~bytes, the sender sends 14.000/500 = 28 segments, and that the sender receives a congestion notification before receiving the first acknowledgement. What happens to the  <em>ssthresh</em> and <em>cwnd</em> values ?	How these values changes are called?</p>
							</li>
							<li>
								<p>We have seen how increases and decreases <em>cwnd</em> depending on the absence or presence of indicators of congestion. How do we call this algorithm? On what principle is based this algorithm?</p>
							</li>
							<li>
								<p>At startup, and after having received a congestion notification,	the value of <em>cwnd</em> is smaller than the value of <em>ssthresh</em>. Describe how <em>cwnd</em> increase when it is lower than <em>ssthresh</em>, depending on the following example. Suppose <em>ssthresh</em> equal to 3000 bytes and <em>cwnd</em> equal to 500 bytes, the size of a segment. The transmitter has several segments ready to be sent. How many segments sends the issuer during the first <em>RTT</em> period? If it receives acknowledgments for all segments, what becomes the value of <em>cwnd</em>? How many segments sends the issuer during the second RTT period? If it receives acknowledgments for all segments, what becomes the <em>cwnd</em> value? In general, how evoluate the size of <em>cwnd</em>?</p>
							</li>
							<li>
								<p>How is called the period during which <em>cwnd</em> is smaller than <em>ssthresh</em>?</p>
							</li>
							<li>
								<p>What happens to the value <em>ssthresh</em> if the sender receives a congestion notification while <em>cwnd</em> is smaller <em>ssthresh</em> that?</p>
							</li>
						</ol>
					<h2>Average bandwidth of a TCP connection</h2>
						<p>Suppose we wish to perform a large data transfer through a TCP connection</p>
						<ol>
							<li>
								<p>By neglecting the period during which <em>cwnd</em> is smaller than <em>ssthresh</em>, show that <em>d</em>, the average flow rate associates to a TCP connexion, is equal to:</p>
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.1.jpeg'>
								</p>
								<p>where <em>W</em> is the size of the window (in segments) at the time of congestion, <em>MSS</em> the size of segment (assumed to maximum), and <em>RTT</em> is the round trip delay (assumed constant during the period of transmission).</p>
							</li>
							<li>
								<p>Show that the loss rate <em>p</em> is equal to:</p>
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.2.jpeg'>
								</p>
							</li>
							<li>
								<p>Show that if the loss rate observed by a TCP connection is <em>p</em>, then <em>d</em>, the average flow rate, could be approximated by:</p>
  								<p class='text-center'>
									<img class='img-responsive img-thumbnail' src='static/img/1.3.3.jpeg'>
								</p>
							</li>
							<li>
								<p>What other parameters can affect the throughput of a TCP connection?</p>
							</li>
							<li>
								<p>What utility do you see to the relation calculated in the last formula of <em>d</em>?</p>
							</li>
						</ol>",
	//TODO Translate
	'serverStudyContent' => "<p>We would like to study the latency bound to the answer to an HTTP request. We make the following simplifying assumptions:</p>
	<ul>
		<li>
			<p>The network is not congested (no losses or retransmissions);</p>
		</li>
		<li>
			<p>The receiver has infinite reception buffer (transmitter only limitation is due to the congestion window)</p>
		</li>
		<li>
			<p>The size of the object to receive the server is <em>O</em>, an integer multiple of <em>MSS</em> (<em>MSS</em> size is <em>S</em> bits);</p>
		</li>
		<li>
			<p>Throughput of the link connecting the client to the server is <em>R</em> (bps) and we neglected the size of all headers (TCP, IP and Link layer). Only the segments carrying data have a significant transmission time. The transmission time of control segments (ACK, SYN ...) is negligible;</p>
		</li>
		<li>
			<p>The value of the initial threshold of congestion control is never reached;</p>
		</li>
		<li>
			<p>The value of the round trip time delay is <em>RTT</em>.</p>
		</li>
	</ul>
	<ol>
		<li>
			<p>Initially, we assume that we have no congestion control window. In this case, justify the following expression of <em>L</em>, the latency:</p>
  			<p class='text-center'>
				<img class='img-responsive img-thumbnail' src='static/img/2.1.jpeg'>
			</p>
		</li>
		<li>
			<p>We now assume a <strong>static</strong> congestion window of	fixed size fixe <em>W</em>. Calculate the latency in this first case:</p>
  			<p class='text-center'>
				<img class='img-responsive img-thumbnail' src='static/img/2.2.jpeg'>
			</p>
		</li>
		<li>
			<p>e still assume a <strong>static</strong> congestion window of fixed size <em>W</em>. Calculate the latency in the second cases:</p>
  			<p class='text-center'>
				<img class='img-responsive img-thumbnail' src='static/img/2.3.jpeg'>
			</p>
		</li>
		<li>
			<p>Compare the latency with a <strong>dynamic</strong> congestion control window (slow start) with the one without congestion control.</p>
		</li>
		<li>
			<p>Numerical implementation</p>
			<table data-toggle='table' class='table table-hover'>
				<thead>
					<tr>
						<th style>
							<div class='th-inner'><em>R</em></div>
						</th>
						<th style>
							<div class='th-inner'><em>O/R</em></div>
						</th>
						<th style>
							<div class='th-inner'><em>L</em> (without <em>slow start</em>)</div>
						</th>
						<th style>
							<div class='th-inner'>K'</div>
						</th>
						<th style>
							<div class='th-inner'><em>L</em> (global latency of TCP)</div>
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
	",
	'analysisContent' => "<p>In this part you will generate traffic to a distant server using the PlanetLab Europe testbed. For each one, draw the chronogram and study the congestion control mechanisms put-in-work. Discuss particular of the following</p>
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
				<h2>HTTP Traffic WAN Intercontinental</h2>"
);

if (array_key_exists('lang', $_GET) and htmlspecialchars($_GET['lang']) == 'en')
{
	$content = $content_en;
}
else
{
	$content = $content_fr;
}

?>
