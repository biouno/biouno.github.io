---
layout: single
title: Using masked passwords with the Active Choices Plug-in
author: Bruno P. Kinoshita
---

The [Mask Passwords Plug-in](https://wiki.jenkins.io/display/JENKINS/Mask+Passwords+Plugin) allow users to automatically
mask passwords in the console. You can also create global passwords, which is similar to what you can do in other plug-ins such
as the EnvInject Plug-in.

The main difference is that any parameter defined in the global parameters section, is automatically masked, should
it appears in the console output.

The plug-in has a [Builder](http://javadoc.jenkins-ci.org/hudson/tasks/Builder.html) that iterates
through the parameters to annotate the console output. You can read the code that does that
[here](https://github.com/jenkinsci/mask-passwords-plugin/blob/f8fb42b62323096970fd379f2439dd5a6fdc2a35/src/main/java/com/michelin/cio/hudson/plugins/maskpasswords/MaskPasswordsBuildWrapper.java#L89).

But if you need the value from that global parameter, in one of your Active Choices parameters,
you can still mimic what that builder is doing. Here is an example.

```groovy
// Assuming you have a global parameter called "build_password"

import com.michelin.cio.hudson.plugins.maskpasswords.*;

// getting global masked password...
maskPasswordsConfig = MaskPasswordsConfig.getInstance()
varPasswordPairs = maskPasswordsConfig.getGlobalVarPasswordPairs()

// default to empty
myPassword = ''
// check if we have a global pair with that password
varPasswordPairs.each { pair ->
    if (pair.getVar().equals("build_password")) {
        // this will use Jenkins' Secret class to decrypt it...
        myPassword = pair.password
    }
}

// use your myPassword variable after here
```
## Related tickets

- [JENKINS-36456: Active Choices Reactive Parameter can't access Mask Passwords (Global name/password pairs)](https://issues.jenkins-ci.org/browse/JENKINS-36456)