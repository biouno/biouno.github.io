---
layout: page
title: R Plugin Tutorials
---

The Jenkins [R-plugin](https://wiki.jenkins.io/display/JENKINS/R+Plugin) provides the primary way for executing R scripts on Jenkins. However, there are a number of design strategies that can make this simple, but powerful programming interface, more standardized and easier to work with. We hope that these tutorials will encouarge others to experiment with [Jenkins as a data science platform]({{ site.url }}/2016/03/07/Creating-a-Jenkins-Data-Science-Platform) that can enhance the power of R.

For example, typical requirements include:

- Transfer of Jenkins parameters and artifacts and configuration files into the R script context for execution
- Transfer of R script analyses results and plots back to Jenkins for archiving, management and report generation
- Management of data sets and associated metadata
- Data pipelining
- Selecting input for downstream analysis
- Reporting of numerical and graphical results
- Data annotation and sharing

We will introduce each of these topics in separate tutorials and we will demonstrate some effective design strategies. We will try to keep the R code in these tutorials simple as to focus primarily on issues of Jenkins-R-Script integration rather than the analytical power of the R language.

* [Using the Jenkins R-Plugin](using-the-jenkins-r-plugin.html)
* [Integrating Jenkins with R-script](tutorial01-jenkins-rscript.html)
