<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BioUno | {title_for_layout}</title>
    <meta name="description" content="Continuous Integration tools and techniques applied to Bioinformatics">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="{base_url}assets/css/bootstrap.css" rel="stylesheet">
    <link href="{base_url}assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="{base_url}assets/css/biouno.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Alegreya:900,400' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-28429437-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    
    </script>
</head>

<body class="home">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <h1><a href='{base_url}' title='BioUno Home'>BioUno</a></h1>
                    <h2 class=''>Continuous Integration tools and techniques applied in Bioinformatics</h2>
                </div>
            </div>
        </div>
    </header>
    <section id="main">
        <div class='container'>
            <div class='row'>
                <div id='menu' class="span3">
                    <ul class="">
                        <li class="title">Principal</li>
                        <li><a href='{base_url}'>Home</a></li>
                        <li><a href='{base_url}jenkins-plugins'>Jenkins Plug-ins</a></li>
                        <li><a href='{base_url}update-site'>Jenkins Update site</a></li>
                        <li class='divider'></li>
                        <li class="title">Documentation</li>
                        <li><a href='{base_url}docs/getting-started'>Getting started with Jenkins</a></li>
                        <li><a href='{base_url}docs/scheduling-your-first-job'>Scheduling your first job</a></li>
                        <li><a href='{base_url}docs/configuring-job-notification'>Configuring job notification</a></li>
                        <li><a href='{base_url}docs/reproducing-an-existing-pipeline'>Reproducing an existing pipeline</a></li>
                        <li class='divider'></li>
                        <li class="title">Tools</li>
                        <li><a href='{base_url}tools/running-mrbayes-with-jenkins'>Running MrBayes with Jenkins</a></li>
                        <li><a href='{base_url}tools/running-structure-in-parallel-with-jenkins'>Running Structure in parallel with Jenkins</a></li>
                        <li><a href='{base_url}tools/creating-a-pipeline-using-mrbayes and-figtree'>Creating a pipeline using MrBayes and FigTree</a></li>
                        <li><a href='{base_url}tools/using-jenkins-r-plugin'>Using Jenkins R Plug-in</a></li>
                        <li><a href='{base_url}tools/creating-graphs-with-r-and-creating-image-galleries'>Creating graphs with R and creating image galleries</a></li>
                        <li class='divider'></li>
                        <li class="title">Project Information</li>
                        <li><a href='{base_url}team'>Team</a></li>
                        <li><a href='{base_url}sponsors'>Sponsors</a></li>
                        <li><a href='{base_url}license'>License</a></li>
                        <li class='divider'></li>
                        <li><a href='{base_url}contact'>Contact</a></li>
                    </ul>
                </div>
                {content_for_layout}
            </div>
        </div>
    </section>
    <hr/>
    <footer>
        <div class="container">
            <div class="row">
                <div class="span12 right">
                    <p><a href="http://www.tupilabs.com" title="TupiLabs"><small>TupiLabs &copy; 2011-2012 </small><img src="{base_url}assets/img/tupilabs_badget-32x32.png" width="24px" title="TupiLabs" /></a></p>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="{base_url}assets/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="{base_url}assets/js/biouno.js"></script>
</body>
</html>