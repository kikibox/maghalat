"""Offline tests. Never import the production runner's executable module tail."""
import ast
import re
import sys
import types
import unittest
from pathlib import Path
from unittest.mock import Mock, patch

ROOT = Path(__file__).resolve().parents[1]
sys.path.insert(0, str(ROOT / "automation"))
import article_link_policy as policy
import city_content_queue as city

GOOD = "https://navar-abyari.ir/thickness/"
BAD = "https://navar-abyari.ir/acf-field/field_private/"


def review_namespace():
    source = (ROOT / "automation/reviewed_publish_city_queue.py").read_text()
    tree = ast.parse(source)
    names = {"safe_links", "reviewed_make_content", "rebuild_internal_links"}
    ns = {"re": re, "article_link_policy": policy,
          "base": types.SimpleNamespace(MIN_LINKS=1),
          "ORIGINAL_MAKE": Mock()}
    for node in tree.body:
        if isinstance(node, ast.Assign):
            for name in node.targets:
                if isinstance(name, ast.Name) and name.id in {
                    "BLOCKED_LINK_TERMS", "BLOCKED_TITLE_TERMS", "PREFERRED_LINK_TERMS"
                }:
                    ns[name.id] = ast.literal_eval(node.value)
    functions = [n for n in tree.body if isinstance(n, ast.FunctionDef) and n.name in names]
    exec(compile(ast.Module(body=functions, type_ignores=[]), "<review-functions>", "exec"), ns)
    return ns


class CityLinkPreventionTests(unittest.TestCase):
    def test_cleaned_html_is_the_returned_html_even_for_small_pool(self):
        obj = {"html": (
            f'<p>متن <a href="{GOOD}">ضخامت نوار تیپ</a> '
            f'<a href="{BAD}">کد نامعتبر</a></p>'
            '[[[IMAGE_1]]][[[IMAGE_2]]][[[IMAGE_3]]]'
        )}
        row = {"url": GOOD, "title": "ضخامت نوار تیپ", "post_type": "post"}
        with patch.object(policy, "select_links", return_value=[row]), \
             patch.object(city, "agnes", return_value=obj), \
             patch.object(city, "MIN_WORDS", 1), patch.object(city, "MIN_LINKS", 1):
            result = city.make_content({"city": "تست", "county": "تست", "province": "تست"}, [row])
        self.assertNotIn(BAD, result["html"])
        self.assertIn(GOOD, result["html"])
        self.assertIn("کد نامعتبر", result["html"])

    def test_city_generation_stops_before_model_if_gate_fails(self):
        with patch.object(policy, "select_links", return_value=[]), \
             patch.object(city, "agnes") as model:
            with self.assertRaisesRegex(RuntimeError, "verified internal links"):
                city.make_content({}, [])
            model.assert_not_called()

    def test_review_rejects_technical_and_unknown_types(self):
        ns = review_namespace()
        rows = [
            {"url": BAD, "title": "ضخامت نوار تیپ", "post_type": "acf-field"},
            {"url": GOOD + "x/", "title": "لوله نخی", "post_type": "unregistered"},
            {"url": GOOD, "title": "ضخامت نوار تیپ", "post_type": "post"},
        ]
        with patch.object(policy, "verified", return_value=True):
            selected = ns["safe_links"](rows)
        self.assertEqual([x["url"] for x in selected], [GOOD])

    def test_review_rejects_failed_live_check(self):
        ns = review_namespace()
        with patch.object(policy, "verified", return_value=False):
            selected = ns["safe_links"]([
                {"url": GOOD, "title": "ضخامت نوار تیپ", "post_type": "post"}
            ])
        self.assertEqual(selected, [])

    def test_review_stops_before_original_draft_when_no_safe_links(self):
        ns = review_namespace()
        with patch.object(policy, "verified", return_value=False):
            with self.assertRaisesRegex(RuntimeError, "before city generation"):
                ns["reviewed_make_content"]({}, [
                    {"url": GOOD, "title": "ضخامت نوار تیپ", "post_type": "post"}
                ])
        ns["ORIGINAL_MAKE"].assert_not_called()

    def test_review_does_not_truncate_before_validation(self):
        ns = review_namespace()
        rows = [{"url": GOOD + str(i) + "/", "title": "ضخامت نوار تیپ",
                 "post_type": "unregistered"} for i in range(12)]
        rows.append({"url": GOOD, "title": "ضخامت نوار تیپ", "post_type": "post"})
        with patch.object(policy, "verified", return_value=True):
            selected = ns["safe_links"](rows)
        self.assertEqual([x["url"] for x in selected], [GOOD])

    def test_runtime_seo_replacement_anchors_still_exist(self):
        source = (ROOT / "automation/reviewed_publish_city_queue.py").read_text()
        for anchor in [
            "import hashlib,json,os,re,time\n",
            "QUALITY_GATE_VERSION=6",
            "        url=str(link.get('url',''));title=str(link.get('title',''))\n",
            "    body=obj.get('html','');errors=language_errors(body)+technical_errors(body)",
            "        obj=rebuild_internal_links(base.agnes(review_prompt),links)\n",
        ]:
            self.assertEqual(source.count(anchor), 1, anchor)


if __name__ == "__main__":
    unittest.main()