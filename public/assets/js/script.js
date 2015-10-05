$(function(){
	
	$('#url-info').select(function(e){ this.setSelectionRange(0, this.value.length); });
	
	x = $('#url-info').attr('data-width')+'x'+$('#url-info').attr('data-height');
	path = $('#url-info').attr('data-path');
	thumb_directory = $('#url-info').attr('thumb-data');
	$('.mediaContainer img').bind({
		click: function() {
			src = $(this).attr('src').split('/');
			src = src[src.length-1];
			src = src.split(x);
			src = src[0]+src[1];
			$('#photoInfo').modal();
			$('#photoInfo .img-info').attr('src',path+'/'+src);
			$('#url-info').val(path+'/'+src);
			$('#delbtn').attr('data-del',$(this).attr('data-ref'));
		}
	});
	
	
    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
		beforeSend: function(e, data) {
			e.setRequestHeader('X-Requested-With' , 'XMLHttpRequest' );
		},
        add: function (e, data) {

            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });
            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
            }
        },

        fail:function(e, data){
            // Something has gone wrong!
			$.each(jQuery.parseJSON(data.jqXHR.responseText), function(k,e) {
				var x = $(data.context).children('p').children('i').html();
				$(data.context).children('p').children('i').html(x+' <b>'+e+'</b>');
			});
            data.context.addClass('error');
        },
		done: function(e,data){
			var resolved = $.parseJSON(data.result);
			
			$('.mediaContainer').prepend('<div class="col-xs-2 jmedia-item"><img data-ref="'+resolved.id+'" src="'+path+'/'+thumb_directory+'/'+resolved.name+x+'.'+resolved.ext+'" class="img-responsive"/></div>');
			
		}

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
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