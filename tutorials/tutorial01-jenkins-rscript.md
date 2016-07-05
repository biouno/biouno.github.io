---
layout: page
title: Tutorial 1 Integrating Jenkins with R-script
---
# Tutorial 1: Integrating Jenkins with R-script

## Passing Jenkins environment and job/ build parameters to R

This tutorial will demonstrate how to pass build parameters and other useful Jenkins configuration metadata to the  R script. Strategies demonstrated in  this tutorial allow the parametrization of the R-Script via the Jenkins configuration and build parameters.

## Tutorial 1 Jenkins Project

The Jenkins example project is a freestyle project that captures two parameters from the build user interface.

- We will show how the R-script can access and use these parameters. In addition,
- We will demonstrate how the R-script can access two other types of parameters that are useful for many types of analysis. These parameters originate in the Jenkins environment or an external configuration file

The project has a single build step 'Execute R script'

## Tutorial 1 Configuration file

You can download the Jenkins project configuration from here:

## The 'Execute R script' Step: What is happening

Here is the R code that will be executed.

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

Let's see step by step what is happening here:

### R-script reads Jenkins parameters and environment variables

The **Jenkins environment and build parameters are exported as environment variables** and can be made available to the R-script using the R function `Sys.getenv` [1].

```R
j<-Sys.getenv(c("JENKINS_URL"))
jenkins.url<-j['JENKINS_URL']

p<-Sys.getenv(c("YOUR_FIRSTNAME","DECADE_OF_BIRTH"))
bparam.name<-p['YOUR_FIRSTNAME']
bparam.decade<-p['DECADE_OF_BIRTH']
```

We read the ``` JENKINS_URL ``` and ```YOUR_FIRSTNAME,DECADE_OF_BIRTH``` build parameters from the environment and store them in the corresponding ```jenkins.url, bparam.name, bparam.decade``` R-script local variables

### R-script reads an external configuration (properties) file

*Note*: **Enable anonymous read access** in Jenkins global security! This will allow the R-script to read the configuration file

An important  input source for many R analyses are various configuration files that Jenkins can access and serve from a URL. 
To start, we will assume that these configuration files are **simple Java properties** since they can be easily read and created using the native scripting language of Jenkins, Groovy.

The URL of the configuration file to be read by the R-script will typically be known or can be derived using environment variables, such as the Jenkins URL.
For example to read the `decade.properties` file stored in the `JENKINS_HOME/userContent/tutorials/properties` folder we can use the R `sprintf` [2] function to generate the Jenkins URL serving this file.

```R
propUrl<-sprintf("%suserContent/tutorials/properties/decade.properties",jenkins.url)
```

Note that the `jenkins.url` variable was assigned earlier by reading the corresponding environment variable into the R `jenkins.url` variable using the expression:

`jenkins.url<-e['JENKINS_URL']`

Now we are ready to read the configuration file using the R function `read.table`. The arguments to this function treat the java style configuration file as a simple `=` delimited file.

```R
# Read an external configuration/properties file from Jenkins
propUrl<-sprintf("%suserContent/tutorials/properties/decade.properties",jenkins.url)
decade.props<-read.table(propUrl, header=FALSE, sep="=", row.names=1, strip.white=TRUE, na.strings="NA", stringsAsFactors=FALSE)
```

This R script reads the `decade.properties` file into the `decade.props` **R data frame**.

### Getting configuration properties from the R table

In the step above we've read the configuration properties into an R `data frame. 
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

## What have we learned  in this tutorial

1. How to use the Jenkins environment variables to create corresponding R variables
2. How to use a static configuration Java-style properties files to create a corresponding R data frame
3. How to read properties from an R data frame with named rows
4. How to assign variables from an R data frame with named rows

These primary skills provide the basis for parametrizing R scripts from Jenkins. In a future tutorial we will discuss strategies for passing R script results and graphics back to Jenkins. 

## R-functions used in this tutorial

Here we reference the R fucntions that are used in this tutorial. You may want to review them for further details on how these functions are used.

Reference | Function | Reference|
---- | ---- | ---- |
1| Sys.getenv | https://stat.ethz.ch/R-manual/R-devel/library/base/html/Sys.getenv.html |
2 | sprintf | https://stat.ethz.ch/R-manual/R-devel/library/base/html/sprintf.html |
3 | read.table | https://stat.ethz.ch/R-manual/R-devel/library/utils/html/read.table.html|

