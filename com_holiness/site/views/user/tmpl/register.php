<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$doc = JFactory::getDocument();
$doc->addStyleDeclaration('body {background-color: #F1F1F1; background-image: url(' . JRoute::_(JURI::base() . 'components/com_holiness/assets/images/body-bg.jpg') . ');-webkit-background-size: 100% auto;-moz-background-size: 100% auto;-o-background-size: 100% auto;background-size: 100% auto;background-repeat: no-repeat;}#main-content {margin-top: 0px!important;background-color:transparent!important;}#main {border-left: 0px!important; border-right:0px!important; padding: 0px!important;width:100%; }');
?>

<div class="row-fluid" style="min-height: 100%; padding: 20px 0px 20px 0px;">
  <div id="reg-cont" class="span4 offset2">
    <div class="row-fluid">
      <h1 style="color: #0079C1">Connecting Christians from around the world</h1>
      
      <h2 style="color: #fd7800;">A website where only Jesus Christ is glorified</h2>

      <form id="reg-form" style="margin-top: 20px; background-color: #F0F0F0;" class="well" action="index.php" method="post">
        <h3 style="color:#0079C1; margin-top: 0px; padding-top: 0px">Register</h3>

        <div id="register-loading" class="progress progress-striped active" style="display:none">
            <div class="bar" style="width: 100%;"></div>
        </div>
        
        <div id="register-loaded" class="alert" style="display:none"></div>
        
        <div class="controls controls-row">
            <input type="text" placeholder="Full Name" id="fullname" name="fullname" class="span12" required="">
        </div>
    
        <div class="controls controls-row">
          <input type="text" placeholder="Username" class="span12" id="username" name="username" required="">
        </div>
            
        <div class="controls">
          <input type="text" placeholder="Email Address"  name="email" id="email" class="span12" required="">
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Password" class="span12" autocomplete="off" value="" id="password" name="password" required="">
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Re-enter Password" class="span12" autocomplete="off" value="" id="password2" name="password2" required="">
        </div>
    
        <p style="font-size: 12px; margin-top: 5px;">By clicking Sign Up, you agree to our Terms and that you have read our Data Use Policy.</p>
            
        <div class="row-fluid">
          <div class="span5"><button class="btn btn-large btn-block btn-primary" type="submit">Sign Up</button></div>
          <div class="span5 offset1" style="padding-top: 8px"><i class="icon-lock"> </i> <a href="#" class="" id="login-link" title="Click here if you are not already a member">Already a member? Login</a></div>
        </div>
        
        <input type="hidden" value="com_holiness" name="option">
        <input type="hidden" value="user.create" name="task">
        <?php echo JHtml::_('form.token');?>
      </form>
      
      <form id="login-form" style="margin-top: 20px; background-color: #F0F0F0; display: none" class="well" action="<?php echo JRoute::_('index.php'); ?>" method="post">
        <h3 style="color:#0079C1; margin-top: 0px; padding-top: 0px">Login</h3>
        
        <div class="alert alert-error alert-success" style="display:none"></div>

        <div class="progress progress-striped active" style="display:none">
            <div class="bar" style="width: 100%;"></div>
        </div>
        
        
        <div class="controls">
          <input type="text" placeholder="Email Address"  name="username" id="username2" class="span12" required="" >
        </div>
            
        <div class="controls">
          <input type="password" placeholder="Password" class="span12" autocomplete="off" value="" id="jform_password1" name="password" required="">
        </div>
         <p>&nbsp;</p>
         
        <input type="hidden" value="com_users" name="option">
        <input type="hidden" value="<?php echo base64_encode(JURI::base()); ?>" name="return">
        <input type="hidden" value="user.login" name="task">
        <?php echo JHtml::_('form.token');?>
        
        <div class="row-fluid">
          <div class="span5"><button class="btn btn-large btn-block btn-primary" id="login" type="submit">Login</button></div>
          <div class="span5 offset1" style="padding-top: 8px"><i class="icon-user"> </i> <a class="" href="#" id="reg-link" title="Click here if you are not already a member">Not registered? Sign Up</a></div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo JRoute::_(JURI::base() . 'components/com_holiness/assets/js/register.js'); ?>"></script>