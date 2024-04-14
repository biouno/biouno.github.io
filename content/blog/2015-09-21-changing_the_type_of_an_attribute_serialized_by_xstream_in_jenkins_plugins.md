---
title: "Changing the type of an attribute serialized by XStream in Jenkins Plug-ins"
description: "In this post, we describe how you can change the type of an attribute that has already been serialized by XStream in your Jenkins Plug-in source code. All that you need is some Java code, and understand what you can and cannot change, and why."
tags: [jenkins,plugins]
author: Bruno P. Kinoshita
date: 2015-09-21
---

This post was written while fixing [JENKINS-23772](https://issues.jenkins-ci.org/browse/JENKINS-23772) for the [Image Gallery Plug-in](https://wiki.jenkins.io/display/JENKINS/Image+Gallery+Plugin). This plug-in can be used to create image galleries for artifacts found in the workspace in Jenkins. 

What was suggested in JENKINS-23772, was that instead of accepting only integers for the width, that the plug-in started to accept text values as well. This way `10`, `10px` or `10%` as valid values. The challenge in user requests like this, is how to maintain backward compatibility in your plug-in, while releasing a new version that changes objects and attributes.

<!--more-->

An [ImageGallery](https://github.com/jenkinsci/image-gallery-plugin/blob/9199c2ac7c42ea19d05f20dd7de588f94408ab75/src/main/java/org/jenkinsci/plugins/imagegallery/ImageGallery.java#L47) implements the Descriptor/Describable pattern for Jenkins, and users can choose an implementation in the job configuration. The ImageGallery abstract class contains an `imageWidth` Integer attribute, which is persisted on the disk by Jenkins, using XStream.

You can read more about retaining backward compatibility in this [Jenkins Wiki page](https://wiki.jenkins.io/display/JENKINS/Hint+on+retaining+backward+compatibility).

## Changing the code

Our task is to change that attribute to String, make sure the behaviour is consistent in the image gallery implementations, and guarantee that Jenkins will not crash when trying to load jobs with old `imageWidth` Integer attribute.

So first you have to make sure that your Serializable classes bump the `serialVersionUID` value, and that **your unit tests are still passing** after your changes.

If we have data already persisted on the disk and being used by XStream, changing attributes may result in strange errors. In our case we would like to change an Integer attribute to String, and persist it again.

The solution in this case, is add the `@Deprecated` annotation to the existing Integer field, add another String field with a different name, and implement the `readResolve` method to load the String value from the Integer value, when necessary.

Remember to also move the `@DataBoundConstructor` to your new constructors, and add `@Deprecated` to the right fields, methods, classes, and so it goes.

```java {linenos=table,filename=Example.java}
// ...
/**
 * Images width.
 */
@Deprecated
private Integer imageInnerWidth;

/**
 * Images inner width.
 */
private final String imageInnerWidthText;

/**
 * Constructor called from jelly.
 */
@Deprecated
public ComparativeArchivedImagesGallery(String title, String baseRootFolder, Integer imageWidth, Integer imageInnerWidth,
                                                boolean markBuildAsUnstableIfNoArchivesFound) {
    super(title, imageWidth, markBuildAsUnstableIfNoArchivesFound);
    this.title = title;
    this.baseRootFolder = baseRootFolder;
    this.imageInnerWidth = imageInnerWidth;
    imageInnerWidthText = Integer.toString(imageInnerWidth);
}

/**
 * Constructor called from jelly.
 */
@DataBoundConstructor
public ComparativeArchivedImagesGallery(String title, String baseRootFolder, String imageWidth, String imageInnerWidth,
                                                boolean markBuildAsUnstableIfNoArchivesFound) {
    super(title, imageWidth, markBuildAsUnstableIfNoArchivesFound);
    this.title = title;
    this.baseRootFolder = baseRootFolder;
    this.imageInnerWidthText = imageInnerWidth;
}
// ...
```

Good. So now our code already supports our changes.

There are at least two places where the integer image width was being saved in our previous jobs: the ImageGallery implementation object, and the Action being saved for each build.

```xml {linenos=table,filename=config.xml}
<publishers>
<hudson.tasks.ArtifactArchiver>
  <artifacts>**/*.png</artifacts>
  <latestOnly>false</latestOnly>
</hudson.tasks.ArtifactArchiver>
<org.jenkinsci.plugins.imagegallery.ImageGalleryRecorder>
  <imageGalleries>
    <org.jenkinsci.plugins.imagegallery.imagegallery.ArchivedImagesGallery>
      <title>test gallery</title>
      <imageWidth>100</imageWidth>
      <markBuildAsUnstableIfNoArchivesFound>false</markBuildAsUnstableIfNoArchivesFound>
      <includes>**/*.png</includes>
    </org.jenkinsci.plugins.imagegallery.imagegallery.ArchivedImagesGallery>
  </imageGalleries>
</org.jenkinsci.plugins.imagegallery.ImageGalleryRecorder>
</publishers>
```

```xml {linenos=table,filename=config.xml}
<org.jenkinsci.plugins.imagegallery.imagegallery.ArchivedImagesGalleryBuildAction>
  <title>test gallery</title>
  <images>
    <string>DB001.png</string>
    <string>RACK001.png</string>
    <string>USERS001.png</string>
  </images>
  <imageWidth>100</imageWidth>
</org.jenkinsci.plugins.imagegallery.imagegallery.ArchivedImagesGalleryBuildAction>
```

Now that we have made our changes in the code, and left the old fields deprecated, we have to tell XStream to use the new field when reading old entries like these.

```java {linenos=table,filename=ComparativeImagesGalleryBuildAction.java}
public Object readResolve() {
    String width = (imageWidth != null && imageWidth > 0) ? Integer.toString(imageWidth) : "0";
    String innerWidth = (imageInnerWidth != null && imageInnerWidth > 0) ? Integer.toString(imageInnerWidth) : "0";
    return new ComparativeImagesGalleryBuildAction(
            title,
            tree,
            width /*imageWidthText*/,
            innerWidth /*imageInnerWidthText*/);
}
```

What it does, basically, it tell our program to use the value of the Integer fields to create a new object, with the String fields that we just created. This way, old instances serialized onto the disk, will be deserialized and filled with the old values.

In other words, it will be transparent to users, no errors on the screen or logs, and we will have kept backward compatibility.

Just remember to review your code, make sure your Jelly is passing the right field names, you are not using the old value, and that everything seems to work.

Happy hacking!
