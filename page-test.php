<?php 
/* 
* 
*/
get_header(); 

$json = get_data_json_file();
$content = file_get_contents($json);
$objects = ($content) ? json_decode($content) : '';
$import_tax = ( isset($_GET['import']) && $_GET['import'] = 'yes' ) ? true : false;
$user_id = get_current_user_id();

if($objects) {
	foreach($objects as $ob) {
		$post_title = $ob->title;
		$category = $ob->category;
		$category = preg_replace('/\s+/', ' ', $category);
		$slug = sanitize_title($category);
		$taxonomy = 'partner-category';
		$post_type = 'partners';
		if($import_tax) {
			// if($category) {
			// 	$termId = wp_insert_term( $category, $taxonomy, array(
			// 		'description' => '',
			// 		'parent'      => 0,
			// 		'slug'        => $slug,
			// 	) );
			// }
		}

		$termObj = get_term_info($slug);
		$term_id = ($termObj) ? $termObj->term_id : '';

		/* Update Posts */
		// $post_id = wp_insert_post( array(
  //           'post_status' => 'publish',
  //           'post_type' => $post_type,
  //           'post_title' => $post_title,
  //           'post_content' => '',
  //           'post_author'=>$user_id
  //       ) );

		// $website = ($ob->website) ? $ob->website : '';
  //       $imgFilename = $ob->filename;
  //       $attachmentId = search_attachment($imgFilename);
  //       $image_path = $ob->image_url;
  //       if($post_id) {
  			
  // 			assigned_term_to_post($post_id,$term_id);

  //       	/* ACF Field */
  //       	update_field('website',$website,$post_id);
  //       	if($attachmentId) {
  //       		update_field('logo',$attachmentId,$post_id);
  //       	} 
        	
  //       }
		
	}
}
?>

<div id="extract" style="display:none!important">
<?php 
$url = 'https://academymedical.net/vendor-network/';
// ob_start();
// echo file_get_contents($url);
// $content = ob_get_contents();
// ob_end_clean();
// echo $content; 
?>
</div>
<div class="wrapper" style="margin: 30px auto 50px">
	<div id="wait">
		<img src="<?php echo get_bloginfo("template_url") ?>/images/wait.gif" alt="">
	</div>
	<div id="response"></div>
	<button id="extractData" data-posttype="partners" class="btn-default" style="margin-right:15px">EXTRACT DATA</button>
	<div id="errors"></div>
</div>

<?php get_footer(); ?>





	
