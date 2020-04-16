<?php
/**
 * Template Name: Contact
 */

get_header(); 
$header_image = get_field("header_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
?>

<div id="primary" class="content-area contactpage default cf <?php echo $has_header_image ?>">
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

			<?php  
			$column1 = get_field("col1");
			if($column1) {
				$column1 = email_obfuscator($column1);
			}
			$column2 = get_field("col2");
			$colClass = ($column1 && $column2) ? 'half':'full';
			if( $column1 || $column2 ) { ?>
			<div class="wrapper colwrap">
				<div class="content-wrap <?php echo $colClass ?>">
					<?php if ($column1) { ?>
						<div class="col col1"><?php echo $column1 ?></div>
					<?php } ?>
					<?php if ($column2) { ?>
						<div class="col col2"><?php echo $column2 ?></div>
					<?php } ?>
				</div>	
			</div>
			<?php } ?>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
