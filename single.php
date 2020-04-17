<?php
get_header(); 
$post_type = get_post_type();
?>

<div id="primary" class="content-area cf">
	<?php if ( $post_type=='post' ) { 

		get_template_part( 'parts/content', 'news' );
		
	} else { ?>
	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post();

		get_template_part( 'parts/content', get_post_format() );

	endwhile; // End of the loop.
	?>
	</main><!-- #main -->

	<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
