<?php
/**
 * Single post template
 *
 * @package MyHero
 */

get_header();

$hban = get_theme_mod( 'myhero_hero_banner', ''); 
?>

<main id="primary" class="site-main">

	<!-- Above The Fold (ATF) Hero banner -->
	<div class="hero-banner">
		<div class="myhero-banner" style="background: url( <?php echo esc_url( $hban ); ?> ); background-position: center;">
				<div class="banner-title">
					<?php the_title( '<span class="post-title-banner">', '</span>' ); ?>	
				</div>
		</div>
	</div>
	<div class="breadcrumbs">
	<?php
	if ( function_exists( 'myhero_breadcrumbs' ) ) {
		myhero_breadcrumbs();
	} 
	?>
</div>
<div class="myhero-with-sidebar">
	<!-- Lower Half (Open for content/widgets) -->
	<section class="index-page-body">
			<?php 
			while ( have_posts() ) :
				the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">

            <div class="post-content">
				<header class="single-header">
				
					<h2 class="post-title"><?php the_title(); ?></h2>

                </header>
				<figure class="linked-attachment-container">
				<a class="imgwrap-link"
				href ="<?php echo esc_url( get_attachment_link( get_post_thumbnail_id() ) ); ?>" 
				title="<?php the_title_attribute( 'before=Permalink to: &after=' ); ?>">
				<?php 
				the_post_thumbnail( 'medium_large', array( 
						'itemprop' => 'image', 
						'class'  => 'april-featured',
						'alt'  => get_attachment_link( get_post_thumbnail_id() )
					) 
				); ?></a>
				</figure>

					<div class="content-single">
                            
                        <?php the_content(); ?>
                        
					</div>
					
					<?php
					endwhile; ?>
			</div>
				

				<div class="after-content">
					<p class="after-cats"><span><small><?php esc_html_e('By: ', 'myhero'); ?></span> 
						<em><?php the_author(); ?></em></small>
					| <span><small><?php esc_html_e('Categorized as: ', 'myhero'); ?></span> 
						<em><?php the_category( ' &bull; ' ); ?></em></small>
					| <span><small><?php esc_html_e('Keys: ', 'myhero'); ?></span> 
						<em><?php the_tags( ' ' ); ?></em></small>
					| <span><small><?php esc_html_e('Added on: ', 'myhero'); ?></span> 
						<em><?php the_date(); ?></em></small></p>
				</div>

					<div class="myhero-comments">
						<?php 
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						} ?>
					</div>

						<div class="prev-next-links">
							<p><?php previous_post_link(); ?><span class="next-links-divider"> | </span><?php next_post_link(); ?></p>
						</div>
		</article>
		
	</section>

		<aside class="blog-sidebar">
		
			<?php get_sidebar(); ?>
	
		</aside>

</div>
</main>

<?php
get_footer();