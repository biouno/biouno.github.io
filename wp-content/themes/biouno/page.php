<?php get_header(); ?>
  <?php roots_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <div class='<?php echo FULLWIDTH_CLASSES; ?>' id='logo'>
    	<a href=""><h1>BioUno</h1></a>
    </div>
    <div id='menu' class="<?php echo SIDEBAR_CLASSES; ?>">
	    <div class='well well-lean'>
	    	<ul class="nav nav-list">
	    		<li class="nav-header">Principal</li>
	    		<li><a href='<?php echo site_url('/'); ?>'>Home</a></li>
	    		<li><a href='<?php echo site_url('/biouno-plugins');?>'>BioUno Plug-ins</a></li>
	    		<li><a href='<?php echo site_url('/update-site');?>'>Update site</a></li>
	    		<li class='divider'></li>
	    		<li class="nav-header">Documentation</li>
	    		<li><a href='<?php echo site_url('/getting-started');?>'>Getting started</a></li>
	    		<li><a href='<?php echo site_url('/scheduling-your-first-job');?>'>Scheduling your first job</a></li>
	    		<li><a href='<?php echo site_url('/configuring-job-notification');?>'>Configuring job notification</a></li>
	    		<li><a href='<?php echo site_url('/running-mrbayes-in-biouno');?>'>Running MrBayes in BioUno</a></li>
	    		<li><a href='<?php echo site_url('/running-structure-in-biouno');?>'>Running Structure in BioUno</a></li>
	    		<li><a href='<?php echo site_url('/running-figtree-in-biouno');?>'>Running FigTree in BioUno</a></li>
	    		<li><a href='<?php echo site_url('/creating-a-pipeline-using-MrBayes and-FigTree');?>'>Creating a pipeline using MrBayes and FigTree</a></li>
	    		<li><a href='<?php echo site_url('/reproducing-an-existing-pipeline');?>'>Reproducing an existing pipeline</a></li>
	    		<li><a href='<?php echo site_url('/publications');?>'>Publications</a></li>
	    		<li class='divider'></li>
	    		<li class="nav-header">Project Information</li>
	    		<li><a href='<?php echo site_url('/motivation');?>'>Motivation</a></li>
	    		<li><a href='<?php echo site_url('/objectives');?>'>Objectives</a></li>
	    		<li><a href='<?php echo site_url('/team');?>'>Team</a></li>
	    		<li><a href='<?php echo site_url('/sponsors');?>'>Sponsors</a></li>
	    		<li><a href='<?php echo site_url('/license');?>'>License</a></li>
	    		<li><a href='<?php echo site_url('/how-to-cite-biouno');?>'>How to cite BioUno</a></li>
	    		<li class='divider'></li>
	    		<li><a href='<?php echo site_url('/contact');?>'>Contact</a></li>
	    	</ul>
	    </div>
    </div>
    <?php roots_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
        <?php roots_loop_before(); ?>
        <?php get_template_part('loop', 'page'); ?>
        <?php roots_loop_after(); ?>
      </div><!-- /#main -->
    <?php roots_main_after(); ?>
    </div><!-- /#content -->
  <?php roots_content_after(); ?>
<?php get_footer(); ?>