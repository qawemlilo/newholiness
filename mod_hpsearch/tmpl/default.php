<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hpsearch/assets/css/typeahead.js-bootstrap.css');
$document->addStyleDeclaration(
'input, textarea, .uneditable-input {
  width: 400px;
}');
?>

<div class="row-fluid affix" style="padding: 10px 0px 10px 0px; background-color: #0094cb; border-bottom: 1px solid #E5E5E5; box-shadow: 1px 0px 5px #333; z-index:9999">
  <div class="row-fluid" id="toppannel">
    <form style="margin-bottom:0px" class="pull-left">
      <a href="<?php echo JURI::base(); ?>">
        <img src="<?php echo JURI::base(); ?>templates/js_wright/images/logo-raw.png" style="width: 192px; margin: 2px 10px 0px 25px">
      </a>
      <input id="search" name="search" placeholder="Search for your Christian friends" type="text" >
    </form>
    
    <ul class="topNav nav nav-pills pull-left" style="margin-left: 50px; margin-bottom: 0px">
       <li><a href="#" title="" id="requestnotices" class="ddowns" data-content="No requests" data-placement="bottom" data-toggle="popover" data-original-title="Devotion Partner Requests"><i class="icon-user icon-large"></i></a></li>
       <li><a href="#" title="" id="notifications" class="ddowns" data-content="No notifications" data-placement="bottom" data-toggle="popover" data-original-title="Notifications"><i class="icon-flag icon-large"></i></a></li>
       <li><a href="#">Home</a></li>
       <li>
       <div class="btn-group pull-left" style="padding-top: 3px; margin-left: 10px">
         <img title="<?php echo $user->name; ?>" style="width:28px; height: 28px" alt="<?php echo $user->name; ?>" <?php echo $src; ?> />

         <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
         <ul class="dropdown-menu">
          <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>"><span style="color: #0094CB"><i class="icon-user"></i></span> My Profile</a></li>
          <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>/edit"><span style="color: red;"><i class="icon-pencil"></i></span> Edit Account</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=user.logout'); ?>"><i class="icon-lock"></i> Logout</a></li>
         </ul>
       </div>
       </li>
    </ul>
  </div>
</div>



<script type="text/html" id="search-tpl">
  <div class="row-fluid">
    <div class="span2">
      <img src="<?php echo JURI::base(); ?>media/com_holiness/images/user-<%= id %>-icon.<%= imgext %>" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" style="width:50px; height:50px;" />
    </div>
    <div class="span10">
      <p><strong><%= value %></strong></p>
      <p><small><%= church %></small></p>
    </div>
  </div>
</script>



<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpsearch/assets/js/typeahead.min.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($, window) {

    $('input#search').typeahead('destroy')
    .typeahead({
        //minLength: 2,
      
        name: 'search',
      
        prefetch: {
            url: '<?php echo JURI::base(); ?>?option=com_holiness&task=user.getusers',
            ttl: (1000 * 60) * 60
        },
      
        template: $('#search-tpl').text(),

        engine: {
            compile: function(template) {
                var compiled = _.template(template);
            
                return {
                    render: function(context) { 
                        return compiled(context);
                    }
                }
            }
        },

        limit: 10
    })
    
    .on('typeahead:selected', function (event, user) {
      window.location = '<?php echo JURI::base(); ?>#/users/' + user.id;
    });
    
    
    $(function () {
        $('.ddowns').on('click', function(){
            $('.ddowns').not(this).popover('hide'); //all but this
        }).popover({
            'trigger': 'click'
        });
    });
}(jQuery, window));
</script>
