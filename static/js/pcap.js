var GLOBAL_HEADER_LENGTH = 24; //bytes
var PACKET_HEADER_LENGTH = 16; //bytes


function handlePcapFile(stringData) 
{
	clearWiresharkTop();
	this.pcap = pcapDissector(stringData, false);
	document.pcapDissected = {
		header: this.pcap.globalHeader,
		packets: new Array()
	}
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

/*
	Convert packet data into an array of hexadecimal value
*/
function dataToArray(data) {
	var array = new Array();
	for(var i=0; i<data.length; i++) {
		array[i] = charCodeToHex(data.charCodeAt(i));
	}
	return array;
}

/*
	Main version that will dissect the pcap file
	pcap object description:
	- packetsHeaders -> Array of packets headers
	- packetsData -> Array of packets data
	- globalHeader -> Header of pcap file
*/
function pcapDissector(file, show) {
	show =  show || false;
	this.pcap = new Object();
	var file_index = 0;
	var packetSize;
	var packetNumber = 0;
	this.pcap.packetsHeaders = new Array();
	this.pcap.packetsData = new Array();
	readGlobalHeader(file.slice(file_index, file_index+GLOBAL_HEADER_LENGTH));
	if(show) {
		printGlobalHeader();
	}
	file_index += GLOBAL_HEADER_LENGTH;
	while(file_index<file.length) 
	{
		readPacketHeader(file.slice(file_index, file_index+PACKET_HEADER_LENGTH), packetNumber);
		if(show) {
			printPacketHeader(packetNumber);
		}
		file_index += PACKET_HEADER_LENGTH;
		readPacketData(file.slice(file_index, file_index+this.pcap.packetsHeaders[packetNumber]['cap_len']), packetNumber);
		if (show) {
			printPacketData(packetNumber)
		}
		file_index += this.pcap.packetsHeaders[packetNumber]['cap_len'];
		packetNumber += 1;
	}
	return this.pcap;
}

/*
	
*/
function readPacketData(data, packetNumber) {
	this.pcap.packetsData[packetNumber] = dataToArray(data);
}

/*
	Print the data into the web page
*/
function printPacketData(packetNumber) {
	var p = document.createElement('p');
	p.textContent = this.pcap.packetsData[packetNumber];
	document.getElementById(packetNumber).insertBefore(p, null);
}

/*
	
*/
function decodeData(data, packetNumber) {
	this.pcap.packetsData[packetNumber] = {
		ethernetHeader: ethernetHeader(data.slice(0,6))
	}
}

/*
	Print global header within the html page
*/
function printGlobalHeader() {
	document.getElementById('magicNumber').textContent = ['Magic number', this.pcap.globalHeader['magicNumber']].join(' ');
	document.getElementById('major').textContent = ['Major version', this.pcap.globalHeader['majorVersion']].join(' ');
	document.getElementById('minor').textContent = ['Minor version', this.pcap.globalHeader['minorVersion']].join(' ');
	document.getElementById('gmt').textContent = ['GMT Correction', this.pcap.globalHeader['gmtOffset']].join(' ');
	document.getElementById('accuracy').textContent = ['Timestamp Accuracy', this.pcap.globalHeader['timestampAccuracy']].join(' ');
	document.getElementById('length').textContent = ['Max length of packet', this.pcap.globalHeader['snapshotLength']].join(' ');
	document.getElementById('type').textContent = ['Data link type', this.pcap.globalHeader['linkLayerType']].join(' ');
}

/*
	Function that will read the global header.
	This header is stored in an object called
	globalHeader
*/
function readGlobalHeader(header) {
	magicNumber = strToHex(header.slice(0,4));
	if (magicNumber == "a1b2c3d4") {
		this.endianness = "BE";
	}
	else if (magicNumber == "d4c3b2a1") {
		this.endianness = "LE";
	}
	else
	{
		this.errored = true;
		msg = 'unknown magic number: '+magicNumber;
		this.error = new Error(msg);
	}
	this.pcap.globalHeader = {
		magicNumber: strToHex(header.slice(0,4)),
		majorVersion: strToInt(header.slice(4,6)),
		minorVersion: strToInt(header.slice(6,8)),
		gmtOffset: strToInt(header.slice(8,12)),
		timestampAccuracy: strToInt(header.slice(12,16)),
		snapshotLength: strToInt(header.slice(16,20)),
		linkLayerType: strToInt(header.slice(20,24)),
	};
}

/*
	Print every packet header within the html page
*/
function printPacketHeader(packetNumber) {
	var p = document.createElement('p');
	packetHeader = this.pcap.packetsHeaders[packetNumber];
	p.textContent = ['Packet', packetNumber+1, 'Timestamp', packetHeader['timestampSeconds'],
		' s ', packetHeader['timestampMicroseconds'], 'ms ---',
		packetHeader['cap_len'], 'octet saved in file,',
		'length ->', packetHeader['len']].join(' ');
	p.setAttribute('id', packetNumber);
	document.getElementById('packet').insertBefore(p, null);
}

/*
	This function build an object containing the packet header
	This object is add in an Array called packetsHeaders
*/
function readPacketHeader(header, packetNumber) {
	var timestamp = strToInt(header.slice(0,4))+(strToInt(header.slice(4,8))/Math.pow(10,6));
	if (packetNumber==0)
	{
		this.initTime = timestamp;
	}
		
	var packetHeader = {
		//TODO Fix bug with date (calculating wrong value)
		time: new Date(timestamp),
		time_epoch: timestamp,
		time_relative: timestamp-this.initTime,
		cap_len: strToInt(header.slice(8,12)),
		len: strToInt(header.slice(12,16)),
		number: packetNumber+1,
		protocols: '',
	};
	this.pcap.packetsHeaders[packetNumber] = packetHeader;
}
