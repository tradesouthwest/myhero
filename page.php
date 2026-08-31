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