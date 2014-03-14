<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
    <form id="createmember" class="form-horizontal well" method="post" action="<?php echo JURI::base()?>index.php?option=com_holiness&task=admin.createmember">
      <fieldset>
        <legend>Create Member</legend>
        
        <div class="progress progress-striped active" style="display:none">
          <div class="bar" style="width: 100%;"></div>
        </div>
        
        <div id="responseD" class="alert" style="display:none">
        </div>
        
        <div class="control-group">
          <label class="control-label" for="theme">Name</label>
          <div class="controls">
            <input id="fullname" name="fullname" value="" class="input-xlarge" type="text">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="bible">Email</label>
          <div class="controls">
            <input id="email" name="email" value="" class="input-xlarge" type="text">
            
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="button1id"></label>
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox" name="sendemail" id="sendemail" checked /> Send Email 
            </label>
            
            <?php echo JHTML::_( 'form.token' ); ?>
            <button id="submit" name="submit" class="btn btn-large btn-primary" type="submit">Create Member</button>
          </div>
        </div>

      </fieldset>
    </form>
  </div>
</div>

<script>
jQuery.noConflict();

(function ($, window) {
    var form = $('#createmember'),
        progress = $('.progress'),
        responseD = $('#responseD');
    
    function send(url, data, fn) {
        $.post(url, data)
        .done(function(data){
            fn(false, data);
        })
        .fail(function (xhr) {
           fn(true, JSON.parse(xhr.responseText));
        });    
    }
    
    function handleSubmit (e) {
        e.preventDefault();
        
        var self=this, data = form.serialize(), action = form.attr('action');
        
        progress.slideDown(function () {      
            send(action, data, function (error, res) {
                if (!error) {
                    self.reset();
                    
                    progress.slideUp(function () {
                        responseD.addClass('alert-success').html($('<strong>' + res.message + '</strong>')).slideDown('slow');
                    });
                      
                    window.setTimeout(function () { 
                        responseD.slideUp(function () {
                            responseD.removeClass('alert-success');
                        }); 
                    }, 10 * 1000);
                }
                else {
                    self.reset();
                    
                    progress.slideUp(function () {
                        responseD.addClass('alert-error').html($('<strong>' + res.message + '</strong>')).slideDown();
                    });
                      
                    window.setTimeout(function () { 
                        responseD.slideUp(function () {
                            responseD.removeClass('alert-error');
                        }); 
                    }, 10 * 1000);               
                }
            });
        });
    };
    
    
    form.on('submit', handleSubmit);
}(jQuery, window));
</script>
