/* --- HTTP Status Codes */
/* Note: The reference for uncommented entries is RFC 2616 */
/*
static const value_string vals_status_code[] = {
	{ 100, "Continue" },
	{ 101, "Switching Protocols" },
	{ 102, "Processing" },                     // RFC 2518
	{ 199, "Informational - Others" },

	{ 200, "OK"},
	{ 201, "Created"},
	{ 202, "Accepted"},
	{ 203, "Non-authoritative Information"},
	{ 204, "No Content"},
	{ 205, "Reset Content"},
	{ 206, "Partial Content"},
	{ 207, "Multi-Status"},                    // RFC 4918
	{ 226, "IM Used"},                         // RFC 3229
	{ 299, "Success - Others"},

	{ 300, "Multiple Choices"},
	{ 301, "Moved Permanently"},
	{ 302, "Found"},
	{ 303, "See Other"},
	{ 304, "Not Modified"},
	{ 305, "Use Proxy"},
	{ 307, "Temporary Redirect"},
	{ 399, "Redirection - Others"},

	{ 400, "Bad Request"},
	{ 401, "Unauthorized"},
	{ 402, "Payment Required"},
	{ 403, "Forbidden"},
	{ 404, "Not Found"},
	{ 405, "Method Not Allowed"},
	{ 406, "Not Acceptable"},
	{ 407, "Proxy Authentication Required"},
	{ 408, "Request Time-out"},
	{ 409, "Conflict"},
	{ 410, "Gone"},
	{ 411, "Length Required"},
	{ 412, "Precondition Failed"},
	{ 413, "Request Entity Too Large"},
	{ 414, "Request-URI Too Long"},
	{ 415, "Unsupported Media Type"},
	{ 416, "Requested Range Not Satisfiable"},
	{ 417, "Expectation Failed"},
	{ 418, "I'm a teapot"},                    // RFC 2324
	{ 422, "Unprocessable Entity"},            // RFC 4918
	{ 423, "Locked"},                          // RFC 4918
	{ 424, "Failed Dependency"},               // RFC 4918
	{ 426, "Upgrade Required"},                // RFC 2817
	{ 428, "Precondition Required"},           // RFC 6585
	{ 429, "Too Many Requests"},               // RFC 6585
	{ 431, "Request Header Fields Too Large"}, // RFC 6585
	{ 499, "Client Error - Others"},

	{ 500, "Internal Server Error"},
	{ 501, "Not Implemented"},
	{ 502, "Bad Gateway"},
	{ 503, "Service Unavailable"},
	{ 504, "Gateway Time-out"},
	{ 505, "HTTP Version not supported"},
	{ 507, "Insufficient Storage"},            // RFC 4918
	{ 511, "Network Authentication Required"}, // RFC 6585
	{ 599, "Server Error - Others"},

	{ 0, 	NULL}
};
*/


function strncmp(data, valueToCompare, lengthToCompare)
{
	if(!lengthToCompare)
	{
		var lengthToCompare = data.length;
	}
	var string = '';
	for( var i = 0; i<lengthToCompare; i++)
	{
		string += String.fromCharCode('0x'+data[i]);
	}
	return (string == valueToCompare);
}

function is_http_request_or_reply(data)
{
	var isHttpRequestOrReply = false;
	var linelen = data.length;
	var type = ''; // variable for http type
	/*
		RFC 2774 - An HTTP Extension Framework
	*/
	if(linelen >= 2 && strncmp(data, "M-", 2))
	{
		data += 2;
		linelen -= 2;
	}

	if(linelen >= 5 && strncmp(data, "HTTP/1.1", 8))
	{
		indx = 8;
		type = 'HTTP_RESPONSE';
		isHttpRequestOrReply = true;
	}
	else
	{
		var indx = 0;
		while(indx < linelen)
		{
			if(String.fromCharCode('0x'+data[indx]) == ' ')
			{
				break;
			}
			else
			{
				indx++;
			}
		}
		switch (indx)
		{
			case 3:
				if (strncmp(data, "GET", indx) ||
					strncmp(data, "PUT", indx))
				{
						type = 'HTTP_REQUEST';
						isHttpRequestOrReply = true;
				}
				else if (strncmp(data, "ICY", indx))
				{
						type = 'HTTP_RESPONSE';
						isHttpRequestOrReply = true;
				}
				break;

			case 4:
				if (strncmp(data, "COPY", indx) |
					strncmp(data, "HEAD", indx) ||
					strncmp(data, "LOCK", indx) ||
					strncmp(data, "MOVE", indx) ||
					strncmp(data, "POLL", indx) ||
					strncmp(data, "POST", indx))
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				break;

			case 5:
				if (strncmp(data, "BCOPY", indx) == 0 ||
					strncmp(data, "BMOVE", indx) == 0 ||
					strncmp(data, "MKCOL", indx) == 0 ||
					strncmp(data, "TRACE", indx) == 0 ||
					strncmp(data, "LABEL", indx) == 0 ||  /* RFC 3253 8.2 */
					strncmp(data, "MERGE", indx) == 0)    /* RFC 3253 11.2 */
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				break;

			case 6:
				if (strncmp(data, "DELETE", indx) == 0 ||
					strncmp(data, "SEARCH", indx) == 0 ||
					strncmp(data, "UNLOCK", indx) == 0 ||
					strncmp(data, "REPORT", indx) == 0 || /* RFC 3253 3.6 */
					strncmp(data, "UPDATE", indx) == 0)   /* RFC 3253 7.1 */
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				else if (strncmp(data, "NOTIFY", indx) == 0)
				{
					type = "HTTP_NOTIFICATION";
					isHttpRequestOrReply = true;
				}
				break;
				
			case 7:
				if (strncmp(data, "BDELETE", indx) == 0 ||
				    strncmp(data, "CONNECT", indx) == 0 ||
				    strncmp(data, "OPTIONS", indx) == 0 ||
			    	strncmp(data, "CHECKIN", indx) == 0)  /* RFC 3253 4.4, 9.4 */
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				break;

			case 8:
				if (strncmp(data, "PROPFIND", indx) == 0 ||
				    strncmp(data, "CHECKOUT", indx) == 0 || /* RFC 3253 4.3, 9.3 */
				    strncmp(data, "CCM_POST", indx) == 0)
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				break;

			case 9:
				if (strncmp(data, "SUBSCRIBE", indx) == 0)
				{
					type = "HTTP_NOTIFICATION";
					isHttpRequestOrReply = true;
				} 
				else if (strncmp(data, "PROPPATCH", indx) == 0 ||
					    strncmp(data, "BPROPFIND", indx) == 0)
				{
					type = "HTTP_REQUEST";
					isHttpRequestOrReply = true;
				}
				break;

			case 10:
				if (strncmp(data, "BPROPPATCH", indx) == 0 ||
					strncmp(data, "UNCHECKOUT", indx) == 0 ||  /* RFC 3253 4.5 */
					strncmp(data, "MKACTIVITY", indx) == 0)    /* RFC 3253 13.5 */
				{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
				}
				break;

			case 11:
				if (strncmp(data, "MKWORKSPACE", indx) == 0 || /* RFC 3253 6.3 */
				    strncmp(data, "RPC_CONNECT", indx) == 0 || /* [MS-RPCH] 2.1.1.1.1 */
				    strncmp(data, "RPC_IN_DATA", indx) == 0)   /* [MS-RPCH] 2.1.2.1.1 */
					{
						type = "HTTP_REQUEST";
						isHttpRequestOrReply = true;
					} 
					else if (strncmp(data, "UNSUBSCRIBE", indx) == 0)
					{
						type = "HTTP_NOTIFICATION";
						isHttpRequestOrReply = true;
					}
					break;

			case 12:
				if (strncmp(data, "RPC_OUT_DATA", indx) == 0)  /* [MS-RPCH] 2.1.2.1.2 */
				{
					type = "HTTP_REQUEST";
					isHttpRequestOrReply = true;
				}
				break;

			case 15:
				if (strncmp(data, "VERSION-CONTROL", indx) == 0)  /* RFC 3253 3.5 */
				{
					type = "HTTP_REQUEST";
					isHttpRequestOrReply = true;
				}
				break;

			case 16:
				if (strncmp(data, "BASELINE-CONTROL", indx) == 0)  /* RFC 3253 12.6 */
				{
					type = "HTTP_REQUEST";
					isHttpRequestOrReply = true;
				}
				break;

			default:
				break;
		}
	}
	return [type, isHttpRequestOrReply, indx];
}

function dissect_http_message(packetFrame, data)
{
	result = is_http_request_or_reply(data);
	var http_object = new Object()
	switch (result[0])
	{
		case "HTTP_REQUEST":
			if(strncmp(data,"GET", 3))
			{
				http_object = dissect_get(data);
			}
			break
		case "HTTP_RESPONSE":
			if(strncmp(data, "HTTP/1.1", 8))
			{
				http_object = dissect_response(data);
			}
			break;
	}
	return http_object;
}

function dissect_response(data)
{
	responseObject = new Object();
	responseObject.request = new Object();
	responseObject.response = new Object();
	stringData = hexToStr(data);
	responseString = stringData.split(String.fromCharCode("0x0d")+String.fromCharCode("0x0a"));
	requestString = responseString.shift().split(String.fromCharCode("0x20"));
	responseObject.request.version = requestString[0];
	responseObject.response.code = requestString[1];
	responseObject.response.phrase = requestString[2];
	while(responseString.length > 0 && responseString[0] != "")
	{
		var newString = responseString.shift()
		newString = newString.split(String.fromCharCode("0x3a")+String.fromCharCode("0x20"));
		responseObject[newString[0]] = newString[1];
	}
	responseObject.data = responseString[1];
	return responseObject;
}

function dissect_get(data)
{
	getObject = new Object();
	request = new Object()
	getObject.request = request;
	stringData = hexToStr(data);
	/*
		Dissect the get object
	*/
	getString = stringData.split(String.fromCharCode("0x0d")+String.fromCharCode("0x0a"));
	requestString = getString.shift().split(String.fromCharCode("0x20"));
	request.method = requestString[0];
	request.uri = requestString[1];
	request.version = requestString[2];
	while(getString.length > 0 && getString[0] != '')
	{
		var newString = getString.shift();
		newString = newString.split(String.fromCharCode("0x3a")+String.fromCharCode("0x20"));
		getObject[newString[0]] = newString[1];
	}
	return getObject;
}

function print_http(http)
{
	var httpDom = addDomElement('li', 'Hypertext Transfer Protocol');
	var httpList = $(document.createElement('ul'));
	httpDom.append(httpList);
	httpList.hide();
	if(typeof http.request != "undefined" && http.request.method =='GET')
	{
		getDom = addDomElement('li', http.request.method+' '+http.request.uri+' '+http.request.version)
		getList = $(document.createElement('ul'));
		getList.append(addDomElement('li', 'Request Method: '+http.request.method));
		getList.append(addDomElement('li', 'Request URI: '+http.request.uri));
		getList.append(addDomElement('li', 'Request Version: '+http.request.version));
		getDom.append(getList);
		httpList.append(getDom)
	}
	for (var k in http)
	{
		if(http.hasOwnProperty(k) && k!='request' && k!='data')
		{
			httpList.append(addDomElement('li', k+': '+http[k]));
		}
	}
	return httpDom;
}

function print_data(data)
{
	var dataDom = addDomElement('li', 'Line-based text data: text/html');
	var dataList = $(document.createElement('ul'));
	dataList.hide()
	dataDom.append(dataList);
	dataList.append(addDomElement('li', data));
	return dataDom;
}
	/**
		http_req_res_t
		{
			int number
			int req_framenum
			int res_framenum
			int req_ts
			http_req_res_t *next
			http_req_res_t *prev
		}
		http_conv_t
		{
			guint response_code
			char *http_host
			char *request_method
			char *request_uri
			int upgrade
			int startframe
		}
		http header
		{
			char content_type
			char content_type_parameters
			boolean have_content_length
			int64 content_length
			char content_encoding
			char transfer_encoding
			int8 upgrade
		}
	**/
	/**
		http type
		{
			HTTP_REQUEST
			HTTP_RESPONSE
			HTTP_NOTIFICATION
			HTTP_OTHERS
		}
	**/
