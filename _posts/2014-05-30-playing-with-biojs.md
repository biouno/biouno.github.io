---
layout: post
title: "Playing with BioJS"
description: "BioJS and Jenkins"
category: 
tags: [jenkins, biojs]
author: Bruno P. Kinoshita
---
{% include JB/setup %}

In the post entitled [The Secret of Building a scientific community](http://manuelcorpas.com/2014/05/25/the-secret-of-building-a-scientific-community/), 
Manuel Corpas describe his experiences coordinating the [BiosJS](http://biojs.net) 
project. It is a great writing and if you are interested in Open Source communities, 
related to research or not, you will find it very interesting.

I learned about BioJS months ago, but never really used it. After reading Manuel's post I 
followed some tutorials and was able to produce some neat HTML pages with sequences and 
trees. A few things that I learned:

- There are several components implemented by contributors
- Components have different dependencies
- Some components can use Java applets
- Some components can be use Ajax to retrieve remote content

## Using Jenkins to serve BioJS artifacts

The [JQuery Plug-in](https://wiki.jenkins-ci.org/display/JENKINS/jQuery+Plugin) simply adds 
JQuery into Jenkins web page, but the same approach won't work with BioJS since it is 
framework agnostic (which is great) and each component may have different dependencies 
(YUI, JQuery UI, ...).

The simplest way to produce artifacts using BioJS in Jenkins, and serve the content 
from Jenkins is by using CDN's for retrieving the JS files, and the 
[HTML Publisher](https://wiki.jenkins-ci.org/display/JENKINS/HTML+Publisher+Plugin) 
plug-in to archive and serve the HTML's. 

Some components use Ajax requests to dynamically update the UI. For these components a 
callback would have to be implemented in a plug-in for Jenkins. So the simplest approach 
is to deploy these artifacts to a Web server with the callback.