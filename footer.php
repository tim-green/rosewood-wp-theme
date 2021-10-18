<footer class="site-footer section-inner">

    <p class="copyright">
    &copy; 
    <?php 
    echo date_i18n( __( 'Y', 'rosewood' ) ); ?> 
    <a href="<?php echo esc_url( home_url() ); ?>" class="site-name">
        <?php bloginfo( 'name' ); ?>
    </a>
    </p>

</footer> <!-- footer -->

</main>

<?php wp_footer(); ?>

</body>
</html>