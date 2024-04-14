---
layout: single
title: "Using Job DSL Plugin with Active Choices Plugin"
description: "How to use Job DSL Plugin to automate the creation the jobs with Active Choices parameters"
category:
tags: [jenkins]
author: Bruno P. Kinoshita
excerpt_separator: <!--more-->
date: 2018-01-29
---

The [Active Choices plugin](https://wiki.jenkins.io/display/JENKINS/Active+Choices+Plugin) can be
used to increase the reactiveness of your parameters. Using the plugin, you are able to better plan
how your parameters will react when a user changes other parameters.

However, managing hundreds of Groovy scripts and several different job parameters may be quite a challenge.

You could use the Scriptler parameter, externalise the configuration to a configuration management
tool such as Puppet, Ansible, or SaltStack, or simply build your own automation with some language
such as Python, Perl, Shell script, and access Jenkins' API via its Groovy console or remotely
via REST services.

In today's post I will show a way of achieving it with the [Job DSL Plugin](https://wiki.jenkins.io/display/JENKINS/Job+DSL+Plugin). With his plugin, you are able to use a domain-specific language (or DSL) to
programmatically create Jenkins projects.

<!--more-->

## Job DSL sample DSL creation script

Our example project is quite simple. We will use one of our examples from the Wiki. More specifically, the
example with some Brazilian states and respective cities. So that when you choose a state, its cities are displayed
as options as another parameter.

Normally you would create a project manually but when you use the Job DSL you normally start by creating
the **seed project**. When this seed project is built it will create new projects, and hence the name.
So this is only built when you need a new project, and it can be triggered manual or automatically.

Let's start with the new project. Create a FreeStyle project with any name you prefer.
For this example I will be using &ldquo;job-dsl-active-choices-states-seed&rdquo;.

You can also parameterise your project, allowing you to use parameters to further customise your
new projects. I will create a String Parameter named &ldquo;NEW_PROJECT_NAME&rdquo;. And I will use
this variable as the name of the new project.

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc01.png' /></center>

Next we will add a build step. Click Add build steps, and choose &rdquo;Process Job DSLs&rdquo;. Here you
will be asked whether you have your DSL sitting somewhere in your workspace, or if you would like to create
one.

This means that you can even store your DSLs in a repository somewhere like GitHub, GitLab, BitBucket, etc.

Here's what the example from our Wiki looks like in the Job DSL syntax.

```
job ("$NEW_PROJECT_NAME") {
    parameters {
        activeChoiceParam('States') {
            description('Select a state option')
            filterable()
            choiceType('SINGLE_SELECT')
            groovyScript {
                script('["Sao Paulo", "Rio de Janeiro", "Parana:selected", "Acre"]')
                fallbackScript('return ["ERROR"]')
            }
        }
        activeChoiceReactiveParam('Cities') {
            description('Active Choices Reactive parameter')
            filterable()
            choiceType('CHECKBOX')
            groovyScript {
                script('''
if (States.equals('Sao Paulo')) {
	return ['Barretos', 'Sao Paulo', 'Itu'];
} else if (States.equals('Rio de Janeiro')) {
	return ['Rio de Janeiro', 'Mangaratiba']
} else if (States.equals('Parana')) {
	return ['Curitiba', 'Ponta Grossa']
} else if (States.equals('Acre')) {
	return ['Rio Branco', 'Acrelandia']
} else {
	return ['Unknown state']
}
                       ''')
                fallbackScript('return ["Script error!"]')
            }
            referencedParameter('States')
        }
    }
}
```

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc02.png' /></center>

When you build your seed project, it will ask you for any parameters you may have configured your project
with.

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc03.png' /></center>

And then once executed you will have your new project created! What's even better, you are able to track the
projects created from the seed project page in Jenkins. As in the following figure.

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc04.png' /></center>

And likewise, you can also find the seed project from your created project's page.

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc05.png' /></center>

Finally, here's the result. Same as if you had manually created the project. But now you can create as many
projects like this as you would like.

<center><img src='/posts/2018-01-29-using-job-dsl-plugin-with-active-choices-plugin/sc06.png' /></center>

## Conclusion

Depending on how complex you design your projects, you may need to spend some long time
reading the [job dsl plugin API](https://jenkinsci.github.io/job-dsl-plugin/) - which is great and
well up to date.

You will probably use parameters in your project seeds, to further customise your new projects. You
can even use Active Choices parameters for that :-) And you can version control your parameters
within your project configuration.

It might still be hard to track if you have several scripts and you want to re-use them in
different projects. In that case, you may want to look into using Scriptler plugin as well.

As per the Perl motto [TIMTOWTDI](https://en.wikipedia.org/wiki/There%27s_more_than_one_way_to_do_it),
this is just one way of achieving it. Hope you find it interesting and useful!

Happy hacking!

