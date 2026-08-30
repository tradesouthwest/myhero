<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package solo
 * @since   1.0.1
 */
?>

<footer class="page-footer">

    <div class="footer-base">
        <div class="site-copyright">
            <small><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="bookmark">
            <?php 
            printf( '<small>%s &copy; %s</small>',
                bloginfo( 'name' ),
                esc_html( gmdate( 'Y' ) ) 
            ); ?></a><span class="myhero-poweredby"> | Powered by <em>ClassicPress</em> </span></small>
        </div>
        <div class="upto">
            <a class="back_to_top" title="<?php esc_attr_e('Top of page link', 'solo'); ?>"><sup>^</sup></a>
        </div>
    </div>
    
</footer>
<?php wp_footer(); ?>
</body>
</html>