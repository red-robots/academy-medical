<?php
$banner = get_field("banner");
$taglines = get_field("taglines");
$placeholder = THEMEURI . 'images/rectangle.png';
if( is_front_page() || is_home() ) {
	if($banner) { ?>
	<div class="banner cf">
		<div class="bimage" style="background-image:url('<?php echo $banner['url'] ?>')">
			<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder" />
			<?php 
			$slidesId = (count($taglines)>1) ? 'slideshow':'static-banner';
			if ($taglines) { ?>
			<div class="bcaption">
				<div id="<?php echo $slidesId ?>" class="slideTextContainer wrapper swiper-container">
					<div class="swiper-wrapper">
						<?php foreach ($taglines as $tag) { ?>
							<div class="swiper-slide">
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder" />
					    		<div class="inner-text">
					    			<div class="textwrap">
							    		<?php if ($tag['large_text']) { ?>
							    		<h2 class="largeTxt"><?php echo $tag['large_text'] ?></h2>	
							    		<?php } ?>
							    		<?php if ($tag['small_text']) { ?>
							    		<div class="smallTxt"><?php echo $tag['small_text'] ?></div>	
							    		<?php } ?>
						    		</div>
					    		</div>
					    	</div>
						<?php } ?>
					</div>
				</div>
			</div>	
			<?php } ?>
		</div>
		<div class="scrolldown">
			<div class="wrapper"><a href="#content" title="Scroll Down" id="scrolldown"><span class="arrow"></span></a></div>
		</div>
	</div>
	<?php } ?>

<?php } else { ?>

	<?php 
	$header_image = get_field("header_image"); 
	$page_title = get_the_title();
	$parent_id = get_page_id_by_template('page-news');
	if($parent_id) {
		$header_image = get_field("header_image",$parent_id);
		$page_title = get_the_title($parent_id);
	}
	$style = ($header_image) ? ' style="background-image:url('.$header_image['url'].')"':'';
	?>

	<div class="hero cf"<?php echo $style ?>>
		<div class="inner">
			<div class="wrapper">
				<div class="titlediv"><h1 class="pagetitle border-animate"><span><?php echo $page_title ?></span></h1></div>
			</div>
		</div>
	</div>	
	

<?php } ?>
