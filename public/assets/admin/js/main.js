$(document).ready(function(){	
	$(".sortable").sortable({
        placeholder: 'show-image',
        forcePlaceholderSize: true,        
        update: function( event, ui ) {        	
			var sortable = $(ui.item).parent('.sortable');  
			var children = $(sortable).children('.show-image');
			var field    = $(sortable).data('field');      
			var temp     = sortings['json_'+field];	
			tmp_image = [];
			children.each(function(){
				tmp_image.push($(this).data('url'));
			});
			sortings['json_'+field] = JSON.stringify(tmp_image);						

        }
    });

	$('.image-del').click(function(){		
		var check = confirm('Do you want to delete it?');
		if(check)
		{
			var path = $(this).data('path');
			var post_id = $(this).data('post');
			var field = $(this).data('field');
			obj = this;
			$.post( '<?php echo base_url()?>admin/systemController/deleteImage/'+post_id, { path: path,field:field})
			  .done(function( data ) {
			  	console.log(data);
			    $(obj).parents('.col-xs-3').remove();
			});
		}		
	});
});