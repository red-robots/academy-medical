<main id="main" class="site-main single-post" role="main">
	<div class="wrapper">

		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php if ( has_post_thumbnail() ) { ?>
			<div class="feat-image"><?php the_post_thumbnail('large') ?></div>	
			<?php } ?>

			<header class="entry-header">
				<p class="postmeta"><?php echo get_the_date('F j, Y'); ?></p>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php 
				$partner = get_field("partners"); 
				$partner_id = ($partner) ? $partner[0] : '';
				?>
				<?php the_content(); ?>
				<?php if ($partner_id) { ?>
				<div class="about-vendor"><a href="<?php echo get_permalink($partner_id); ?>" class="btn-more">About the Vendor</a></div>
				<?php } ?>
			</div><!-- .entry-content -->

		</article><!-- #post-## -->
		<?php endwhile;  ?>

		<?php
		$current_id = get_the_ID();
		$posts_per_page = 4;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$post_type = 'post';
		$args = array(
			'posts_per_page'=> $posts_per_page,
			'post_type'		=> $post_type,
			'post_status'	=> 'publish',
			'post__not_in' 	=> array($current_id),
			'paged'			=> $paged,
			'orderby'       => 'date',       
		  	'order'         => 'DESC'
		);

		$all_args = array(
			'posts_per_page'=> -1,
			'post_type'		=> $post_type,
			'post_status'	=> 'publish',
			'post__not_in' 	=> array($current_id),
		);

		$posts = get_posts($args);
		$all = get_posts($all_args);
		$total = ($all) ? count($all) : 0;
		?>
		<aside id="sidebar" class="sidebar-right">
			<?php if ($posts) { ?>
			<div id="widget-articles" class="widget articles">
				<h3 class="wtitle">More Articles</h3>
				<div id="recentPosts">
					<ul class="recent-posts">
						<?php foreach ($posts as $p) { 
						$id = $p->ID; 
						$title = $p->post_title;
						$link = get_permalink($id);
						$content = strip_tags( $p->post_content );
						$content = ($content) ? shortenText($content,100,' ') : '';
						?>
						<li class="item animated fadeIn">
							<p class="postdate"><?php echo get_the_date('F j, Y',$id); ?></p>
							<h4><a href="<?php echo $link ?>"><?php echo $title ?></a></h4>
							<p class="excerpt"><?php echo $content ?></p>
							<div class="button"><a href="<?php echo $link ?>" class="btn-more">Read More</a></div>
						</li>	
						<?php } ?>
					</ul>
				</div>

				<?php 
				$total_pages = ceil($total / $posts_per_page);
				if($paged!=$total_pages) { ?>
				<div class="morediv text-center"><a href="#" id="sbloadmore" data-maxpagenum="<?php echo $total_pages ?>" data-nextpage="<?php echo $paged ?>" class="btn-default">Load More</a></div>
				<?php } else { ?>
				<div class="morediv text-center endpage"><span class="end">No more posts to load.</span></div>
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
			<?php } ?>
		</aside>
	</div>
</main>
