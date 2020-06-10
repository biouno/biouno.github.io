---
layout: single
title: Plotting graphs and creating image galleries
---

<p>
	There are many R modules that can be very useful for plotting your data, especially in bioinformatics. A 
	common necessity, is that you make your R scripts reproducible and publish your graphs in some standard way.
</p>

<p>
	With this thought in mind, we proposed an R plug-in + Image Gallery Plug-in pipeline. With the former you can 
	create an interface for R scripts and, using the latter, you can create image galleries in Jenkins for 
	displaying your graphs to other users.
</p>

<p>
    You can create many different types of galleries. Some of these galleries may use patterns to look for 
    images in your job workspace.
</p>

<p class="center">
	<a href="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_001.png">
		<img src="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_001.png">
	</a>
</p>

<p>
	The image galleries give you a simpler interface for showing your graphs to other users, as well as for 
	yourself to analyze the results of your analysis.
</p>

<p class="center">
	<a href="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_002.png">
		<img src="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_002.png">
	</a>
</p>

<p class="center">
	<a href="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_003.png">
		<img src="{{ site.url }}/assets/img/tutorials/plotting-graphs-and-creating-image-galleries/screenshot_ig_003.png">
	</a>
</p>

<hr>

<p>The work on BioUno resulted in 
<a href="https://wiki.jenkins.io/display/JENKINS/Image+Gallery+Plugin">Jenkins Image Gallery plug-in</a>, 
released to the whole Jenkins community.</p>
