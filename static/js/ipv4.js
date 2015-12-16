function hexToIPv4(hexValue)
{
	if (hexValue.length == 4)
	{
		var IP = new Array();
		for (var i=0; i<hexValue.length; i++)
		{
			IP[i] = parseInt(hexValue[i], 16);
		}
		IP = IP.join('.')
	}
	else
	{
		console.log('KO');
		console.log(hexValue.length, hexValue);
	}
	return IP;
}

function dissectIPv4(ipHeader)
{
	var dsfieldObject = {
		dscp: hexToBin(ipHeader.slice(1,2).join('')).slice(4,6),
		ecn: hexToBin(ipHeader.slice(1,2).join('')).slice(6,8)
	}
	var flagsObject = {
		rb: hexToBin(ipHeader.slice(6,7).join(''))[0],
		df: hexToBin(ipHeader.slice(6,7).join(''))[1],
		mf: hexToBin(ipHeader.slice(6,7).join(''))[2]
	}
	var ipHeaderObject = {
		version: 4,
		hdr_len: 20,
		dsfield: dsfieldObject,
		len: hexToInt(ipHeader.slice(2,4).join('')),
		id: ipHeader.slice(4,6).join(''),
		flags: flagsObject,
		ttl: hexToInt(ipHeader.slice(8,9)),
		proto: hexToInt(ipHeader.slice(9,10)),
		checksum: ipHeader.slice(10,13).join(''),
		src: hexToIPv4(ipHeader.slice(12,16)),
		dst: hexToIPv4(ipHeader.slice(16,20))
	}
	return ipHeaderObject;
}
