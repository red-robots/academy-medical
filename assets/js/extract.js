/**	
 *	Developed by: Lisa DeBona
 */
jQuery(document).ready(function ($) {
	
	var entries = [];
	$(".gdlr-core-item-list").each(function(){
		var imageURL = $(this).find(".gdlr-core-portfolio-thumbnail-image-wrap img").attr("src");
		var title = $(this).find(".gdlr-core-portfolio-title").text();
		var args = {
			'image':imageURL,
			'title':title

		};
		entries.push(args);
	});

	
	$("#extractData").click(function(e){
		e.preventDefault();
		var button = $(this);
		var post_type = $(this).attr("data-posttype");
		if( $(entries).length > 0 ) {
			$.ajax({
				url : myAjax.ajaxurl,
				type : 'post',
				dataType : "json",
				data : {
					action : 'extract_data_from_website',
					posttype : post_type,
					objects : entries
				},
				beforeSend:function(){
					$("#wait").show();
					button.hide();
				},
				success : function( obj ) {
					if(obj.message) {
						$("#response").html(obj.message);
						$("#wait").hide();
					}
				},
				error: function (xhr, status, error) {
					$("#wait").hide();
					var error = '<div>'+xhr+'</div>';
					error += '<div>'+status+'</div>';
					error += '<div>'+error+'</div>';
					$("#errors").html(error);
			    }
			});
		}
	});
	

});