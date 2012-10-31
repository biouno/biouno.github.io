
  </div><!-- /#wrap -->

  <?php roots_footer_before(); ?>
  <footer id="content-info" class="<?php echo WRAP_CLASSES; ?>" role="contentinfo">
    <?php roots_footer_inside(); ?>
    <?php dynamic_sidebar('roots-footer'); ?>
    <p class="copy pull-right"><img title='TupiLabs' src='<?php echo site_url('/img/tupilabs_badget-32x32.png');?>' width='32px' height='32px' /> <small>&copy; 2011-<?php echo date('Y'); ?> TupiLabs</small></p>
  </footer>
  <?php roots_footer_after(); ?>

  <?php wp_footer(); ?>
  <?php roots_footer(); ?>

</body>
</html>