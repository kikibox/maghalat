# Root repair: legacy 75mm reinforced-hose URL

Verified 2026-10-15T21:41:46.204373+00:00. Scope is one legacy product alias, not all Search Console issues.

## Root cause and minimum change
- Product35005 is published at `/product/لوله-نخ-دار-75-میلیمتر/`. The legacy spelling `/product/لوله-نخ-دار-75-میلمتر/` returned404.
- A native read-only search of nonrevision post_content, postmeta and options found exactly one matching article body: post37889, the Arabic Halabja article. Its single wrong href was replaced with the canonical URL using an exact before-hash guard. Text and all other hrefs were preserved.
- A native WordPress old-slug metadata experiment did not redirect with the installed permalink routing. Its temporary row156777 was subsequently removed; independent DB readback confirms only preexisting row19836 remains. No old-slug metadata change persists.
- Added one domain-scoped anchored301 rule in the existing .htaccess exact-legacy block, using the same UTF8-byte pattern/literal-target format as its eight working predecessors. No plugin was added. A percent-encoded destination tried during testing was rejected after incorrect-target output; the final literalUTF8 target was deployed, read back and passed.

## Final evidence
- GET and HEAD of the old alias: one301, then200 at the exact canonical product.
- Canonical product200; English and Arabic product translations200. Product JSONLD graph unchanged.
- Public article:81hrefs before/after, exactly1href changed, obsolete75href0, canonical75href1, visible text unchanged.
- Independent DB readback: exact expected after hash and content bytes. Matching legacy spelling in searched post_content, postmeta and options:0. Revisions, other tables, external sites and theme files are not claimed fully searched.
- All eight preexisting exact alias redirects still pass one301→200 to their intended products.
- Unrelated deliberately nonexistent URL remains404. The separately preexisting `لوله-نخ-دار-سایز-75` alias was404 before and remains404; it is not part of this repair. Five path-isolation unit tests passed.
- Whole .htaccess byte comparison confirms only the new three-line addition; other directives preserved. WP Rocket page cache was purged after article edit; delayJS settings unchanged.

## Safety and next work
Private pre-change article and .htaccess backups plus guarded rollback SQL were packaged outside GitHub. Only this report, public metrics and the new-rule patch are synced. No credentials, cPanel sessions, full DB dump, complete .htaccess or licensed plugin source is published.

No RequestIndexing or ValidateFix was submitted, and no new Google crawl/index recovery is claimed. Next: recheck this URL after Google's recrawl, then investigate the remaining high-value failed links at their sources and use exact verified equivalent redirects only where warranted. This article also contains other legacy links (including a separate layflat75 link); this fix does not declare the whole article/site error-free.
