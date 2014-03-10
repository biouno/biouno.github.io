---
layout: page
title: The BioUno project
---
BioUno is a project that applies Continuous Integration tools and techniques in Bioinformatics. 
It uses tools like Jenkins for creating biology workflows and to manage computer clusters.

<div class='center'>
<div id="videoplayer" style="display:none;">&nbsp;</div>
<img src="{{ site.baseurl }}assets/img/video.png" id="videoimage" width="500" />
</div>

Jenkins plug-in API is used for creating wrappers for tools like MrBayes, Structure, R and scripts 
and programs written in many different programming languages, like Perl, PHP, Ruby and Java. 
And it uses Jenkins slaves as general-purpose computing grid.

Jenkins can also be used to glue scripts and programs in your existing pipeline in Galaxy, 
Taverna, Mobyle or CloudGene. Read more about how to use Jenkins to orchestrate 
existing biology pipelines.

Check out our [blog]({{ site.baseurl }}blog.html) for the latest news about the project.

<script type='text/javascript'>

$(function() {
	$('#videoimage').click(function() {
		$('#videoplayer').show();
		$('#videoplayer').append("<iframe width='500' height='315' src='http://www.youtube.com/embed/6Dl6V249W30' frameborder='0' allowfullscreen='allowfullscreen'></iframe>");
		$('#videoimage').hide();
	});
});
</script>