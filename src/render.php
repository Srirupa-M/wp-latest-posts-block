<?php
if ( !defined( 'ABSPATH' ) ) exit;

$number = $attributes['numberOfPosts'] ?? 6;
$order = $attributes['order'] ?? 'desc';

$args = [
    'post_type' => 'post',
    'posts_per_page' => $number,
    'post_status' => 'publish',
    'order' => strtoupper( $order ),
];

if ( !empty( $attributes['category'] ) ) {
    $args['cat'] = intval( $attributes['category'] );
}

$query = new WP_Query( $args );

if ( !function_exists( 'wplpb_reading_time' ) ) {
    function wplpb_reading_time() {
        $content = get_post_field( 'post_content', get_the_ID() );
        $word_count = str_word_count( wp_strip_all_tags( $content ));
        $minutes = ceil( $word_count / 200);
        return max( 1, $minutes );
    }
}
?>

<div class="wplpb-posts-grid">
    <?php if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
           $category = get_the_category();
           $cat_name = !empty( $category ) ? esc_html( $category[0]->name ) : 'Uncategorized';
    ?>
        <article class="wplpb-card">
            <!--Featured Image + Category-->
            <div class="wplpb-image">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large' );
                    }
                    ?>
                </a>
                <span class="wplpb-badge">
                    <?php echo $cat_name; ?>
                </span>
            </div>

            <!--Card Body-->
            <div class="wplpb-body">
                <!--Meta-->
                <div class="wplpb-meta">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', '', [ 'class' => 'wplpb-avatar' ] ); ?>
                    <span class="wplpb-author"><?php the_author(); ?></span>
                    <span class="wplpb-dot">•</span>
                    <span class="wplpb-date"><?php echo get_the_date(); ?></span>
                    <span class="wplpb-dot">•</span>
                    <span class="wplpb-readtime">
                        ⏱️<?php echo wplpb_reading_time(); ?> min read
                    </span>
                </div>

                <!--Title-->
                <h3 class="wplpb-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <!--Excerpt-->
                <div class="wplpb-excerpt">
                    <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                </div>

                <!--Read More-->
                <div class="wplpb-button">
                    <a href="<?php the_permalink(); ?>" class="read-more">
                        Read More ➝
                    </a>
                </div>
            </div>
        </article>

        <?php endwhile;

        else : ?>

        <div class="wplpb-empty">
            <h3>No Posts Found.</h3>
            <p>Try changing the block settings.</p>
        </div>

        <?php endif; ?>
        
</div>

<?php wp_reset_postdata(); ?>