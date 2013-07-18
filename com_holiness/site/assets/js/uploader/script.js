jQuery.noConflict();

(function ($) {
  $(function () {
    var progressbar = $('#upload .progress-div');
    
    $('#photo').on('click', function () {
        if (!$('#church').val()) {
            $('#church').focus();
            return false;
        }
        else {
           return true;
        }
    })

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            var tpl = $('<div class="progress progress-striped"><div class="bar" style="width: 0%;"></div></div>');
            
            $('#uploadbutton').attr('disabled', 'disabled');

            data.context = tpl.appendTo(progressbar);

            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('.bar').css('width', progress + '%');

            if (progress == 100) {
                $('#upload .successful').slideDown();
            }
        },

        fail:function(e, data) {
            // Something has gone wrong!
            alert('An error occured! Reload page and try again.');
            location.reload(true); 
        }

    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
  });
}(jQuery));