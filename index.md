---
layout: page
title: The BioUno project
---
{% include JB/setup %}

The ​BioUno​ open­ source project seeks to improve scientific application automation, 
performance, reproducibility, usability, and management by applying and extending software 
engineering (SE) best practices in the field of scientific research applications. 
[Deliverables from the project](/publications.html) have found a variety of applications
in life­science research (bioinformatics, genetics, drug discovery).

* We ​**explore​ and apply​** best practices in software engineering to 
support the project mission
* We **​develop extensions​** to established SE tools, frameworks and technologies that directly ​
**support​** or indirectly **​enhance​** scientific applications.  
* We **​develop APIs​** and **​integration​** points that empower scientific applications through 
the use 
* We promote **​collaboration and reuse​** through contributing to existing open source 
projects 
* We **​educate users​** through [blog](/blog/), [wiki](https://github.com/biouno),
and [presentations](/publications.html) on the application of SE best practices in
scientific applications
* We **​advocate​** with software engineers for enabling SE tools and frameworks for use 
by scientists 

Read more [about the project](/about.html), its mission, objectives, motivations and strategy.

## Latest from our Blog

<div class="">
    <ul class="">
{% for post in site.posts limit: 5 %}
        <li class=""><a href="{{ post.url }}" class="">{{ post.title }}</a> &mdash; <small><em>{{ post.date | date: "%-d %B %Y" }} by {{ post.author }}</em></small></li>
{% endfor %}
    </ul>
</div>

[>> more from our blog](/blog/).

## BioUno on social media

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

[>> follow us on Twitter!](https://twitter.com/biouno)
