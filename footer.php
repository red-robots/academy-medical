	</div><!-- #content -->
	
	<?php  
	$footlogo = get_field("footlogo","option");
	$address = get_field("address","option");
	$phone = get_field("phone","option");
	$fax = get_field("fax","option");
	$email = get_field("email","option");
	$contacts = array($address,$phone,$fax,$email);
	$other_info = get_field("other_info","option");
	$social_media = get_field("social_links","option");
	$social_icons = social_icons();
	$footer_logos = get_field("footer_logos","option");
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-content cf">
			<div class="footcolums">
				<div class="footcol fcol1">
					<div class="inner">
						<?php if ($footlogo) { ?>
						<img src="<?php echo $footlogo['url'] ?>" alt="<?php echo $footlogo['title'] ?>" class="footlogo">	
						<?php } ?>
						<?php if ($social_media) { ?>
						<div class="social-media">
							<?php foreach ($social_media as $s) { 
								$socialLink = $s['link'];
								$socialIcon = '';
		                		$socialName = '';
		                		if($socialLink) { 
		                			$parts = parse_url($socialLink);
		                			$host = ( isset($parts['host']) && $parts['host'] ) ? str_replace('www.','',$parts['host']):'';
		                			$hostArrs = ($host) ? explode('.',$host):'';
		                			$domain = trim(strtolower($hostArrs[0]));
		                			if( array_key_exists($domain, $social_icons) ) {
		                				$socialIcon = $social_icons[$domain];
		                			}
		                			if($socialIcon) { ?>
		                			<a href="<?php echo $socialLink ?>" target="_blank"><i class="<?php echo $socialIcon ?>"></i><span class="sr"><?php echo $domain ?></span></a>
		                			<?php } ?>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>

				<div class="footcol fcol2">
					<div class="inner">
						<?php if ($contacts && array_filter($contacts)) { ?>
							<?php if ($address) { ?>
							<div class="info address"><?php echo $address ?></div>
							<?php } ?>

							<?php if ($phone) { ?>
							<div class="info phone"><?php echo $phone ?></div>
							<?php } ?>
							<?php if ($fax) { ?>
							<div class="info fax"><?php echo $fax ?></div>
							<?php } ?>
							<?php if ($email) { ?>
							<div class="info email"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php echo antispambot($email) ?></a></div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>

				<div class="footcol fcol3">
					<div class="inner">
						<?php if ($other_info) { ?>
						<div class="info other"><?php echo $other_info ?></div>	
						<?php } ?>
					</div>
				</div>

				<div class="footcol fcol4">
					<div class="inner">
						<?php if ($footer_logos) { ?>
						<div class="footlogos">
							<?php foreach ($footer_logos as $f) { 
								$logo = ($f['logo']) ? $f['logo']['url']:'';
								$link = ($f['link']) ? parse_external_url($f['link']):'';
								?>
								<?php if ($logo && $link) { ?>
								<a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>">
									<img src="<?php echo $logo ?>" alt="<?php echo $f['logo']['title'] ?>" />
								</a>
								<?php } else { ?>
									<?php if ($logo) { ?>
									<img src="<?php echo $logo ?>" alt="<?php echo $f['logo']['title'] ?>" />	
									<?php } ?>
								<?php } ?>	
							<?php } ?>
						</div>	
						<?php } ?>
					</div>
				</div>

				<div class="footcol footnavi fcol5">
					<div class="inner">
						<?php wp_nav_menu( array( 'menu' => 'Footer Menu', 'menu_id' => 'footer-menu','container_class'=>'footer-menu-wrap' ) ); ?>
					</div>
				</div>
			</div>
		</div><!-- wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
