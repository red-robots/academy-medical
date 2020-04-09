<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
$header_image = get_field("header_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
?>

<div id="primary" class="content-area default cf <?php echo $has_header_image ?>">
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
			$sections = get_field("twoColContent");
			if($sections) { ?>
			<section class="twocol-content cf">
				<?php $i=1; foreach ($sections as $s) { 
				$title = $s['col1'];
				$text = $s['col2'];
				$hasBlueBox = ($s['hasbluebox'] && $s['hasbluebox']=='yes') ? true : false;
				if($hasBlueBox) {
					$bluebox = $s['bluebox'];
				} else {
					$bluebox = '';
				}
				
				$class = ($title && $text) ? 'twocol':'full';
				if($i==1) {
					$class .= ' first';
				}
				?>
				<div class="contentrow <?php echo $class ?>">
					<div class="wrapper">
						<div class="flexwrap cf">
							<?php if ($title) { ?>
							<div class="col title">
								<h2 class="hd"><?php echo $title ?></h2>
							</div>	
							<?php } ?>
							<?php if ($text) { ?>
							<div class="col text">
								<?php echo $text ?>
							</div>	
							<?php } ?>
						</div>
					</div>

					<?php if ($bluebox) { ?>
					<div class="bluebox-area cf">
						<div class="wrapper">
							<div class="bluebox">
								<?php echo $bluebox ?>
							</div>
						</div>
					</div>	
					<?php } ?>
				</div>	
				<?php $i++; } ?>
			</section>
			<?php } ?>

			<?php 
				$bottomtext = get_field("bottom_text"); 
				$bottomImg = get_field("bottom_image");
				$text1 =  (isset($bottomtext['text1']) && $bottomtext['text1']) ? $bottomtext['text1'] : '';
				$text2 =  (isset($bottomtext['text2']) && $bottomtext['text2']) ? $bottomtext['text2'] : '';
				$bottomStyle = ($bottomImg) ? ' style="background-image:url('.$bottomImg['url'].')"':'';
			?>

			<?php if ($bottomtext) { ?>
			<section class="bottom-section cf"<?php echo $bottomStyle ?>>
				<div class="wrapper">
					<div class="textcol">
						<?php if ($text1) { ?>
						<h3 class="txt1"><?php echo $text1 ?></h3>	
						<?php } ?>
						<?php if ($text2) { ?>
						<p class="txt2"><?php echo $text2 ?></p>	
						<?php } ?>
					</div>
				</div>
			</section>
			<?php } ?>

			

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
