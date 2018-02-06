---
layout: page
title: About the project
---

## Project Motivation

### Complexity vs Quality: The Bumpy Relation of Scientific Software

Scientific software is used in physical, environmental, earth and life sciences on a daily
basis to make important discoveries. Due to its highly specialized nature, scientific
software is frequently developed by scientists with deep domain knowledge, but not
necessarily deep knowledge in technologies and tools used by software engineers and
developers that build more mainstream applications. As a result, scientific software
tends to be highly customized, less flexible, complex, poorly tested, less documented
and even less maintained in the long run

[Computational science: Error... why scientific programming does not compute](http://www.nature.com/news/2010/101013/full/467775a.html)
(Zeeya Merali, Nature: 2010)
 
### Reproducible Computational Research

Many issues plaguing scientific software have been discussed in the literature, but the ability to
reproduce computational discoveries has taken center stage in recent years. The term **reproducible
computational research** has been coined, and used as an umbrella concept for identifying and proposing
solutions to issues that affect the reproducibility of computational scientific research.

[Scientific Reproducibility through Computational Workflows and Shared Provenance Representations](http://www.evernote.com/l/AJ8x2KJTSTlGmbrFDKXSR709G2wRjbN32Tk/)
(Yolanda Gil, NSF Workshop: 2010)

### Some Proposed Solutions

Although the challenge of reproducible computational research is multi-dimensional, some of
the proposed solutions are rooted in existing, **well established and robust software
engineering solutions** such as:

1. Source code management (SCM)
2. Computational Workflow Engines
3. Scalable and distributed compute platforms
4. Compute and storage hardware virtualization
5. Centralized repositories of digital collections of scientific data

In addition, the organized and homogeneous tagging of scientific data with **metadata**
(data about data) has been a well-established foundation for information retrieval and
discovery. The development of consistent metadata and **controlled vocabularies** is
another important component to searching, finding and using scientific data in a manner
consistent with reproducible research.

Finally, (and to some degree an obvious requirement) reproducible computational research
depends on the ability of other scientists or research experts to **freely access the source
code and scientific data** used in generating new computational discoveries. These free
and open access concepts have been championed by many in the software development community
under the umbrella of the **open-source community**. Open-source code is meant to be a
collaborative effort, where programmers improve upon the source code and share the changes
within the community.

## Project Mission

The BioUno open source project seeks to improve scientific application automation, 
performance, reproducibility, usability, and management by applying and extending software 
engineering (SE) best practices in the field of scientific research applications. 
[Deliverables from the project](/publications.html) have found a variety of applications
in life science research (bioinformatics, genetics, drug discovery).

## Project Objectives

* We **explore and apply** the application of best practices in software engineering to 
support the project mission
* We **develop extensions** to established SE tools, frameworks and technologies that directly 
**support** or indirectly **enhance** scientific applications.  
* We **develop APIs** and **integration** points that empower scientific applications through 
the use 
* We promote **collaboration and reuse** through contributing to existing open source 
projects 
* We **educate users** through [blog](/blog.html), [wiki](https://github.com/biouno),
and [presentations](/presentations.html) on the application of SE best practices in
scientific applications
* We **advocate** with software engineers for enabling SE tools and frameworks for use 
by scientists 

Check out our [roadmap](/roadmap.html) for a list of short and long term specific objectives.

## Project Strategy

BioUno has pioneered the use of continuous integration tools and techniques to create reproducible
computational pipelines and to manage computer clusters in support of scientific research applications.

In addition, BioUno has adopted a variety of Software Engineering best practices, to achieve its objectives:

* **[Revision Control](http://en.wikipedia.org/wiki/Revision_control)** (e.g. Git, Subversion, 
branching strategies),
* **[Continuous Integration](http://en.wikipedia.org/wiki/Continuous_integration)**
(e.g. Jenkins CI, SonarQube, code metrics, reproducible builds),  
* **[Software Testing](http://en.wikipedia.org/wiki/Software_testing)** (e.g. Nestor-QA, 
TestLink, TDD, code coverage),  
* **[Virtualization](https://en.wikipedia.org/wiki/Virtualization)** (e.g. Docker, Vagrant, VirtualBox)
* It uses SE tools and techniques to create powerful pipelines and to manage 
computer clusters. 

Finally, BioUno strives to minimize the
[open source proliferation problem](http://gondwanaland.com/mlog/2013/10/22/open-source-proliferation-problem/).
While the BioUno project covers a broad range of technologies and tools, it tries to avoid the Open-Source
proliferation problem by actively contributing to existing open-source projects rather than releasing or
starting a new project.

---

<div class=''>
<div id="videoplayer" style="display:none;">&nbsp;</div>
<img src="{{ site.url }}/assets/img/video.png" id="videoimage" width="500" />
</div>

<div class=''>
<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/search?q=%23biouno+OR+%40biouno" data-widget-id="445763950747979776">Tweets about "#biouno OR @biouno"</a>
</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<script type='text/javascript'>
$(function() {
	$('#videoimage').click(function() {
		$('#videoplayer').show();
		$('#videoplayer').append("<iframe width='500' height='315' src='http://www.youtube.com/embed/6Dl6V249W30' frameborder='0' allowfullscreen='allowfullscreen'></iframe>");
		$('#videoimage').hide();
	});
});
</script>
