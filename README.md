# CNS Wiki Suite

A WordPress block toolset for building wiki-like experiences. Designed as a first-party extension to the **Clouds And Spaceships** theme.

---

## Description

CNS Wiki Suite adds blocks and tooling to help writers, fans, and world-builders organise information. It provides structured content types (wiki posts), display blocks (wiki card, wiki contents, infobox family), and integrates into the CNS theme admin panel.

---

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.8 |
| PHP | 8.0 |
| CNS Theme | any (admin integration is optional) |

---

## Installation

1. Upload the `cns-wiki-suite` folder to `/wp-content/plugins/`.
2. Activate the plugin via **Plugins → Installed Plugins**.
3. The **Wiki** post type and blocks are immediately available.
4. If the CNS theme is active, a **Wiki** tab appears in **CNS → Wiki** in the admin sidebar.

---

## Blocks

| Block | Description |
|---|---|
| `wiki-card` | Displays a linked card for a wiki post with thumbnail, title, categories, tags, and excerpt |
| `wiki-contents` | Grid of wiki cards — manual (inner blocks) or automatic (newest N posts, rendered as `wiki-card` blocks) |
| `infobox` | Collapsible per-article infobox container (Interactivity API) |
| `infobox-group` | Collapsible section inside an infobox |
| `infobox-row` | Key/value row inside an infobox |
| `glossary-index` | Lists all glossary entries grouped alphabetically (shared 0–9 & symbols section) or by glossary category |

## Glossary

Opt-in via **CNS → Wiki → Glossary** (enable toggle, archive URL slug, entry text colour). When enabled:

- A **Glossary** post type (classic editor, thumbnails, excerpt) with its own `glossary_category` taxonomy appears in the admin menu.
- The archive at `/<slug>/` renders the `archive-glossary.html` template containing the `glossary-index` block.
- A **Glossary term** button appears in the rich-text toolbar (More menu) of any block editor. Highlight text, pick an entry — the text becomes a link to the definition with a hover tooltip.
- Tooltips and hrefs are refreshed server-side on render from `data-glossary-id` (see `glossary/setup.php`), so they never go stale; terms pointing at deleted entries degrade to plain text.

All blocks and PHP strings use the `cns-wiki-suite` text domain; PHP functions are prefixed `cns_wiki_`. Settings live in the `cns_wiki_settings` option (read via `cns_get_wiki_setting()`); uninstalling deletes the options but keeps wiki posts.

---

## CNS theme admin integration

When the CNS theme is active, the plugin registers a **Wiki** tab on the **Clouds And Spaceships** settings page via the `cns_admin_tabs` filter. No configuration is needed — the tab appears automatically on activation and disappears on deactivation.

The integration lives in `admin/cns-wiki-admin.php`. The tab content partial is at `admin/partials/tab-wiki.php`.

### How the hook works

```php
// admin/cns-wiki-admin.php
add_filter( 'cns_admin_tabs', function ( array $tabs ): array {
    $tabs['wiki'] = [
        'menu_title' => 'Wiki',
        'title'      => 'CNS Wiki Suite',
        'capability' => 'manage_options',
        'callback'   => 'cns_wiki_admin_render_tab',
        'priority'   => 20,
    ];
    return $tabs;
} );
```

If the CNS theme is not active the filter is never called and the file is a no-op. See the theme's `functions/theme-admin/README.md` for the full tab definition reference.

---

## File structure

```
cns-wiki-suite/
  cns-wiki-suite.php       — plugin entry point
  admin/
    cns-wiki-admin.php     — CNS theme admin tab registration
    partials/
      tab-wiki.php         — Wiki tab content
  src/blocks/              — block source files
  build/blocks/            — compiled block assets
  wiki/
    setup.php              — wiki post type registration
  glossary/
    setup.php              — glossary post type, taxonomy, term rendering
  src/formats/glossary/    — inline glossary-term rich-text format
  assets/css/              — static frontend styles (glossary term/tooltip)
  templates/               — block theme templates
```

---

## Authors

Marian Maschke (Nama Tamago Dev)

## License

[GPL-2.0](https://www.gnu.org/licenses/gpl-2.0.html)
