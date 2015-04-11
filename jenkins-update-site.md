---
layout: page
title: Jenkins Update Site
---

The plug-ins developed for BioUno are too niche-specific and thus aren't released to 
Jenkins update center. In order to install the plug-ins you have to add our update 
center.

# Install UpdateSites Manager plugin

The first step is install the [UpdateSites Manager plugin](https://wiki.jenkins-ci.org/display/JENKINS/UpdateSites+Manager+plugin). 
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
MIICMjCCAZugAwIBAgIJALtKi5rSkEBNMA0GCSqGSIb3DQEBBQUAMDIxCzAJBgNV
BAYTAkJSMRIwEAYDVQQIDAlTYW8gUGF1bG8xDzANBgNVBAoMBkJpb1VubzAeFw0x
NDAzMDgxNTE2MzVaFw0xNzAzMDcxNTE2MzVaMDIxCzAJBgNVBAYTAkJSMRIwEAYD
VQQIDAlTYW8gUGF1bG8xDzANBgNVBAoMBkJpb1VubzCBnzANBgkqhkiG9w0BAQEF
AAOBjQAwgYkCgYEAy2xgPFxaYIb6INfQTbR5hy+zCpTl9+Xe/IA0k/dxBWwozuKS
SxInH20kkaXPI/J4aLM+ygyCLslNc7hI9hNh7BMP5WbTzRorRo4tfmQzvEjdE94T
6+ElJOzHExToxUH8cAqKCrDDREvrzprNCQ7ylVRSrhaic7lI+FXZYCCntQcCAwEA
AaNQME4wHQYDVR0OBBYEFARhXoiXnoosPZr6nQDvT+OSQmWqMB8GA1UdIwQYMBaA
FARhXoiXnoosPZr6nQDvT+OSQmWqMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEF
BQADgYEAfxBd9+JT8hwLROWcbPKDLO87r/Gxd7+7dmdoNBl7oXhWht2QaHvEMoFP
9TV9GPeYZ6wFUaAsba6wyiMtcR9pAaktJWVzPoJ89Y5wbIstPkq9lCVuFO5q83+2
D+xEs/7Sc3L2bWSsCtk4Lb3O1QIsNS9uRMROhKPbIdRJgsOZyn0=
-----END CERTIFICATE-----</pre></td>
		</tr>
	</tbody>
</table>

In newer versions of Jenkins you have to add certificates used by third party
update centers manually. Download [our certificate](biouno.org/jenkins-update-center/biouno-update-center.crt) 
or execute `wget http://biouno.org/jenkins-update-center/biouno-update-center.crt`, and copy the certificate to `$JENKINS_ROOT/update-center-rootCAs/`. This directory will be located in your Jenkins root directory (likely the WEB-INF directory in your Web container or Jenkins root directory in most servers).

Now go back to "Manage Jenkins" > "Plugins" > "Advanced" and click 
"Check now". That will sync the plug-ins and you will be able to 
install any plug-in available in our update center.
