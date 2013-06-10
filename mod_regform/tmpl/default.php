<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$doc = JFactory::getDocument();
$doc->addStyleDeclaration('body {background-image: url(' . JRoute::_(JURI::base() . 'modules/mod_regform/files/images/body-bg.jpg') . ');-webkit-background-size: 100% auto;-moz-background-size: 100% auto;-o-background-size: 100% auto;background-size: 100% auto;background-repeat: no-repeat;}');
?>

<div class="row-fluid" style="min-height: 100%; padding: 20px 0px 20px 0px;">
  <!--

  -->
  
  <div id="reg-cont" class="span4 offset2">
    <div class="row-fluid">
      <h1 style="color: #0079C1">Connecting Christians from around the world</h1>
      
      <h2 style="color: #fd7800;">A website where only Jesus Christ is glorified</h2>

      <form id="reg-form" style="margin-top: 20px; background-color: #F0F0F0;" class="well" action="<?php echo JRoute::_('index.php?option=users&task=registration.register'); ?>" method="post">
        <h3 style="color:#0079C1; margin-top: 0px; padding-top: 0px">Register</h3>
    
        <div class="controls controls-row">
            <input type="text" placeholder="Full Name" id="jform_name" name="jform[name]" class="span12">
        </div>
    
        <div class="controls controls-row">
          <input type="text" placeholder="Username" class="span12" id="jform_username" name="jform[username]">
        </div>
            
        <div class="controls">
          <input type="text" placeholder="Email Address"  name="jform[email1]" id="jform_email1" class="span12">
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Password" class="span12" autocomplete="off" value="" id="jform_password1" name="jform[password1]">
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Re-enter Password" class="span12" autocomplete="off" value="" id="jform_password2" name="jform[password2]">
        </div>
    
        <p style="font-size: 12px; margin-top: 5px;">By clicking Sign Up, you agree to our Terms and that you have read our Data Use Policy.</p>
            
        <div class="row-fluid">
          <div class="span5"><button class="btn btn-large btn-block btn-primary" type="button">Sign Up</button></div>
          <div class="span5"><a href="#" class="btn btn-large btn-block btn-primary" id="login-link" title="Click here if you are not already a member">Login</a></div>
        </div>
    
        <input type="hidden" value="com_users" name="option">
        <input type="hidden" value="registration.register" name="task">
        <?php echo JHtml::_('form.token');?>
      </form>
      
      <form id="login-form" style="margin-top: 20px; background-color: #F0F0F0; display: none" class="well" action="<?php echo JRoute::_('index.php?option=users&task=registration.register'); ?>" method="post">
        <h3 style="color:#0079C1; margin-top: 0px; padding-top: 0px">Login</h3>
        <div class="controls">
          <input type="text" placeholder="Email Address"  name="jform[email1]" id="jform_email1" class="span12">
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Password" class="span12" autocomplete="off" value="" id="jform_password1" name="jform[password1]">
        </div>
            
        <div class="row-fluid">
          <div class="span5"><button class="btn btn-large btn-block btn-primary" id="" type="button">Login</button></div>
          <div class="span5"><a class="btn btn-large btn-block btn-primary" href="#" id="reg-link" title="Click here if you are not already a member">Not registered?</a></div>
        </div>
    
        <input type="hidden" value="com_users" name="option">
        <input type="hidden" value="registration.register" name="task">
        <?php echo JHtml::_('form.token');?>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
jQuery.noConflict();

(function ($, window) {
    function wResize() {
        var winW = $(window).width(), 
            Body = $('body'),
            cont = $('#reg-cont');

        if ( winW < '1024') {
            if (cont.hasClass('offset2')) {
               cont.removeClass('offset2');
            }               
        }
        if ( winW >= '1024' ) {
            if (!cont.hasClass('offset2')) {
               cont.addClass('offset2');
            } 
        }         

    }
    
    
    function logIn() {
        var loginform = $('#login-form'), regform = $('#reg-form'), link = $('#reg-link');

        link.on('click', function () {
            loginform.hide(function () {
                regform.show();
            });    
        });
    }
    
    
    function register() {
        var loginform = $('#login-form'), regform = $('#reg-form'), link = $('#login-link');

        link.on('click', function () {
            regform.hide(function () {
                loginform.show();
            });    
        });   
    }
    
    $(function() {
        wResize();
        register();
        logIn();

        $(window).resize(function() {
            wResize();
        });
    });
}(jQuery, window));
</script>
