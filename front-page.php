<?php
/**
 * Template Name: Front Page
 *
 * @package Hello_Theme
 */

get_header();

	// Fetch all hero options at once
	$hero = myhero_get_hero_mods();
	
	// Inline style check
$hero_style = '';
if ( 'image' === $hero['bg_type'] && ! empty( $hero['bg_image'] ) ) {
	$hero_style = 'style="background-image: url(' . esc_url( $hero['bg_image'] ) . ');"';
}
?>

<main id="primary" class="site-main">

	<section class="hero-atf <?php echo esc_attr( 'has-media-' . $hero['bg_type'] ); ?>" <?php echo $hero_style; ?>>

		<?php if ( 'video' === $hero['bg_type'] && ! empty( $hero['bg_video'] ) ) : ?>
			<div class="hero-video-wrapper">
				<video autoPlay loop muted playsInline class="hero-video">
					<source src="<?php echo esc_url( $hero['bg_video'] ); ?>" type="video/mp4">
				</video>
			</div>
		<?php endif; ?>

		<div class="hero-overlay"></div>

		<div class="hero-content">
			<?php if ( ! empty( $hero['title'] ) ) : ?>
				<h1 class="hero-title"><?php echo esc_html( $hero['title'] ); ?></h1>
			<?php endif; ?>

			<?php if ( ! empty( $hero['subtitle'] ) ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>
			<?php endif; ?>
			
			<div class="hero-cta-group">
				<?php if ( ! empty( $hero['btn_prim_text'] ) && ! empty( $hero['btn_prim_url'] ) ) : ?>
					<a href="<?php echo esc_url( $hero['btn_prim_url'] ); ?>" class="btn btn-primary">
						<?php echo esc_html( $hero['btn_prim_text'] ); ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $hero['btn_sec_text'] ) && ! empty( $hero['btn_sec_url'] ) ) : ?>
					<a href="<?php echo esc_url( $hero['btn_sec_url'] ); ?>" class="btn btn-secondary">
						<?php echo esc_html( $hero['btn_sec_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
	
	    <section class="front-page-body">
		<div class="container">
			<?php
				the_content();
			?>
		</div>
	    </section>
</main>

<?php
get_footer();