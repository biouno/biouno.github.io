---
title: Jenkins Plug-ins
aliases:
  - /jenkins-plugins.html
---

Using Jenkins gives us not only the possibility to use its job
scheduling, monitoring and triggering, and notifications. We can also
extend Jenkins with plug-ins. There is a [Jenkins update site]({{< ref "/jenkins-update-site.html" >}}) for BioUno which
stores all bio-plugins, like MrBayes and FigTree.

You can install any plug-in automatically using the Web user
interface or by running a command in your shell.

<table class="pure-table pure-table-bordered" style='width: 100%'>
	<tbody>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">Grid computing</th>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/pbs-plugin" title="BioUno PBS Plug-in">PBS Plug-in</a></td>
			<td>This plug-in lets you use Jenkins to control a <a href="https://www.adaptivecomputing.com/products/open-source/torque/">Torque PBS</a> cluster. More information about it in the <a href="https://github.com/biouno/pbs-plugin/wiki/Home">PBS Plug-in GitHub Wiki</a></td>
		</tr>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">Phylogenetics</th>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/figtree-plugin" title="BioUno FigTree Plug-in">FigTree Plug-in</a></td>
			<td>Integrates <a href="https://tree.bio.ed.ac.uk/software/figtree/">FigTree</a> and Jenkins.</td>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/mrbayes-plugin" title="BioUno MrBayes Plug-in">MrBayes Plug-in</a></td>
			<td>Integrates <a href="https://mrbayes.sourceforge.net/">MrBayes</a> and Jenkins.</td>
		</tr>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">Genetic Analysis</th>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/clumpp-plugin" title="BioUno CLUMPP Plug-in">CLUMPP Plug-in</a></td>
			<td>Integrates <a href="https://www.stanford.edu/group/rosenberglab/clumpp.html">CLUMPP</a> and Jenkins.</td>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/distruct-plugin" title="BioUno Distruct Plug-in">Distruct Plug-in</a></td>
			<td>Integrates <a href="https://www.stanford.edu/group/rosenberglab/distruct.html">Distruct</a> and Jenkins.</td>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/structure-plugin" title="BioUno Structure Plug-in">Structure Plug-in</a></td>
			<td>Integrates <a href="https://pritch.bsd.uchicago.edu/software.html">Structure</a> and Jenkins.</td>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/structure-harvester-plugin" title="BioUno Structure Harvester Plug-in">Structure Harvester Plug-in</a></td>
			<td>Integrates <a href="https://taylor0.biology.ucla.edu/structureHarvester/">Structure Harvester</a> and Jenkins.</td>
		</tr>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">Chemical Structures</th>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/jmol-plugin" title="BioUno Jmol Plug-in">Jmol Plug-in</a></td>
			<td>Renders Jmol molecules in the build page, using Jmol Javascript library</td>
		</tr>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">UI</th>
		</tr>
		<tr>
			<td><a href="https://github.com/jenkinsci/active-choices-plugin/" title="Jenkins Active Choices Plugin">Active Choices Plugin</a></td>
			<td>A Jenkins UI plugin for selecting one or multiple options for a job parameter. The UI control can be rendered in a variety of ways including dynamic HTML</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Image+Gallery+Plugin" title="Jenkins Image Gallery  Plug-in">Image Gallery Plug-in</a></td>
			<td>This plug-in reads a job workspace and collects images to produce an image gallery using colorbox lightbox Javascript library.</td>
		</tr>
		<tr>
			<th colspan="2" style="background-color: #EEEEEE">Misc</th>
		</tr>
		<tr>
			<td><a href="https://github.com/biouno/figshare-plugin" title="BioUno figshare Plug-in">figshare Plug-in</a></td>
			<td>This plug-in integrates figshare and Jenkins, using figshare API v1 with OAuth 1.0 and the Credentials Plug-in.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/R+Plugin" title="Jenkins R Plug-in">R Plug-in</a></td>
			<td>A simple plug-in to invoke R interpreter and execute an R script.</td>
		</tr>
	</tbody>
</table>

### Other recommended Jenkins plug-ins

Jenkins already has several plug-ins that you can find useful for your lab. We have listed a few plug-ins below with 
a brief description.

<table class="pure-table pure-table-bordered" style='width: 100%'>
	<thead>
		<tr>
			<th>Plug-in name</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Build+Pipeline+Plugin">Build Pipeline Plug-in</a></td>
			<td>For managing your build pipelines.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/JobConfigHistory+Plugin">JobConfigHistory Plug-in</a></td>
			<td>To keep a history of your job configuration changes.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Build-timeout+Plugin">Build Timeout Plug-in</a></td>
			<td>To limit the time of your jobs.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Backup+Plugin">Backup Plugin</a></td>
			<td>For creating back-ups for your Jenkins instance and jobs.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Email-ext+plugin">E-mail-ext Plug-in</a></td>
			<td>Lets you easily configure e-mail notifications for different
				actions in Jenkins.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Git+Plugin">Git Plug-in</a></td>
			<td>For storing biology data in GitHub.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Summary+Display+Plugin">Summary Display Plugin</a></td>
			<td>Generates dynamic, rich summary reports on build pages. The reports are written in a consistent XML format.</td>
		</tr>
		<tr>
			<td><a href="https://wiki.jenkins.io/display/JENKINS/Timestamper">Timestamper Plug-in</a></td>
			<td>Adds timestamps to the Console Output.</td>
		</tr>
	</tbody>
</table>
