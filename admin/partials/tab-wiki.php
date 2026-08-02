<?php
/**
 * CNS Wiki Suite — Wiki admin tab content.
 */
defined( 'ABSPATH' ) || exit;

// ── Settings values ───────────────────────────────────────────────────────────
$archive_slug  = cns_get_wiki_setting( 'archive_slug',  'wiki' );
$per_page      = (int) cns_get_wiki_setting( 'archive_per_page', 12 );
$archive_order = cns_get_wiki_setting( 'archive_order', 'date_desc' );
$archive_url   = get_post_type_archive_link( 'wiki' );

$grid_desktop  = (int) cns_get_wiki_setting( 'grid_columns_desktop', 3 );
$grid_tablet   = (int) cns_get_wiki_setting( 'grid_columns_tablet',  2 );
$grid_mobile   = (int) cns_get_wiki_setting( 'grid_columns_mobile',  1 );
$grid_col_gap  = (int) cns_get_wiki_setting( 'grid_column_gap', 16 );
$grid_row_gap  = (int) cns_get_wiki_setting( 'grid_row_gap',    16 );

$infobox_bg       = cns_get_wiki_setting( 'infobox_bg_color',       '' );
$infobox_contrast = cns_get_wiki_setting( 'infobox_contrast_color', '' );
$infobox_border   = cns_get_wiki_setting( 'infobox_border_color',   '' );

$glossary_enabled = (bool) cns_get_wiki_setting( 'glossary_enabled', false );
$glossary_slug    = cns_get_wiki_setting( 'glossary_slug', 'glossary' );
$glossary_color   = cns_get_wiki_setting( 'glossary_text_color', '' );
$glossary_url     = $glossary_enabled ? get_post_type_archive_link( 'glossary' ) : false;

$order_options = [
    'date_desc' => __( 'Newest first (date ↓)', 'cns-wiki-suite' ),
    'date_asc'  => __( 'Oldest first (date ↑)', 'cns-wiki-suite' ),
    'title_asc' => __( 'Alphabetical (A → Z)',  'cns-wiki-suite' ),
];

// ── Stats ─────────────────────────────────────────────────────────────────────
$counts    = wp_count_posts( 'wiki' );
$published = (int) ( $counts->publish ?? 0 );
$draft     = (int) ( $counts->draft   ?? 0 );
$wiki_ids  = $published > 0
    ? get_posts( [ 'post_type' => 'wiki', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => 'publish' ] )
    : [];
$cat_count = empty( $wiki_ids ) ? 0 : count( get_terms( [
    'taxonomy'   => 'category',
    'object_ids' => $wiki_ids,
    'hide_empty' => true,
    'fields'     => 'ids',
] ) );
$tag_count = empty( $wiki_ids ) ? 0 : count( get_terms( [
    'taxonomy'   => 'post_tag',
    'object_ids' => $wiki_ids,
    'hide_empty' => true,
    'fields'     => 'ids',
] ) );
?>
<div class="cns-admin-panel">

  <?php /* ── Stats ──────────────────────────────────────────────────── */ ?>
  <h2><?php esc_html_e( 'Overview', 'cns-wiki-suite' ); ?></h2>
  <table class="widefat striped" style="max-width:480px;">
    <tbody>
      <tr>
        <td><?php esc_html_e( 'Published wikis', 'cns-wiki-suite' ); ?></td>
        <td><strong><?php echo esc_html( $published ); ?></strong></td>
      </tr>
      <tr>
        <td><?php esc_html_e( 'Drafts', 'cns-wiki-suite' ); ?></td>
        <td><strong><?php echo esc_html( $draft ); ?></strong></td>
      </tr>
      <tr>
        <td><?php esc_html_e( 'Categories in use', 'cns-wiki-suite' ); ?></td>
        <td><strong><?php echo esc_html( $cat_count ); ?></strong></td>
      </tr>
      <tr>
        <td><?php esc_html_e( 'Tags in use', 'cns-wiki-suite' ); ?></td>
        <td><strong><?php echo esc_html( $tag_count ); ?></strong></td>
      </tr>
    </tbody>
  </table>

  <hr>

  <form method="post" action="options.php">
    <?php settings_fields( 'cns_wiki_settings_group' ); ?>

    <?php /* ── Archive ──────────────────────────────────────────────── */ ?>
    <h2>
      <?php esc_html_e( 'Archive', 'cns-wiki-suite' ); ?>
      <?php if ( $archive_url ) : ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" target="_blank"
           style="font-size:13px;font-weight:normal;margin-left:12px;vertical-align:middle;"
        ><?php esc_html_e( 'View wiki archive ↗', 'cns-wiki-suite' ); ?></a>
      <?php endif; ?>
    </h2>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row">
          <label for="cns_wiki_slug"><?php esc_html_e( 'URL slug', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input
            type="text"
            id="cns_wiki_slug"
            name="cns_wiki_settings[archive_slug]"
            value="<?php echo esc_attr( $archive_slug ); ?>"
            class="regular-text"
            pattern="[a-z0-9\-]+"
            placeholder="wiki"
          >
          <p class="description">
            <?php esc_html_e( 'Lowercase letters, numbers, and hyphens only. Changes the archive URL and all wiki post URLs — existing links will break.', 'cns-wiki-suite' ); ?>
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_wiki_per_page"><?php esc_html_e( 'Wikis per page', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input
            type="number"
            id="cns_wiki_per_page"
            name="cns_wiki_settings[archive_per_page]"
            value="<?php echo esc_attr( $per_page ); ?>"
            min="1" step="1"
            class="small-text"
          >
          <p class="description">
            <?php esc_html_e( 'Overrides the global Reading Settings value for the wiki archive only.', 'cns-wiki-suite' ); ?>
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_wiki_order"><?php esc_html_e( 'Default sort order', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <select id="cns_wiki_order" name="cns_wiki_settings[archive_order]">
            <?php foreach ( $order_options as $value => $label ) : ?>
              <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $archive_order, $value ); ?>>
                <?php echo esc_html( $label ); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
    </table>
    <hr>

    <?php /* ── Grid defaults ─────────────────────────────────────────── */ ?>
    <h2><?php esc_html_e( 'Wiki Grid Defaults', 'cns-wiki-suite' ); ?></h2>
    <p class="description" style="margin-bottom:12px;">
      <?php esc_html_e( 'Fallback column and gap values used by any wiki-contents block that does not have explicit per-block settings.', 'cns-wiki-suite' ); ?>
    </p>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row"><?php esc_html_e( 'Columns', 'cns-wiki-suite' ); ?></th>
        <td>
          <fieldset>
            <label style="display:inline-flex;align-items:center;gap:6px;margin-right:16px;">
              <span><?php esc_html_e( 'Desktop', 'cns-wiki-suite' ); ?></span>
              <input type="number" name="cns_wiki_settings[grid_columns_desktop]"
                value="<?php echo esc_attr( $grid_desktop ); ?>" min="1" max="6" step="1" class="small-text">
            </label>
            <label style="display:inline-flex;align-items:center;gap:6px;margin-right:16px;">
              <span><?php esc_html_e( 'Tablet', 'cns-wiki-suite' ); ?></span>
              <input type="number" name="cns_wiki_settings[grid_columns_tablet]"
                value="<?php echo esc_attr( $grid_tablet ); ?>" min="1" max="4" step="1" class="small-text">
            </label>
            <label style="display:inline-flex;align-items:center;gap:6px;">
              <span><?php esc_html_e( 'Mobile', 'cns-wiki-suite' ); ?></span>
              <input type="number" name="cns_wiki_settings[grid_columns_mobile]"
                value="<?php echo esc_attr( $grid_mobile ); ?>" min="1" max="2" step="1" class="small-text">
            </label>
          </fieldset>
        </td>
      </tr>
      <tr>
        <th scope="row"><?php esc_html_e( 'Gap (px)', 'cns-wiki-suite' ); ?></th>
        <td>
          <fieldset>
            <label style="display:inline-flex;align-items:center;gap:6px;margin-right:16px;">
              <span><?php esc_html_e( 'Column', 'cns-wiki-suite' ); ?></span>
              <input type="number" name="cns_wiki_settings[grid_column_gap]"
                value="<?php echo esc_attr( $grid_col_gap ); ?>" min="0" max="64" step="1" class="small-text">
            </label>
            <label style="display:inline-flex;align-items:center;gap:6px;">
              <span><?php esc_html_e( 'Row', 'cns-wiki-suite' ); ?></span>
              <input type="number" name="cns_wiki_settings[grid_row_gap]"
                value="<?php echo esc_attr( $grid_row_gap ); ?>" min="0" max="64" step="1" class="small-text">
            </label>
          </fieldset>
        </td>
      </tr>
    </table>
    <hr>

    <?php /* ── Infobox colours ─────────────────────────────────────── */ ?>
    <h2><?php esc_html_e( 'Infobox Colours', 'cns-wiki-suite' ); ?></h2>
    <p class="description" style="margin-bottom:12px;">
      <?php esc_html_e( 'Default colours for infobox blocks using theme preset values. Per-block colour overrides take precedence. Leave empty to keep the theme defaults.', 'cns-wiki-suite' ); ?>
    </p>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row">
          <label for="cns_infobox_bg"><?php esc_html_e( 'Background', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input type="color" id="cns_infobox_bg"
            name="cns_wiki_settings[infobox_bg_color]"
            value="<?php echo esc_attr( $infobox_bg ?: '#ffffff' ); ?>">
          <?php if ( $infobox_bg ) : ?>
            <label style="margin-left:8px;">
              <input type="checkbox" id="cns_infobox_bg_clear" style="vertical-align:middle;">
              <?php esc_html_e( 'Clear (use theme default)', 'cns-wiki-suite' ); ?>
            </label>
          <?php endif; ?>
          <p class="description"><?php esc_html_e( 'Maps to --wp--preset--color--element-bg on the infobox wrapper.', 'cns-wiki-suite' ); ?></p>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_infobox_contrast"><?php esc_html_e( 'Title bar', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input type="color" id="cns_infobox_contrast"
            name="cns_wiki_settings[infobox_contrast_color]"
            value="<?php echo esc_attr( $infobox_contrast ?: '#e0e0e0' ); ?>">
          <?php if ( $infobox_contrast ) : ?>
            <label style="margin-left:8px;">
              <input type="checkbox" id="cns_infobox_contrast_clear" style="vertical-align:middle;">
              <?php esc_html_e( 'Clear (use theme default)', 'cns-wiki-suite' ); ?>
            </label>
          <?php endif; ?>
          <p class="description"><?php esc_html_e( 'Maps to --wp--preset--color--element-contrast. Used for the infobox title background.', 'cns-wiki-suite' ); ?></p>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_infobox_border"><?php esc_html_e( 'Border', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input type="color" id="cns_infobox_border"
            name="cns_wiki_settings[infobox_border_color]"
            value="<?php echo esc_attr( $infobox_border ?: '#dedede' ); ?>">
          <?php if ( $infobox_border ) : ?>
            <label style="margin-left:8px;">
              <input type="checkbox" id="cns_infobox_border_clear" style="vertical-align:middle;">
              <?php esc_html_e( 'Clear (use theme default)', 'cns-wiki-suite' ); ?>
            </label>
          <?php endif; ?>
          <p class="description"><?php esc_html_e( 'Overrides the hardcoded #dedede border on the infobox wrapper.', 'cns-wiki-suite' ); ?></p>
        </td>
      </tr>
    </table>

    <hr>

    <?php /* ── Glossary ─────────────────────────────────────────────── */ ?>
    <h2>
      <?php esc_html_e( 'Glossary', 'cns-wiki-suite' ); ?>
      <?php if ( $glossary_url ) : ?>
        <a href="<?php echo esc_url( $glossary_url ); ?>" target="_blank"
           style="font-size:13px;font-weight:normal;margin-left:12px;vertical-align:middle;"
        ><?php esc_html_e( 'View glossary ↗', 'cns-wiki-suite' ); ?></a>
      <?php endif; ?>
    </h2>
    <p class="description" style="margin-bottom:12px;">
      <?php esc_html_e( 'A glossary of terms with its own archive page. Once enabled, mark text as a glossary term from the editor toolbar to get a tooltip definition and a link to the entry.', 'cns-wiki-suite' ); ?>
    </p>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row"><?php esc_html_e( 'Enable glossary', 'cns-wiki-suite' ); ?></th>
        <td>
          <label>
            <input
              type="checkbox"
              id="cns_glossary_enabled"
              name="cns_wiki_settings[glossary_enabled]"
              value="1"
              <?php checked( $glossary_enabled ); ?>
            >
            <?php esc_html_e( 'Enable the glossary post type, archive, and editor toolbar button', 'cns-wiki-suite' ); ?>
          </label>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_glossary_slug"><?php esc_html_e( 'Archive URL slug', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input
            type="text"
            id="cns_glossary_slug"
            name="cns_wiki_settings[glossary_slug]"
            value="<?php echo esc_attr( $glossary_slug ); ?>"
            class="regular-text"
            pattern="[a-z0-9\-]+"
            placeholder="glossary"
          >
          <p class="description">
            <?php esc_html_e( 'Lowercase letters, numbers, and hyphens only. Changes the glossary archive URL and all entry URLs — existing links will break.', 'cns-wiki-suite' ); ?>
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="cns_glossary_color"><?php esc_html_e( 'Entry text colour', 'cns-wiki-suite' ); ?></label>
        </th>
        <td>
          <input type="color" id="cns_glossary_color"
            name="cns_wiki_settings[glossary_text_color]"
            value="<?php echo esc_attr( $glossary_color ?: '#ffffff' ); ?>">
          <?php if ( $glossary_color ) : ?>
            <label style="margin-left:8px;">
              <input type="checkbox" id="cns_glossary_color_clear" style="vertical-align:middle;">
              <?php esc_html_e( 'Clear (use theme default)', 'cns-wiki-suite' ); ?>
            </label>
          <?php endif; ?>
          <p class="description"><?php esc_html_e( 'Colour of inline glossary terms in content. Leave empty to inherit the surrounding text colour.', 'cns-wiki-suite' ); ?></p>
        </td>
      </tr>
    </table>

    <?php submit_button(); ?>
  </form>
</div>

<?php
// Inline JS: wire "Clear" checkboxes to blank the hidden colour value on submit.
// Each checkbox, when ticked, swaps the colour input's value to empty string.
?>
<script>
(function () {
    var pairs = [
        ['cns_infobox_bg_clear',       'cns_infobox_bg'],
        ['cns_infobox_contrast_clear', 'cns_infobox_contrast'],
        ['cns_infobox_border_clear',   'cns_infobox_border'],
        ['cns_glossary_color_clear',   'cns_glossary_color'],
    ];
    pairs.forEach(function (pair) {
        var cb    = document.getElementById(pair[0]);
        var input = document.getElementById(pair[1]);
        if (!cb || !input) return;
        cb.addEventListener('change', function () {
            input.disabled = cb.checked;
            if (cb.checked) input.value = '';
        });
    });
})();
</script>
