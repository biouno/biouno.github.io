---
layout: post
title: "Experiences from JUC 2014 Boston"
description: "My personal impressions from the JUC 2014 Boston Meeting"
category: 
tags: []
---
{% include JB/setup %}

On June 18th, I attended my first ever Jenkins User Conference in Boston, USA [0]. 

Not only I attended, but I also had the privilege to present at this meeting my work on *Using Jenkins as a scientific data and image management platform*.

The meeting attracted more than 400 people, a quite impressive number of attendees. Most of these people were of course supporting the development operations of various companies, and they were clearly interested in what I call the **standard Jenkins functionality and software build workflows**. So, I was a bit pleasantly surprised when at least 150-200 people attended my talk which was clearly outside the  primary interest of most attendees. Furthermore, at least 10 people remained after my talk to  ask questions, discuss ideas, provide feedback and inquire how they could get a hold of the presentation slides [1]. If you follow the slides you'll see that in the end I'm making some recommendations on the types of improvements we need to make to the Jenkins platform for easier usability by scientists. Note that my slides on the JUC 2014 CloudBees site are an earlier version of my presentation that does not include some last minutes update.

On the other hand I was a bit disappointed when Kohsuke Kawaguchi (CloudBees) in his opening address described the Jenkins community as a vibrant exotic 'bazaar' with many narrow but excitement filled aisles and went on to highlight several extensions to the basic Jenkins platform (focusing on the current discussion about refreshing the Jenkins UI) without any mention of the applications that projects like the BioUno advocate.

One of the major announcements from the meeting was the new Workflow Plugin that uses a groovy DSL to script Jenkins workflows.
This is an open source project incubated by the 'CloudBees' company but it is clearly inspired by the 'Build Flow Plugin'[2]. The main difference between the new Workflow and the original Build Flow plugins will be the ability to restart a build pipeline after a failure. This will be made possible through the inclusion of new *workflow checkpoints*.

The Workflow plugin is still in beta with a 1.0 version release expected by the end of the year. The DSL is still evolving as are some of the ideas on how to visualize the potentially very complex workflows that this plugin is supposed to address. Gesse Glick (CloudBess) suggested that some visualization will be initially supported for executed builds, but not for the build configuration. I questioned both him and Kohsuke on this strategy that continues the Jenkins tradition of poor comprehension of project configuration due to the lack of appropriate visualization tools. I got no satisfactory answer as to why they do not see the need!

Other things in progress are the ability to use use a pluggable workflow definition language (Activity for example instead of the Groovy DSL), externalization of the DSL build definition script (currently embedded in job configuration), and a workflow  definition testing strategy. In addition, *interoperability* with existing Jenkins builds and plugins will soon come although it may need some Jenkins core changes.

Anyway, the new Workflow plugin promises a lots of cool new capabilities for Jenkins pipelines, and it should be of significant interest to anyone interested in building bioinformatic workflows and integrating Jenkins with compute grids.

In addition, I was able to attend two additional talks, one by Praveen Kumar (RedHat) on the use of the python API [3] to access Jenkins functionality, and one by Kohsuke on using the Cloudbees extension of Jenkins and specifically the JOC (Jenkins Operations Center) Server [4] to manage large scale installations of Jenkins in the enterprise. For those that need it, JOC seems like a capable management tool that is disguised almost like a standard Jenkins server with custom plugins.

Finally, I attended an afternoon hands-on workshop lead by Stephen Christou (CloudBees) on how to get started with writing Jenkins plugins. The workshop was divided into three parts basic, intermediate and advanced. I thought the workshop was OK, but was not setup in an optimal way to achieve its goal. Round tables, few electrical outlets and poor Wi-Fi connectivity made it difficult for most people to follow along on their own computers. Most participants ended-up following Stephen's live demonstration and abandoned programming on their own laptop. Some of the provided pointers were really good, and I must say that at least now I can generate the structure of a basic Jenkins hpi project using Maven. We'll see how much further than that I can go on my own now!

[0] http://www.cloudbees.com/jenkins/juc-2014/boston/sessions
[1] http://www.tinyurl.com/JUC2014-Moutsatsos
[2] https://wiki.jenkins-ci.org/display/JENKINS/Build+Flow+Plugin
[3] https://github.com/salimfadhley/jenkinsapi
[4] http://pages.cloudbees.com/rs/cloudbees/images/Jenkins-Operations-Center-by-CloudBees.pdf