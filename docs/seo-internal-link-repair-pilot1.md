# Internal linking — first guarded repair batch

Verified 2026-10-15 T 22:38:46.195595+00:00. This is the first 20-source pilot following `docs/seo-internal-link-audit.md`, not completion of the whole-site audit queue.

## Deployed
- Repaired one obsolete `/product/لوله-نخ-دار-160-میلیمتر/` href in each of 20 published ordinary articles.
- 13 Persian articles now link to the canonical Persian product 35012, `/product/لوله-نخ-دار-سایز-160-میلیمتر/`.
- 7 Arabic articles now link to the corresponding Arabic product 501925, `/product/ar-iq-product-35012/`. The source-product relation and language were checked in fresh DB metadata; public H 1 identifies the same 160 mm reinforced hose.
- No added links, anchor-text rewrites, new plugin, redirect, product-URL change, language-setting change, schema edit or timestamp bump. Existing visible text and every other href were preserved.

## Safety and verification
Private backups and after-hash-guarded rollback SQL were packaged before mutation. A larger full-body SQL submission returned a rejected/connection-error message; no success was inferred. Independent readback confirmed 20 unchanged before hashes. The subsequent compact native SQL transaction locked the 20 rows, checked the entire group's before hashes, and required each replacement to produce its exact expected after hash. Conflict result:0.

Independent fresh DB readback confirmed the exact expected content bytes for 20 rows, all loaded nonbody fields unchanged, all 5 localized product-family rows unchanged, and language/source metadata unchanged.

WP Rocket cache was purged once using its native toolbar; its success message was observed. No cache or delay-JS setting was changed.

All 20 public article pages then returned 200. Each had zero occurrences of this obsolete href and exactly one changed href against its before HTML. Visible text, href counts and complete page JSONLD graphs were unchanged. Both localized product canonical URLs returned direct 200 with unchanged full JSONLD graphs. Two 390 px mobile samples, onePersian and oneArabic, had a visible corrected link inside the viewport; this is a narrow smoke check, not a new whole-site mobile audit.

## Remaining scope
Fresh DB reference search found zero remaining occurrences in the selected 20 sources. The same obsolete spelling still has 19 other published article sources:6 Arabic and 13 Tajik. They are queued, not silently declared fixed. Other defective aliases, technical WordPress links, generic/garbled anchors and weak contextual inlink coverage remain separate tasks.

No Request Indexing or Validate Fix was submitted. This report does not establish a new Google crawl, indexing recovery, traffic or ranking gain. Rank Math's auxiliary link-count tables were not rebuilt in this batch; public HTML and independent DB reads are the evidence.

## Next
Verify localized target 501926 live before the Tajik follow-up and preserve exact source/target identity, then finish the 19 remaining sources. After that, address high-frequency 404 andtechnical targets from their source articles and use a same-language topical map for new editorial links.

## Repository/privacy
The earlier legacy 75 repair and full audit were synced in commit 3 a 66 abe 1 e 6 c 98 dbef 29 cf 51 fd 0 af 8 a 6057511 e 46. This follow-up contains only public source URLs, IDs, hashes and verification results. Native-login URLs, cPanel sessions, cookies/nonces, complete post bodies, full DB exports, full .htaccess and private rollback SQL are excluded from GitHub.
