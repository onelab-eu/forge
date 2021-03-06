<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="static/css/wireshark.css">
		<link rel="stylesheet" href="static/css/bootstrap.min.css">
		<link rel="stylesheet" href="static/css/sharkcss.css">
	</head>
	<body>
		<?php include('static/content/wiresharkFrameContent.php'); ?>
		<form class='form-horizontal' role="form" method="post" id='form'>
				<div class="form-group">
					<label for='clientHost' class="col-sm-2 control-label"><?php echo $content['clientHost']; ?></label>
					<div class="col-sm-10">
						<input id="clientHost" type="text" name="clientHost" value="planetlab1.utt.fr" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for='clientPort' class="col-sm-2 control-label"><?php echo $content['clientPort']; ?></label>
					<div class="col-sm-10">
						<input type="text" id="clientPort" name="clientPort" value="8080" readonly>
					</div>
				</div>
			<!--<?php echo $content['sshPort']; ?>: --><input type="hidden" name="sshPort" value="22"/>
			<!-- <?php echo $content['sliceName']; ?>: --><input type="hidden" name="sliceName" value="upmc_forge"/>
			<div class="form-group">
				<label for='serverAndPort' class="col-sm-2 control-label"><?php echo $content['serverHost']; ?></label>
				<div class="col-sm-10">
					<select name="serverAndPort" class="form-control">
						<option value="planetlab2.utt.fr:8081">Local planetlab2.utt.fr:8081</option>
						<option value="planetlab4.hiit.fi:8080">Continental planetlab4.hiit.fi:8080</option>
						<option value="planet2.pnl.nitech.ac.jp:8080">Inter-Continental planet2.pnl.nitech.ac.jp:8080</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="fileName" class="col-sm-2 control-label"><?php echo $content['fileName']; ?></label>
				<div class="col-sm-10">
					<input type="text" name="fileName" id="fileName" value="test">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="radio">
						<label>
							<input type="radio" name="fileTarget" id="fileTargetIndex" value="index.html">
								Index.html
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="fileTarget" id="fileTarget1Mo" value="file1Mo" checked>
							1Mo File
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="submit" onclick="my_first_interactive(); return false;" id="submit"/>
				</div>
			</div>
		</form>
		<div id="loader" style='display: none;'>Now running your experiment <img src="static/img/loader.gif"></div>
		<div id="wrapper" style='display: none; width: 920px; height: 500px'>
			<a id='downloadLink' href="#"><?php echo $content['download']; ?></a>
			<div class="summary-div" class="pane">
				<div class="fht_fixed_header" style="width: 920px; height: 29px;">
					<table width="1420px" style="margin-left: 0px;">
						<thead>
							<tr>
								<th class="first-cell" width="26px">
									<div class="empty-cell" style="width:25px">No.</div>
								</th>
								<th width="66px">
									<div class="empty-cell" style="width:65px;">Time</div>
								</th>
								<th width="114px">
									<div class="empty-cell" style="width:113px;">Source</div>
								</th>
								<th width="114px">
									<div class="empty-cell" style="width:113px;">Destination</div>
								</th>
								<th width="66px">
									<div class="empty-cell" style="width:65px;">Protocol</div>
								</th>
								<th width="50px">
									<div class="empty-cell" style="width:49px;">Length</div>
								</th>
								<th class="last-cell" width="866px">
									<div class="empty-cell" style="width:865px;">Info</div>
								</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="fht_table_body" style="width: 920px; height: 140px; overflow: auto;">
					<table id="wiresharkTop" style="width: 920px; margin-top: -29px;">
						<thead>
							<tr>
								<th class="first-cell" width="26px">
									<div class="empty-cell" style="width:25px">No.</div>
								</th>
								<th width="66px">
									<div class="empty-cell" style="width:65px;">Time</div>
								</th>
								<th width="114px">
									<div class="empty-cell" style="width:113px;">Source</div>
								</th>
								<th width="114px">
									<div class="empty-cell" style="width:113px;">Destination</div>
								</th>
								<th width="66px">
									<div class="empty-cell" style="width:65px;">Protocol</div>
								</th>
								<th width="50px">
									<div class="empty-cell" style="width:49px;">Length</div>
								</th>
								<th class="last-cell" width="866px">
									<div class="empty-cell" style="width:865px;">Info</div>
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					
					</table>
				</div>
			</div>
			<div class="detail-div" class="pane" style="height: auto; bottom: 89.25px;">
				<ul id="wiresharkMiddle">
				</ul>
			</div>
			<div id="wiresharkBottom">
			</div>
		</div>

		<script src="static/js/jquery.js"></script>
		<script src="static/js/require.js"></script>
        <script src="static/js/base64.js"></script>
        <script src="static/js/tincan-min.js"></script>
        <script src="static/js/common.js" ></script>
        <script src="static/js/contentfunctions.js" ></script>
        <script>
            
            var xapiendpoint = "http://forgebox.eu/lrs/learninglocker/public/data/xAPI/"; 
            var xapiauthtxt = "<?php print "Basic ".base64_encode("576763bd688cccf580d3f14fbacf42000f73e40f:c0b6ea446215e31c05b950c5a2ae272b0671ed23"); ?>";  

            var actorname = "anonymous";
            var actoremail = "anonymous@anonymous.com";
            
            var tincan = new TinCan (
            {
                url: window.location.href,
                recordStores: [
                    {
                        endpoint:   xapiendpoint,
                        auth:       xapiauthtxt,
                        allowFail:  false 
                    }
                ]
            }
            );

        tincan.sendStatement(
            {
                actor: {
                    name: actorname,
                    mbox: "mailto:"+actoremail        
                  },
                  verb: {
                    id: "http://adlnet.gov/expapi/verbs/experienced",
                    display: {"en-US": "experienced"}
                },
                object: {
                    id: "http://forge.npafi.org",
                    definition: {
                        type: "http://adlnet.gov/expapi/activities/assessment",
                        name: { "en-US":  "UPMC - FORGE course" },
                    }
                }
            },
            function () {}
        );
        
        function my_first_interactive(){
            
            tincan.sendStatement(
            {
                actor: {
                    name: actorname,
                    mbox: "mailto:"+actoremail
                  },
                  verb: {
                    id: "http://adlnet.gov/expapi/verbs/interacted",
                    display: {"en-US": "interacted"}
                },
                object: {
                    id: "http://forge.npafi.org/wiresharkFrame.php?undefined",
                    definition: {
                        type: "http://adlnet.gov/expapi/activities/interaction",
                        name: { "en-US":  "Wireshark widget - submit experiment" },
                    }
                }
            },
            function () {}
        );
            
        }
        
</script>
		<script>
			$(document).ready( function() 
			{
				require(['static/js/pcap', 'static/js/packetDissector', 'static/js/ipv4', 'static/js/ipv6', 'static/js/utils', 'static/js/protocole', 'static/js/wireshark', 'static/js/http'], function(pcap)
				{
					var xhr = new XMLHttpRequest();
					

					function jsTest()
					{
						$('#form').hide();
						$('#loader').show();
						if(xhr)
						{
							xhr.open('POST', 'scripts/index.php', true);
							xhr.onreadystatechange = handler;
							var formData = new FormData(document.getElementById('form'))
							xhr.send(formData);
						}
						else
						{
							console.log('fail');
						}
						return false;
					}
		
					function handler(evtXHR)
					{
						if(xhr.readyState == 4)
						{
							if(xhr.status == 200)
							{
								if(xhr.response==0)
								{
									xhr.open('GET', 'http://'+$('input[name="clientHost"]').val()+':'+$('input[name="clientPort"]').val()+'/', true);
									xhr.onreadystatechange = handlePcap;
									xhr.send();
								}
							}
						}
					}
	
					function handlePcap(evtXHR)
					{
						if(xhr.readyState == 4)
						{
							if(xhr.status == 200)
							{
								handlePcapFile(hexToStr(pairHex(xhr.responseText)));
								$('#downloadLink').attr('href', 'scripts/downloadTrace.php?clientHost='+$('input[name="clientHost"]').val()+'&clientPort='+$('input[name="clientPort"]').val()+'&fileName='+$('input[name="fileName"]').val());
								$('#loader').hide();
								$('#wrapper').show();
							}
						}
					}
					$('#submit').click(jsTest);
				});
			});
		</script>
	</body>
</html>
