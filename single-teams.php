<?php
get_header(); 
?>

<div id="primary" class="content-area cf">
	<main id="main" class="site-main team-posts" role="main">
		<div class="wrapper">
		<?php while ( have_posts() ) : the_post(); 
			$photo = get_field("photo");
			$jobtitle = get_field("jobtitle");
			$style_photo = ($photo) ? ' style="background-image:url('.$photo['url'].')"':'';
			$photo_class = ($photo) ? 'haspic':'nopic';
			$first = ($i==1) ? ' first':'';
			$square = THEMEURI . 'images/square.png';
			?>
			<div class="team<?php echo $first ?>">
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

		<?php endwhile; ?>
		</div>
	</main><!-- #main -->

</div><!-- #primary -->

<?php
get_footer();
