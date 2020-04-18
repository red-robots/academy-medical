<?php
/**
 * Template Name: Team
 */

get_header(); 
$header_image = get_field("header_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
$rectangle = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
?>

<div id="primary" class="content-area newspage default cf <?php echo $has_header_image ?>">
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
			'post_type'		=> 'teams',
			'post_status'	=> 'publish',
		);
		$teams = new WP_Query($args);
		if ( $teams->have_posts() ) {  ?>
		<section class="team-posts">
			<div class="wrapper">
			<?php $i=1; while ( $teams->have_posts() ) : $teams->the_post();  
				$photo = get_field("photo");
				$jobtitle = get_field("jobtitle");
				$style_photo = ($photo) ? ' style="background-image:url('.$photo['url'].')"':'';
				$photo_class = ($photo) ? 'haspic':'nopic';
				$first = ($i==1) ? ' first':'';
				$delay = $i*2;
				?>
				<div class="team fadeIn wow <?php echo $first ?>" data-wow-delay="0.<?php echo $delay?>s">
					<div class="inside cf">
						<div class="photo <?php echo $photo_class ?>"<?php echo $style_photo ?>>
							<img src="<?php echo $square ?>" alt="" aria-hidden="true" class="placeholder">
						</div>
						<div class="text">
							<div class="teaminfo">
								<div class="wrap">
									<h2 class="name"><?php echo get_the_title(); ?></h2>
									<?php if ($jobtitle) { ?>
									<p class="jobtitle"><?php echo $jobtitle ?></p>	
									<?php } ?>
								</div>
							</div>
							<div class="description"><?php the_content(); ?></div>
						</div>
					</div>
				</div>
			<?php $i++; endwhile; wp_reset_postdata(); ?>
			</div>
		</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
