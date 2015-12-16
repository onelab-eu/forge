function dissectTCP(initialSequenceNumber, tcpData)
{
	binFlags = hexToBin(tcpData.slice(12,14).join('')).slice(4,16);
	var flagsObject = {
		res: binFlags.slice(0,3),
		ns: binFlags.slice(3,4),
		cwr: binFlags.slice(4,5),
		ecn: binFlags.slice(5,6),
		urg: binFlags.slice(6,7),
		ack: binFlags.slice(7,8),
		push: binFlags.slice(8,9),
		reset: binFlags.slice(9,10),
		syn: binFlags.slice(10,11),
		fin: binFlags.slice(11,12)
	}
	var tcp = {
		srcport: hexToInt(tcpData.slice(0,2).join('')),
		dstport: hexToInt(tcpData.slice(2,4).join('')),
		seq: hexToInt(tcpData.slice(4, 8).join('')),
		ack: hexToInt(tcpData.slice(8,12).join('')),
		hdr_len: hexToInt(tcpData.slice(12,13).join(''))/4,
		flags: flagsObject,
		window_size_value: hexToInt(tcpData.slice(14,16).join('')),
		checksum: tcpData.slice(16,18).join(''),
		options: new Array()
	}
	if(initialSequenceNumber == 0)
	{
		initialSequenceNumber = tcp.seq;
		tcp.seq = 0;
	}
	else
	{
		tcp.seq = tcp.seq - initialSequenceNumber;
		tcp.ack = tcp.ack - initialSequenceNumber;
	}
	return [initialSequenceNumber, tcp];
}

function dissectTCPOptions(optionsData)
{
	var options = new Array();
	var i = 0;
	while (optionsData.length>0)
	{
		var option = new Object();
		option.kind = hexToInt(optionsData.splice(0,1).join(''));
		if (option.kind!=1)
		{
			option.len = hexToInt(optionsData.splice(0,1).join(''));
		}
		switch (option.kind)
		{
			case 0: //EOL
				break;
			case 1: //NOP
				break;
			case 2: //MSS
				option.mss_val = hexToInt(optionsData.splice(0,2).join(''));
				break;
			case 3: //WSCALE
				option.wscale = {
					shift: optionsData.splice(0,1),
					multiplier: 64
				};
				break;
			case 4: //SACKOK
				break;
			case 5: //SACK
				break;
			case 6: //Echo
				break;
			case 7: //EchoReply
				break;
			case 8: //TimeStamp
				option.timestamp = {
					tsval: hexToInt(optionsData.splice(0,4).join('')),
					tsecr: hexToInt(optionsData.splice(0,4).join(''))
				};
				break;
			case 9: //CC
				break;
			case 10: //CCNew
				break;
			case 11: //CCEcho
				break;
			case 12: //md5
				break;
			case 13: //Enhanced Auth
				break;
			case 14: //UTO
				break;
			case 15: //MPTCP
				break;
			case 16: //EXP
				break;
		}
		options.push(option);
	}
	return options;
}

function dissectUDP(udpData)
{
	var udp = {
		srcport: hexToInt(udpData.slice(0,2).join('')),
		dstport: hexToInt(udpData.slice(2,4).join('')),
		length: hexToInt(udpData.slice(4,6).join('')),
		checksum: udpData.slice(6,8).join('')
	};
	return udp;
}
