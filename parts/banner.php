<?php
$banner = get_field("banner");
$taglines = get_field("taglines");
$placeholder = THEMEURI . 'images/rectangle.png';
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
