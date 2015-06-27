---
layout: post
title: "From Uno-Choice to Active Choices"
description: "How the BioUno Uno-Choices became the Jenkins Active Choices Plugin"
category: 
tags: [Jenkins, life-sciences, analysis, bioinformatics, Active-Choices]
author: Ioannis K. Moutsatsos
---
{% include JB/setup %}

More than a year ago I approached Bruno via a series of posts on the BioUno developer's forum and discussed my frustration with the available Jenkins user interface controls for generating advanced, dynamic user interfaces for scientific applications. I had seen partial implementations of what I thought we needed in some Jenkins plugins, but none of them was well maintained or provided in a single plugin the features I wanted. So, I asked Bruno whether it would be possible to create a new plugin with all of these features? He said 'yes' and he took on this challenge. One of Bruno's first questions was 'What should we call this new plugin?'. To credit the BioUno project contribution and my expectation that this UI plugin would make all the related incomplete plugins obsolete, I answered 'Uno-Choice', the one choice for all your needs!

In this blog entry, I will describe a bit of the Uno-Choice plugin history until its contribution to the Jenkins project with a new name, Active Choices plugin.

<!--more-->
As I started exploring Jenkins for Bioinformatic and other life-sciences applications, some of the dev-ops roots of Jenkins started presenting challenges. Jenkins being an automation tool, did not really have good UI components for creating modern looking, sophisticated interactive user interfaces. The free-form, parameterized project is the most basic form of a life-sciences project, but many of the parameters may need to be dynamically generated, and can vary from build to build. The next important requirements was the ability to select more than one values for a parameter. This feature is also know as multi-select.

My initial search for Jenkins plugins that offered these features, lead me to the Dynamic Parameter Plugin and the Extended Choice Parameter Plugin. Both offered a bit of the functionality I was looking for, but not in a single plugin. The Dynamic Parameter Plugin was full of good intentions, but had not delivered on its promise (cascading parameters and multi-select were both features of several snapshots, but not the main code, and the snapshots did not seem to work for me). The Extended Choice Parameter plugin, was (and continues to be) one of my favorites. However,  it did not support token expansion and the addition of MultiLevel (Cascading), Multi-Select in the 0.2 version of the plugin was so cumbersome as to render multi-select impractical for more than a few selections (I was interested in multi-select of dozens if not hundreds of values).

As a result, I approached Bruno and the BioUno project with a proposal to develop such a unified plugin that would deliver this functionality, as well as, a true cascade, dynamically updated parameter type whose value could depend on one or more of the current build parameters. We coined the name Uno-Choice for the new plugin, and Bruno started developing and delivering on my main requirements. Over the next year, the Uno-Choice plugin emerged with this and some additional functionality that made it indispensable in most of my analytical and bioinformatic Jenkins based build forms! For a complete description of the functionality you can see the Jenkins wiki.

In summary, the Uno-Choice plugin supported three new Jenkins parameter types with the following functionality:
- dynamically generated values (using Groovy or a Scriptler script)
- dynamically updated values based on other UI parameters
- multi-valued (can have more than one value, represented as a comma separated list of strings)
- rendered with a variety of UI single and multi-select controls, including dynamic HTML

Finally, towards the end of 2014, Bruno started thinking that the Uno-Choice plugin was stable enough and functional enough for a 1.0 release under the auspices of the Jenkins community (rather than the BioUno project). We started probing the Jenkins developers forum for feedback on the new release. What we've heard was that the Uno-Choice name did not clearly convey the purpose and utility of the plugin. As a result, we started thinking of new names and the Active Choices name was proposed and eventually selected as the new official plugin name. In June 2014 the Active Choices plugin was released to the Jenkins community, and this and future releases will be available through the Jenkins update center.

Just for reference here are the old and new names of the parameters
- Uno-Choice Dynamic Choice: Active Choices Parameter
- Uno-Choice Cascade Dynamic: Active Choices Reactive Parameter
- Uno-Choice Dynamic Reference:Active Choices Reactive Reference Parameter

If you still see some references to the old plugin name or ID please, bear with us! Eventually these will go away, but until then they may still appear in some of our documentation or examples. Please, use the Active Choices plugin and follow our Tweets and blog entries that will describe examples, various alternate configurations and additional use-cases. As always we ask that you submit issues through the plugin Jenkins JIRA system using the component name Active-Choices.
