<?php
/**
 * Template Name: Partners
 */

get_header(); 
$header_image = get_field("header_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
?>

<div id="primary" class="content-area vendorpage default cf <?php echo $has_header_image ?>">
	<main id="main" class="site-main cf" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$mainText = strip_tags(get_the_content());
			$mainText = preg_replace('/\s+/', '', $mainText);
			if (strpos($mainText, 'string(0)') !== false) {
			    $mainText = '';
			}
			?>
			<?php if ( $mainText ) { ?>
			<section class="maintext cf">
				<div class="midwrap">
					<?php the_content(); ?>
				</div>
			</section>
			<?php } ?>

		<?php endwhile; ?>


		<?php 
		/* Team Posts */
		$args = array(
			'posts_per_page'=> -1,
			'post_type'		=> 'partners',
			'post_status'	=> 'publish',
		);
		$rectangle = THEMEURI . 'images/rectangle.png';
		$partners = new WP_Query($args);
		if ( $partners->have_posts() ) {  ?>
		<section class="partners-posts">
			<div class="wrapper">
				<div class="flexwrap cf">
					<?php $i=1; while ( $partners->have_posts() ) : $partners->the_post();  
					$logo = get_field("logo");
					$website = get_field("website");
					?>
					<div class="vendor-info fadeIn wow" data-wow-delay=".4s">
						<div class="inside">
							<div class="imagecol <?php echo ($logo) ? 'haslogo':'nologo' ?>">
								<a href="<?php echo get_permalink(); ?>">
								<?php if ($logo) { ?>
									<img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['title'] ?>" class="vendor-logo">
								<?php } else { ?>
									<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true">
								<?php } ?>
								</a>
							</div>	
							<div class="info">
								<h2 class="name"><?php echo get_the_title(); ?></h2>
							</div>
							<div class="button">
								<a href="<?php echo get_permalink(); ?>" class="btn-more">Read More</a>
							</div>
						</div>
					</div>
					<?php $i++; endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
