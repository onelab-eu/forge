function tvb_find_line_end(tvb, offset, len, next_offset, desegment)
{
	var eob_offset;
	var eol_offset;
	var linelen;
	var found_needle = 0;
	
	if (len == -1)
	{
		len = tvb.length
	}

	eob_offset = offset+len;

}
