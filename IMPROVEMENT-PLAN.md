# CNS Wiki Suite — Improvement Plan

## Status (updated 2026-07-02, second pass)

**Done & verified:** #1 infobox context bug fixed with a v1 block deprecation (existing `data-wp-context="{}"` content stays valid, migrates on save); #2 placeholder `wiki-archive` block removed (no content used it) and `archive-wiki.html` rebuilt as an inherited Query Loop grid with pagination (verified at `/lore/`); #3 manifest/template `file_exists` guards; #4 activation/deactivation hooks (flush) + `uninstall.php`; #5 single `cns-wiki-suite` text domain everywhere (block.json + PHP + JS); #6 `cns_wiki_` prefixes, dead code removed; #7 theme-conditional CPT content template; #8 `newest` mode renders real wiki-card blocks; #9 color validation in wiki-card; #10 single `enqueue_block_assets` hook, empty view.js removed, README updated.

**Deferred:** P3 feature roadmap (taxonomy, infobox presets, related articles, wikilinks, metadata footer, search block).

---

Reviewed: 2026-07-02. This is the smallest and least mature of the three plugins — closer to a scaffold that grew than a designed suite. The settings/rewrite-flush handling in `admin/cns-wiki-admin.php` is genuinely well done; most of the rest needs consolidation. Ordered by priority.

---

## P0 — Bugs / correctness

### 1. Infobox serializes a function into `data-wp-context`
`src/blocks/infobox/save.js`:

```js
data-wp-context={JSON.stringify({ isActive: is_infobox_open })}
```

`is_infobox_open` is passed as a function reference, and `JSON.stringify` drops function-valued keys — the rendered attribute is `{}`, so `context.isActive` is always undefined/falsy regardless of `display_mode`. It must be `is_infobox_open()`. Two follow-ups:
- Changing save output invalidates existing block instances → ship a **block deprecation** entry alongside the fix.
- `expanded__all` mode currently only *looks* open because of the CSS class on `.infobox`; after the fix, `aria-expanded` will finally be correct too.

### 2. `wiki-archive` block is a shipped placeholder
`src/blocks/wiki-archive/render.php` outputs "Wiki Archive – hello from a dynamic block!". It's registered and insertable in production. Either implement it (a query-driven grid honoring the archive settings — most of the markup already exists in `wiki-contents`'s `newest` mode) or unregister it until it's real.

### 3. No guard around block registration
`cns-wiki-suite.php` calls `wp_register_block_types_from_metadata_collection()` with no `file_exists` check on `build/blocks-manifest.php` — a fresh checkout without `npm run build` warns/fatals on every request. Both sibling plugins guard this; copy their pattern. Same for the two `file_get_contents()` calls in `wiki/setup.php` (`insert_cns_wiki_suite_templates`).

### 4. Missing lifecycle hooks
- **No activation hook** → the `wiki` CPT rewrite rules aren't flushed on activation; `/wiki/…` 404s until permalinks are re-saved. (The flush-flag machinery only fires when settings are *saved*.) Add `register_activation_hook` that registers the CPT and flushes, plus a deactivation hook that unregisters + flushes — mirror map-suite.
- **No `uninstall.php`** → `cns_wiki_settings` and `cns_wiki_needs_flush` options persist after deletion.

---

## P1 — Structure & code quality

### 5. Text domain chaos
The plugin's header declares `cns-wiki-suite`, but the code uses **four** domains: `'wiki'` (setup.php), `'wiki-card'`, `'wiki-contents'`, `'wiki-archive'` (each block), and `'cns-wiki-suite'` (admin). Only strings under the declared domain are translatable. Standardize everything on `cns-wiki-suite` — including the `textdomain` field in every `block.json`.

### 6. Function prefixes
`cns_post_tax_init` (registers no taxonomy despite the name), `insert_cns_wiki_suite_templates`, `create_block_cns_wiki_suite_block_init` — inconsistent and collision-prone. Adopt `cns_wiki_` for everything, and delete the commented-out `class cnsWikiSuite` stub at the bottom of the main file.

### 7. Degrade gracefully without the theme
The `wiki` CPT template hardcodes `cns-theme/cns-section`, `cns-theme/cns-tab`, and `core/template-part slug=sidebar` — all Clouds-and-Spaceships-specific. On any other theme, new wiki posts are born with invalid blocks. Since the suite's stated design is "work in tandem, not all parts required":

```php
$template = [ /* columns skeleton */ ];
if ( wp_is_block_theme() && get_template() === 'clouds-and-spaceships' ) {
    // rich three-column layout with cns-section / cns-tab / sidebar part
} else {
    // plain columns: paragraph placeholder + infobox
}
```

Same consideration for the two registered block templates (they reference theme parts).

### 8. Reuse the card renderer
`wiki-contents/render.php`'s `newest` mode hand-duplicates the wiki-card markup (thumbnail/title/excerpt/read-more). Render actual `cns-wiki-suite/wiki-card` blocks instead:

```php
$inner .= render_block([ 'blockName' => 'cns-wiki-suite/wiki-card',
                         'attrs' => [ 'postId' => $pid ] ]);
```

One markup source, and card display options apply consistently.

### 9. Attribute hygiene in wiki-card
`backgroundColor`/`textColor` attributes go into the `style` attr with only `esc_attr()` — a value like `red;position:fixed;inset:0` injects extra declarations. Validate with `sanitize_hex_color()` (or accept only preset slugs and emit `var(--wp--preset--color--…)`, the pattern the theme's cns-sidebar block already implements well).

### 10. Minor cleanups
- `cns_wiki_enqueue_infobox_styles` is hooked to both `wp_enqueue_scripts` **and** `enqueue_block_assets`; the latter already fires on the frontend, so it runs twice. Keep only `enqueue_block_assets` (covers editor + frontend).
- `infobox-row/view.js` is an empty file; drop it and its `viewScript` entry.
- Add a `README.md`: what each block does, the `cns_wiki_settings` keys, the `cns_admin_tabs` integration.
- Tooling parity with the other plugins: PHPCS config, CI build check, and the same `Requires`/version discipline.

---

## P2 — Performance

Nothing alarming at current scale — the plugin is mostly render callbacks over `WP_Query`. Two notes:

- `wiki-contents` `newest` mode already sets `no_found_rows` — good. Add `update_post_term_cache => false` when categories/tags aren't shown.
- `cns_get_wiki_setting()`'s static cache is per-request and fine; just be aware it means a settings save later in the same request isn't visible (not currently an issue).

---

## P3 — Features

This plugin has the biggest gap between name ("wiki experience") and delivered features. High-leverage additions, roughly in order of impact:

1. **Real archive block** (#2 above) with category/tag filter bar and pagination — the wiki landing page is the front door of the whole platform.
2. **Wiki-specific taxonomy** (e.g. `wiki_topic`), instead of borrowing post categories — keeps the wiki's organization independent of the blog.
3. **Infobox presets**: the map/story suites resolve infoboxes from linked posts; the wiki infobox is purely manual. A "fields" schema (label/value rows, already half-built as `infobox-row`) with reusable presets per topic (Character, Location, Ship…) would make authoring much faster and marries well with `cns-map-suite`'s linked-post infoboxes.
4. **Related articles block**: query by shared terms; pairs with wiki-card.
5. **Cross-linking helpers**: a `[[wikilink]]`-style autocomplete format button, plus a "what links here" panel — the two features people actually expect from a wiki.
6. **Article metadata footer**: last-updated date + contributor list (data is free from revisions).
7. **Search integration**: the theme exposes `all/v1/search`; a wiki-scoped search block would give the archive page instant filtering.

---

## Suggested order of work

1. P0 #1 (context bug + deprecation) and #3/#4 (guards + lifecycle) — small, immediate.
2. Text domain + prefix sweep (#5, #6) — mechanical, do before the codebase grows.
3. Theme-independent CPT template (#7) and card reuse (#8).
4. Archive block for real (#2 → feature 1).
5. Features 2–5 as the wiki roadmap.
