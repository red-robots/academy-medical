<?php
/**
 * Template Name: News
 */

get_header(); 
$header_image = get_field("header_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
$rectangle = THEMEURI . 'images/rectangle.png';
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


		<?php /* NEWS FEEDS */ ?>
		<div class="news-section-wrapper cf">
			<div class="wrapper cf">
				<div class="filter-wrapper">
					<form action="" method="get">
						<span class="label">Filter By:</span>
						<div class="select-input-field">
							<select name="year" id="year" class="form-control selectstyle">
								<option></option>
								<option value="2020">2020</option>
								<option value="2019">2019</option>
								<option value="2018">2018</option>
							</select>
						</div>

						<div class="select-input-field">
							<select name="month" id="month" class="form-control selectstyle">
								<option></option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
							</select>
						</div>

						<div class="select-input-field">
							<select name="vendor" id="vendor" class="form-control selectstyle">
								<option></option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
							</select>
						</div>
					</form>
				</div>


				<?php  
				$posts_per_page = 9;
				$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
				$post_type = 'post';
				$args = array(
					'posts_per_page'=> $posts_per_page,
					'post_type'		=> $post_type,
					'post_status'	=> 'publish',
					'paged'			=> $paged,
					'orderby'       => 'date',       
				  	'order'         => 'DESC'
				);
				$posts = new WP_Query($args);
				if ( $posts->have_posts() ) {  ?>
				<div class="news-results">
					<div id="newsContent">
						<div id="newsInner" class="flexwrap">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); 
							$content = strip_tags( get_the_content() );
							$content = ($content) ? shortenText($content,100,' ') : '';
							?>
							<div class="fcol news animated fadeIn">
								<div class="inside">
									<?php if ( has_post_thumbnail() ) { ?>
									<div class="feat-image"><?php the_post_thumbnail('large') ?></div>	
									<?php } else { ?>
									<div class="feat-image na"><img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" class="placeholder"></div>
									<?php } ?>
									<div class="textwrap">
										<div class="postdate"><?php echo get_the_date('F j, Y') ?></div>
										<h3 class="posttitle"><?php echo get_the_title(); ?></h3>
										<div class="excerpt"><?php echo $content; ?></div>
										<div class="button"><a href="<?php echo get_permalink(); ?>" class="more">Read More</a></div>
									</div>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
						</div>

						<?php 
						$total_pages = $posts->max_num_pages;
						if($paged!=$total_pages) { ?>
						<div class="morediv text-center"><a href="#" id="loadmore" data-maxpagenum="<?php echo $total_pages ?>" data-nextpage="<?php echo $paged ?>" class="btn-default">Load More</a></div>
						<?php } else { ?>
						<div class="morediv text-center endpage"><span>No more posts to load.</span></div>
						<?php } ?>

						<?php if ($total_pages > 1){ ?>
						<div id="pagination" class="pagination" style="display:none;">
				            <?php
				                $pagination = array(
				                    'base' => @add_query_arg('pg','%#%'),
				                    'format' => '?paged=%#%',
				                    'current' => $paged,
				                    'total' => $total_pages,
				                    'prev_text' => __( '&laquo;', 'red_partners' ),
				                    'next_text' => __( '&raquo;', 'red_partners' ),
				                    'type' => 'plain'
				                );
				                echo paginate_links($pagination);
				            ?>
				        </div>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
					<div class="news-results notfound">
						<p><strong class="red">No record found.</strong></p>
					</div>
				<?php } ?>

			</div>
		</div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
