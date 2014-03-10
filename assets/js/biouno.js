$(function() {
	$('#videoimage').click(function() {
		$('#videoplayer').show();
		$('#videoplayer').append('<iframe width="500" height="315" src="http://www.youtube.com/embed/6Dl6V249W30" frameborder="0" allowfullscreen></iframe>');
		$('#videoimage').hide();
	});
});
