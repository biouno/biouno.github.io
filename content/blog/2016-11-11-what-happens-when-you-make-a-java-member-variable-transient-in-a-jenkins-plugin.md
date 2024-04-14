---
layout: single
title: "What happens when you make a Java member variable transient in a Jenkins plug-in"
description: "What happens when you make a Java member variable transient in a Jenkins plug-in"
category: 
tags: [jenkins, post-mortem]
author: Bruno P. Kinoshita
date: 2016-11-11
---

This blog post is a post mortem. Even though it is not exactly about an outage in a system,
as it is common to be announced in [post mortems](https://github.com/danluu/post-mortems),
it is still a big mess that happened due to a field in one of our Jenkins plug-ins
being made transient.

<!--more-->
Before anything, here is a TL;DR on transient fields in Java. When you have a field such as

```
public class SomeClass {
    private transient String someVariable;
}
```

you are specifying that you do not want it to be persisted if/when the class is serialized.

We made some fields transient in Active Choices Plug-in, which caused users to
lose the Groovy scripts used in their jobs parameters.

So sit back and relax, while I tell you what happened to the release 1.5 of our
[Active Choices Plug-in](https://wiki.jenkins.io/display/JENKINS/Active+Choices+Plugin),
which was dropped and never made the update center, 
why we had to remove release 1.5.0 from Jenkins update center. And finally, how we fixed it
in release 1.5.1.

## Skipped release 1.5

We released 1.5-alpha to the [Jenkins experimental update center](https://jenkins.io/blog/2013/09/23/experimental-plugins-update-center/) on 20th March this year. We cut that release due to the
[script-security-plugin](https://github.com/jenkinsci/script-security-plugin) integration.

This alpha release is not available to all users, unless they choose to use the alpha version.
This was announced in our mailing list, and I tried giving it some testing.

But our post mortem has - almost - nothing to do with the script-security-plugin.

The problem with the release 1.5, which was next following after our previous releases 1.3 and 1.4,
was that since 1.4, Jenkins plug-in API changed, and plug-ins now are required to update
how they define the Jenkins version against which they are built against. You can read more
about it in [INFRA-588](https://issues.jenkins-ci.org/browse/INFRA-588).

The release process works almost completely flawlessly. Except for the upload stage. Before the
upload stage, there is a task where a tag is created. The tag (uno-choice-1.5) is in GitHub,
in the active-choices-plugin repository under the Jenkins organization.

After fixing the issue, following the instructions in INFRA-588, we couldn't release
1.5, since the task to create a tag would fail, before it tried to upload the plug-in binary
to the update center.

It is possible to request someone with karma to manually delete the tag from GitHub,
or we can just skip that version. That is what was done, and that is why the release 1.5
was skipped.

## FindBugs in Jenkins plug-ins

This is important because it plays part in the issue. After the plug-in was ready to be
released as 1.5.0, it was just a matter of running `mvn clean release:prepare release:perform`.
However, during the execution of the release, besides running tests,
[Jenkins is now also running FindBugs](https://wiki.jenkins.io/display/JENKINS/FindBugs+in+plugins).

It means that every plug-in released recently, has been scanned by FindBugs, which is great.

One of the issues in Active Choices Plug-in, was that instead of Groovy scripts being
Strings, they are now instances of [SecureGroovyScript](https://github.com/jenkinsci/script-security-plugin/blob/ca9eef328b969fd9c7cf16d859184bb269092fe0/src/main/java/org/jenkinsci/plugins/scriptsecurity/sandbox/groovy/SecureGroovyScript.java#L64), from the script-security-plugin.

The SecureGroovyScript does not implement Serializable. Which is not really a problem since Jenkins
is not using Java traditional serialization to persist objects as XML. But since FindBugs was
complaining about it, and it was Friday night, I fixed that warning by
making that field as transient...

<center><img src='/posts/hmmmm.png' alt="Hmmmm" /></center>

## Removing version 1.5.0

So Monday morning I started seeing users reporting the issue. Actually, one issue reported
before Monday that his scripts had disappeared, but since he mentioned the pipeline-plugin, I didn't consider
it could be such a blocker issue (active-choices-plugin does not support the pipeline-plugin).

It took Ioannis reporting the same issue, and some coffee, until I realized what had happened.
Anyone who installed the 1.5.0 release, and saved the job, or had a plug-in saving the job, or
if Jenkins decided to save the job, would get all the GroovyScript instances removed from the
job XML. Meaning that the next time someone tried to execute the job, the parameters would probably
be empty.

Another issue reported that the same happened to him, and suggested to remove that release, so that
other users would not lose their scripts. It took just a few minutes (OSS is great, Jenkins project
is great, Daniel Beck is great! Hooray!). I logged in to Jenkins #jenkins IRC channel,
briefly explained the issue and asked how to remove a release from the update center.

You just need to submit a pull request to the [backend-update-center2](https://github.com/jenkinsci/backend-update-center2),
like [this one](https://github.com/jenkinsci/backend-update-center2/commit/d2c99d7ad1d696c8ab21aecdcf4b804823f03cde).

So now users won't be affected by the issue. Great, let's fix the issue and release a new version.

## Add FindBugs filters to ignore warnings in Jenkins plug-ins

That's how we fixed it. Revert the change, removing the transient tokens from the code,
add an ignore filter for FindBugs. Took just [a few minutes to write the fix](https://github.com/jenkinsci/active-choices-plugin/commit/44c21fc6bab67a538d785712d2a3aa302d20ea1a),
but even then we still had to test the change, before releasing 1.5.1.

## Confirming the regression is gone

So I arrived earlier from work today, and decided to thoroughly test that the fix would work, before
releasing 1.5.1.

- Download Jenkins LTS 2.19.2
- Create a blank JENKINS_HOME
- Start Jenkins (`JENKINS_HOME=/tmp/new_home java -jar jenkins*war), and accept the default plug-ins
- Install active-choices-plugin 1.4
- Restart Jenkins
- Create test job, with a simple parameter

Now here's the job XML.

```
<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <keepDependencies>false</keepDependencies>
  <properties>
    <jenkins.model.BuildDiscarderProperty>
      <strategy class="hudson.tasks.LogRotator">
        <daysToKeep>-1</daysToKeep>
        <numToKeep>-1</numToKeep>
        <artifactDaysToKeep>-1</artifactDaysToKeep>
        <artifactNumToKeep>-1</artifactNumToKeep>
      </strategy>
    </jenkins.model.BuildDiscarderProperty>
    <hudson.model.ParametersDefinitionProperty>
      <parameterDefinitions>
        <org.biouno.unochoice.ChoiceParameter plugin="uno-choice@1.4">
          <name>param001</name>
          <description></description>
          <randomName>choice-parameter-6543037871533</randomName>
          <visibleItemCount>1</visibleItemCount>
          <script class="org.biouno.unochoice.model.GroovyScript">
            <script>return [1,2,3,4]</script>
            <fallbackScript>return []</fallbackScript>
          </script>
          <projectName>test-001</projectName>
          <choiceType>PT_MULTI_SELECT</choiceType>
          <filterable>true</filterable>
        </org.biouno.unochoice.ChoiceParameter>
      </parameterDefinitions>
    </hudson.model.ParametersDefinitionProperty>
  </properties>
  <scm class="hudson.scm.NullSCM"/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers/>
  <concurrentBuild>false</concurrentBuild>
  <builders/>
  <publishers/>
  <buildWrappers/>
</project>
```

Notice the **&lt;script class="org.biouno.unochoice.model.GroovyScript"&gt;**.

- Execute job, save job, reload configuration from disk, restart, execute job
- Install active-choices-plugin 1.5.0
- Restart Jenkins
- Save job

Here's the job XML.

```
<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <keepDependencies>false</keepDependencies>
  <properties>
    <jenkins.model.BuildDiscarderProperty>
      <strategy class="hudson.tasks.LogRotator">
        <daysToKeep>-1</daysToKeep>
        <numToKeep>-1</numToKeep>
        <artifactDaysToKeep>-1</artifactDaysToKeep>
        <artifactNumToKeep>-1</artifactNumToKeep>
      </strategy>
    </jenkins.model.BuildDiscarderProperty>
    <hudson.model.ParametersDefinitionProperty>
      <parameterDefinitions>
        <org.biouno.unochoice.ChoiceParameter plugin="uno-choice@1.5.0">
          <name>param001</name>
          <description></description>
          <randomName>choice-parameter-6543037871533</randomName>
          <visibleItemCount>1</visibleItemCount>
          <script class="org.biouno.unochoice.model.GroovyScript"/>
          <projectName>test-001</projectName>
          <choiceType>PT_MULTI_SELECT</choiceType>
          <filterable>true</filterable>
        </org.biouno.unochoice.ChoiceParameter>
      </parameterDefinitions>
    </hudson.model.ParametersDefinitionProperty>
  </properties>
  <scm class="hudson.scm.NullSCM"/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers/>
  <concurrentBuild>false</concurrentBuild>
  <builders/>
  <publishers/>
  <buildWrappers/>
</project>
```

Noticed anything?

- Execute job. No issues.
- Reload configuration from disk.
- At this point, I have **successfully reproduced the issue**
- So let's update to 1.5.1
- Save the job

```
<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <keepDependencies>false</keepDependencies>
  <properties>
    <jenkins.model.BuildDiscarderProperty>
      <strategy class="hudson.tasks.LogRotator">
        <daysToKeep>-1</daysToKeep>
        <numToKeep>-1</numToKeep>
        <artifactDaysToKeep>-1</artifactDaysToKeep>
        <artifactNumToKeep>-1</artifactNumToKeep>
      </strategy>
    </jenkins.model.BuildDiscarderProperty>
    <hudson.model.ParametersDefinitionProperty>
      <parameterDefinitions>
        <org.biouno.unochoice.ChoiceParameter plugin="uno-choice@1.5.1-SNAPSHOT">
          <name>param001</name>
          <description></description>
          <randomName>choice-parameter-6543037871533</randomName>
          <visibleItemCount>1</visibleItemCount>
          <script class="org.biouno.unochoice.model.GroovyScript">
            <secureScript plugin="script-security@1.24">
              <script>return [1,2,3,4]</script>
              <sandbox>false</sandbox>
            </secureScript>
            <secureFallbackScript plugin="script-security@1.24">
              <script>return []</script>
              <sandbox>false</sandbox>
            </secureFallbackScript>
          </script>
          <projectName>test-001</projectName>
          <choiceType>PT_MULTI_SELECT</choiceType>
          <filterable>true</filterable>
        </org.biouno.unochoice.ChoiceParameter>
      </parameterDefinitions>
    </hudson.model.ParametersDefinitionProperty>
  </properties>
  <scm class="hudson.scm.NullSCM"/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers/>
  <concurrentBuild>false</concurrentBuild>
  <builders/>
  <publishers/>
  <buildWrappers/>
</project>
```

Again, not quite the same as 1.4, but our script is in persisted in the job configuration. So what
changed? The script is not wrapped around a &lt;secureScript&gt; tag, from the script-security-plugin.

## Issue fixed, quite

Users that installed 1.5.0 have lost their scripts. Unless they used a test bed server to install
and test the plug-in against their jobs, or they have some backup process in place, I am afraid
there is not much that can be done.

I also tested a very similar scenario, but going from 1.4 to 1.5.1, which is going to happen
to users that have not upgraded to 1.5.0. Again, the script was not correctly rendered.

But this time it is not exactly an issue in the plug-in code. Maybe a usability, an UX, issue.
What I got in the logs after upgrading from 1.4 to 1.5.1 was the following exception.

```
SEVERE: Error executing script for dynamic parameter
java.lang.RuntimeException: Failed to evaluate fallback script: script not yet approved for use
    at org.biouno.unochoice.model.GroovyScript.eval(GroovyScript.java:178)
    at org.biouno.unochoice.util.ScriptCallback.call(ScriptCallback.java:96)
    at org.biouno.unochoice.AbstractScriptableParameter.eval(AbstractScriptableParameter.java:233)
    at org.biouno.unochoice.AbstractScriptableParameter.getChoices(AbstractScriptableParameter.java:196)
    at org.biouno.unochoice.AbstractScriptableParameter.getChoices(AbstractScriptableParameter.java:184)
    at sun.reflect.NativeMethodAccessorImpl.invoke0(Native Method)
    at sun.reflect.NativeMethodAccessorImpl.invoke(NativeMethodAccessorImpl.java:62)
    at sun.reflect.DelegatingMethodAccessorImpl.invoke(DelegatingMethodAccessorImpl.java:43)
    at java.lang.reflect.Method.invoke(Method.java:498)
    at org.apache.commons.jexl.util.introspection.UberspectImpl$VelMethodImpl.invoke(UberspectImpl.java:258)
    at org.apache.commons.jexl.parser.ASTMethod.execute(ASTMethod.java:104)
    at org.apache.commons.jexl.parser.ASTReference.execute(ASTReference.java:83)
    at org.apache.commons.jexl.parser.ASTReference.value(ASTReference.java:57)
    at org.apache.commons.jexl.parser.ASTReferenceExpression.value(ASTReferenceExpression.java:51)
    at org.apache.commons.jexl.ExpressionImpl.evaluate(ExpressionImpl.java:80)
    at hudson.ExpressionFactory2$JexlExpression.evaluate(ExpressionFactory2.java:74)
    at org.apache.commons.jelly.expression.ExpressionSupport.evaluateRecurse(ExpressionSupport.java:61)
    at org.apache.commons.jelly.expression.ExpressionSupport.evaluateAsIterator(ExpressionSupport.java:94)
    at org.apache.commons.jelly.tags.core.ForEachTag.doTag(ForEachTag.java:89)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.JellyViewScript.run(JellyViewScript.java:95)
    at org.kohsuke.stapler.jelly.IncludeTag.doTag(IncludeTag.java:147)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.TagSupport.invokeBody(TagSupport.java:161)
    at org.apache.commons.jelly.tags.core.WhenTag.doTag(WhenTag.java:46)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.TagSupport.invokeBody(TagSupport.java:161)
    at org.apache.commons.jelly.tags.core.ChooseTag.doTag(ChooseTag.java:38)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.kohsuke.stapler.jelly.CallTagLibScript$1.run(CallTagLibScript.java:99)
    at org.apache.commons.jelly.tags.define.InvokeBodyTag.doTag(InvokeBodyTag.java:91)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.CallTagLibScript.run(CallTagLibScript.java:120)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.JellyViewScript.run(JellyViewScript.java:95)
    at org.kohsuke.stapler.jelly.IncludeTag.doTag(IncludeTag.java:147)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.JellyViewScript.run(JellyViewScript.java:95)
    at org.kohsuke.stapler.jelly.IncludeTag.doTag(IncludeTag.java:147)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.TagSupport.invokeBody(TagSupport.java:161)
    at org.apache.commons.jelly.tags.core.ForEachTag.doTag(ForEachTag.java:150)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.CallTagLibScript$1.run(CallTagLibScript.java:99)
    at org.apache.commons.jelly.tags.define.InvokeBodyTag.doTag(InvokeBodyTag.java:91)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.CallTagLibScript.run(CallTagLibScript.java:120)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.CallTagLibScript$1.run(CallTagLibScript.java:99)
    at org.apache.commons.jelly.tags.define.InvokeBodyTag.doTag(InvokeBodyTag.java:91)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$1.run(CoreTagLibrary.java:98)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.CallTagLibScript.run(CallTagLibScript.java:120)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.CallTagLibScript$1.run(CallTagLibScript.java:99)
    at org.apache.commons.jelly.tags.define.InvokeBodyTag.doTag(InvokeBodyTag.java:91)
    at org.apache.commons.jelly.impl.TagScript.run(TagScript.java:269)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.kohsuke.stapler.jelly.ReallyStaticTagLibrary$1.run(ReallyStaticTagLibrary.java:99)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.CallTagLibScript.run(CallTagLibScript.java:120)
    at org.apache.commons.jelly.impl.ScriptBlock.run(ScriptBlock.java:95)
    at org.apache.commons.jelly.tags.core.CoreTagLibrary$2.run(CoreTagLibrary.java:105)
    at org.kohsuke.stapler.jelly.JellyViewScript.run(JellyViewScript.java:95)
    at org.kohsuke.stapler.jelly.DefaultScriptInvoker.invokeScript(DefaultScriptInvoker.java:63)
    at org.kohsuke.stapler.jelly.DefaultScriptInvoker.invokeScript(DefaultScriptInvoker.java:53)
    at org.kohsuke.stapler.jelly.JellyRequestDispatcher.forward(JellyRequestDispatcher.java:55)
    at jenkins.model.ParameterizedJobMixIn.doBuild(ParameterizedJobMixIn.java:188)
    at hudson.model.AbstractProject.doBuild(AbstractProject.java:1759)
    at hudson.model.AbstractProject.doBuild(AbstractProject.java:1765)
    at sun.reflect.NativeMethodAccessorImpl.invoke0(Native Method)
    at sun.reflect.NativeMethodAccessorImpl.invoke(NativeMethodAccessorImpl.java:62)
    at sun.reflect.DelegatingMethodAccessorImpl.invoke(DelegatingMethodAccessorImpl.java:43)
    at java.lang.reflect.Method.invoke(Method.java:498)
    at org.kohsuke.stapler.Function$InstanceFunction.invoke(Function.java:324)
    at org.kohsuke.stapler.Function.bindAndInvoke(Function.java:167)
    at org.kohsuke.stapler.Function.bindAndInvokeAndServeResponse(Function.java:100)
    at org.kohsuke.stapler.MetaClass$1.doDispatch(MetaClass.java:124)
    at org.kohsuke.stapler.NameBasedDispatcher.dispatch(NameBasedDispatcher.java:58)
    at org.kohsuke.stapler.Stapler.tryInvoke(Stapler.java:746)
    at org.kohsuke.stapler.Stapler.invoke(Stapler.java:876)
    at org.kohsuke.stapler.MetaClass$5.doDispatch(MetaClass.java:233)
    at org.kohsuke.stapler.NameBasedDispatcher.dispatch(NameBasedDispatcher.java:58)
    at org.kohsuke.stapler.Stapler.tryInvoke(Stapler.java:746)
    at org.kohsuke.stapler.Stapler.invoke(Stapler.java:876)
    at org.kohsuke.stapler.Stapler.invoke(Stapler.java:649)
    at org.kohsuke.stapler.Stapler.service(Stapler.java:238)
    at javax.servlet.http.HttpServlet.service(HttpServlet.java:790)
    at org.eclipse.jetty.servlet.ServletHolder.handle(ServletHolder.java:812)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1669)
    at hudson.util.PluginServletFilter$1.doFilter(PluginServletFilter.java:135)
    at hudson.util.PluginServletFilter.doFilter(PluginServletFilter.java:126)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at hudson.security.csrf.CrumbFilter.doFilter(CrumbFilter.java:86)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:84)
    at hudson.security.UnwrapSecurityExceptionFilter.doFilter(UnwrapSecurityExceptionFilter.java:51)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at jenkins.security.ExceptionTranslationFilter.doFilter(ExceptionTranslationFilter.java:117)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at org.acegisecurity.providers.anonymous.AnonymousProcessingFilter.doFilter(AnonymousProcessingFilter.java:125)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at org.acegisecurity.ui.rememberme.RememberMeProcessingFilter.doFilter(RememberMeProcessingFilter.java:142)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at org.acegisecurity.ui.AbstractProcessingFilter.doFilter(AbstractProcessingFilter.java:271)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at jenkins.security.BasicHeaderProcessor.doFilter(BasicHeaderProcessor.java:93)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at org.acegisecurity.context.HttpSessionContextIntegrationFilter.doFilter(HttpSessionContextIntegrationFilter.java:249)
    at hudson.security.HttpSessionContextIntegrationFilter2.doFilter(HttpSessionContextIntegrationFilter2.java:67)
    at hudson.security.ChainedServletFilter$1.doFilter(ChainedServletFilter.java:87)
    at hudson.security.ChainedServletFilter.doFilter(ChainedServletFilter.java:76)
    at hudson.security.HudsonFilter.doFilter(HudsonFilter.java:171)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at org.kohsuke.stapler.compression.CompressionFilter.doFilter(CompressionFilter.java:49)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at hudson.util.CharacterEncodingFilter.doFilter(CharacterEncodingFilter.java:82)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at org.kohsuke.stapler.DiagnosticThreadNameFilter.doFilter(DiagnosticThreadNameFilter.java:30)
    at org.eclipse.jetty.servlet.ServletHandler$CachedChain.doFilter(ServletHandler.java:1652)
    at org.eclipse.jetty.servlet.ServletHandler.doHandle(ServletHandler.java:585)
    at org.eclipse.jetty.server.handler.ScopedHandler.handle(ScopedHandler.java:143)
    at org.eclipse.jetty.security.SecurityHandler.handle(SecurityHandler.java:553)
    at org.eclipse.jetty.server.session.SessionHandler.doHandle(SessionHandler.java:223)
    at org.eclipse.jetty.server.handler.ContextHandler.doHandle(ContextHandler.java:1127)
    at org.eclipse.jetty.servlet.ServletHandler.doScope(ServletHandler.java:515)
    at org.eclipse.jetty.server.session.SessionHandler.doScope(SessionHandler.java:185)
    at org.eclipse.jetty.server.handler.ContextHandler.doScope(ContextHandler.java:1061)
    at org.eclipse.jetty.server.handler.ScopedHandler.handle(ScopedHandler.java:141)
    at org.eclipse.jetty.server.handler.HandlerWrapper.handle(HandlerWrapper.java:97)
    at org.eclipse.jetty.server.Server.handle(Server.java:499)
    at org.eclipse.jetty.server.HttpChannel.handle(HttpChannel.java:311)
    at org.eclipse.jetty.server.HttpConnection.onFillable(HttpConnection.java:257)
    at org.eclipse.jetty.io.AbstractConnection$2.run(AbstractConnection.java:544)
    at winstone.BoundedExecutorService$1.run(BoundedExecutorService.java:77)
    at java.util.concurrent.ThreadPoolExecutor.runWorker(ThreadPoolExecutor.java:1142)
    at java.util.concurrent.ThreadPoolExecutor$Worker.run(ThreadPoolExecutor.java:617)
    at java.lang.Thread.run(Thread.java:745)
Caused by: org.jenkinsci.plugins.scriptsecurity.scripts.UnapprovedUsageException: script not yet approved for use
    at org.jenkinsci.plugins.scriptsecurity.scripts.ScriptApproval.using(ScriptApproval.java:459)
    at org.jenkinsci.plugins.scriptsecurity.sandbox.groovy.SecureGroovyScript.evaluate(SecureGroovyScript.java:168)
    at org.biouno.unochoice.model.GroovyScript.eval(GroovyScript.java:175)
    ... 167 more

```

This happens to scripts that are pending approval. Users now have to go to the manage page, and the
in process approval option. There they are able to approve/reject scripts, and manage their script
security. This is not part of the active-choices-plugin, but from the script-security-plugin.

Version 1.5.1 has just been released. If you intend to upgrade, please remember to always use
a test bed server, as well as to have a good backup process. And also that you may have
to have some time to approve your parameter scripts.

On the bright side:

* Our next releases will be better tested
* You probably won't see any issue related to making fields transient in BioUno plug-ins
* Maybe this post will prevent other developers of doing the same mistake

Apologies for the inconvenience.
