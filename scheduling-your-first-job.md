---
layout: page
title: Scheduling your first job
---

<p>Scheduling jobs in Jenkins is very simple and easy. First of all,
	let's create a simple job. Go to the main screen.</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_scheduling_001.png"> <img src="{{ site.baseurl }}assets/img/screenshot_scheduling_001.png">
	</a>
</p>

<p>
	Now click on <em>New Job</em>. That should take you to screen below.
	Give the job a name and click on OK.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_scheduling_002.png"> <img src="{{ site.baseurl }}assets/img/screenshot_scheduling_002.png">
	</a>
</p>

<p>
	Okay, now you have to find the <em>Build Triggers</em> section and
	check the box that says <em>Build periodicatlly</em>. There will
	appear a box where you can schedule jobs using a CRON-like syntax.
</p>

<p>You can also include build steps. Try adding one that executes a
	shell script that prints the current date.</p>

<p>
	In the example below, it says to schedule the job to be executed <em>every
		5 minutes</em>.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_scheduling_003.png"> <img src="{{ site.baseurl }}assets/img/screenshot_scheduling_003.png">
	</a>
</p>

<p>If you pay attention to your build history, with time you'll realize
	builds are being executed every 5 minutes, just like you scheduled.</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_scheduling_004.png"> <img src="{{ site.baseurl }}assets/img/screenshot_scheduling_004.png">
	</a>
</p>

<p>And checking the console output you can see the results of your job,
	and who/when triggered its execution.</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_scheduling_005.png"> <img src="{{ site.baseurl }}assets/img/screenshot_scheduling_005.png">
	</a>
</p>

<p>There are many ways to schedule a job in Jenkins. You can use the
	web interface, the command line CLI, the REST API or use plug-ins for
	that. Try reading the Jenkins Wiki and looking for other ways to
	schedule jobs.</p>
