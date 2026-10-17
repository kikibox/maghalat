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
was rewritten. Modification timestamps reflect the actual edit using the
site's configured GMT offset.

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