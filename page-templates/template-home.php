<?php /* Template Name: Home */ ?>
<?php get_header();

$args = array(
	'post_type' => 'inicio'
);
$the_query = new WP_Query( $args ); ?>
<?php if($the_query->have_posts()): while($the_query->have_posts()): $the_query->the_post(); ?>
    <h2><?php the_title(); ?></h2>
<?php endwhile; endif; wp_reset_postdata();?>


<?php get_footer(); ?>
