---
layout: page
title: Installing Plug-ins
---

<p>
	There are different ways to install plug-ins. BioUno has some Jenkins
	plug-ins that have to be installed manually. You can find the complete
	documentation for installing plug-ins in the <a href="https://wiki.jenkins-ci.org/display/JENKINS/Plugins#Plugins-Howtoinstallplugins" title="Plug-ins Wiki
	page">Plug-ins Wiki page</a> from Jenkins project.
</p>

<p>
	From the main screen, go to <em>Manage Jenkins</em> and in sequence to
	<em>Manage Plugins</em>.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_installing_plugins_001.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_installing_plugins_001.png">
	</a>
</p>

<p>
	There you should see a screen with four tabs. Looks for the <em>Available</em>
	tab. Clicking on it will bring the list of available plug-ins,
	organized by categories.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_installing_plugins_002.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_installing_plugins_002.png">
	</a>
</p>

<p>
	As we've talked about notifications prior, look for the <em>email-ext
		plugin</em>. This plug-ins adds more options for sending
	notifications from your builds.
</p>

<p>
	In newer versions of Jenkins you can install some plug-ins without
	having to restart. All you have to do is just click on <em>Install
		without restart</em>.
</p>

<p class="center">
	<a href="{{ site.baseurl }}assets/img/screenshot_installing_plugins_003.png">
		<img src="{{ site.baseurl }}assets/img/screenshot_installing_plugins_003.png">
	</a>
</p>

<p>Wait until the screen is refreshed and voilà, you have just
	installed your first plug-in.</p>

In order to install BioUno Jenkins Plug-ins, you will have to add our 
[update site]({{ site.baseurl }}jenkins-update-site.html).
