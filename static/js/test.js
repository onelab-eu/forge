var GLOBAL_HEADER_LENGTH = 24; //bytes
var PACKET_HEADER_LENGTH = 16; //bytes

$(document).ready(function() {
	require(['pcap', 'packetDissector', 'ipv4', 'ipv6', 'utils', 'protocole', 'wireshark', 'http'], function (pcap){

		var invocation = new XMLHttpRequest();
		var url = 'http://192.168.0.38/traces/';
		var invocationHistoryText;

		function dissectFixedFile(evt)
		{
			if(invocation)
			{
				invocation.open('GET', url, true);
				invocation.onreadystatechange = handler;
				invocation.send();
			}
			else
			{
				console.log('fail');
			}
		}

		function handler(evtXHR)
		{
			if(invocation.readyState == 4)
			{
				if (invocation.status == 200)
				{
					console.log(typeof invocation.response);
					console.log(invocation);
					console.log(invocation.response.length);
					var response = invocation.responseText;
					console.log(typeof response);
					console.log(response.length);
					response = pairHex(response);
					console.log(response)
					handlePcapFile(hexToStr(response));
				}
				else
				{
					console.log("Invocation error Ocured");
				}
			}
		}

		function dissectChoosenFile(evt)
		{
			var reader = new FileReader();

			reader.onload = function(evt)
			{
				if (evt.target.readyState == FileReader.DONE)
				{
					handlePcapFile(evt.target.result);
				};
			};
			reader.readAsBinaryString(document.getElementById('pcap-file').files[0]);
			//handlePcapFile(document.getElementById('pcap-file').files[0]);
		}

		function handlePcapFile(stringData) 
		{
			clearWiresharkTop();
			this.pcap = pcapDissector(stringData, false);
			document.pcapDissected = {
				header: this.pcap.globalHeader,
				packets: new Array()
			}
			console.log(document.pcapDissected);
			for (var i=0; i<this.pcap.packetsData.length; i++)
			{
				dissectedValue = dissectPacketData(this.pcap.packetsHeaders[i], this.pcap.packetsData[i]);
				document.pcapDissected['packets'][i] = dissectedValue[0]
				document.pcapDissected['packets'][i].frame = this.pcap.packetsHeaders[i];
				document.pcapDissected['packets'][i].frame.protocols = dissectedValue[1];
			}
			wiresharkDisplay(document.pcapDissected.packets);
			attachEvent();
			$('tr#0').trigger("click");
		}

		document.getElementById('pcap-file').addEventListener('change', dissectChoosenFile, false);
		document.getElementById('dissect').addEventListener('click', dissectFixedFile, false);
	});

});
