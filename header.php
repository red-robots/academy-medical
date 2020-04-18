<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700|Open+Sans+Condensed:300,300i,700|Fira+Sans+Condensed:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<?php wp_head(); ?>
<?php  
$customClass = (get_field("banner")) ? 'hasbanner':'nobanner';
?>
<script>var params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v});</script>
</head>

<body <?php body_class($customClass); ?>>
<div id="page" class="site cf">
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>
	<dvi id="overlay"></dvi>
	<div id="mobileNav">
		<div class="main-menu-mobile">
			<ul id="topcustom" class="menu"><li class="homepage"><a href="<?php echo get_site_url(); ?>"><i class="fas fa-home"></i><span class="sr">Home</span></a></li></ul>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'mobile-menu','container'=>false ) ); ?>
		</div>
	</div>
	<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="sr"><?php esc_html_e( 'MENU', 'bellaworks' ); ?></span><span class="bar"></span></button>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrapper">

			<?php  
			$btn = get_field("header_button","option");
			$link_type = ( isset($btn['link_type']) && $btn['link_type'] ) ? $btn['link_type'] : 'internal';
			$buttonLabel = ( isset($btn['button_label']) && $btn['button_label'] ) ? $btn['button_label'] : '';
			$buttonLink = ( isset($btn[$link_type.'_link']) && $btn[$link_type.'_link'] ) ? $btn[$link_type.'_link'] : '';
			
			if ($buttonLabel && $buttonLink) { 
				$opt = parse_external_url($buttonLink); ?>
				<div class="topbuttons">
					<a href="<?php echo $buttonLink ?>" target="<?php echo $opt['target'] ?>" class="<?php echo $opt['class'] ?>">Start Now</a>
				</div>
			<?php } ?>
			
			<div class="flexwrap">
				<?php if( get_custom_logo() ) { ?>
		            <div class="logo">
		            	<?php the_custom_logo(); ?>
		            </div>
		        <?php } else { ?>
		            <h1 class="logo">
			            <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
		            </h1>
		        <?php } ?>

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu','container_class'=>'main-menu' ) ); ?>
				</nav><!-- #site-navigation -->
			</div>
		</div><!-- wrapper -->
	</header><!-- #masthead -->

	<?php get_template_part("parts/banner"); ?>

	<div id="content" class="site-content cf">
