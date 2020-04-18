<?php 
get_header(); 
?>
<div id="primary" class="content-area cf">
<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	/* ROW 2 */
	$row2_content1 = get_field("row2_content1"); 
	$row2_content2 = get_field("row2_content2"); 
	$row2_class = ($row2_content1 && $row2_content2) ? 'half':'full';
	$row2bg = get_field("row2bg"); 
	$row2CTA = get_field("row2CTA"); 
	$row2BtnName = ( isset($row2CTA['button_name']) && $row2CTA['button_name'] ) ? $row2CTA['button_name'] : '';
	$row2BtnType = ( isset($row2CTA['button_type']) && $row2CTA['button_type'] ) ? $row2CTA['button_type'] : 'internal';
	$row2BtnLink = ( isset($row2CTA[$row2BtnType.'_link']) && $row2CTA[$row2BtnType.'_link'] ) ? $row2CTA[$row2BtnType.'_link']:'';
	$part2 = ($row2BtnLink) ? parse_external_url($row2BtnLink) : '';
	$parallaxBg = ($row2bg) ? ' data-parallax="scroll" data-position="right" data-image-src="'.$row2bg['url'].'" data-natural-width="'.$row2bg['width'].'" data-natural-height="'.$row2bg['height'].'"':'';
	if($row2_content1 || $row2_content2) { ?>
	<section class="row2 cf <?php echo $row2_class ?>"<?php echo $parallaxBg ?>>
		<div class="wrapper fadeInUp wow" data-wow-delay=".6s">
			<div class="flexwrap">
				<?php if ($row2_content1) { ?>
				<div class="fcol">
					<div class="txt1"><?php echo $row2_content1 ?></div>
				</div>
				<?php } ?>
				<?php if ($row2_content2) { ?>
				<div class="fcol">
					<div class="txt2">
						<?php echo $row2_content2 ?>
						<?php if ($row2BtnName && $row2BtnLink) { ?>
						<div class="ctadiv">
							<a href="<?php echo $row2BtnLink ?>" target="<?php echo $part2['target'] ?>" class="btn-default"><?php echo $row2BtnName ?></a>
						</div>
						<?php } ?>		
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="bottom-arrow"></div>
		
	</section>
	<?php } ?>

	<?php endwhile; ?>

	<?php  
	/* ROW 3 */
	$portrait = THEMEURI . 'images/portrait.png';
	$row3_section_title = get_field("row3_section_title");
	$row3CTA = get_field("row3CTA");
	$row3BtnName = ( isset($row3CTA['button_name']) && $row3CTA['button_name'] ) ? $row3CTA['button_name'] : '';
	$row3BtnType = ( isset($row3CTA['button_type']) && $row3CTA['button_type'] ) ? $row3CTA['button_type'] : 'internal';
	$row3BtnLink = ( isset($row3CTA[$row3BtnType.'_link']) && $row3CTA[$row3BtnType.'_link'] ) ? $row3CTA[$row3BtnType.'_link']:'';
	$part3 = ($row3BtnLink) ? parse_external_url($row3BtnLink) : '';
	$args = array(
		'posts_per_page' => -1,
	    'post_type' => 'advantages',
	    'post_status' => 'publish',
	);
	$advantages = new WP_Query($args);
	if ( $advantages->have_posts() ) { ?>
	<section class="row3 cf">
		<div class="wrapper fadeIn wow" data-wow-delay=".5s">
			<?php if ($row3_section_title) { ?>
				<h2 class="stitle text-center"><?php echo $row3_section_title ?></h2>
			<?php } ?>
			<div class="boxes cf">
				<div class="flexwrap">
				<?php while ( $advantages->have_posts() ) : $advantages->the_post();
					$img = get_field("thumbnail");
					$title = get_the_title();
					$text = get_field("short_description");
					$bg = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
					?>
					<div class="box">
						<a href="<?php echo get_permalink(); ?>" class="inside"<?php echo $bg ?>>
							<img src="<?php echo $portrait ?>" alt="" aria-hidden="true" class="placeholder">
							<span class="text">
								<h3 class="title"><?php echo $title ?></h3>
								<?php echo $text ?>
							</span>
						</a>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>	
				</div>
			</div>
			<?php if ($row3BtnName && $row3BtnLink) { ?>
			<div class="ctadiv text-center">
				<a href="<?php echo $row3BtnLink ?>" target="<?php echo $part3['target'] ?>" class="btn-default"><?php echo $row3BtnName ?></a>
			</div>
			<?php } ?>	
		</div>
	</section>
	<?php } ?>
	
	<?php  
	/* ROW 4 */
	$rectangle = THEMEURI . 'images/rectangle.png';
	$row4_image = get_field("row4_col_image");
	$row4_title = get_field("row4_title");
	$row4_description = get_field("column_2_description");
	$row4CTA = get_field("row4CTA");
	$row4BtnName = ( isset($row4CTA['button_name']) && $row4CTA['button_name'] ) ? $row4CTA['button_name'] : '';
	$row4BtnType = ( isset($row4CTA['button_type']) && $row4CTA['button_type'] ) ? $row4CTA['button_type'] : 'internal';
	$row4BtnLink = ( isset($row4CTA[$row4BtnType.'_link']) && $row4CTA[$row4BtnType.'_link'] ) ? $row4CTA[$row4BtnType.'_link']:'';
	$part4 = ($row4BtnLink) ? parse_external_url($row4BtnLink) : '';
	$row4_class = ( $row4_image && ( $row4_title || ($row4BtnName && $row4BtnLink) ) ) ? 'half':'full';
	if( $row4_image && ( $row4_title || ($row4BtnName && $row4BtnLink) ) ) { ?>
	<section class="row4 cf <?php echo $row4_class ?>">
		<div class="full-wrapper cf">
			<div class="flexwrap">
				<?php if ($row4_image) { ?>
					<div class="fcol image fadeIn wow" data-wow-delay=".4s" style="background-image:url('<?php echo $row4_image['url']?>');">
						<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" class="placeholder" />
					</div>
				<?php } ?>

				<?php if ( $row4_title || ($row4BtnName && $row4BtnLink) ) { ?>
					<div class="fcol text fadeIn wow" data-wow-delay=".8s">
						<div class="wrap">
							<?php if ($row4_title) { ?>
							<h3 class="stitle"><?php echo $row4_title ?></h3>	
							<?php } ?>
							<?php if ($row4_description) { ?>
							<div class="stext"><?php echo $row4_description ?></div>	
							<?php } ?>
							<?php if ($row4BtnName && $row4BtnLink) { ?>
							<div class="ctadiv">
								<a href="<?php echo $row4BtnLink ?>" target="<?php echo $part4['target'] ?>" class="btn-default"><?php echo $row4BtnName ?></a>
							</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

</div><!-- #primary -->
<?php
get_footer();
