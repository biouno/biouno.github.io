---
layout: page
title: Using the Jenkins R Plug-in
---

<p>
	The Jenkins R plug-in has been released to the Jenkins community. So
	you can download it from Jenkins update site directly. Follow the
	instructions <a href="{{ site.baseurl }}/docs/installing-plugins" title="Installing plug-ins">here</a> to install the plug-in.
</p>

<p>
	After you've installed the plug-in, proceed by creating a FreeStyle
	project. Now add a build step to <em>Execute R script</em>. You'll
	need <a href="http://www.r-project.org" title="R project">R</a>
	installed, as the plug-in calls RCmd to execute the scripts.
</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_001.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_001.png">
	</a>
</p>

<p>
	We will use an example from <a href="http://www.harding.edu/fmccown/r/">http://www.harding.edu/fmccown/r/</a>,
	that is a very introductory article describing how to plot data with
	R. Copy any of his examples and paste in the <em>Script</em>
	text-area.
</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_002.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_002.png">
	</a>
</p>

<p>Now save and build your project.</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_003.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_003.png">
	</a>
</p>

<p>Check the output in the job console. You should see something
	similar to the output below.</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_004.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_004.png">
	</a>
</p>

<p>As by default R outputs the graph as a PDF, now you should have a
	PDF in your job workspace. You can browse it via the web interface or
	via a file navigator.</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_005.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_005.png">
	</a>
</p>

<p>And here's the output of the R script that you executed in Jenkins.
	You can use this plug-in for computing statistics, plotting, measuring
	fuzziness of sets, among other interesting stuff that you can do with
	this plug-in.</p>

<p class="center">
	<a href="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_006.png"> <img src="{{ site.baseurl }}/assets/img/using-the-jenkins-r-plugin/screenshot_r_006.png">
	</a>
</p>
