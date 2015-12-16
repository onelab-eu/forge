function hexToIPv6(hexValue)
{
	if (hexValue.length == 16)
	{
		var IP = new Array();
		for (var i=0; i<hexValue.length; i+=2)
		{
			IP[i/2] = hexValue[i]+""+hexValue[i+1];
		}
		IP = IP.join(':');
	}
	else
	{
		console.log('KO');
		console.log(hexValue.length, hexValue);
	}
	return IP;
}

function dissectIPv6(ipHeader)
{
	var classObject = {
		dscp: hexToBin(ipHeader.slice(0,2).join('')).slice(4,10),
		ect: hexToBin(ipHeader.slice(0,2).join('')).slice(10,11),
		ce: hexToBin(ipHeader.slice(0,2).join('')).slice(11,12)
	}
	var ipv6 = {
		version: binToInt(hexToBin(ipHeader.slice(0,1).join('')).slice(0,4)),
		class: classObject,
		flow: hexToBin(ipHeader.slice(1,4).join('')).slice(4,25),
		plen: hexToBin(ipHeader.slice(4,6).join('')),
		nxt: hexToInt(ipHeader.slice(6,7).join('')),
		hlim: hexToInt(ipHeader.slice(7,8).join('')),
		src: hexToIPv6(ipHeader.slice(8,24)),
		dst: hexToIPv6(ipHeader.slice(24, 40))
	};
	return ipv6;
}
