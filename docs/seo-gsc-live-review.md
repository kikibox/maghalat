# تازه‌خوانی زندهٔ سرچ کنسول پس از اصلاح سبد

## خلاصهٔ تصمیم
نشست معتبر گوگل در مرورگر موجود بود. با وجود خطای قالب خروجی sites_list در MCP، گزارش‌ها از رابط Search Console فقط خوانده شدند؛ این خطا کمبود دسترسی را ثابت نمی‌کرد. هیچ تنظیم سایت، sitemap submit، Request indexing، Test live URL، Validate fix یا حذف آدرسی انجام نشد.

دو محصول فارسی مهم در URL Inspection آدرس کنونیکال هنوز «URL is unknown to Google» هستند، با آنکه اکنون HTTP200، index،self-canonical، حضور در XML سایت‌مپ و لینک از دستهٔ مربوط دارند. علت قطعی ثابت نشده؛ ناشناخته‌بودن گوگل را نباید با noindex یا نبود فعلی در سایت‌مپ یکی دانست.

| محصول | شناسه | URL Inspection ذخیره‌شده | بررسی فعلی سایت |
| --- | --- | --- | --- |
| لوله نخدار125میلیمتر |35011|URL is not on Google؛unknown to Google؛خزش و referring sitemap ثبت نشده|200،index،self-canonical،داخل sitemap و لینک از دسته|
| لوله تاشو125میلیمتر،5اینچ |37849|URL is not on Google؛unknown to Google؛خزش و referring sitemap ثبت نشده|200،index،self-canonical،داخل sitemap؛از خانه و دسته لینک دارد|
| خرطوم قماشي75ملم،عربی |501917|URL is on Google؛Page is indexed؛Product snippets وMerchant listings معتبر با هشدار غیربحرانی|200،index،self-canonical،داخل sitemap|

محصول عربی در گزارش تجمیعی Crawled–currently not indexed بود ولی Inspection فعلی indexed است. بنابراین دست‌کم این ردیف تجمیعی قدیمی است و شمار گزارش کلی را نباید به همهٔ آدرس‌ها در زمان حاضر تعمیم داد.

## سایت‌مپ‌ها
- در رابط زنده product-sitemap.xml با Success،آخرین خواندن7اکتبر2026 و46صفحهٔ کشف‌شده گزارش شد.
- XML فعلی همین فایل158URLمحصول دارد. این دو مشاهده تاریخ پردازش یکسان ندارند؛ تفاوت، نرخ رشد یا دلیل قطعی ناشناخته‌بودن دو محصول نیست. گزارش Google هنوز پردازش نسخهٔ فعلی را ثابت نمی‌کند.
- product_cat-sitemap.xml با Success،25صفحه و آخرین خواندن14اکتبر2026 دیده شد. این25عدد،تعداد ایندکس‌شده نیست.
- همهٔ33ردیف سایت‌مپ درDOMبارگذاری‌شده بررسی شدند؛ثبت جدید انجام نشد.

## مسیر لینک‌دهی و robots
دو دستهٔ مرتبط فعلی200,index,self-canonical هستند و به محصول خود لینک مستقیم دارند. خانه به هر دو دسته لینک دارد؛محصول تاشو125علاوه‌برآن لینک مستقیم از خانه دارد. بنابراین در این بررسی،دو محصول orphan یا درrobotsمسدود تشخیص داده نشدند. robots فعلی پارامترnavar_lang وfeed/embedرا منع می‌کند،نه این دو مسیر کنونیکال. دستورها کورکورانه برداشته نشدند.

## دامنهٔ نمونه‌ها
تمام457نمونهٔ بارگذاری‌شدهٔCrawled و1000نمونه از2184موردDiscovered استخراج شدند. ردیف‌هایDOMبارگذاری‌شده ازdata-value واقعیURL خوانده شدند،نه متن آیکون‌ها و نه فرض صفحه‌بندی. بخشDiscovered کامل نیست؛1184مورد بیرون نمونه‌اند.1457URLیکتا،بدون ردیف تکراری داریم؛محدودیت نمونه در همهٔ نتیجه‌گیری‌ها حفظ شد.
در نمونه‌هایCrawled،198feed و56مسیرasset/system وجود دارند؛اینها خودبه‌خود صفحهٔ اصلیِ نیازمند ایندکس نیستند. دسته‌بندی مسیر صرفاً مکانیکی است،نه تشخیص کیفیت محتوا. LastCrawledخالی برایDiscovered انتظار می‌رود و صفر تلقی نشده؛هیچ روند زمانی محاسبه نشد. گزارش کلیPagesتاریخ8اکتبررا نشان می‌دهد؛بعضی captureهای جزئی8/9اکتبر را نشان دادند و از تفاوت سربرگ‌ها نتیجهٔ بهبود گرفته نشد.
تمام13URLمحصولِ حاضر در این نمونه‌ها و5نمونهٔ محتوای اصلی/FAQ/شهر،جمعاً18آدرس،باHTTP/کنونیکال/robots/فرم محصول بررسی شدند؛این آزمون عمومی جانشینURL Inspectionهمهٔ18آدرس نیست.چهارURLمحصولیِ خراب‌نویسی‌شده در نمونهٔCrawled با400/404می‌رسند؛برای آنها مقصد معادل قطعی تعیین نشده وریدایرکت جدیدی اعمال نشد.یک نمونهٔمقالهٔDiscoveredهم404بود؛نباید صرفاً برای کاهش شمار گزارش به خانه منتقل شود.

## گزارش‌های زندهٔ دیگر
Core Web Vitals باآخرین بروزرسانی11اکتبر:462poorURLموبایل؛دسکتاپ دادهٔاستفادهٔکافی ندارد.اصلاح اخیرکش وسبد،تأییدرفعINP/LCPمیدانی نیست.
Product snippets وMerchant listings باآخرین بروزرسانی11اکتبر:هرکدام20valid،0invalid،بدونcriticalissue.هشدارهایReview/aggregateRatingهرکدام16؛درMerchant،hasMerchantReturnPolicy/shippingDetails/validFromهرکدام20،categoryنامعتبر13.این تعدادها هم‌پوشان و قابل‌جمع برای تعدادمحصول یکتا نیستند؛سطرهایN/Aباعدد0خطای فعال تلقی نشدند.
درHTMLفعلی سه محصول نمونه،offers فاقدshippingDetails/returnPolicy/validFromاست؛categoryنام دستهٔمحلی است.این بررسی اولیهٔخروجی است،نه اثبات علت تک‌تک13categorywarning.برای35011rating/reviewواقعی موجود است ولی برایدو نمونهٔدیگر نیست؛هیچ امتیازیاReviewجعلی پیشنهادیاایجاد نشد.

## مرحلهٔ بعد پیشنهادی؛هنوز اجرا نشده
1. با تأیید کاربر،ارسال مجدد همینproduct-sitemap.xmlموجود برای پردازش نسخهٔ فعلی؛ثبت تکراری سایت‌مپ دسته‌ها لازم نیست.
2. درخواست ایندکس محدود به دو URLکنونیکال200تأییدشده،نه bulkهمهٔآدرس‌ها و نه feed/asset/400/404.این درخواست تضمین ایندکس نیست.
3. تکمیل اسکیما مطابق سیاست واقعی ارسال و مرجوعی؛validFromفقطبراساس تاریخ واقعی قابل‌اثبات؛رفعcategoryپس ازتطبیق الزامات،نه حذفدسته‌بندیWordPress.براینبودReviewواقعی داده‌سازی نشود.
4. بررسی محتوای مهم،لینک‌های داخلی و404های باقی‌مانده با مقصد معادل واقعی؛ازnoindex/redirect/بازنویسی انبوه بدون شواهد پرهیز شود.

## منابع و حریم خصوصی
URLهای عمومی ونتایج خلاصه‌شده درمخزن ثبت شدند؛cookie،حساب گوگل،URLجلسه،توکنopaqueURLInspection،HTMLخاموexportکاملخصوصی هستند ودرمخزن عمومی قرار نگرفتند.فهرست کامل1457نمونهٔخوانده‌شده وHTMLخامخصوصی می‌مانند؛فقطنتیجهٔفنی18نمونهٔانتخابی و خلاصهٔمحدودیت‌ها سینک می‌شود.

- گزارش Pages: https://search.google.com/search-console/index?resource_id=sc-domain%3Anavar-abyari.ir
- گزارش سایت‌مپ: https://search.google.com/search-console/sitemaps?resource_id=sc-domain%3Anavar-abyari.ir
- Core Web Vitals: https://search.google.com/search-console/core-web-vitals?resource_id=sc-domain%3Anavar-abyari.ir
- Product snippets: https://search.google.com/search-console/r/product?resource_id=sc-domain%3Anavar-abyari.ir
- Merchant listings: https://search.google.com/search-console/r/merchant-listings?resource_id=sc-domain%3Anavar-abyari.ir

### URLهای کنونیکال بررسی‌شده
- 35011: https://navar-abyari.ir/product/%d9%84%d9%88%d9%84%d9%87-%d9%86%d8%ae%d8%af%d8%a7%d8%b1-125-%d9%85%db%8c%d9%84%db%8c%d9%85%d8%aa%d8%b1/
- 37849: https://navar-abyari.ir/product/%d9%84%d9%88%d9%84%d9%87-%d8%aa%d8%a7%d8%b4%d9%88-125-%d9%85%db%8c%d9%84%db%8c%d9%85%d8%aa%d8%b1-5-%d8%a7%db%8c%d9%86%da%86/
- 501917: https://navar-abyari.ir/product/ar-iq-product-35005/
