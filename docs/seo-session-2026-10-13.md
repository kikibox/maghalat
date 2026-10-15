# Session handoff — 2026-10-13 — Navar Abyari

## Scope and safety
- Requested: continue SEO remediation for navar-abyari.ir and sync this session to the project's repository.
- User confirmed repository: kikibox/maghalat, main branch. Existing auto-generated translation status files are preserved.
- Public-repository payload must exclude full SQL dumps, credentials, cookies, raw account screens, service account keys and raw private GSC exports. This handoff is a sanitized technical summary.
- Current status: authorized root article-link, Ardabil native-video and eight exact native legacy-301 repairs are deployed and verified. Earlier read-only/pending sections below document historical stages; the latest deployment section supersedes them. No additional redirect plugin installed.

## Earlier work and confirmations
- Russian content corrections were imported by user (v2; v1 had a MySQL temporary-table reporting issue).
- User activated language output and product category query fixes prepared earlier in the session.
- Product category sitemap was enabled and submitted by user; GSC reports Success. Sitemap discovery does not prove indexing.
- Audit reviewed primary GSC reports and issue details, not every site's URL or every URL Inspection. Older report snapshots must not be interpreted as proof the latest changes failed.

## Priorities identified during the audit (deployment updates below)
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

## Latest authorized root deployment and independent verification
- Re-read exact current values as HEX and compared client SHA-256 with MySQL SHA2 before mutation. phpMyAdmin display converts some spaces to NBSP; an earlier guarded attempt detected mismatches and made no content updates. Do not reuse display-normalized text as a byte-exact backup.
- Corrected twelve exact anchor href occurrences in the original bodies of nine published articles. Anchor text, other content, revisions, language configuration, valid product slugs and article modification timestamps were preserved. Six published destination products were independently validated.
- Independent SELECT after the guarded transaction confirmed all nine stored body hashes matched the prepared replacements.
- Added the already-declared MP4 to original Ardabil post35373 as a native controlled video player: no autoplay, preload=none, responsive sizing, genuine video-frame poster. No new persistent plugin or schema-output filter.
- Source MP4 remained unchanged. Genuine frame extracted from the source (640x640); verified uploaded JPEG HTTP200 and exact SHA256. Poster uses a versioned image URL to bypass an earlier negatively cached bare URL.
- Unserialized and reserialized native Rank Math VideoObject row11648 with round-trip verification. Only thumbnailUrl and duration (PT57S from a 57.424s source) changed. Existing contentUrl and all other fields were preserved. Page modification dates updated in the site's Asia/Tehran timezone.
- Independent SELECT confirmed the video page and serialized schema hashes. Stored native schema successfully unserialized after mutation.
- Persistent server backup table navar_seo_root_backup_20261013 now has eleven before-value records; guarded rollback scripts protect later edits. A byte-exact private combined rollback bundle was delivered separately; it is not a full-site backup and is NOT committed here.
- Public unparameterized canonical URLs of all nine articles returned HTTP200 with zero occurrences of the eight known bad product hrefs. Ardabil's ordinary URL returned HTTP200, rendered the player and emitted VideoObject with the accessible poster and PT57S. A cache-bypassed check also passed. No global cache deletion was needed or performed.
- These are live-output and database checks, NOT a new Google crawl or Search Console validation result. Displaying a video on a city sales page does not guarantee watch-page/video indexing.
- Exact native 301 handling of the eight external legacy aliases is still pending; internal source correction does not by itself repair external bookmarks. The rejected redirect plugin remains uninstalled. No unrelated 404s redirected.
- Remaining separate work: legacy exact 301s through existing tools/configuration, mobile performance diagnosis, important unindexed content review and genuine noncritical product-schema data.
- Public sync excludes snapshots, full article SQL payloads, serialized private backup values, session URLs, credentials and raw GSC exports. Existing translation live-status files remain untouched.

## Latest exact native legacy-301 deployment
- Baseline: all eight selected aliases returned404; all six verified product destinations returned200.
- Read current Rank Math module configuration and schema: redirection module inactive and no native redirection tables. Did not activate it or change plugin options.
- Read original root .htaccess, saved a private local copy, and made a private server copy outside public_html before editing. Original editor text matched the backup exactly.
- Prepended a clearly marked eight-rule block OUTSIDE WordPress-generated markers. The existing WordPress, compression/browser-cache and PHP directives remain an exact unchanged suffix. No new plugin, database updates, language changes or product slug edits.
- Exact byte-path matches, domain restriction, GET/HEAD only, empty query string only; no wildcard 404/home redirects. The exact malformed-byte alias is included without fuzzy normalization.
- Initial percent-encoded substitution interacted with this webserver's numeric backreferences. Post-save checks caught incorrect Location output; original configuration was immediately restored and checked. Corrected substitutions use literal UTF-8 target paths. Independent fresh read confirmed final saved file hash. Server propagation briefly returned older responses; repeated final checks passed for every source. Do not reuse the failed encoded-substitution variant.
- Final verification: all eight GET and eight HEAD requests returned301 to their exact expected destinations. Following each source required exactly one redirect and ended at HTTP200 on the correct product. All eight query-string exclusions returned404, an unrelated404 stayed404 and a POST control stayed404. Homepage and sitemap_index.xml returned200.
- Backups and complete server configuration are private. Only the isolated new rule block and sanitized documentation are synced. Existing auto-generated translation status files remain untouched.
- Fixed external handling for these eight selected aliases only. This does not mean all site404s are resolved, all GSC examples are fixed or Google has recrawled. No GSC Validate Fix clicked.
- Next priority: independently diagnose mobile LCP/INP, then review important unindexed content and remaining real schema warnings.

## Latest read-only mobile performance diagnosis
- Nine controlled mobile navigations across the two prior GSC group examples and homepage; detailed method, medians, limits and cache safety plan: docs/seo-mobile-performance-2026-10-13.md.
- TTFB and LCP independently measured, no site changes. Recent active-plugin list excludes WP Rocket; stable public HTML-cache HIT not established.
- Main LCP images already eager/high priority and font swap already configured. INP cannot be inferred from navigation Long Tasks; no INP fix claim.
- Next execution: verify/enable safe public HTML cache with actual WooCommerce, language/query/cookie exclusions; backup and regression tests, then repeat comparable measurements.

## Final cache/no-delay verification
- User enabled WP Rocket and disabled Delay JavaScript; public output/cache verified. Nine comparable final mobile runs and before/after medians recorded in performance report and sanitized metrics.
- Five home language attributes, Ardabil video/schema and eight exact301s preserved. Menu opens/closes.
- Guest product655qty1 add-to-cart verified; checkout HTML200/private read-only. No order/payment or identity entry. Test item cleaned, cart empty.
- Two unresolved root issues: Russian Fresh in store recommendation titles on Persian empty cart; mobile remove button covered by price wrapper. Programmatic removal used only for test cleanup, not evidence that ordinary remove clicks work.
- No agent plugin/settings changes and no new GSC/field INP validation. Next investigate child-theme/Woo language-query and cart CSS before scoped repair.

## Cart root repairs deployed and verified
Both previously open cart issues fixed in active child-theme source without new plugin or DB/settings mutation. Legacy product-new query now receives existing authoritative language clauses on cart only, with cart-grid transient bypass before lookup. Article table rules exclude Woo cart; two-column mobile row prevents implicit price-column overlap. Exact backups outside public_html and private ZIP retained. Stored files read back byte-exact. Normal remove click passed at mobile; hit tests and visible cells passed widths360/393/620/768/1280; guest cart cleaned. Five cart language outputs, five home languages, native video and eight exact301s pass. Generated domain HTML and only this theme minifiedCSS cache regenerated, new public CSS version verified. Details: docs/seo-cart-root-fix-2026-10-13.md.
User asked other GSC issues: sites_list refresh failed on output-schema permissionLevel; no live coverage update or permissions diagnosis claimed. Historical comprehensive report preserved separately; browser refresh requires user approval.

## Live GSC readonly review completed
Authenticated browser session available. Pages still shows Oct8 aggregate data; CWV/Product/Merchant reports Oct11. Current stored inspection confirms core Persian canonical products35011/37849 unknown to Google although reachable200/index/self-canonical/in current sitemap with category links. Arabic501917 is already indexed despite stale aggregate Crawled-not-indexed row. Current product sitemap158URLs;GSC last-read Oct7 shows46. Category sitemapSuccess25,readOct14. Captured457/457Crawled and1000/2184Discovered examples;18bounded live technical checks. No site changes, sitemap submit, request indexing, live test or validation performed. Suggested next with user confirmation:resubmit existing product sitemap and selectively request two verified canonical URLs;then truthful product schema cleanup. Details docs/seo-gsc-live-review.md.


## نتیجهٔ مرحلهٔ تأییدشدهٔ ارسال سایت‌مپ و بازبینی ایندکس

این مرحله پس از تأیید صریح کاربر اجرا شد و جایگزین وضعیت «هنوز اجرا نشده» برای ارسال سایت‌مپ است.

- ارسال مجدد همان `https://navar-abyari.ir/product-sitemap.xml` با پیام صریح **Sitemap submitted successfully** تأیید شد. ردیف موجود سپس Success، تاریخ ارسال/آخرین خواندن ۱۴ اکتبر ۲۰۲۶ و ۷۶ Discovered pages نشان داد. XML عمومی در پیش‌آزمون ۱۵۸ URL داشت. این اعداد به معنی تعداد صفحات ایندکس‌شده یا تکمیل پردازش همهٔ URLها نیستند.
- برای محصول 35011 (لوله نخدار ۱۲۵ میلی‌متر) دکمهٔ Request indexing فقط یک بار زده شد. بررسی خودکار شروع شد؛ مرورگر پیش از مشاهدهٔ پیام پذیرش نهایی اتصالش را از دست داد. بنابراین پذیرش نهایی خودِ درخواست تأیید نشده است. پس از بازیابی، بازرسی دقیق همان کنونیکال **URL is on Google / Page is indexed** نشان داد. خزش مجاز، دریافت موفق و ایندکس مجاز بود؛ Google-selected canonical همان Inspected URL است. Last crawl در رابط ۱۴ اکتبر ۲۰۲۶، ۱۴:۲۵:۲۳ نمایش داده شد؛ منطقهٔ زمانی رابط مشخص نشده و تبدیل نشده است. درخواست تکراری ارسال نشد.
- برای محصول 37849 (لوله تاشو ۱۲۵ میلی‌متر / ۵ اینچ)، بازرسی تازه پیش از هر درخواست **URL is on Google / Page is indexed** نشان داد. خزش مجاز، دریافت موفق و ایندکس مجاز بود؛ Google-selected canonical همان Inspected URL است. Last crawl در رابط ۱۱ اکتبر ۲۰۲۶، ۱۲:۵۷:۰۴ بود. چون ایندکس تأیید شد، هیچ درخواست ایندکس برای این محصول ارسال نشد.
- هر دو آدرس در پیش‌آزمون HTTP 200، robots index، کنونیکال خودارجاع و حضور در سایت‌مپ فعلی داشتند. نمایش قبلی unknown برای این دو محصول با نتیجهٔ فعلی جایگزین شده است؛ علت تغییر یا رابطهٔ علّی با ارسال سایت‌مپ/درخواست ادعا نمی‌شود.
- No referring sitemaps detected هنوز در بخش Discovery هر دو بازرسی دیده شد؛ با وجود Page is indexed، آن را به معنی ایندکس‌نشدن یا نبود URL در XML تلقی نمی‌کنیم.
- این مرحله هیچ تغییری در پایگاه داده، قالب، افزونه‌ها، تنظیمات زبان یا ریدایرکت‌ها ایجاد نکرد. Validate fix، حذف URL، درخواست انبوه یا درخواست برای صفحات دیگر اجرا نشد.

### کارهای باز بعدی
- پیگیری دادهٔ میدانی Core Web Vitals موبایل؛ گزارش قبلی همچنان ۴۶۲ URL ضعیف داشت و از این دو بازرسی رفع آن نتیجه نمی‌شود.
- اصلاح هشدارهای غیرحیاتی اسکیما با اطلاعات واقعی ارسال و مرجوعی؛ بدون ساخت امتیاز، نظر یا تاریخ جعلی.
- بررسی 404های مهم و محتوای اصلی با تشخیص مقصد معادل واقعی؛ بدون ریدایرکت یا noindex انبوه.

حریم خصوصی: فقط خلاصهٔ عملیاتی و URL عمومی ثبت شده‌اند؛ حساب، کوکی، شناسهٔ بازرسی، URL جلسه، HTML و خروجی خام منتشر نشده‌اند.


## مرحلهٔ بعد: بررسی ریشه‌ای اسکیما
قوانین عمومی فروش و خروجی تازهٔ دو محصول بررسی شد. نرخ حمل توافقی است و مهلت/روش/هزینهٔ مرجوعی در متن فعلی کامل نیست. پیاده‌سازی دادهٔ ساختگی متوقف شد؛ منتظر تأیید مالک دربارهٔ دامنهٔ کشورها، مهلت و هزینهٔ بازگشت، زمان آماده‌سازی/حمل و نرخ واقعی هستیم. هیچ تغییر زنده اجرا نشده است. جزئیات: `docs/seo-schema-root-audit.md`.


## انتشار قوانین صادرات در چهار زبان
برگه‌های عربی501884،تاجیکی501885،انگلیسی518701 و روسی518748 با شرایط تأییدشده مالک منتشر و عمومی تأیید شدند. صفحه فارسی15 با تطبیق مستقل تمام فیلدهای خوانده‌شده ثابت ماند. اسلاگ، عنوان، وضعیت و خلاصه حفظ شد؛ اسکیما و تنظیمات فروشگاه تغییر نکرد. پشتیبان و بازگردانی مشروط خصوصی آماده است. گزارش و متن عمومی نسخه‌ها در `docs/seo-export-policy-update.md` و `content/export-policies/` ثبت شد.


## تشخیص فقط‌خواندنی کد نصب‌شده اسکیما
شش فایل نصب‌شده خوانده و سه فایل Rank Math با آرشیو تطبیق دقیق شدند. تنظیم برند به‌اشتباهproduct_type و خروجیsimple است؛ فیلتر فعلی قالب به ووکامرس متصل است ولی Rank Math خروجی آن را جایگزین کرده. لینک قوانین محصولات هنوز به برگه‌های قدیمی200می‌رود. تاریخ پایان قیمت پیش‌فرض2027-12-31 و زبانItemPageغیرفارسیfa-IR است. محل اصلاح محدود و بدون تغییر هسته افزونه در گزارش `docs/seo-schema-installed-diagnosis.md` مشخص شد. categoryمحلی طبق مستندات لزوماً نامعتبر نیست و علت دقیق هشدار آن هنوز اثبات نشده؛ هیچ تغییر زنده، Validate fix یا درخواست ایندکس اجرا نشد.
