<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Joomlashack / Meritage Assets
 * @author		Joomlashack
 * @package		Wright
 *
 * Do not edit this file directly. You can copy it and create a new file called
 * 'custom.php' in the same folder, and it will override this file. That way
 * if you update the template ever, your changes will not be lost.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

$myUser =& JFactory::getUser();
$myview = JRequest::getVar('view');

// get the bootstrap row mode ( row / row-fluid )
$gridMode = $this->params->get('bs_rowmode','row-fluid');
$containerClass = 'container';
if ($gridMode == 'row-fluid') {
    $containerClass = 'container-fluid';
}

$bodyclass = "";
if ($this->countModules('toolbar')) {
	$bodyclass = "toolbarpadding";
}

?>
<doctype>
<html>
<head>
	
<w:head />
<link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

<?php if ((!$myUser->guest && $myview == 'home') || $myview == 'devotion') { ?>
<script type="text/javascript" src="components/com_holiness/app/js/libs/require.js" data-main="components/com_holiness/app/js/main"></script>
<?php } else {?>
<script type="text/javascript" src="components/com_holiness/app/js/libs/jquery.js"></script>
<?php } ?>
<?php if ($myUser->guest) { ?>
<style type="text/css">
#main {
    min-height: 100px!important;
}
#main-content {
  height: auto!important;
}
#footer {
  position: absolute;
  bottom: 0px;
}
</style>
<?php } ?>
</head>
<body<?php if ($bodyclass != "") :?> class="<?php echo $bodyclass?>"<?php endif; ?>>
    <?php if ($this->countModules('toolbar')) : ?>
    <!-- menu -->
	<w:nav containerClass="<?php echo $containerClass ?>" rowClass="<?php echo $gridMode;?>" wrapClass="navbar-fixed-top navbar-inverse" type="toolbar" name="toolbar" />
    <?php endif; ?>
    <div class="<?php echo $containerClass ?>" style="padding-left: 0px; padding-right: 0px;">


        <?php if ($this->countModules('menu')) : ?>
        <!-- menu -->
   		<w:nav name="menu" />
        <?php endif; ?>
        <!-- featured -->
        <?php if ($this->countModules('featured')) : ?>
        <div id="featured">
            <w:module type="none" name="featured" chrome="xhtml" />
        </div>
        <?php endif; ?>
        <!-- grid-top -->
        <?php if ($this->countModules('grid-top')) : ?>
        <div id="grid-top">
            <w:module type="<?php echo $gridMode; ?>" name="grid-top" chrome="wrightflexgrid" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('grid-top2')) : ?>
        <!-- grid-top2 -->
        <div id="grid-top2">
            <w:module type="<?php echo $gridMode; ?>" name="grid-top2" chrome="wrightflexgrid" />
        </div>
        <?php endif; ?>
        
        <?php if ($this->countModules('above-content')) : ?>
          <!-- above-content -->
          <div id="above-content">
            <w:module type="none" name="above-content" chrome="xhtml" />
          </div>
        <?php endif; ?>
        
        <?php if ($this->countModules('breadcrumbs')) : ?>
          <!-- breadcrumbs -->
          <div id="breadcrumbs">
            <w:module type="single" name="breadcrumbs" chrome="none" />
          </div>
        <?php endif; ?>
                
        <div id="main-content" class="<?php echo $gridMode; ?>">
            <!-- sidebar1 -->
            <aside id="sidebar1">
            	<w:module name="sidebar1" chrome="xhtml" />
            </aside>
            <!-- main -->
            <section id="main">
            	<!-- component -->
                
                <!-- main content -->
                <div>
            	  <w:content />
                </div>
                
                
                <?php if ($this->countModules('below-content')) : ?>
                <!-- below-content -->
                <div id="below-content">
                    <w:module type="none" name="below-content" chrome="xhtml" />
                </div>
                <?php endif; ?>
            </section>
            <!-- sidebar2 -->
            <aside id="sidebar2">
            	<w:module name="sidebar2" chrome="xhtml" />
            </aside>
        </div>
        <?php if ($this->countModules('grid-bottom')) : ?>
        <!-- grid-bottom -->
        <div id="grid-bottom" >
    			<w:module type="<?php echo $gridMode; ?>" name="grid-bottom" chrome="wrightflexgrid" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('grid-bottom2')) : ?>
        <!-- grid-bottom2 -->
        <div id="grid-bottom2" >
    			<w:module type="<?php echo $gridMode; ?>" name="grid-bottom2" chrome="wrightflexgrid" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('bottom-menu')) : ?>
        <!-- bottom-menu -->
		<w:nav containerClass="<?php echo $containerClass ?>" rowClass="<?php echo $gridMode;?>" name="bottom-menu" />
        <?php endif; ?>
        
    </div>
    
    <!-- footer -->
    <div class="wrapper-footer">
	    <footer id="footer" <?php if ($this->params->get('stickyFooter',1)) : ?> class="sticky"<?php endif;?>>
	    	 <div class="<?php echo $containerClass ?>">
	    		<?php if ($this->countModules('footer')) : ?>
					<w:module type="<?php echo $gridMode; ?>" name="footer" chrome="wrightflexgrid" />
			 	<?php endif; ?>
				<w:footer />
			</div>
	    </footer>
    </div>
	
</body>
</html>
