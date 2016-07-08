---
layout: page
title: Integrating Jenkins with R
---

# Motivation

The primary motivation of this series of tutorials is to provide a step by step guide of basic skills required for setting up Jenkins for data analyses and graphing using the power of the R language. The Jenkins [R-plugin](https://wiki.jenkins-ci.org/display/JENKINS/R+Plugin) provides the primary way for executing R scripts on Jenkins. However, there are a number of design strategies that can make this simple, but powerful programming interface, more standardized and easier to work with. We hope that these tutorials will encouarge others to experiment with [Jenkins as a data science platform]({{ site.baseurl }}2016/03/07/Creating-a-Jenkins-Data-Science-Platform) that can enhance the power of R.

For example, typical requirements include:

- Transfer of Jenkins parameters and artifacts and configuration files into the R script context for execution
- Transfer of R script analyses results and plots back to Jenkins for archiving, management and report generation
- Management of data sets and associated metadata
- Data pipelining
- Selecting input for downstream analysis
- Reporting of numerical and graphical results
- Data annotation and sharing

We will introduce each of these topics in separate tutorials and we will demonstrate some effective design strategies. We will try to keep the R code in these tutorials simple as to focus primarily on issues of Jenkins-R-Script integration rather than the analytical power of the R language.

##Links to Tutorials

### Using the Jenkins R-Plugin
- Install the R-Plugin
- Writing a Jenkins build step that uses the R-Plugin
- Reviewing graphical output from R

### Tutorial 1 - Integrating Jenkins with R-script
- Passing Jenkins environment and job/ build parameters to R
- Creating R variables from configuration files
  - Reading Java property files into R data frames
  - Creating R varaibles from a named data frame row
