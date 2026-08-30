<?php
/**
 * Single post template
 *
 * @package MyHero
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Above The Fold (ATF) Hero Section -->
	<section class="hero-atf">
		<div class="hero-content">
			<h1 class="hero-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
			<p class="hero-subtitle"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			
			<div class="hero-cta-group">
				<a href="#primary-cta" class="btn btn-primary">Get Started</a>
				<a href="#secondary-cta" class="btn btn-secondary">Learn More</a>
			</div>
		</div>
	</section>

	<!-- Lower Half (Open for content/widgets) -->
	<section class="page-page-body">
		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                itemtype="https://schema.org/Article">

            <div class="post-content">
				<header class="excerpt-header">
                    
                    <?php the_title(
                        sprintf( '<h2 class="post-title h4"><a href="%s" rel="bookmark">', 
                            esc_attr( esc_url( get_permalink() ) ) 
                            ), '</a></h2>' ); ?>

                    </header>
					<span class="excerpt-ghost">
                            
                                <?php the_content(); ?>
                        
                            </span>
</div>
</article>
<?php 
        endwhile; ?>
		<?php endif; ?>

	</section>

</main>

<?php
get_footer();