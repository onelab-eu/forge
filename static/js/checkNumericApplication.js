function checkTableA()
{
	if($('#tableA #A1-1').val()=='14.629')
		$('#tableA #A1-1').addClass("correct");
	if($('#tableA #A1-2').val()=='14.829')
		$('#tableA #A1-2').addClass('correct');
	if($('#tableA #A1-3').val()=='1')
		$('#tableA #A1-3').addClass('correct');
	if($('#tableA #A1-4').val()=='14.929')
		$('#tableA #A1-4').addClass('correct');
	
	if($('#tableA #A2-1').val()=='1.600')
		$('#tableA #A2-1').addClass('correct');
	if($('#tableA #A2-2').val()=='1.800')
		$('#tableA #A2-2').addClass('correct');
	if($('#tableA #A2-3').val()=='3')
		$('#tableA #A2-3').addClass('correct');
	if($('#tableA #A2-4').val()=='2.068')
		$('#tableA #A2-4').addClass('correct');

	
	if($('#tableA #A3-1').val()=='0.102')
		$('#tableA #A3-1').addClass('correct');
	if($('#tableA #A3-2').val()=='0.302')
		$('#tableA #A3-2').addClass('correct');
	if($('#tableA #A3-3').val()=='7')
		$('#tableA #A3-3').addClass('correct');
	if($('#tableA #A3-4').val()=='0.941')
		$('#tableA #A3-4').addClass('correct');

	if($('#tableA #A4-1').val()=='0.008')
		$('#tableA #A4-1').addClass('correct');
	if($('#tableA #A4-2').val()=='0.208')
		$('#tableA #A4-2').addClass('correct');
	if($('#tableA #A4-3').val()=='11')
		$('#tableA #A4-3').addClass('correct');
	if($('#tableA #A4-4').val()=='0.900')
		$('#tableA #A4-4').addClass('correct');
}

$(document).ready(function() {
	$('#checkTableA').click(checkTableA);
});

