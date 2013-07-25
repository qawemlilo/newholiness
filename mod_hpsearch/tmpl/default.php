<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hpsearch/assets/css/typeahead.js-bootstrap.css');
$document->addStyleDeclaration(
'input, textarea, .uneditable-input {
  width: 300px;
}');
$document->addScript(JURI::base() . 'modules/mod_hpsearch/assets/js/hogan.min.js');
?>

<div class="row-fluid affix" style="padding: 10px 0px 10px 0px; background-color: #F1F1F1; border-bottom: 1px solid #E5E5E5; box-shadow: 1px 0px 5px #333;">
  <div class="span7">
    <div class="row-fluid">
    <form style="margin-bottom:0px">
      <img src="<?php echo JURI::base(); ?>templates/js_wright/images/logo-raw.png" style="width: 192px; margin: 2px 10px 0px 25px">
      <input id="search" name="search" placeholder="Search for your Christian friends" type="text" >
    </form>
    </div>
  </div>
  
  <div class="span5">
    <div class="btn-group pull-right" style="margin-right: 10px">
      <img title="<?php echo $user->name; ?>" style="width:38px; height: 38px" alt="<?php echo $user->name; ?>" <?php echo $src; ?> />

      <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>"><span style="color: #0094CB"><i class="icon-user"></i></span> My Profile</a></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>/edit"><span style="color: red;"><i class="icon-pencil"></i></span> Edit Account</a></li>
         <li class="divider"></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=user.logout'); ?>"><i class="icon-lock"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpsearch/assets/js/typeahead.min.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($, window) {
    var search = $('input#search');
    
    search
    .typeahead('destroy')
    .typeahead({
      //minLength: 3,
      
      name: 'search',
      
      prefetch: 'components/com_holiness/assets/data/users.json',
      
      //remote: '<?php echo JURI::base(); ?>?option=com_holiness&task=user.getuser&name=%QUERY',
      
      template: [
        '<div class="row-fluid">',
        '<div class="span3"><img src="<?php echo JURI::base(); ?>media/com_holiness/images/user-{{userid}}-icon.{{imgext}}" onerror="this.src=\'data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\'" style="width:50px; height:50px;" /></div>',
        '<div class="span9"><p><strong>{{name}}</strong></p><p><small>{{church}}</small></p></div>',
        '</div>'
      ].join(''),
      
      //footer: '<hr style="margin: 10px 0px 5px 0px"><button class="btn btn-block btn-primary" type="button" style="margin-left: 2%; width: 96%;">See more results...</button>',
      
      engine: Hogan,

      limit: 10
    })
    
    .on('typeahead:selected', function (event, user) {
      window.location = '<?php echo JURI::base(); ?>#/users/' + user.userid;
    });
}(jQuery, window));
</script>