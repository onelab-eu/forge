var PACKET_DATA_HEADER_LENGTH = 14; //bytes

function ethernetHeader(header) {
	var dstObject = {
		addr: header.slice(0,6).join(":"),
		lg: hexToBin(header.slice(0,2).join(''))[6],
		ig: hexToBin(header.slice(0,2).join(''))[7],
	}
	var srcObject = {
		addr: header.slice(6, 12).join(":"),
		lg: hexToBin(header.slice(6,9).join(''))[6],
		ig: hexToBin(header.slice(6,9).join(''))[7],
	}
	var eth = {
		dst: dstObject,
		src: srcObject,
		type: header.slice(12,14).join('')
	};
	return eth;
}

var INITIAL_SEQUENCE_NUMBER = 0

function dissectPacketData(frame, data) {
	var packet = {};
	packet.eth = ethernetHeader(data.splice(0,14));
	protocols = 'eth';
	if (hexToInt(packet.eth['type']) > 1500)
	{
		switch (packet.eth['type'])
		{
			case "0800":
				packet.ip = dissectIPv4(data.splice(0, 20));
				dataLength = packet.ip.totalLength - packet.ip.headerLength;
				proto = packet.ip.proto;
				protocols += ':ip';
				break;
			case "86dd":
				packet.ipv6 = dissectIPv6(data.splice(0,40));
				dataLength = packet.ipv6.plen;
				proto = packet.ipv6.nxt;
				protocols +=':ipv6';
				break;
		}
		switch (proto)
		{
			case 6:
				var result = dissectTCP(INITIAL_SEQUENCE_NUMBER, data.splice(0, 20));
				INITIAL_SEQUENCE_NUMBER = result[0];
				packet.tcp = result[1];

				packet.tcp.options = dissectTCPOptions(data.splice(0, packet.tcp.hdr_len - 20));
				protocols += ':tcp';
				dstport = packet.tcp.dstport;
				srcport = packet.tcp.srcport;
				break;
			case 17:
				packet.udp = dissectUDP(data.splice(0, dataLength));
				protocols += ':udp';
				dstport = packet.udp.dstport;
				srcport = packet.udp.srcport;
				break;
			default:
				console.log(proto);
				console.log("Protocol not recognize");
		}
		http_port = [80, 8080, 8081, 8082, 8083];
		if ((http_port.indexOf(srcport) != -1 || http_port.indexOf(dstport) != -1) && data.length > 0)
		{
			protocols += ':http';
			packet.http = dissect_http_message(frame, data);
		}
	}
	else
	{
		var packet = {
			eth: ethHeader
		};
	}
	return [packet, protocols];
}
