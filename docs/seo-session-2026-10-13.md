# Session handoff — 2026-10-13 — Navar Abyari

## Scope and safety
- Requested: continue SEO remediation for navar-abyari.ir and sync this session to the project's repository.
- User confirmed repository: kikibox/maghalat, main branch. Existing auto-generated translation status files are preserved.
- Public-repository payload must exclude full SQL dumps, credentials, cookies, raw account screens, service account keys and raw private GSC exports. This handoff is a sanitized technical summary.
- Current work is read-only against the live site. Local package creation is NOT live deployment.

## Earlier work and confirmations
- Russian content corrections were imported by user (v2; v1 had a MySQL temporary-table reporting issue).
- User activated language output and product category query fixes prepared earlier in the session.
- Product category sitemap was enabled and submitted by user; GSC reports Success. Sitemap discovery does not prove indexing.
- Audit reviewed primary GSC reports and issue details, not every site's URL or every URL Inspection. Older report snapshots must not be interpreted as proof the latest changes failed.

## Remaining priorities
1. Mobile LCP and INP remediation: field-data issues, cause still requires performance diagnosis.
2. Exact legacy product aliases: fix only verified equivalents; do not redirect all 404s to home.
3. Important content not indexed: separate feeds, query variants and intentional exclusions before assessing content quality.
4. Ardabil VideoObject: missing thumbnailUrl; current server-rendered page HTML contains neither a player nor a direct video link. User approved displaying the declared video on the page with a genuine thumbnail. Do not add an arbitrary image just to satisfy validation.
5. Noncritical product schema warnings: shipping/returns/category and real reviews only. No fabricated ratings.
6. Video watch-page exclusion does not mean the underlying article/product is unindexed.

## Prepared product-redirect patch — not selected for deployment
- Plugin: Navar Product Legacy Redirects 1.0.0.
- Eight exact legacy source paths mapped to six published product IDs: 35006, 655, 35011, 37850, 37848, 35012.
- All six destinations verified live with HTTP 200, index robots and self-canonical on 2026-10-13.
- Exact path matching only; no wildcard/fuzzy matches. One URL-decode pass supports the exact malformed-byte alias reported by Google.
- Only GET/HEAD 404s; query-string requests, valid URLs, admin/AJAX/cron and other routes untouched.
- Only published product destinations, matching the verified permalink, on this domain over HTTPS. Fail closed for missing/draft/wrong-type/changed or external destinations.
- No database writes, schema changes, robot rules, language changes, flush rules or GSC submission.
- PHP lint passed. 47 assertions passed with local WordPress stubs. This is NOT a full WordPress integration test or live installation test.
- ZIP v1 was prepared but user requested a root-cause fix instead of an additional runtime plugin. User was instructed NOT to install it. No installation/activation confirmed.
- Rollback: deactivate plugin and purge caches. Previously cached browser/crawler 301s may persist separately.

## Next actions
- Sync this handoff to the confirmed repository without overwriting unrelated project state.
- Investigate original stored content, menu/meta/options and theme code for exact old links. Prefer permanent targeted edits using native WordPress/Rank Math APIs; keep legitimate existing product permalinks unchanged. Retain exact 301s only for externally used old aliases via existing tools.
- Verify each of the eight sources, six destination pages, unrelated 404 and translated-product URLs.
- Add the approved video to original Ardabil content and correct native Rank Math VideoObject metadata. Implementation/deployment pending; do not mark fixed until live validation.
- Do not click Validate Fix until post-deployment live checks pass; user authorization required for further actions.

## Latest user decision
The user explicitly prefers root-cause remediation rather than another wrapper plugin. The next fix should repair original data/code where wrong links are generated. The old redirect package remains an uninstalled fallback, not the chosen solution. Backup-derived findings must be distinguished from current live DB state.

## Root-cause findings from the supplied backup (not current DB proof)
- Eight wrong product aliases occur in 23 ha_posts content records: nine published articles and fourteen revisions. Revisions should not be edited as current content.
- Published candidate IDs: 36975, 37219, 37889, 37891, 37907, 502145, 502146, 502187, 502188.
- No corresponding matches were found in the supplied custom theme/plugin source, postmeta or options under the exact-string inventory. This is a bounded search, not proof no other producer exists.
- Ardabil page ID35373 has no video/player marker in backup post_content. Native Rank Math metadata row11648 declares the existing MP4 and uses thumbnailUrl=%post_thumbnail%; live JSON-LD has no thumbnailUrl. Root remediation should update original content and native schema metadata, not add another runtime filter.
- Public REST verification of the nine candidate posts failed with an SSL EOF; no write attempted. A small read-only current-state export is requested before preparing guarded native updates. Do not overwrite current content with old backup snapshots or run naive REPLACE on PHP-serialized metadata.
- Diagnostic SQL is SELECT-only. Current export must remain local and never be committed to this public repository.
- Full root remediation, thumbnail extraction and live deployment remain pending.

## Current-state verification after secure sign-in
- Secure cPanel login succeeded; phpMyAdmin opened for the requested database. No credentials or session URLs are committed.
- One SELECT-only query fetched ten current published pages and one native video metadata row. Snapshot remains local/private.
- Current stored content confirms twelve wrong href occurrences across the nine candidate articles; this is no longer merely a backup finding.
- Current Ardabil metadata still declares VideoObject; the requested _thumbnail_id record is absent. Native thumbnail handling needs correction with a real accessible video image.
- The earlier manual current-export request is now resolved: user does not need to send exports.
- No UPDATE, INSERT, DELETE, ALTER, media upload or live fix has been executed in this verification step.
- Next: prepare guarded, reversible root edits using this current snapshot, then present/execute within the authorized repair workflow. Runtime redirect ZIP is still not the selected solution.
