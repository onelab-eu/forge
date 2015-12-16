function attachEvent()
{
	$('table#wiresharkTop > tbody > tr').click(function() 
	{
		detailPacket($(this), document.pcapDissected['packets']);
		$.each($('li:has(ul)'), function(index, value)
		{
			$(value).dblclick(function(e) 
			{
				e.stopPropagation(); // Avoid problem with list inclusion
				$(this).children().toggle();
			});
		});
	});
}

function clearWiresharkTop()
{
	$('table#wiresharkTop > tbody > tr').each(function() 
	{
		this.remove();
	});
}

function addDomElement(nodeType, content)
{
	var node = $(document.createElement(nodeType));
	node.append(document.createTextNode(content));
	return node;
}

function detailTCP(tcp)
{
	var tcpDom = addDomElement('li', 'Transmission Control Protocol, Src Port: '+tcp.srcport+', Dst Port: '+tcp.dstport+', Seq: '+tcp.seq);
	var tcpList = $(document.createElement('ul'));
	tcpList.hide();
	tcpList.append(addDomElement('li', 'Source port: '+tcp.srcport));
	tcpList.append(addDomElement('li', 'Destination port: '+tcp.dstport));
	tcpList.append(addDomElement('li', 'Sequence number: '+tcp.seq+' (relative sequence number)'));
	tcpList.append(addDomElement('li', 'Acknowledgement number: '+tcp.ack+' (relative ack number)'));
	tcpList.append(addDomElement('li', 'Header length: '+tcp.hdr_len+' bytes'));
	var flagsValue = '';
	if(tcp.flags.fin == 1)
		flagsValue = 'FIN'
	if(tcp.flags.syn == 1)
		flagsValue.length == 0 ? flagsValue='SYN' : flagsValue+= ', SYN';
	if(tcp.flags.reset == 1)
		flagsValue.length == 0 ? flagsValue='RST' : flagsValue+= ', RST';
	if(tcp.flags.push == 1)
		flagsValue.length == 0 ? flagsValue='PSH' : flagsValue+= ',PSH';
	if(tcp.flags.ack == 1)
		flagsValue.length == 0 ? flagsValue='ACK' : flagsValue+= ', ACK';
	if(tcp.flags.urg == 1)
		flagsValue.length == 0 ? flagsValue='URG' : flagsValue+= ', URG';
	if(tcp.flags.ecn == 1)
		flagsValue.length == 0 ? flagsValue='ECN' : flagsValue+= ', ECN';
	if(tcp.flags.cwr == 1)
		flagsValue.length == 0 ? flagsValue='CWR' : flagsValue+= ', CWR';
	if(tcp.flags.ns == 1)
		flagsValue.length == 0 ? flagsValue='NS' : flagsValue+= ', NS';
	if(tcp.flags.res == 1)
		flagsValue.length == 0 ? flagsValue='RES' : flagsValue+= ', RES';
	var flags = addDomElement('li', 'Flags: 0x'+binToInt(tcp.flags.res+tcp.flags.ns)+binToInt(tcp.flags.cwr+tcp.flags.ecn+tcp.flags.urg+tcp.flags.ack)+binToInt(tcp.flags.push+tcp.flags.reset+tcp.flags.syn+tcp.flags.fin)+(flagsValue.length == 0 ? '' : '  ('+flagsValue+')'));
	var flagsList = $(document.createElement('ul'));
	flagsList.append(addDomElement('li', tcp.flags.res+'. .... .... = Reserved: '+(parseInt(tcp.flags.res) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '...'+tcp.flags.ns+' .... .... = Nonce: '+(parseInt(tcp.flags.ns) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... '+tcp.flags.cwr+'... .... = Congestion Window Reduced (CWR): '+(parseInt(tcp.flags.cwr) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... .'+tcp.flags.ecn+'.. .... = ECN-Echo: '+(parseInt(tcp.flags.ecn) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... ..'+tcp.flags.urg+'. .... = Urgent: '+(parseInt(tcp.flags.urg) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... ...'+tcp.flags.ack+' .... = Acknowledgement: '+(parseInt(tcp.flags.ack) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... .... '+tcp.flags.push+'... = Push: '+(parseInt(tcp.flags.push) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... .... .'+tcp.flags.reset+'.. = Reset: '+(parseInt(tcp.flags.reset) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... .... ..'+tcp.flags.syn+'. = Syn: '+(parseInt(tcp.flags.syn) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.... .... ...'+tcp.flags.fin+' = Fin: '+(parseInt(tcp.flags.fin) ? 'Set' : 'Not set')));
	flags.append(flagsList);
	tcpList.append(flags);
	tcpList.append(addDomElement('li', 'Window size value: '+tcp.window_size_value));
	tcpDom.append(tcpList);
	return tcpDom;
}

function detailIPv4(ip)
{
	var ipv4 = addDomElement('li', 'Internet Protocol Version 4, Src: '+ip.src+', Dst: '+ip.dst);
	var ipv4List = $(document.createElement('ul'));
	ipv4List.hide();
	ipv4List.append(addDomElement('li', 'Version: '+ip.version));
	ipv4List.append(addDomElement('li', 'Header length: '+ip.hdr_len+' bytes'));
	
	var dsfield = addDomElement('li', 'Differentiated Services Field: (DSCP 0x'+ip.dsfield.dscp+' ECN: 0x'+ip.dsfield.ecn);
	var dsfieldList = $(document.createElement('lu'));
	dsfieldList.append(addDomElement('li', '0000 '+ip.dsfield.dscp+'.. = Differentiated Services Codepoint: Default (0x00)'));
	dsfieldList.append(addDomElement('li', '.... ..'+ip.dsfield.ecn+' = Explicit Congestion Notification: Not-ECN (Not ECN-Capable Transport) (0x'+ip.dsfield.ecn+')'));
	dsfield.append(dsfieldList);
	ipv4List.append(dsfield);
	
	ipv4List.append(addDomElement('li', 'Total Length: '+ip.len));
	ipv4List.append(addDomElement('li', 'Identification: 0x'+ip.id));
	
	var flags = addDomElement('li', 'Flags: 0x0'+(parseInt(ip.flags.rb)*4+parseInt(ip.flags.df)*2+parseInt(ip.flags.mf)));
	var flagsList = $(document.createElement('ul'));
	flagsList.append(addDomElement('li', ip.flags.rb+'... .... = Reserved bit: '+(parseInt(ip.flags.rb) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '.'+ip.flags.df+'.. .... = Don\'t fragment: '+(parseInt(ip.flags.df) ? 'Set' : 'Not set')));
	flagsList.append(addDomElement('li', '..'+ip.flags.rb+'. .... = More  fragments: '+(parseInt(ip.flags.rb) ? 'Set' : 'Not set')));
	flags.append(flagsList);
	ipv4List.append(flags);
	
	ipv4List.append(addDomElement('li', 'Fragment offset: '+ip.frag_offset));
	ipv4List.append(addDomElement('li', 'Time to live: '+ip.ttl));
	ipv4List.append(addDomElement('li', 'Protocol: '+ip.proto));
	ipv4List.append(addDomElement('li', 'Header checksum: 0x'+ip.checksum));
	ipv4List.append(addDomElement('li', 'Source: '+ip.src));
	ipv4List.append(addDomElement('li', 'Destination: '+ip.dst));
	ipv4.append(ipv4List);
	return ipv4
}

function detailEthernet(eth)
{
	//Ethernet details
	var ethDom = addDomElement('li', 'Ethernet II, Src:'+packet.eth.src.addr+', Dst:'+eth.dst.addr);
	var ethDomList = $(document.createElement('ul'));
	ethDomList.hide();
	var ethDst = addDomElement('li', 'Destination: '+eth.dst.addr);
	var ethDstList = $(document.createElement('ul'));
	ethDstList.append(addDomElement('li', 'Address: ('+eth.dst.addr+')'));
	ethDstList.append(addDomElement('li', '.... ..'+eth.dst.lg+'. .... .... .... .... = LG Bit: Globally unique address (factory default)'));
	ethDstList.append(addDomElement('li', '.... ...'+eth.dst.ig+' .... .... .... .... = IG Bit: Individual address (unicast)'));
	ethDst.append(ethDstList);
	ethDomList.append(ethDst);
	var ethSrc = addDomElement('li', 'Source: '+eth.src.addr);
	var ethSrcList = $(document.createElement('ul'));
	ethSrcList.append((addDomElement('li', 'Address: ('+eth.src.addr+')')));
	ethSrcList.append(addDomElement('li', '.... ..'+eth.src.lg+'. .... .... .... .... = LG Bit: Globally unique address (factory default)'));
	ethSrcList.append(addDomElement('li', '.... ...'+eth.src.ig+' .... .... .... .... = IG Bit: Individual address (unicast)'));
	ethSrc.append(ethSrcList);
	ethDomList.append(ethSrc);
	ethDomList.append(addDomElement('li', 'Type: '+eth.type));
	ethDom.append(ethDomList);
	return ethDom;
}

function detailFrame(frame)
{
	// Frame details
	var frameDom = addDomElement('li', 'Frame '+frame.number+': '+frame.len+' bytes on wire ('+frame.len*8+' bits), '+frame.cap_len+' bytes captured ('+frame.cap_len*8+' bits)');
	var frameList = $(document.createElement('ul'));
	frameList.hide();
	frameList.append(addDomElement('li', 'Arrival time: '+frame.time));
	frameList.append(addDomElement('li', 'Epoch time: '+frame.time_epoch));
	frameList.append(addDomElement('li', '[Time since reference of first frame: '+packet.frame.time_relative+' seconds]'));
	frameList.append(addDomElement('li', 'Frame number: '+packet.frame.number));
	frameList.append(addDomElement('li', 'Frame length: '+packet.frame.len));
	frameList.append(addDomElement('li', 'Capture length: '+packet.frame.cap_len));
	frameList.append(addDomElement('li', '[Protocols in frame: '+packet.frame.protocols+']'));
	frameDom.append(frameList);
	return frameDom;
}

function detailPacket(clickedRow, pcap)
{
	//Clear wireshark bottom display
	$('#wiresharkMiddle').empty();
	$('#wiresharkTop > tbody > tr').each(function() {
		if($(this).hasClass('clicked'))
		{
			$(this).removeClass('clicked');
		}
	});
	
	clickedRow.addClass('clicked');
	packet = pcap[clickedRow.attr('id')];
	protocolsList = packet.frame.protocols.split(':');
	$('#wiresharkMiddle').append(detailFrame(packet.frame));
	for(var i=0; i<protocolsList.length; i++)
	{
		switch(protocolsList[i])
		{
			case 'eth':
				$('#wiresharkMiddle').append(detailEthernet(packet.eth));
				break;
			case 'ip':
				$('#wiresharkMiddle').append(detailIPv4(packet.ip));
				break;
			case "ipv6":
				proto = packet.ipv6.nxt;
			case 'tcp':
				$('#wiresharkMiddle').append(detailTCP(packet.tcp));
				break
			case 'udp':
				break;
			case 'http':
				$('#wiresharkMiddle').append(print_http(packet.http));
				if(typeof packet.http.data != "undefined")
				{
					$('#wiresharkMiddle').append(print_data(packet.http.data));
				}
				break;
		}
	}
}

function wiresharkDisplay(pcapObject)
{
	var tbody = $('#wiresharkTop');
	for( var i = 0; i<pcapObject.length; i++)
	{
		packet = pcapObject[i];
		var row = $(document.createElement('tr'));
		if (i==0)
		{
			//row.addClass('clicked');
		}
		row.attr('id', i);

		// Number of the packet
		var number = $(document.createElement('td'));
		number.className = "packetNumber";
		number.append(document.createTextNode(packet.frame.number));
		row.append(number);
		// Time of the packet capture
		var time = $(document.createElement('td'));
		time.className = "packetTimestamp";
		time.append(document.createTextNode(packet.frame.time_relative.toFixed(6)));
		row.append(time);
		// Source of the packet
		var srcValue = '', dstValue = '', protoNumber = 0;
		switch (packet.eth.type)
		{
			case '0800':
				srcValue = packet.ip.src;
				dstValue = packet.ip.dst;
				protoNumber = packet.ip.proto;
				break;
			case '86dd':
				srcValue = packet.ipv6.src;
				dstValue = packet.ipv6.dst;
				protoNumber = packet.ipv6.nxt;
				break;
		}
		var src = $(document.createElement('td'));
		src.className = "sourceAddress";
		src.append(document.createTextNode(srcValue));
		row.append(src);
		// Destination of the packet
		var dst = $(document.createElement('td'));
		dst.className = "destinationAddress";
		dst.append(document.createTextNode(dstValue));
		row.append(dst);
		// Protocol
		var proto = $(document.createElement('td'));
		proto.className = "protocol"
		proto.append(document.createTextNode(protoNumber));
		row.append(proto);
		// Length
		var len = $(document.createElement('td'));
		len.className = "packetLength"
		len.append(document.createTextNode(packet.frame.cap_len));
		row.append(len);
		// Info 
		var info = $(document.createElement('td'));
		info.className = "packetInfo"
		info.append(document.createTextNode(''));
		row.append(info);
		// Append the row to the table
		$(tbody).append(row);
	}
}
