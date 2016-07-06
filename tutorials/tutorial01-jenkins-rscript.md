---
layout: page
title: Tutorial 1 - Integrating Jenkins with R-script
---

## Passing Jenkins environment and job/ build parameters to R

This tutorial will demonstrate how to pass Jenkins build parameters and configuration metadata to the  R script. Strategies demonstrated in  this tutorial allow the parametrization of the R-Script via the Jenkins configuration and build parameters.

## Tutorial 1: Jenkins Project

The Jenkins example project is a freestyle project that captures two parameters from the build user interface.

- We will show how the R-script can access and use these parameters. In addition,
- We will demonstrate how the R-script can access two other types of parameters that are useful for many types of analysis. These parameters originate in the Jenkins environment or an external configuration file

The project has a single build step 'Execute R script'

## Tutorial 1: Configuration file

You can download the Jenkins project configuration from here:

## The 'Execute R script' Build Step

The R-plugin will execute the following R code.

```R
j<-Sys.getenv(c("JENKINS_URL"))
jenkins.url<-j['JENKINS_URL']

p<-Sys.getenv(c("YOUR_FIRSTNAME","DECADE_OF_BIRTH"))
bparam.name<-p['YOUR_FIRSTNAME']
bparam.decade<-p['DECADE_OF_BIRTH']

# Read an external configuration file from Jenkins
# Read static dataType properties from properties file
propUrl=sprintf("%suserContent/tutorials/properties/decade.properties",'http://illuminationpc:8080/')
decade.props<-read.table(propUrl, header=FALSE, sep="=", row.names=1, strip.white=TRUE, na.strings="NA", stringsAsFactors=FALSE)

decadePropKey<-sprintf("d%s",bparam.decade)
decade.message=decade.props[decadePropKey,1]

message<-sprintf("%s was born in the decade of %s, the %s",bparam.name, bparam.decade, decade.message)
print(message)
```

Let's have a step by step walk through this code:

### Passing Jenkins parameters and environment variables to R

```R
j<-Sys.getenv(c("JENKINS_URL"))
jenkins.url<-j['JENKINS_URL']

p<-Sys.getenv(c("YOUR_FIRSTNAME","DECADE_OF_BIRTH"))
bparam.name<-p['YOUR_FIRSTNAME']
bparam.decade<-p['DECADE_OF_BIRTH']
```
The **Jenkins environment and build parameters are exported as environment variables** and can be made available to the R-script using the R function `Sys.getenv` [1]. We read the ``` JENKINS_URL ``` and ```YOUR_FIRSTNAME,DECADE_OF_BIRTH``` build parameters from the environment and assign them to the corresponding ```jenkins.url, bparam.name, bparam.decade``` R-script variables.

### Reading an external configuration (properties) file in R

*Note*: **Enable anonymous read access** in Jenkins global security! This will allow the R-script to read the configuration file

```R
# Read an external configuration/properties file from Jenkins
propUrl<-sprintf("%suserContent/tutorials/properties/decade.properties",jenkins.url)
decade.props<-read.table(propUrl, header=FALSE, sep="=", row.names=1, strip.white=TRUE, na.strings="NA", stringsAsFactors=FALSE)
```
Input for many R analyses comes from configuration and data files served from a Jenkins URL. 
To start, we assume that configuration files are **simple Java properties**. Java properties files can be easily read and created using Groovy, the native scripting language of Jenkins, but it's not that more difficult to do the same with R.
In our example project, custom messages for each decade are read from the `decade.properties` file in the `JENKINS_HOME/userContent/tutorials/properties` folder. I make use of the R `sprintf` [2] function and the `jenkins.url` variable to generate the Jenkins URL serving this file.

```R
propUrl<-sprintf("%suserContent/tutorials/properties/decade.properties",jenkins.url)
```

Note that the `jenkins.url` variable was assigned earlier by reading the corresponding environment variable into the R `jenkins.url` variable using the expression: `jenkins.url<-e['JENKINS_URL']`

Once we have the file URL we can read the configuration file using the `read.table`[3] R function. The `sep="="` argument to this function splits the java key-value pairs into separate columns. The `read.table`return type is an R `data frame`[4], so the `decade.properties` file is now assigned to the `decade.props` **R data frame**.

### Reading configuration properties from the R data frame

In the step above we've read the configuration properties into an R `data frame`. 
How do we now access these properties so that we can use them in our code? 

The next part of the R-code demonstrates exactly that.

```R 
decadePropKey<-sprintf("d%s",bparam.decade)
decade.message=decade.props[decadePropKey,1]
```

First we use the `sprintf` function to format the key of the property we are interested in. Note that the `decade.properties` keys are in the format 'dNNNN' where NNNN is the decade value. For example 'd1980'

- The property keys become row names using the argument `row.names=1`
- Then we access the R table row by name using as name the property keys and get the value at the table column with index position 1. 

This is the value of the indicated property. So decade.props['dNNNN',1] should return the message for decade 'dNNNN' 

### R-output to Jenkins console

The R-plugin captures R-script output to the Jenkins console. So the output of any print statements is dispyed there

```R 
message<-sprintf("%s was born in the decade of %s, the %s",bparam.name, bparam.decade, decade.message)
print(message)
```

We format a message and `print` it to the console

## What have we learned?

In this tutorial we have developed some primary skill for parametrizing R scripts from Jenkins. We have demonstrated:

1. How to read and create R variables from **Jenkins environment** variables and **build parameters**
2. How to use a static configuration Java-style properties files to create a corresponding R data frame
3. How to read properties from an R data frame with named rows
4. How to assign variables from an R data frame with named rows

In a future tutorial we will discuss strategies for passing R script results and graphics back to Jenkins. 

## R-functions used in this tutorial

You may want to review the R manual for further details on how these functions are used.

{:.pure-table}
| Reference | Function | Details|
| ---- | ---- | ---- |
| 1| Sys.getenv | [https://stat.ethz.ch/R-manual/R-devel/library/base/html/Sys.getenv.html](https://stat.ethz.ch/R-manual/R-devel/library/base/html/Sys.getenv.html) |
| 2 | sprintf | [https://stat.ethz.ch/R-manual/R-devel/library/base/html/sprintf.html](https://stat.ethz.ch/R-manual/R-devel/library/base/html/sprintf.html) |
| 3 | read.table | [https://stat.ethz.ch/R-manual/R-devel/library/utils/html/read.table.html](https://stat.ethz.ch/R-manual/R-devel/library/utils/html/read.table.html)|
| 4 | data.frame | [https://stat.ethz.ch/R-manual/R-devel/library/base/html/data.frame.html](https://stat.ethz.ch/R-manual/R-devel/library/base/html/data.frame.html)|

