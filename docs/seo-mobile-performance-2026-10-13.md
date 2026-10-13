# بررسی سرعت موبایل — ۲۰۲۶-۱۰-۱۳

## نتیجه و محدوده
این مرحله تشخیصی است؛ هیچ تنظیم سایت، افزونه، کش سرور یا پایگاه داده تغییر نکرده است. شرایط فقط در مرورگر آزمایش اعمال و پس از پایان به حالت عادی بازگردانده شد.

دو نمونهٔ گروه‌های گزارش قبلی گوگل (یونجه و اصفهان) به‌علاوه صفحهٔ اصلی، هرکدام سه بار آزمایش شدند. این نمونه‌ها نمایندهٔ قطعی همهٔ URLهای گروه نیستند. نتیجهٔ آزمایش، گزارش تازهٔ CrUX/Search Console یا Lighthouse نیست.

## شرایط ثابت
- مرورگر موبایل با viewport393×851 و DPR2.75
- شبکه شبیه‌سازی‌شده با latency150ms، دانلود1.6Mbps، آپلود0.75Mbps
- CPU slowdown4× و کش مرورگر غیرفعال برای هر نمونه
- اتصال اندازه‌گیری در تمام بارگذاری‌ها باز نگه داشته شد؛ LCP از observer نصب‌شده پیش از navigation ثبت شد.
- فقط ۹ اجرای controlled.json در نتایج زیر استفاده شد؛ نمونه‌های مقدماتی CLI که محدودیت شبکه و observer آن‌ها پایدار تأیید نشده بود، از این مقایسه کنار گذاشته شدند.

## میانهٔ سه اجرای هر صفحه

| نمونه | انتظار اولین بایت TTFB، ثانیه | نمایش بزرگ‌ترین عنصر LCP، ثانیه | عنصر LCP |
| --- | --- | --- | --- |
| مقالهٔ یونجه | 3.82 | 6.68 | تصویر اصلی |
| صفحهٔ اصلی | 1.62 | 2.89 | عنوان اصلی |
| صفحهٔ اصفهان | 1.61 | 2.94 | تصویر اصلی |

TTFB شامل انتظار شبکه و پردازش پاسخ است؛ تمام این زمان را نباید زمان PHP یا مشکل هاست نامید. اختلاف نمونه‌ها، دلیل بررسی پاسخ HTML و کش است، نه اثبات نقش یک افزونه.

## شواهد و احتیاط‌ها
- در فهرست فعال افزونه‌ها که اخیراً از دادهٔ جاری خوانده شد، WP Rocket و Fast Velocity Minify فعال نبودند. خواندن داده‌ها SELECT-only بود.
- در پاسخ‌های HTTP عمومی، gzip و Server-Timing رندر وردپرس مشاهده شد؛ HIT ثابت کش صفحه در این بررسی تأیید نشد. نبود headerHIT به‌تنهایی اثبات نبود همهٔ انواع کش نیست.
- تصاویر LCP یونجه و اصفهان از قبل eager و fetchpriority=high هستند؛ lazy-loading تصویر LCP در این نمونه‌ها علت نیست.
- فونت Vazir از قبل preload و font-display:swap دارد؛ توصیهٔ تکراری تغییر به swap ارزش افزوده ندارد.
- در مقالهٔ یونجه Chart.js از CDN بدون async/defer بارگیری می‌شود. این یک نامزد بررسی frontend است، اما اندازهٔ اثر یا علت INP با این آزمایش اثبات نشده. بدون هماهنگ‌کردن bootstrap نمودار، صرفاً deferکردن آن ممکن است نمودار را خراب کند.
- INP میدان واقعی اندازه‌گیری نشده است. Long Taskهای زمان بارگذاری جای INP کاربر را نمی‌گیرند؛ مقدار INP در CSV عمداً خالی است، نه صفر.
- میانه‌های pandas با مسیر مستقل statistics.median از JSONهای خام تطبیق داده شد. دادهٔ nested ابتدا قابل پروفایل مستقیم نبود و به ۹ ردیف، یک ردیف برای هر navigation، نرمال شد؛ تکرار URLها عمدی و کلید(page,repeat) یکتا است. timestamp صرفاً provenance است و جمع زمان‌های تست نباید روزانه تفسیر شود.

## قدم اجرایی بعدی
1. بررسی/فعال‌سازی کنترل‌شدهٔ کش HTML کاربران ناشناس، با قابلیت موجود سایت؛ نخست بدون CSS/JS combine، delay یا removal خودکار.
2. URLهای واقعی سبد خرید، تسویه‌حساب، حساب کاربری و درخواست‌های AJAX/API یا دارای query زبان، و نشست‌ها/کوکی‌های WooCommerce از کش عمومی مستثنا شوند؛ آدرس‌ها نباید از روی حدس تعیین شوند.
3. جداسازی خروجی هر زبان بر اساس URL و بررسی lang/navar_lang؛ خروجی زبان‌ها نباید با هم مخلوط شود.
4. قبل و بعد از فعال‌سازی، زبان/RTL، canonical، تصویر ویدئو، قیمت/موجودی، فرم‌ها، سبد/تسویه‌حساب و ۸ ریدایرکت301 فعلی آزمایش شوند. بکاپ بیرون public_html و بلوک native301 باید حفظ شوند.
5. HIT واقعی با درخواست تکراری و پاسخ عمومی بررسی، سپس همین آزمایش مقایسه‌پذیر تکرار شود. موفقیت کش را پیشاپیش فرض نکنید.
6. سپس پروفایل تعامل‌های واقعیِ منوی موبایل/فهرست/کنترل‌های خرید برای INP؛ فعلاً ادعای رفع INP نشده است.

## منابع و داده
- metrics/seo-mobile-performance-2026-10-13.csv شامل ۹ مشاهده آزمایشگاهی عمومی است.
- JSON خام مرورگر، sessionها و اطلاعات ورود منتشر نشده‌اند.
- تاریخ گزارش‌های میدانی قبلی با تاریخ این آزمایش یکی فرض نشده است.

- https://navar-abyari.ir/%D9%85%DB%8C%D8%B2%D8%A7%D9%86-%D8%A8%D8%B1%D8%AF%D8%A7%D8%B4%D8%AA-%DB%8C%D9%88%D9%86%D8%AC%D9%87-%D8%AF%D8%B1-%D9%87%DA%A9%D8%AA%D8%A7%D8%B1/
- https://navar-abyari.ir/
- https://navar-abyari.ir/isfahan/%D9%86%D9%88%D8%A7%D8%B1-%D8%AA%DB%8C%D9%BE-%D8%A7%D8%B5%D9%81%D9%87%D8%A7%D9%86-%D9%82%DB%8C%D9%85%D8%AA-%D8%AE%D8%B1%DB%8C%D8%AF-%D8%B1%D9%88%D9%84-1000-%D9%85%D8%AA%D8%B1%DB%8C/

## Final verification: WP Rocket ON, Delay JavaScript OFF

The user enabled existing WP Rocket and then disabled Delay JavaScript execution. Agent made no plugin/theme/settings changes. Interim delay-enabled measurements are not the current configuration. Current public HTML has zero rocketlazyloadscript tags on the three diagnostic pages.

| Page | Before TTFB seconds | Current TTFB seconds | Before LCP seconds | Current LCP seconds |
| --- | --- | --- | --- | --- |
| مقالهٔ یونجه | 3.82 | 0.41 | 6.68 | 2.91 |
| صفحهٔ اصلی | 1.62 | 0.41 | 2.89 | 2.19 |
| صفحهٔ اصفهان | 1.61 | 0.40 | 2.94 | 2.17 |

Medians of three navigations per page per phase; same Pixel5 viewport393x851/DPR2.75, latency150ms, download1.6Mbps, upload0.75Mbps, CPU4x, fresh browser-cache-disabled requests. Nine final runs, independent pandas/statistics medians reconciled. First slower alfalfa run retained (TTFB1.874s/LCP4.300s); its cause is not definitively assigned. Cache does not remove the cost of future uncached rendering.
Repeated public requests show identical HTML and Last-Modified per page, cached@ marker and no dynamic WP Server-Timing. These support real public HTML caching. Sequential before/after diagnostic, not randomized causal attribution. INP is null/unmeasured, not zero; no new field Google/GSC validation. Dates are sample provenance, not daily trends; duration/day profiler hint is inapplicable. Resource bytes exclude navigation HTML and are not site traffic.

### Regressions and bounded purchase-path checks
- Five language homepages HTTP200 with correct language/direction; not proof every language-dependent product query is correct.
- Native Ardabil video/schema/poster preserved. All eight selected aliases still GET/HEAD301, one hop to correct200; query404 and unrelated404/POST controls retained.
- Mobile menu opens/closes with script delay off. No field INP claim.
- Guest session initially not logged in, cart empty. Native product655 button added quantity1; filled cart confirmed correct product655 quantity1. No customer information entered.
- Actual checkout link from filled cart points to /checkout/. HTML-only fetch HTTP200, private/no-cache, Woo Blocks checkout present. Checkout client scripts were deliberately not executed; no order or payment submitted. This is not end-to-end payment or logged-in testing.
- Test item removed through the observed remove button DOM click; final Store cart GET confirms zero items and empty-cart text. No blanket cart/cookie reset.

### Confirmed exceptions; NOT fixed yet
1. Persian empty cart displays Russian/Cyrillic product titles in Fresh in store recommendations. Confirmed before and after cart test; earlier activation-phase empty cart already showed it, so it cannot be attributed to disabling DelayJS. Root cause needs Woo Blocks query/language filtering investigation; do not assume generic cache-language bleed.
2. Mobile cart remove control is covered at its click point by wc-block-cart-item__total-price-and-sale-badge-wrapper; normal user-like click was blocked. Programmatic click used only to remove our own test item. Likely layout/CSS overlap, not a completed root-cause diagnosis. Needs root repair and ordinary touch/click retest.

Next: inspect existing child theme and multilingual product filtering before minimal scoped cart repairs; retain backups, native301 block, cache exclusions and no-order boundary. Continue remaining article LCP and uncached rendering work afterward.
Only sanitized navigation CSV is committed; raw HTML, cookies, session IDs, database backups and auth data remain private.

## Cart exceptions subsequently resolved
The two exceptions above are historical: both were root-fixed and independently verified later this session. See docs/seo-cart-root-fix-2026-10-13.md. No new performance benchmark or Google field validation was run in that repair phase.
