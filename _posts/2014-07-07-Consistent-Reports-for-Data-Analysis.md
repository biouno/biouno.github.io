---
layout: post
title: "Consistent Reports for Data Analysis"
description: "How to generate dynamic but consistent reports for data analysis"
category: 
tags: [Jenkins, workflow, life-sciences, analysis, bioinformatics, reporting]
author: Ioannis K. Moutsatsos
---
{% include JB/setup %}

When you use Jenkins for analytics it is important to deliver consistent analysis reports from each build. There are a few different ways that you can create graphical, tabular and/or textual analysis reports, but one thing that becomes clear immediately is that you also require a certain level of dynamic behavior. Dynamic behavior is required so that you can easily adapt the reports to the underlying data whose format and content will likely change even when the same type of analysis is performed.

In this this blog entry, I will describe how I have used the [Summary Display](https://wiki.jenkins-ci.org/display/JENKINS/Summary+Display+Plugin) and [Scriptler](https://wiki.jenkins-ci.org/display/JENKINS/Scriptler+Plugin) plugins to create a simple but effective framework for displaying consistent but dynamic reports following numerical data analysis using the [R plugin](https://wiki.jenkins-ci.org/display/JENKINS/R+Plugin).

<!--more-->

## How it works

### What you need:
1. You need the [Summary Display](https://wiki.jenkins-ci.org/display/JENKINS/Summary+Display+Plugin) and [Scriptler](https://wiki.jenkins-ci.org/display/JENKINS/Scriptler+Plugin) plugins
2. You need to create a new Scriptler Script from the groovy code for **writeXMLProperties\_scriptlet**, available from my [github repository](https://github.com/imoutsatsos/jenkins-scriptlets.git). Call it **writeXMLProperties\_scriptlet**.

### The Setup
1. You **write a configuration file** for your report (for details see this blog)
2. You add a **Scriptler build step** that uses the **writeXMLProperties\_scriptlet** to generate the XML file that the Summary Display Plugin parses. It uses the configuration file from Step 1.
3. You add a **Summary Display post-build action step** to parse the XML file generated in Step 2.

## Background
When you perform some numerical, statistical or bioinformatic data analysis, the typical result can be assigned to one of two broad result categories.

1. **Results** representing **new values** derived from the numerical transformations performed by the analysis (reshaped, normalized etc)
2. **Annotations** that describe **but do not alter** the original data set. 
	These annotations are important metadata about the data and inform us of the data numeric, statistic and biological properties. For example, group statistics such as mean, median and standard deviation describe a data set, but they do not fundamentally transform its data, so they are considered metadata.

In either case, it is desirable to be able to display this information to our users after the build for immediate feedback and increased understanding of the underlying data.

## Requirements
I will start with an illustration of the reporting requirements we are trying to implement. As an example, I will use a Jenkins project that assists users to upload and annotate a variety of file types (images, annotations, text, tabular data etc). Each build generates a multi-tab report where various properties and annotations of the uploaded file are displayed. In a follow-up entry, I will describe in more detail this FILE_UPLOAD Jenkins project.

The basic requireement is that build reports **dynamically adapt to display different tabs and file/user-provided metadata** depending on the type of file uploaded. 

Binary file uploads (such as PDF, images, etc.) should generate reports with 4 tabs (DESCRIPTION, PROPERTIES, DOWNLOAD, ACTIONS). 

CSV or TSV file uploads (typical formats for delimited numerical data) should generate reports that display an additional 3 tabs (CHARACTER_COLUMNS, NUMERIC_COLUMNS, SAMPLE) with information on the numeric and character columns of the table, as well as, a small sample of the data itself. In addition, the DESCRIPTION tab for CSV/TSV file reports should display extra fields to provide information about the number of columns, rows and rows of complete data (data rows with no 'NA' values, an R convention for missing data) in the data set.

Below are two report examples.

#### A build report for a PDF file upload 
The report displays the 4 standard tabs
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070414_060550_PM.jpg' alt="Summary Display for PDF" /></center>

#### A build report for a CSV file upload 
The report displays an additional 3 tabs and extra fields in the DESCRIPTION tab. 
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070414_061309_PM.jpg' alt="Summary Display for CSV" /></center>

## Summary Display Plugin
The Summary Display plugin is a powerful report generator. It uses an XML configuration file to generate a number of different HTML reports on the build page. The available report types and the required XML elements for generating them are described in detail on the [plugin wiki page](https://wiki.jenkins-ci.org/display/JENKINS/Summary+Display+Plugin). The build process is responsible for generating the XML configuration file, while the Summary Display plugin is used in a post-build action for parsing the XML and generating the HTML report that is displayed on the build page. In this blog entry I will focus on the generation of multi-tab reports, as they are capable of reporting in a consistent, compact and familiar way a variety of numerical data and annotations.

Despite its promise, **the Summary Display plugin is missing one crucial piece**. And that is a **prescriptive way for generating the required XML** summary display configuration file. Instead, each XML configuration file has to be generated by custom code restricted to the artifacts and environment of each build. **This discussion addresses this limitation** and allows you to build the required XML diplay properties not from code but from a report configuration file.

## XML generation from Business Rules: What, not How!
What about if rather than writing custom code each time we wanted to create a new XML configuration file we could just rather write a set of simple rules of what type of report we want and what content we want to include. Basically, we want to tell the build what type of report to generate and let it figure out how to write the XML configuration file for us.

Let's start by defining some basic requirements for such a tool and the types of content it can display.

1. A configuration file will maintain the 'business rules' of how and what the report will display 
2. Report data will be provided by key-value data (such as java properties or typical configuration files) or by delimited value data (such as CSV or TSV).
3. Report data can reside locally or be accessible via the http protocol
4. Report configuration should support a basic filtering mechanism
5. The report generation should not fail on missing data
6. The report should automatically display hyperlinks for all data values that start with 'http://...'

## The report configuration file
Given the requirements above, I will now describe the **syntax of the configuration file** for encoding the report generation options.The **supported options** for each configuration property are **shown in brackets**.

* report.style: [*tabs*] 
  * What type of layout report container we want. Currently only the 'tabs' option is supported but I plan to implement the remaining two Summary Display options [table, accordion] in future improvements

* tab.header:[*TAB1-NAME,TAB2-NAME,TAB3-NAME*...] 
  * A comma separated list of the tab names to be displayed. 
  * The tabs will be displayed in the order specified here.

* summary.properties:[fileName,http://URL.to.File], (required)
   * Path to file containing Key-value properties that will be displayed as fields
   * If no fields will be displayed from properties set the **summary.properties=none**
   * Currently we only support a single properties file per report but it can contain multiple sets of properties. Each set can be displayed separately using the **Selector for field content** (see below)

* content.TAB_NAME: [*field,table*]  
  * What content each tab should display.The available options are: field (for key-value pairs) or table for delimited values. Each tab can be specified with a different content option
* table.data.TAB_NAME:[fileName,http://URL.to.File] 
  * Path to file containing the tab content.
  * If only a file name is specified, the file must reside in the project's workspace.
  * alternatively a file can be accessed via http from any accessible site

* table.separator:[separator character], (optional) Value separator in source table data. 
  * The default value is ','
* Selectors for table content. These options allow you to select how much of a table to display. This is convenient for **displaying samples of large data sets**

  * table.length.TAB\_NAME:[INTEGER\_NUMBER], _(optional) defines how many rows from the table will be displayed_
  * table.header.TAB\_NAME:[COL1,COL2,COL3,COL4...], _(optional) defines which columns from the table will be displayed_
* Selectors for field content. This option is a simple STARTS_WITH selector for keys in a property file.
  * field.key.TAB\_NAME:[key-start] All properties starting with 'key-start' text will be displayed as report fields. As a matter of convention, I generate related properties with the same key prefix so they can be reported together.

* Field Presentation Attributes
  * field.key.color:[color_name]
  * field.value.color:[color_name]
  * Field key and value color can be specified. Note the presentation attributes are somewhat restricted by the CSS formatting that the Summary Plugin imposes on the generated HTML report.

## An example Configuration file
The example file **sumReport_test_data_upload.properties** is used to configure a tabbed report for each FILE_UPLOAD build. The file is located in the userContent/properties folder on the Jenkins-CI server

     # A properties file for configuring tabbed report of uploaded data
     # Thursday, June 26, 2014

     summary.properties=JData.properties
     #summary.properties=none
     report.style=tab
     
     tab.header=DESCRIPTION,CHARACTER_COLUMNS,NUMERIC_COLUMNS,PROPERTIES,SAMPLE,DOWNLOAD,ACTIONS
     
     content.DESCRIPTION=field
     field.key.DESCRIPTION=data
     field.key.color=black
     field.value.color=blue
     
     content.SAMPLE=table
     table.data.SAMPLE=JData.csv
     table.length.SAMPLE=10
     
     content.CHARACTER_COLUMNS=table
     table.data.CHARACTER_COLUMNS=meta.csv
     
     content.NUMERIC_COLUMNS=table
     table.data.NUMERIC_COLUMNS=measure.csv
     
     content.PROPERTIES=table
     table.data.PROPERTIES=JData.properties
     separator.PROPERTIES==
     
     content.DOWNLOAD=field
     field.key.DOWNLOAD=download
     
     content.ACTIONS=table
     table.data.ACTIONS=http://JenkinsURL/userContent/properties/after_test_data_upload.properties
     separator.ACTIONS==

## A Configuration Driven Summary Display Report
Once a Summary Display report configuration is authored, it is used in a **Scriptler-Script build step** that executes the **writeXMLProperties\_scriptlet** groovy script. 

_Note: The **writeXMLProperties\_scriptlet** takes 2 parameters

1. The _worskpaceVar_ should be set to the project's workspace. This allows you to refer to files residing in the project's workspace simply by their name
2. The _configProps_ should be set to the Summary Display report configuration file. The Scriptler plugin allows you to use Jenkins environment tokens to refer to the location of this file.

This build step **generates the custom formatted XML report file** that the Summary Display plugin then uses in rendering the build report.
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070514_113654_AM.jpg' alt="Summary Display Configuration Sriptlet" /></center>

_NOTE_: The groovy code for **writeXMLProperties\_scriptlet** is available from my [github repository](https://github.com/imoutsatsos/jenkins-scriptlets.git)

The Scriptler step generates the **writeXMLSummary.xml** file that the Summary Display Plugin will parse.

In the project's **post-build actions** we now add the Summary Display Plugin step, referred to as **'Publish XM Summary Reports'**. 
The configuration of this action requires thta we provide one or more appropriately formatted XML files. We will provide the XML file (_writeXMLSummary.xml_) that the Scriptler step above generated.
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070714_040251_PM.jpg' alt="Summary Display Report 1" /></center>

## Report Examples
In addition to the reports displayed under 'Requirements', the following figures display additional Multi-Tab Reportss that are dynamically generated from a single report configuration (the one shown above)

We see that the tabs **dynamically adjust** to the availability of properties and content data but importantly, maintain a **consistent 'look and feel'** that aids users in data review and improved comprehension of the results of a data analysis. 

The PROPERTIES tab content is read from a standard Java properties file that is generated during the build.
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070414_064719_PM.jpg' alt="Summary Display Properties Tab" /></center>

The CHARACTER_COLUMNS tab content only appears when CSV files are parsed. The content is read from the meta.csv file that is generated during the build
<center><img src='{{ site.baseurl }}assets/posts/IKM_Clipping_070414_061534_PM.jpg' alt="Summary Display CSV Character Columns Metadata" /></center>