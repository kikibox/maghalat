# Technical destination links: city cleanup and producer hardening

## Live cleanup scope

Twenty published city pages contained 22 injected
`p.navar-related-inline` paragraphs linking to WordPress implementation
objects (`acf-field`, `nav_menu_item` or `rank_math_schema`), not articles.
Labels included internal codes such as `k3` and `p1`.

Each removed paragraph contained exactly one anchor, pointing to one of these
non-content namespaces. Only those complete, meaningless referral paragraphs
were removed. Other article bytes, legitimate links, headings, images,
figures, tables, video and iframe blocks were preserved. No arbitrary
replacement destination or redirect was created.

The database update was guarded by all 20 original SHA-256 hashes and
retained private before/after backups and a guarded rollback. Independent
database readback matched all 20 expected full content hashes.

WP Rocket cache was purged through WordPress administration, with a visible
success confirmation. Public, unauthenticated HTTP checks after the purge
confirmed all 20 source pages still return HTTP 200 and contain no links
to the three technical namespaces. All 22 such links were present in the
same public pages before the change.

No original publication date, slug, title, price or product specification
was rewritten. Modification timestamps preserve the actual UTC edit instant. The follow-up
batch aligned local times with WordPress' resolved Asia/Tehran timezone; the
raw gmt_offset option was blank and was not a reliable offset source.

## Producer hardening

The active city workflow is in `maghalat`; source copies also exist in
`maghala2`, which has no city-generation workflow in the inspected tree.

Two concrete source-code defects were addressed in the active repository:

1. The basic city producer sanitized a local HTML variable, checked it,
   then returned the original unsanitized object. It now returns the exact
   sanitized HTML that passed QA. A small candidate pool no longer bypasses
   prompt initialization.
2. The reviewed production pipeline relied on a negative term list, without
   a live canonical/language/indexability check. It now uses the same
   fail-closed link verification policy as the article producer, before
   the original drafting function is called as well as during final review.

The policy is a source-code helper, not a WordPress plugin or a render-time
wrapper. Generation-state files and existing SQL packages were not edited.
The seven regression tests use mocked operations and do not import the
production review module's executable runner tail.

The runtime SEO launcher's exact replacement anchors were preserved and
checked by tests. Registering this source patch does not manually dispatch
generation, change its existing schedule, or re-import old bundles.

## Limits

The exact historical script that originally injected every
`navar-related-inline` paragraph has not been independently proven.
The code fixes above address verified present-day publication weaknesses;
they are not evidence that this particular script authored every legacy
paragraph.

This batch is not a claim that every technical link on the site is removed,
every old 404 is fixed, or the agronomic accuracy of each article is verified.
Other city pages remain for fresh inspection. Technical object URLs should
not be redirected to unrelated pages to make Search Console counts disappear.
## Final verification and remaining scope

The registered source change is commit
`59ca2c48683ebd4902b2b3875734762cac139dfa`. All six committed files were
read back and matched the intended bytes. All seven regression tests passed
locally and in GitHub Actions:
https://github.com/kikibox/maghalat/actions/runs/39057462437

All 20 public source pages were also checked for their exact WordPress post
identity, their own matching canonical, and zero redirect hops. Reapplying the
same paragraph-removal transform has no remaining targets in this batch.

After the first 20-page batch, a database query found 84 other published pages
with the same technical path patterns. They were queued for individual review;
the follow-up results below supersede that remaining-work count.

## Follow-up: all 84 remaining source pages completed

All 84 queued pages were loaded afresh and checked against their stored
SHA-256 content hashes. They contained 88 additional injected referral
paragraphs, each with exactly one link to an implementation-object namespace.
All 88 were removed at the stored source, preserving every other body byte,
valid link, heading, image, figure, table, video and iframe.

An independent live database readback verified all 104 content hashes across
both batches. A fresh query across every published post type now finds zero
post_content values containing the three audited technical path patterns.
This result is scoped to published stored content, not every database field
or every possible malformed URL spelling.

WordPress REST reports timezone Asia/Tehran and a resolved offset of +03:30.
The raw gmt_offset option is blank. Local modification timestamps were
aligned with the resolved zone, including the earlier 20 pages, while
retaining their original UTC edit instants. No publication date was
rewritten and no artificial later edit time was assigned.

One source already had a historical alias redirecting to its actual
canonical with a -2 suffix. Its exact post identity was independently
verified at the direct canonical; no slug, canonical or redirect rule was
changed in this follow-up.

After a confirmed WP Rocket purge, unauthenticated public requests checked
all 104 source pages, including the earlier batch. Every page returned
direct HTTP 200, had the expected WordPress post identity and matching
canonical, and exposed zero links to the three technical namespaces.

Combined verified result: 110 invalid referral paragraphs removed from
104 source pages. The public-before link counts independently match the
repair plan. A second identical removal pass has zero targets. Private
backups, hash-guarded repair/rollback files, and verification evidence remain
outside this public repository.

This closes the audited three-namespace internal-referral cleanup, not all
site SEO or factual-content review. Technical object URLs were not
redirected to unrelated content. Search Console may retain historical
examples; no blanket validation was started. Old SQL packages still require
review before re-import and were not certified by this cleanup.
