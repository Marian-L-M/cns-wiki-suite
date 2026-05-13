<?php
/**
 * Render callback for the wiki-card block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block content (unused – dynamic block).
 * @var WP_Block $block      Block instance.
 */

$post_id    = intval( $attributes['postId'] ?? 0 );
$bg_color   = $attributes['backgroundColor'] ?? '#f0f0f0';
$show_thumb = (bool) ( $attributes['showThumbnail'] ?? true );
$show_title = (bool) ( $attributes['showTitle']     ?? true );
$show_exc   = (bool) ( $attributes['showExcerpt']   ?? true );
$show_link  = (bool) ( $attributes['showLink']      ?? true );

if ( ! $post_id ) {
	return;
}

$post = get_post( $post_id );
if ( ! $post || 'publish' !== $post->post_status ) {
	return;
}

$title   = get_the_title( $post );
$link    = get_permalink( $post );
$excerpt = get_the_excerpt( $post );
$thumb   = $show_thumb ? get_the_post_thumbnail_url( $post_id, 'medium' ) : '';

$wrapper = get_block_wrapper_attributes( [
	'class' => 'wiki-card',
	'style' => 'background-color:' . esc_attr( $bg_color ) . ';',
] );
?>
<div <?php echo $wrapper; ?>>

	<?php if ( $show_thumb && $thumb ) : ?>
		<div class="wiki-card__thumbnail">
			<img
				src="<?php echo esc_url( $thumb ); ?>"
				alt="<?php echo esc_attr( $title ); ?>"
				loading="lazy"
			>
		</div>
	<?php endif; ?>

	<?php if ( $show_title ) : ?>
		<h3 class="wiki-card__title"><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<?php if ( $show_exc && $excerpt ) : ?>
		<div class="wiki-card__excerpt"><?php echo wp_kses_post( $excerpt ); ?></div>
	<?php endif; ?>

	<?php if ( $show_link ) : ?>
		<a class="wiki-card__link" href="<?php echo esc_url( $link ); ?>">
			<?php esc_html_e( 'Read more', 'wiki-card' ); ?>
		</a>
	<?php endif; ?>

</div>
