<div class="wrap-all">
   <span class="sr-only"><a href=".main-content">Skip to main content</a> <a href="#search-flyout">Skip to search</a></span>
    <!-- Header Region -->
   <div class="site-banner">
    <div class="navbar navbar-default">

	      <nav class="navbar-buttons">
	        <span class="menu-icon menu-toggle" role="button" aria-label="Main Menu"><a href="#"><span class="sr-only">Main Menu</span><span class="icon shanticon-menu"></span></a></span><!-- desktop > 768 drilldown menu : main-menu -->
	        <span class="menu-explore menu-exploretoggle" role="button" aria-label="Explore Collections"><a href="#"><span>Explore</span><span class="icon shanticon-directions"></span></a></span><!-- mobile < 768 : collections -->
	      </nav>

	      <h1 class="navbar-header<?php if(!$variables['shanti_site']) { print " default"; } ?>">
	        <a href="<?php print $variables['home_url']; ?>" class="navbar-brand" title="<?php print $site_name; ?> Homepage">
	          <?php if($variables['shanti_site']): ?>
	            <span class="icon shanticon-logo"></span><span class="shanti">SHANTI</span><?php if($variables['use_admin_site_title']) {
		            	print "<span class=\"site-title\">{$site_name}</span>";
		            } ?>
	          <?php else: ?>
	            <img src="<?php print $logo; ?>" class="site-logo" /> <span class="site-title"><?php print $site_name; ?></span>
	          <?php endif; ?>
	          <?php if($site_slogan) { print '<span class="site-slogan">' . $site_slogan . '</span>' ;} ?>
	        </a>
	      </h1>

	      <!-- HEADER REGION -->
	      <nav id="sarvaka-header" class="region navbar-collapse collapse navtop"> <!-- desktop display > 768 -->
	         <form class="form">
	         <fieldset>
	          <ul class="nav navbar-nav navbar-right">
		            <!-- If admin puts blocks in  header, render here -->
		            <?php print render($page['header']);  ?>
	          </ul>
	         </fieldset>
	         </form>
	       </nav>
	       <!-- End of HEADER region -->
     </div>
     <!-- include shanti-explore-menu if it exists -->
     <?php if(module_exists('explore_menu')) { print render($variables['explore_menu']); } ?>
    </div>


    <!-- Begin Content Region -->
    <main class="main-wrapper container-fluid">
      <article class="main-content" role="main">
        <section class="row" role="banner">

          <!-- Banner Region -->
          <div class="titlearea banner<?php print $variables['banner_class']; ?>">
           <div>
            <header role="banner">
              <h1 class="page-title"><span class="icon shanticon-<?php print $variables['icon_class']; ?>"></span><span class="page-title-text">
                <?php
              	if(!empty($variables['default_title']) && !empty($variables['prefix_default_title'])) {
              		print ($title == '')? $variables['default_title'] : $variables['default_title'] . ': ' . $title;
              	} else {
              		print ($title == '')? $variables['default_title']:$title;
              	}
                ?></span>
              </h1>
            </header> 
              <nav class="breadwrap" style="display:none;">
                <?php print theme('breadcrumb', array('breadcrumb' => $breadcrumb)); ?>
              </nav>
              <div class="banner-content">
                <?php print render($page['banner']); ?>
              </div>
              <div class="banner-tabs">
                <?php
                  // For view/edit tabs
                  print render($tabs);
                ?>
              </div>
            </div>
          </div>

        </section> <!-- End of Banner Row -->


        <!-- Begin Content Row -->
        <section class="row row-offcanvas<?php print " $offcanvas_trigger_sb"; ?>" role="main">

          <!-- Sidebar First Region -->
          <?php if ($page['sidebar_first']): ?>
            <section id="sidebar-first" class="region sidebar sidebar-first sidebar-offcanvas<?php print " $bsclass_sb1"; ?> equal-height">
              <?php print render($page['sidebar_first']); ?>
            </section>
          <?php endif; ?>

          <!-- Begin Page Content -->
          <section class="content-section <?php if (!empty($bsclass_main)) { print " $bsclass_main"; } ?> equal-height">
	        
		        <button type="button" class="btn btn-default view-offcanvas-sidebar" data-toggle="offcanvas" style="display:none;">
	            <span class="icon"></span>
	          </button>
          
          	<!-- Message Area -->
          	<?php if (!empty($messages)) { print "<div class=\"messages\">$messages</div>"; } ?>
          	
          	<!-- Main Content -->
            <div class="tab-content container-fluid">
              <article class="tab-pane main-col active" id="tab-overview">
              	 <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                 <?php print render($page['content']); ?>
              
	              <!-- All versus My Visualization Tabs -->
	              <div class="sn-tab-blocks">
					        <ul class="nav nav-tabs nav-justified" role="tablist">
					          <li class="active"><a href="#allvis" role="tab" data-toggle="tab" id="allvis-tab"><?php print t('All Visualizations'); ?></a></li>
					          <li><a href="#myvis" role="tab" data-toggle="tab" id="myvis-tab"><?php print t('My Visualizations'); ?></a></li>
					        </ul>
					        <!-- Tab panes -->
					        <div class="tab-content">
					          <div class="tab-pane active" id="allvis">
					          	<?php if(!empty($page['allvis'])) { print $page['allvis']['#markup']; } ?>
					          </div>
					          <div class="tab-pane" id="myvis">
					          	<?php 
					          	    if (!$logged_in) {
					          	        print '<div class="msg"><p>' . 
					          	                t('Use the log in link from the Main Menu in the upper right corner to view your visualizations.') .
					          	                '</p></div>';
					          	    } elseif (!empty($page['myvis']))  {
					          	         print $page['myvis']['#markup']; 
                                    } 
                                   ?>
					          </div>
					        </div>
					      </div>
              </article>             
            </div>
          </section>
          <!-- END Content -->

          <!-- Sidebar Second Region -->
          <?php if ($page['sidebar_second']): ?>
            <section id="sidebar-second" class="region sidebar sidebar-second pull-right sidebar-offcanvas<?php print " $bsclass_sb2"; ?> equal-height">
              <?php print render($page['sidebar_second']); ?>
            </section>
          <?php endif; ?>
        </section>

        <a href="#" class="back-to-top" role="button" aria-label="Back to Top of Page"><span class="icon fa"></span></a>
      </article>

		  <!-- Search Flyout -->
		  <?php if(!empty($page['search_flyout'])): ?>
		      <!--print render($page['search_flyout']); -->
				<div id="search-flyout" class="region extruder right" role="search" style="display: none;">
				   <?php print render($page['search_flyout']); ?>
				</div>
	    <?php endif; ?>

    </main> <!-- End Main Content -->


  <!-- LOAD menus -->
  <section id="menu" class="menu-main" style="display:none;">
    <nav id="menu-drill">
     <?php print $variables['user_menu_links']; ?>
    </nav>
  </section><!-- END menu -->
  
</div> <!-- End wrap-all -->

<!-- Footer -->
<footer class="footer">
  <div>
    <p>&copy; Copyright 2016</p>
    <?php print render($page['footer']); ?>
  </div>
</footer>

<!-- Admin Footer -->
<div id="admin-footer">
  <?php print render($page['admin_footer']); ?>
</div>




