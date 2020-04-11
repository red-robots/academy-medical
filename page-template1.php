<?php
/**
 * Template Name: Template with Animation
 *
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
				<div class="midwrap fadeIn wow" data-wow-delay=".5s">
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
				$delay = ($i+1) * 2;
				$sec = '0.' . $delay;
				?>
				<div class="contentrow <?php echo $class ?> fadeInUp wow" data-wow-offset="10" data-wow-delay="<?php echo $sec?>s">
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
			$button_name = get_field("button_name");
			$button_link = get_field("button_link");
			?>

			<?php if ($bottomtext) { ?>
			<section class="bottom-section cf">
				<div class="wrapper">
					<div class="textcol fadeInLeft wow" data-wow-delay="1.2s">
						<?php if ($text1) { ?>
						<h3 class="txt1"><?php echo $text1 ?></h3>	
						<?php } ?>
						<?php if ($text2) { ?>
						<p class="txt2"><?php echo $text2 ?></p>	
						<?php } ?>
						<?php if ($button_name && $button_link) { ?>
						<div class="ctadiv">
							<a href="<?php echo $button_link ?>" class="btn-default lg"><?php echo $button_name ?></a>
						</div>	
						<?php } ?>
					</div>
				</div>
				<?php if ($bottomImg) { ?>
				<div class="bg fadeIn wow"<?php echo $bottomStyle ?> data-wow-delay="1s"></div>	
				<?php } ?>
			</section>
			<?php } ?>

			

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
