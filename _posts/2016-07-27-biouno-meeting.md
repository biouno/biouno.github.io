---
layout: post
title: "BioUno meeting 2016-07-27"
description: "BioUno meeting 2016-07-27"
category:
tags: [project-meeting]
author: Ioannis K. Moutsatsos, Bruno P. Kinoshita
---
{% include JB/setup %}

Participants: Bruno P. Kinoshita and Ioannis K. Moutsatsos. 2016-07-27 08:00 PM UTC using Google
Hangouts.

<iframe width="560" height="315" src="https://www.youtube.com/embed/_8eCDUzllzk" frameborder="0" allowfullscreen></iframe>

# Meeting topics

## New requirements

* Control number of items shown in Active Choice Options.
    * note: There is already a ticket for that in JIRA
* Allow an HTML select element to be displayed like a multi-select, but the user must choose just one
    * action: @ioannis: create ticket
* AC-Reactive-Reference: Easier way to pass an 'input' value to the build-New return type option?
    * action: To think
* Improve 'trigger' control of a 'self-referential' active reference.
    * note: there is already a ticket related to that (filtering delay)
    * note: probably related: [JENKINS-34750](https://issues.jenkins-ci.org/browse/JENKINS-34750) Reactive Parameter updating on click of itself not on change of referenced parameter
    * option #1: Suppress trigger parameters, Delay, or ignore change due to filtering
    * option #2: Have a button for on-demand triggering the change
* r plug-in
    * action: Have a better way to search for the plug-in name in the update centre

## Current issues in Jenkins Plug-ins

* [JENKINS-31973](https://issues.jenkins-ci.org/browse/JENKINS-31973): When using the scriptler plugin the server is responding very slow
    * action: Need to find an easy way to reproduce the issue
* [https://groups.google.com/d/msg/jenkinsci-users/sQ65m4Y7nRE/Vvti2XpmNwAJ](https://groups.google.com/d/msg/jenkinsci-users/sQ65m4Y7nRE/Vvti2XpmNwAJ)
    * action: @bruno try to reproduce and comment back in the mailing list
* [https://groups.google.com/d/msg/jenkinsci-issues/k3G8PMOlFd0/vOH7QgQGBAAJ](https://groups.google.com/d/msg/jenkinsci-issues/k3G8PMOlFd0/vOH7QgQGBAAJ)
    * note: fixed for Folders, other issues logged for multi-branch and multi-configuration
* Scriptler links to scripts: are they correct in Active Choices? Bug [JENKINS-24584](https://issues.jenkins-ci.org/browse/JENKINS-24584): View selected script option' in build configuration displays wrong scriptler script
    * action: @bruno will work on this issue in this development cycle
* BioUno log reports errors that do not trigger default script or affect functionality. Can we clean it up?
    * note: related to: Bug [JENKINS-34188](https://issues.jenkins-ci.org/browse/JENKINS-34188): jenkins.log noise: "script parameter ... is not an instance of Java.util.Map."
    * action: @bruno will work on this issue in this development cycle
* Bug [JENKINS-36158](https://issues.jenkins-ci.org/browse/JENKINS-36158): Active choice reactive reference parameter not working on checkbox reference
    * action: @ioannis will reproduce and comment on the ticket
* [JENKINS-35101](https://issues.jenkins-ci.org/browse/JENKINS-35101) The selected values of checkbox reactive parameter are not available in Scriptler groovy script
    * note: I think I've also experienced this
    * note: Need examples to test with
    * note: @bruno pinged the user. If there's no answer, close as Not able to Reproduce or similar status
* Value of file type Active Choice React Reference is not cascaded. Want to cascade name of user selected file
    * action: @ioannis will file an issue in JIRA
    * action: @bruno will work this ticket, given that the file parameter works and should be easy to fix

## Future Directions

* R Plug-in improvements and Scriptler integration
* PBS Plug-ins n' [DRMAA](https://www.drmaa.org/) integration
* Script catalogs for organizing and grouping functionality. See also: [JENKINS-24354](https://issues.jenkins-ci.org/browse/JENKINS-24354)
* Deploy R on Jenkins. Invoke with API and parameters (See Domino Server [http://www.r-bloggers.com/integrating-r-with-production-systems-using-an-http-api/](http://www.r-bloggers.com/integrating-r-with-production-systems-using-an-http-api/))
    * note: we can use [RServer](https://rforge.net/Rserve/) with Java to transform Jenkins into a kind of [Shiny](http://shiny.rstudio.com/) server
* Metadata catalog and metadata searching
    * note: enrich build metadata with property artifacts so they can be found using the Jenkins API
    * note: implement flexible metadata searching
    * action: @bruno to make some progress during this development cycle
