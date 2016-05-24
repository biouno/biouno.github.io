---
layout: post
title: "Java DRMAA API &mdash; part 1"
description: "First part of series of posts about a Java API for PBS, compliant with DRMAA spec"
category: 
tags: [jenkins, pbs, java, api, drmaa]
author: Bruno P. Kinoshita
---
{% include JB/setup %}

This is the first part of a series of posts about a Java API for PBS servers, compliant with 
the [DRMAA spec](http://www.drmaa.org/documents.php). PBS is a type of batch server, or distributed resource 
manager (DRM). It manages resources like CPU and memory in a network of computers, and is able to schedule 
jobs to run utilizing the maximum of these resources.

We have a [PBS Plug-in](https://github.com/biouno/pbs-plugin/) for Jenkins, that enables us to submit 
and monitor jobs from Jenkins to a PBS server. James Hetherington proposed enhancements for the 
[pbs-java-api](https://github.com/biouno/pbs-java-api) and PBS Plug-in, including supporting other 
batch servers like SGE.

<!--more-->

Our pbs-java-api was implemented to quickly prototype the PBS Plug-in. It was highly influenced by 
the [pbs4java](https://code.google.com/p/pbs4java/). We didn't use this existing API due to 
the number of changes required to release it to Maven Central (code format, Object design and Mavenization). 
However, we did interact with the maintainer and tried to explain our needs.

## DRMAA spec

<img src='{{ site.baseurl }}assets/posts/drmaalogo.png' alt="DRMAA Logo" align="right" width="300px" />

The DRMAA (Distributed Resource Management Application API) is a working group that maintains an API 
specification to enable a standard way to communicate with batch servers like PBS. Supported vendors 
include: 

* SGE 
* Condor 
* GridWay
* LSF
* PBS

DRMAA v1 is the stable version, but a v2 is under development. Looking at search.maven.org for 
drmaa returns few entries, all under the *us.levk* group ID. Even though there are documents that 
mention the Java binding, I couldn't find an official Maven release of it.

<center><img src='{{ site.baseurl }}assets/posts/drmaa_search_maven.png' alt="DRMAA at search.maven.org" /></center>

## DRMAA v1 and Java

The DRMAA v1 provides a C reference API, and other programming languages build their implementations 
on top of it. Some write wrapper code or use [SWIG](http://www.swig.org/). The existing Java implementations 
from the DRMAA web site are bindings to the C API. In other words, it uses JNI to call the C code.

DRMAA has two parts, the DRMAA API, that is vendor independent, and provides the basic interfaces and implementations 
for managing a DRM. The second part is the SPI (Service Provider Implementation), that is the implementation of 
the former part, and can be vendor specific.

Supposing you wanted to control a PBS server, you would need the DRMAA API (e.g. us.levk.drmaa-common) 
and the DRMAA PBS implementation (e.g. org.biouno.drmaa-pbs maybe). Let's take a look at an DRMAA v1 code snippet 
from [http://gridscheduler.sourceforge.net/howto/drmaa_java.html](http://gridscheduler.sourceforge.net/howto/drmaa_java.html).

<pre>
01: package com.sun.grid.drmaa.howto;
02:
03: import java.util.Collections;
04: import org.ggf.drmaa.DrmaaException;
05: import org.ggf.drmaa.JobTemplate;
06: import org.ggf.drmaa.Session;
07: import org.ggf.drmaa.SessionFactory;
08:
09: public class Howto2 {
10:    public static void main(String[] args) {
11:       SessionFactory factory = SessionFactory.getFactory();
12:       Session session = factory.getSession();
13:
14:       try {
15:          session.init("");
16:          JobTemplate jt = session.createJobTemplate();
17:          jt.setRemoteCommand("sleeper.sh");
18:          jt.setArgs(Collections.singletonList("5"));
19:
20:          String id = session.runJob(jt);
21:
22:          System.out.println("Your job has been submitted with id " + id);
23:
24:          session.deleteJobTemplate(jt);
25:          session.exit();
26:       } catch (DrmaaException e) {
27:          System.out.println("Error: " + e.getMessage());
28:       }
29:    }
30: }
</pre>

What this code does, is initialize a session, create a job template and submit it to the 
DRM. 

If you try the code in a newly created Ubuntu machine, <code>apt-get install gridengine-drma-dev</code>, and run your 
code with <code>-Djava.library.path=/usr/lib/gridengine-drmaa/lib/</code>, you'll likely get an error like below.

<pre>
Exception in thread "main" org.ggf.drmaa.SessionFactory$ConfigurationError: Provider for org.ggf.drmaa.SessionFactory cannot be found
	at org.ggf.drmaa.SessionFactory.newFactory(SessionFactory.java:194)
	at org.ggf.drmaa.SessionFactory.access$0(SessionFactory.java:123)
	at org.ggf.drmaa.SessionFactory$NewFactoryAction.run(SessionFactory.java:296)
	at java.security.AccessController.doPrivileged(Native Method)
	at org.ggf.drmaa.SessionFactory.getFactory(SessionFactory.java:103)
	at org.biouno.drmaa.Main.main(Main.java:9)
</pre>

It happens because you don't have the [session implementation](https://github.com/gridengine/gridengine/blob/master/source/libs/jdrmaa/src/org/ggf/drmaa/SessionFactory.java#L141). And at the moment, looks like there are no PBS DRMAA implementations. 
Or at least I couldn't find any in GitHub, SourceForge, Googling and reading the docs.

## First look at the DRMAA v2

The new DRMAA version provides the same features as v1 but it will provide more methods for retrieving 
cluster information. This can be useful for designing dashboards or cluster management tools. There is 
a work-in-progress [code repository](https://github.com/biouno/drmaav2-mock).

The drmaav2-mock provides the basic interfaces, a SQLite persistence module, threading, and 
calls to /bin/date to simulate submitting jobs. However, it looks like it will take a while to be 
ready, and the same goes for a Java binding.

## Next steps

Building a Java API on top of the C API is a viable alternative. But it breaks the portability of the 
code, and can be hard to debug. Jenkins [has plug-ins](http://jenkins-ci.361315.n4.nabble.com/use-JGit-in-git-plugin-td4655488.html) 
that are in similar situation, using native/executable calls but considering pure java API's. 

After reading about the DRMAA specification and playing with the existing Java bindings, 
I will continue investigating ways to control PBS clusters with Java, but I also downloaded 
the Torque PBS Open Srouce code. I want to find the *qsub* C code, and check **how hard would it 
be to create a pure Java PBS API**. If that is doable, we could write such API, and create the 
DRMAA Java API that would uses it as dependency. 

We could then use the drmaa-common, our drmaa-pbs, without the need of installing DRMAA 
libraries or the PBS client in the client machine.

## Final thoughts

Hopefully after all this work we will be able to release a newer version of the Java API and 
the PBS Plug-ins, and include this work in the [stories section of the DRMAA website](http://www.drmaa.org/stories.php).

<center><img src='{{ site.baseurl }}assets/posts/no-results.gif' alt="Still looking for" /></center>

## References

**DRMAA v1**

* http://www.drmaa.org/
* http://en.wikipedia.org/wiki/DRMAA
* https://blogs.oracle.com/templedf/entry/drmaa_internals1
http://gridscheduler.sourceforge.net/howto/drmaa_java.html

**DRMAA v2**

* https://github.com/biouno/drmaav2-mock
* https://github.ugent.be/hpcugent/hanythingondemand/blob/master/README.md
* http://www.ogf.org/pipermail/drmaa-wg/2014-March/001517.html

**PBS**

* https://code.google.com/p/pbs4java/
* https://github.com/bryan-lunt/PBSJavaDRMAA/

**Native code binding**

* http://www.swig.org/
* http://stackoverflow.com/questions/1393937/disadvantages-of-using-java-native-interface

**Cool stuff**

* https://github.ugent.be/hpcugent/hanythingondemand/blob/master/README.md (creating a Hadoop cluster within a PBS cluster)
* https://github.com/biancini/Science-Gateway (a portlet to control a DRM)

Troger, P., Rajic, H., Haas, A. and Domagalski, P.
Standardization of an API for Distributed Resource Management Systems
Troger, P., Rajic, H., Haas, A. and Domagalski, P. (2007). Standardization of an API for Distributed Resource Management Systems. pp.619-626.