-- READ ONLY: inspection/export; this file does NOT fix or update any data.
-- Run against the current navaraby_wp569 database in phpMyAdmin.
-- Export each query result as SQL or JSON, then share the two small exports.
-- Only nine affected article IDs from the supplied backup plus Ardabil video page.
SELECT `ID`, `post_name`, `post_type`, `post_status`, `post_title`,
       `post_content`, `post_excerpt`, `post_modified`, `post_modified_gmt`
FROM `ha_posts`
WHERE `ID` IN (36975, 37219, 37889, 37891, 37907,
               502145, 502146, 502187, 502188, 35373)
ORDER BY `ID`;

-- Video metadata only; excludes users, passwords, keys and general options.
SELECT `meta_id`, `post_id`, `meta_key`, `meta_value`
FROM `ha_postmeta`
WHERE `post_id` = 35373
  AND `meta_key` IN ('rank_math_schema_VideoObject', '_thumbnail_id')
ORDER BY `meta_id`;
