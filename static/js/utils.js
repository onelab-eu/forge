/*
	Function used to convert a Charcode to an hexadecimal value
	It fix the bug when this Charcode is lower than 15
*/
function charCodeToHex(charCode) {
	if (charCode<16) {
		return "0"+charCode.toString(16);
	}
	else {
		return charCode.toString(16);
	}
}

/*
	Function used to convert a string into integer value
*/
function strToInt(str) {
	var hexVal = '';
	if (this.endianness == "LE") {
		str = str.split("").reverse().join("");
	}
	for(var i=0; i<str.length; i++) {
		hexVal += charCodeToHex(str.charCodeAt(i));
	}
	var intValue = parseInt(hexVal, 16);
	return intValue;
}

/*
	Function used to convert a string into hexadecimal value
*/
function strToHex(str) {
	var hex = '';
	for(var i=0; i<str.length; i++) {
		hex += charCodeToHex(str.charCodeAt(i));
	}
	return hex;
}

/*
	Function to check if the hexadecimal value is valid
*/
function checkHex(n)
{
	return/^[0-9A-Fa-f]{1,64}$/.test(n);
}

/*
	Function to check if the binary value is valid
*/
function checkBin(n){
	return/^[01]{1,64}$/.test(n)
}

/*
	Function to check if the decimal value is valid
*/
function checkDec(n){return/^[0-9]{1,64}$/.test(n)}

/*
	Function to convert hexadecimal to binary value
*/
function hexToBin(n)
{
	if(!checkHex(n))
		return 0;
	var intValue = parseInt(n,16).toString(2);
	while (intValue.length < n.length*4)
	{
		intValue = "0"+intValue;
	}
	return intValue;
}

/*
	Function to convert hexadecimal to integer value
*/
function hexToInt(hexValue)
{
	var intValue = 0;
	for (var i=0; i<hexValue.length;i++)
	{
		intValue += parseInt(hexValue[i], 16) * Math.pow(16, hexValue.length-(i+1));
	}
	return intValue;
}

/*
	Function to convert hexadecimal array to string
*/
function hexToStr(hexValue)
{
	var str = "";
	for (var i=0; i<hexValue.length;i++)
	{
		str += String.fromCharCode("0x"+hexValue[i]);
	}
	return str;
}

/*
	Function to convert binary to integer value
*/
function binToInt(n){
	if(!checkBin(n))
		return 0;
	return parseInt(n,2).toString(10)
}

/*
	Function used to pair hexadecimal value
*/
function pairHex(hexString)
{
	var hexValidString = [];
	for(var i = 0; i < hexString.length; i+=2)
	{
		hexValidString.push(hexString[i]+hexString[i+1]);
	}
	return hexValidString;
}

/*
	Function to convert a b64 String to a blob
*/
function b64toBlob(b64Data, contentType, sliceSize)
{
	console.log(typeof b64Data);
	contentType = contentType || '';
	sliceSize = sliceSize || 512;

	var byteCharacters = atob(b64Data);
	var byteArrays = [];

	for (var offset = 0; offset < byteCharacters.length; offset += sliceSize)
	{
		var slice = byteCharacters.slice(offset, offset + sliceSize);

		var byteNumbers = new Array(slice.length);
		for (var i = 0; i < slice.length; i++)
		{
			byteNumbers[i] = slicecharCodeAt(i);
		}

		var byteArray = new Uint8Array(byteNumbers);

		byteArrays.push(byteArray);
	}

	var blob = new Blob(byteArrays, { type: contentType});
	return blob;
}
