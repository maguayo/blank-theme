<?php get_header(); ?>

<section id="seccion-contenido">

	<?php if ( have_posts() ) : ?>
        <header class="page-header">
            <h1 class="page-title">
            	<?php printf( __( 'Resultados de búsqueda para: %s', 'shape' ), '<span>"' . get_search_query() . '"</span>' ); ?>
            </h1>
        </header>
        <?php while ( have_posts() ) : the_post(); ?>

        	<article class="entrada-blog">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', array('class' => 'img-cat-' . $categories[0]->term_id)); ?></a>
				<h2><?php the_title(); ?></h2>
				<p>
					<?php $string = get_the_content();
					$string = strip_tags($string);
                	$string = (strlen($string) > 300) ? substr($string, 0, 297).' [...]' : $string;
                	echo $string; ?>
                </p>
			</article>		

        <?php endwhile; ?>

    <?php else: ?>
    	<header class="page-header">
            <h1 class="page-title">
            	<?php printf( __( 'No se encuentra nada para: %s', 'shape' ), '<span>"' . get_search_query() . '"</span>' ); ?>
            </h1>
        </header>
        <form role="search" method="get" id="searchform2" action="<?php echo home_url( '/' ); ?>">
		    <div><label class="screen-reader-text" for="s">Search for:</label>
		        <input type="text" value="" name="s" id="s2" />
		        <input type="submit" id="searchsubmit2" value="Buscar" />
		    </div>
		</form>
    <?php endif; ?>

	<div class="posts_nav_link">
		<?php posts_nav_link(' &#183; ', 'previous page', 'next page'); ?>
	</div>

</section>

<?php get_footer(); ?>
