---
layout: page
title: Running Structure in parallel using Jenkins slaves
---

<p>
	Jenkins will be responsible for spawning **multiple builds per K**. It 
	expects you to provide value mainparams and extraparams files. You can 
	also use an extra job to collect the output and call other programs 
	(e.g.: structure harvester).
</p>

<p>
	<strong>TL;DR</strong>
</p>

<div class='center'>
<div id="videoplayer" style="display:none;">&nbsp;</div>
<img src="{{ site.baseurl }}assets/img/video2.png" id="videoimage" width="500" />
</div>

<p>
	In order to use this plug-in, you'll need Structure version 2.3.4 or 
	superior. The GUI version won't work, so grab the version without 
	front end. 
</p>

<p>
	Now go to the main configuration page in Jenkins and add an Structure installation.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_001.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_001.png">
	</a>
</p>

<p>
	After this you can create a job in Jenkins to run Structure. A simple 
	FreeStyle job is enough to run Structure in a single machine (local or 
	remotely). But for running Structure in parallel accross many nodes, 
	you'll need a Multi-configuration job. Give it any name. We are using 
	the <a href="http://bodegaphylo.wikispot.org/Structure">Bodega 
	tutorial on Structure</a> data as example.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_002.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_002.png">
	</a>
</p>

<p>
	You will have to add an axis to your project. Name it K and add the 
	desired values separated by space. Now add a build step to invoke 
	Structure, and select the right installation.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_003.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_003.png">
	</a>
</p>

<p>
	Enter <strong>${K}</strong> as the K value. This will be replaced 
	by each value of K. You can enter the remaining parameters as 
	necessary for your work. Finally, add the <strong>mainparam</strong> 
	and <strong>extraparam</strong> files contents.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_004.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_004.png">
	</a>
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_005.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_005.png">
	</a>
</p>

<p>
	If you want to gather all the output files of your execution, add 
	a post build action to archive the artifacts of your build. And 
	if you have other jobs to run afterwards, just add them in the 
	post build actions section too.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_006.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_006.png">
	</a>
</p>

<h3>Running your job</h3>

<p>
	Click Build to trigger your job execution. You will notice in the 
	console log that several sub-executions were triggered. One for 
	each axis value. That's how Jenkins multi-configuration jobs work.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_007.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_007.png">
	</a>
</p>

<p>
	You can click in the axis values to open the sub-execution console 
	log and see what is going on or what happened during this axis 
	execution.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_008.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_008.png">
	</a>
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_009.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_009.png">
	</a>
</p>

<p>
	Once the job is finished, you'll be able to see the final results, 
	access the console log again at any time, and download the build 
	artifacts - which in our case are the Structure output files. 
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_010.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_010.png">
	</a>
</p>

<p>
	Furthermore, later you can compare your job total execution time 
	after a few builds have completed. This is useful specially if you 
	are responsible for tuning or managing large number of jobs.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_011.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_011.png">
	</a>
</p>

<h3>Extra: aggregating output files into a single Zip file</h3>

<p>
	The screen shots below contain information on how to create a job 
	that can be triggered by the job you created in this tutorial to 
	collect the output files and produce a single Zip file per build 
	in Jenkins.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_012.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_012.png">
	</a>
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_013.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_013.png">
	</a>
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_structure_014.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_structure_014.png">
	</a>
</p>

<script type='text/javascript'>

$(function() {
	$('#videoimage').click(function() {
		$('#videoplayer').show();
		$('#videoplayer').append("<iframe width='500' height='315' src='http://www.youtube.com/embed/4xZh6xxiTv4' frameborder='0' allowfullscreen='allowfullscreen'></iframe>");
		$('#videoimage').hide();
	});
});

</script>
