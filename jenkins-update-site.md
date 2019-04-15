---
layout: single
title: Jenkins Update Site
---

The plug-ins developed for BioUno are too niche-specific and thus aren't released to 
Jenkins update center. In order to install the plug-ins you have to add our update 
center.

# Install UpdateSites Manager plugin

The first step is install the [UpdateSites Manager plugin](https://wiki.jenkins.io/display/JENKINS/UpdateSites+Manager+plugin). 
You don't need to restart Jenkins after you have installed this plug-in.

# Add BioUno Update Center

There will be a new entry in your configuration screen, to Manage UpdateSites. There you 
will find the option to add a new update site. Fill the form with the following values:

<table class='pure-table pure-table-bordered'>
	<thead>
		<tr>
			<th>Property</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Disable this site</td><td>Uncheck</td>
		</tr>
		<tr>
			<td>ID</td><td>biouno-update-center</td>
		</tr>
		<tr>
			<td>URL</td><td>http://biouno.org/jenkins-update-center/update-center.json</td>
		</tr>
		<tr>
			<td>Note</td><td>BioUno Jenkins update center</td>
		</tr>
		<tr>
			<td>Need CA Certificate</td><td>Check</td>
		</tr>
		<tr>
			<td>CA Certificate</td><td><pre>-----BEGIN CERTIFICATE-----
MIICFTCCAX4CCQC6q+72+iGszzANBgkqhkiG9w0BAQsFADBPMQswCQYDVQQGEwJO
WjEUMBIGA1UECAwLTmV3IFplYWxhbmQxGTAXBgNVBAcMEEF1Y2tsYW5kIENlbnRy
YWwxDzANBgNVBAoMBkJpb1VubzAeFw0xNzA0MTUwOTQwNDVaFw0yMDA0MTQwOTQw
NDVaME8xCzAJBgNVBAYTAk5aMRQwEgYDVQQIDAtOZXcgWmVhbGFuZDEZMBcGA1UE
BwwQQXVja2xhbmQgQ2VudHJhbDEPMA0GA1UECgwGQmlvVW5vMIGfMA0GCSqGSIb3
DQEBAQUAA4GNADCBiQKBgQDLbGA8XFpghvog19BNtHmHL7MKlOX35d78gDST93EF
bCjO4pJLEicfbSSRpc8j8nhosz7KDIIuyU1zuEj2E2HsEw/lZtPNGitGji1+ZDO8
SN0T3hPr4SUk7McTFOjFQfxwCooKsMNES+vOms0JDvKVVFKuFqJzuUj4VdlgIKe1
BwIDAQABMA0GCSqGSIb3DQEBCwUAA4GBAIA4Ez4wVB8wzwYXz+N9Bky6qt7TYiKm
cS8yHOQ6ZMqPzY3VLO39nrfm/mc5H9CYhKEPBk3a35/4seLU8koxpEOk5APvj8tb
q/5H2CYW2f9Co2HJc01lXd+68+vfbXnvHgalocpQo5ptal1MPbOdVJFkQ4g0L4Gh
MbsJaI+P6NjE
-----END CERTIFICATE-----</pre></td>
		</tr>
	</tbody>
</table>

In newer versions of Jenkins you have to add certificates used by third party
update centers manually. Download [our certificate](http://biouno.org/jenkins-update-center/biouno-update-center.crt) 
or execute `wget http://biouno.org/jenkins-update-center/biouno-update-center.crt`, and copy the certificate to `$JENKINS_ROOT/update-center-rootCAs/`. This directory will be located in your Jenkins root directory (likely the WEB-INF directory in your Web container or Jenkins root directory in most servers).

Now go back to "Manage Jenkins" > "Plugins" > "Advanced" and click 
"Check now". That will sync the plug-ins and you will be able to 
install any plug-in available in our update center.

## Generating update center

When generating the update center, there are two repositories to clone.

* https://github.com/biouno/jenkins-update-center
* https://github.com/biouno/backend-update-center2

The jenkins-update-center project contains the update center HTML and JSON files. This is server as GitHub
Pages, from the `gh-pages` branch. When our certificate expires, using the original key we can generate
a new certificate with a new expiration date. Then put the `.crt` file in the jenkins-update-center root directory.

The backend-update-center2 is used to update the JSON and HTML files, with a command such as.

```
mvn -X -e exec:java -Dexec.args="-id biouno-update-center \
    -h /dev/null \
    -o /home/kinow/Development/java/biouno/jenkins-update-center/update-center.json \
    -r /home/kinow/Development/java/biouno/jenkins-update-center/release-history.json \
    -repository http://biouno.org/jenkins-update-center/ \
    -hpiDirectory /home/kinow/Development/java/biouno/jenkins-update-center \
    -nowiki \
    -key biouno-update-center.key \
    -certificate biouno-update-center.crt \
    -root-certificate biouno-update-center.crt \
    -pretty"
```
