<?php
/**
 * Render callback for the wiki-contents block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks (manual mode).
 * @var WP_Block $block      Block instance.
 */

$mode            = $attributes['mode']           ?? 'manual';
$columns_mobile  = intval( $attributes['columnsMobile']  ?? 1 );
$columns_tablet  = intval( $attributes['columnsTablet']  ?? 2 );
$columns_desktop = intval( $attributes['columnsDesktop'] ?? 3 );
$rows_desktop    = intval( $attributes['rowsDesktop']    ?? 2 );
$column_gap      = $attributes['columnGap'] ?? '1rem';
$row_gap         = $attributes['rowGap']    ?? '1rem';

// CSS custom properties drive the responsive grid via style.scss media queries.
$grid_vars = sprintf(
	'--wiki-columns-mobile:%d;--wiki-columns-tablet:%d;--wiki-columns-desktop:%d;--wiki-column-gap:%s;--wiki-row-gap:%s;',
	$columns_mobile,
	$columns_tablet,
	$columns_desktop,
	esc_attr( $column_gap ),
	esc_attr( $row_gap )
);

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => 'wiki-contents',
	'style' => $grid_vars,
] );

if ( 'newest' === $mode ) {
	$total = $columns_desktop * $rows_desktop;

	$query = new WP_Query( [
		'post_type'      => 'wiki',
		'posts_per_page' => $total,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	] );

	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		$pid     = get_the_ID();
		$title   = get_the_title();
		$link    = get_permalink();
		$excerpt = get_the_excerpt();
		$thumb   = get_the_post_thumbnail_url( $pid, 'medium' );
		?>
		<div class="wiki-card">
			<?php if ( $thumb ) : ?>
				<div class="wiki-card__thumbnail">
					<img
						src="<?php echo esc_url( $thumb ); ?>"
						alt="<?php echo esc_attr( $title ); ?>"
						loading="lazy"
					>
				</div>
			<?php endif; ?>
			<h3 class="wiki-card__title"><?php echo esc_html( $title ); ?></h3>
			<?php if ( $excerpt ) : ?>
				<div class="wiki-card__excerpt"><?php echo wp_kses_post( $excerpt ); ?></div>
			<?php endif; ?>
			<a class="wiki-card__link" href="<?php echo esc_url( $link ); ?>">
				<?php esc_html_e( 'Read more', 'wiki-contents' ); ?>
			</a>
		</div>
		<?php
	}
	wp_reset_postdata();

	$inner = ob_get_clean();
} else {
	$inner = $content;
}
?>
<div <?php echo $wrapper_attrs; ?>>
	<div class="wiki-contents__grid">
		<?php echo $inner; ?>
	</div>
</div>
