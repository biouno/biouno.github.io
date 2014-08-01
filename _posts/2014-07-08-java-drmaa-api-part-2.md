---
layout: post
title: "Java DRMAA API &mdash; part 2"
description: "Second part of series of posts about a Java API for PBS, compliant with DRMAA spec"
category: 
tags: [jenkins, pbs, java, api, drmaa]
author: Bruno P. Kinoshita
---
{% include JB/setup %}

This is the first part of a series of posts about a Java API for PBS servers, compliant with 
the [DRMAA spec](http://www.drmaa.org/documents.php). 

[Java DRMAA API &mdash; part 1]({{ site.baseurl }}/2014/06/21/java-drmaa-api-part-1/)

This post could also be entitled "Why we won't use DRMAA for our Jenkins plug-in", with spoilers 
included. After working on a [prototype DRMAA PBS Java library](https://github.com/biouno/drmaa-pbs) 
for a few days, I finally understand why we can't use DRMAA v1 for the plug-in.

<!--more-->

## DRMAA v2 includes methods to retrieve cluster information

That's one the news in the v2 of the DRMAA specification. It will include extra methods not 
present in the v1, that will allow us to pull information about the cluster (memory, cores 
available, etc).

Since our [Jenkins PBS Plug-in](https://github.com/biouno/pbs-plugin) has only basic features 
like submitting jobs and monitoring queue status, maybe we could stick with a DRMAA PBS library, 
include a SGE, Condor and other libraries. But in case we needed an extra method it would 
be our [first broken window](http://en.wikipedia.org/wiki/Broken_windows_theory).

The DRMAA v2 has only a [C/C++ alpha version](https://github.com/troeger/drmaav2-mock) available 
and no Java port yet implemented, or released to Maven Central.

## Creating an interface from our current implementation

We are not going to create a standard, but rather keep in mind all the great things we have 
seen in DRMAA v1 and read about the DRMAA v2, and extract a general API from our existing 
[pbs-java-api](https://github.com/biouno/pbs-java-api).

Then the next step will be write a sge-java-api and create a new plug-in, that supports both 
PBS and SGE.

<center><img src='{{ site.baseurl }}/assets/posts/MOTHAFUCKINSCIENCE.gif' alt="SCIENCE!" /></center>

This is an interesting and very challenging task, so if you have interest in helping, drop 
us a line in our [mailing list](https://groups.google.com/d/forum/biouno-developers).