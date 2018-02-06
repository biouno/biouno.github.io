---
layout: page
title: "Using Jenkins Credentials Plug-in to create the BioUno figshare Plug-in"
description: "This post details how we used the Credentials Plug-in to store figshare OAuth credentials"
category: 
tags: [jenkins","plugins"]
author: Bruno P. Kinoshita
---

figshare is a platform where users can upload and share images, graphs, presentations and other documents. These artifacts can be generated using different tools - including Jenkins. The [BioUno figshare Plug-in](https://github.com/biouno/figshare-plugin) integrates Jenkins and figshare. The figshare API uses OAuth 1.0, and requires data such as client key, client secret, token key and token secret stored in Jenkins.

What the [Jenkins Credentials Plug-in](https://wiki.jenkins-ci.org/display/JENKINS/Credentials+Plugin) does, basically, is store these credentials in a way that it is both safer and easier to maintain in Jenkins. Before that, users would add passwords as parameters in jobs or store credentials globally in Jenkins via plug-ins. This resulted in security problems, and was also difficult to maintain with a high number of jobs with different credentials.

<!--more-->

This [blog post](http://blog.cloudbees.com/2012/02/open-sourcing-credentials-plugin.html) written by Stephen Connolly when the plug-in was open sourced by CloudBees will tell you more about why the plug-in was created, and also contains a more complete description.

## The Credentials Plug-in API per example

The Wiki of the Credentials Plug-in contains a good starting point for plug-in developers. Having a working example can be useful too - the Wiki page lists several implementations.

For the figshare Plug-in, we have used the [Rally Plug-in](https://github.com/jenkinsci/rally-plugin/) as example. This post describes our process of learning how to use the Credentials Plug-in. Hopefully it will be useful for other plug-in developers doing the same thing.

### Adding Maven dependency

The first step is to add the credentials-plugin to our `pom.xml`, so that we can use the API.

{% highlight xml %}
<dependency>
    <groupId>org.jenkins-ci.plugins</groupId>
    <artifactId>credentials</artifactId>
    <version>1.22</version>
</dependency>
{% endhighlight %}

We are using the latest and greatest version.

### Implementing the Credentials interface

The Credentials interface defines the basic contract for the credentials. It defines what kind of information the credentials hold. In our case, it will have a client key, a client secret, a token key and a token secret.

{% highlight java %}
public interface FigShareOauthCredentials extends Credentials {

    String getName();

    String getDescription();

    String getClientKey();

    Secret getClientSecret();

    String getTokenKey();

    Secret getTokenSecret();

}
{% endhighlight %}

Then we can implement our `FigShareOauthCredentials`.

{% highlight java %}
@NameWith(value = FigShareCredentialsNameProvider.class)
public class FigShareOAuthCredentialsImpl extends BaseStandardCredentials implements FigShareOauthCredentials {

    private final String name;
    private final String description;
    private final String clientKey;
    private final Secret clientSecret;
    private final String tokenKey;
    private final Secret tokenSecret;

    @DataBoundConstructor
    public FigShareOAuthCredentialsImpl(String id,
            String name, 
            String description, 
            String clientKey, 
            String clientSecret,
            String tokenKey, 
            String tokenSecret) {
        super(id, name);
        this.name = name;
        this.description = description;
        this.clientKey = clientKey;
        this.clientSecret = Secret.fromString(clientSecret);
        this.tokenKey = tokenKey;
        this.tokenSecret = Secret.fromString(tokenSecret);
    }

    // getters

    @Extension
    public static class Descriptor extends CredentialsDescriptor {

        public String getDisplayName() {
            return "figshare OAuth Credentials";
        }

    }

}
{% endhighlight %}

The `@NameWith` annotation defines a name provider for this credential. This name provider is used by the user interface to list the credentials by name.

The `@DataBoundConstructor` annotation is used by Stapler to bind the user interface parameters to the Java properties.

And finally `@Extension` is for the [descriptor](https://wiki.jenkins-ci.org/display/JENKINS/Defining+a+new+extension+point) of our credential. The display name of the descriptor of a credential is used as the **kind** of credentials.

The name provider used in the first is quite simple.

{% highlight java %}
public class FigShareCredentialsNameProvider 
    extends CredentialsNameProvider<FigShareOauthCredentials> {

    public String getName(FigShareOauthCredentials figshareOauthCredential) {
        return figshareOauthCredential.getName();
    }

}
{% endhighlight %}

<center><img src='{{ site.url }}/assets/posts/2015-09-05_using_jenkins_credentials_plugin_to_create_the_biouno_figshare_plugin/credentials_screenshot_001.png' alt="Screen shot 001" /></center>

When the user have to pick a credential, the name provider will display the name of the credential in Jenkins (not the display name).

These are the classes that we need to write specifically for the Credentials Plug-in. Next we will add the Jelly views, that display forms in the Jenkins UI to create these objects, and finally some more Java code that is related to the credentials, but in the Notifier (the extension point used for the figshare Plug-in).

### Jelly views

The Jelly files are used to create forms and contribute to the Jenkins user interface. It is XML but also contains several helper tags. Our Jelly form for the credentials, `FigShareOAuthCredentialsImpl/config.jelly`, contains the following code.

{% highlight xml %}
<?xml version="1.0" encoding="utf-8"?>
<j:jelly xmlns:j="jelly:core" xmlns:f="/lib/form" xmlns:st="jelly:stapler">
    <f:entry title="Name" field="name">
        <f:textbox/>
    </f:entry>
    <f:entry title="Description" field="description">
        <f:textbox/>
    </f:entry>
    <f:entry title="Client Key" field="clientKey">
        <f:textbox/>
    </f:entry>
    <f:entry title="Client Secret" field="clientSecret">
        <f:password/>
    </f:entry>
    <f:entry title="Token Key" field="tokenKey">
        <f:textbox/>
    </f:entry>
    <f:entry title="Token Secret" field="tokenSecret">
        <f:password/>
    </f:entry>
</j:jelly>
{% endhighlight %}

If you look at our constructor with `@DataBoundConstructor`, you will notice where the parameters in the constructor come from.

### How to use credentials in a Notifier/Publisher

A Notifier is a type of Publisher, that sends information to another system. Publisher is an extension point in Jenkins, called after build steps, exactly for publishing data (graphs, reports, artefacts, results, etc) to other entities.

This is the extension point that we used for the figshare Plug-in.

The first change is that the constructor of the notifier must be prepared to receive a `credentialsId`, which the user will select out of a combo.

{% highlight java %}
@DataBoundConstructor
public FigShareNotifier(String credentialsId, String articleTitle, String articleDescription, String antPattern) {
    this.credentialsId = credentialsId;
    this.articleTitle = articleTitle;
    this.articleDescription = articleDescription;
    this.antPattern = antPattern;
    
    // Get credential defined by user, using credential ID
    List<FigShareOauthCredentials> credentials = 
        CredentialsProvider.lookupCredentials(
            FigShareOauthCredentials.class, Jenkins.getInstance(), ACL.SYSTEM,
            Collections.<DomainRequirement> emptyList());
    FigShareOauthCredentials credential = 
        CredentialsMatchers.firstOrNull(credentials,
            CredentialsMatchers.allOf(CredentialsMatchers.withId(credentialsId)));

    this.credential = credential;
    if (null == credential) {
        LOGGER.warning(String.format(
                "Could not locate credential with ID %s. figshare integration is disabled for this notifier",
                credentialsId));
    }
}
{% endhighlight %}

The code inside the constructor after a comment is responsible for calling `CredentialsProvider` to look up for certain types of credentials. These credentials are assumed to have already been created. It is simply looking for the credential with the ID equals to the given `credentialsId`.

Once the credential has been created, we can later use it to interact with figshare in another part of the code.

{% highlight java %}
if (LOGGER.isLoggable(Level.FINE)) {
    LOGGER.log(Level.FINE, "Initialising the figshare API");
}
final FigShareClient figshare = FigShareClient.to("http://api.figshare.com/", 1,
        credential.getClientKey(), credential.getClientSecret().getPlainText(),
        credential.getTokenKey(), credential.getTokenSecret().getPlainText());
if (LOGGER.isLoggable(Level.FINE)) {
    LOGGER.log(Level.FINE, String.format("Creating article %s, description: %s", title, description));
}
{% endhighlight %}

There is, however, one more change required in the **Descriptor of the Notifier**. You must include a `doFillCredentialsIdItems` method, which will return a list of credentials. This list is used in the job configuration, to let the user select one.

{% highlight java %}
public ListBoxModel doFillCredentialsIdItems(
        @AncestorInPath Jenkins context,
        @QueryParameter String remoteBase) {
    if (context == null || !context.hasPermission(Item.CONFIGURE)) {
        return new StandardListBoxModel();
    }

    List<DomainRequirement> domainRequirements = new ArrayList<DomainRequirement>();
    return new StandardListBoxModel()
            .withEmptySelection()
            .withMatching(
            CredentialsMatchers
                .anyOf(CredentialsMatchers.instanceOf(FigShareOauthCredentials.class)),
                CredentialsProvider.lookupCredentials(
                        StandardCredentials.class, context, ACL.SYSTEM,
                        domainRequirements));
}
{% endhighlight %}

And here is how the `config.jelly` of the notifier looks like.

{% highlight xml %}
<j:jelly xmlns:j="jelly:core"
         xmlns:st="jelly:stapler"
         xmlns:d="jelly:define"
         xmlns:l="/lib/layout"
         xmlns:t="/lib/hudson"
         xmlns:f="/lib/form"
         xmlns:c="/lib/credentials">

    <f:entry title="figshare OAuth Credentials" field="credentialsId">
        <c:select/>
    </f:entry>

    <f:entry title="figshare Article title" field="articleTitle">
        <f:textbox/>
    </f:entry>

    <f:entry title="figshare Article description" field="articleDescription">
        <f:textbox/>
    </f:entry>

    <f:entry title="Pattern (ant-like) to find files in the workspace" field="antPattern">
        <f:textbox/>
    </f:entry>

</j:jelly>
{% endhighlight %}

The `<c:select/>` is a special tag, provided by the Credentials Plug-in, that will call your `doFillCredentialsIdItems` method to fill a combo box with credentials ID's for the user to pick one.

<center><img src='{{ site.url }}/assets/posts/2015-09-05_using_jenkins_credentials_plugin_to_create_the_biouno_figshare_plugin/credentials_screenshot_002.png' alt="Screen shot 002" /></center>

That is all for today. We hope you find it useful and will enjoy using the plug-in. It is being released this weekend as 0.1 to [our update center](http://biouno.org/jenkins-update-site.html).

[Plug-in source code at GitHub](https://github.com/biouno/figshare-plugin)

<small>The development of the figshare Plug-in started during the Mozilla Global Science Sprint 2015 at [NIWA](http://niwa.co.nz)'s office in Auckland, New Zealand, with the support of [DJ Moralita](https://github.com/deejmore).</small>

