# مرحله سوم اسکیما: ارجاع صحیح قوانین مرجوعی سازمان

## انتخاب روش
مستندات جاری گوگل برای MerchantReturnPolicy درسطح Organization، گزینهB یعنی `merchantReturnLink` را به‌عنوان روش الزامی جایگزین می‌پذیرد. برای سیاست پیچیده این فروشنده، لینک به متن واقعی از ساخت یک بازه مرجوعی عمومی یا هزینه ثابت صادقانه‌تر است. پشتیبانی این روش درسطح Organization به‌معنای تضمین رفع هشدارhasMerchantReturnPolicy تک‌تکOfferها نیست؛ الزامات Offer متفاوت‌اند.

## تغییر اجراشده
- فقط `wp-content/themes/navar-child-zamtar-reader/inc/schema.php` به‌صورت الحاق محدود تغییر کرد. نسخه قبل با مرحله دوم تطبیق دقیق، قبل ازSave دوباره کنترل و فایل پس از یکSave در View بومی مستقل بازخوانی شد؛ هش نهایی یکسان بود. هسته افزونه، DB، قیمت/دسته/تاریخ و متن قوانین تغییر نکرد.
- hook رسمی `rank_math/schema/validated_data` روی همان موجودیت با @id=`https://navar-abyari.ir/#organization` و نوعOrganization/LocalBusiness موجود، `hasMerchantReturnPolicy` می‌گذارد. Organization جدید، Product جدید یا سیاست Offer ساخته نشد. Organization دیگر و سیاست غیرخالی ازقبل‌پیکربندی‌شده بازنویسی نمی‌شوند.
- دو سیاست با scope روشن ثبت می‌شوند: ایران با `applicableCountry=[IR]` و لینک قوانین فارسی؛ صادرات با `[IQ,AF,AM,GE,TJ]` و لینک زبان جاری بهar-iq-qawanin/tg-tj-qoidaho/en-us-terms/ru-ru-terms. در صفحه فارسی، ارجاع صادرات به نسخه انگلیسی منتشرشده است تا هر دو سیاست عمومی در همان سازمان موجود باشند. زبانen-US/ru-RU به معنی فروش بهآمریکا/روسیه نیست.
- هر سیاست فقط@type،@id پایدار،merchantReturnLink وapplicableCountry دارد. هیچmerchantReturnDays،returnPolicyCategory،returnFees،shippingRate،refundType یا وعده حمل رایگان ساخته نشد.24ساعت اعلام مغایرت، یک فصل زراعی ضمانت و20روزکاری بازپرداخت باهم اشتباه گرفته نشدند.
- فقط برگه واقعاً موجود باوضعیتpublish وpermalink معتبر به‌عنوان هدف پذیرفته می‌شود؛ حذف/پیش‌نویس‌شدن ترجمه باعث fallback گمراه‌کننده بهقوانین داخلی برای صادرات نمی‌شود. زبان ناشناخته و admin بدون تغییر برمی‌گردند.
- کش صفحات از گزینه بومی «پاک کردن کش» WP Rocket یک‌بار تازه شد؛ تنظیماتWP Rocket/DelayJavaScript/CSS/DB تغییری نکرد.

## کنترل‌ها
- PHP lint پیش از ذخیره و روی فایل بازخوانی‌شده موفق بود.
-84assertion اختصاصی سیاست و61assertion رگرسیون مرحله قبل، جمع145assertion، موفق بود: پنج زبان، کشورهای واقعی، سیاست‌های جدا، نبود عدد/هزینه ساختگی، حفظ سیاست موجود، برگهdraft/حذف‌شده، شکل گراف، admin/زبان ناشناخته، تاریخ قیمت و زبان محتوا.
- baseline تازه مهمان از پنج محصول درپنج زبان و پنج برگه قوانین گرفته شد. پس از انتشار، هر10صفحهHTTP200 و یکOrganization هدف با دوMerchantReturnPolicy صحیح داشتند. با کنارگذاشتن فقطhasMerchantReturnPolicy سازمان، کل گراف هر10نمونه دقیقاً باbaseline برابر بود؛ Product/Offer/قیمت/ارز/برند/امتیاز/دسته/تاریخ/زبان/کنونیکال دست‌نخورده ماندند.
- متن قابل‌مشاهدهmain هرپنج برگه قوانین عینbaseline بود. لینک بله فوتر درهمه و آیکون شناور فقط درنمونه‌های فارسی باقی ماند.
- نمونه روسیِ دقیق گزارش قبلی category، `/product/ru-ru-product-37849/` نیزHTTP200، یکProduct و دوسیاست سازمان داشت. category همان متن `Плоский шланг без армирования`، ازنوعJSON string است. این مشاهده اثبات علت هشدار نیست؛ مستندات جاری گوگل category سفارشیText را می‌پذیرند، پس بدون شاهد دقیق دسته حذف یا بهGPC جعلی تبدیل نشد.

## آزمون رسمی گوگل: اقدام شد، نتیجه‌ای نگرفتیم
نمونه روسی فوق در رابط واقعی Rich Results Test، حالتURL وGoogle Inspection Tool smartphone، ارسال شد. ابزار فوراً پیام `Something went wrong. If the issue persists, try again in a few hours.` داد؛ هیچ نتیجه ارزیابی/تأیید دریافت نشد. طبق پیام ابزار، دوباره پشت‌سرهم تکرار نشد. این پیام به‌عنوان اشکال خودسایت، robots block، خطای اسکیما یا رفع هشدار تفسیر نشده است. داده حساب Google یا صفحه خصوصی درمخزن نیست.

## محدودیت‌ها و اقدام بعد
- وضعیت تازه Search Console خوانده نشد، Validatefix ودرخواست ایندکس اجرا نشد. نمونه‌های عمومی و آزمون‌های محلی موفق‌اند، اما تأیید RichResults یا رفع هشدارGSC ادعا نشده؛ crawl بعدی ممکن است لازم باشد.
- هشدارهای Offer-level returnPolicy، shippingDetails، validFrom بدون منبع واقعی و بررسی مستقلcategory ممکن است باقی بمانند. سیاست لینک‌محور سازمان نباید با افزودن فیلد ناقص بهOffer یا حمل رایگان ساختگی جایگزین شود.
- پس از در‌دسترس‌شدن ابزار گوگل، همان نمونهcategory دوباره تست شود؛ درصورت نیاز وضعیت ایندکس‌شده وHTMLگوگل مقایسه گردد. تا آن زمان category تغییر نکند.
- نسخه پیش ازاین مرحله که اصلاح زبان/تاریخ/برند قبلی را دارد درپشتیبان خصوصی نگهداری شده است؛ بازگردانی فقطschema.php وپاک‌سازی کش لازم است. بله و فوتر مستقل‌اند.

## منابع
- https://developers.google.com/search/docs/appearance/structured-data/return-policy (OptionB و Organization درمقابلOffer)
- https://developers.google.com/search/docs/appearance/structured-data/merchant-listing (الزامات Offer وcategoryText)
- صفحات قوانین عمومی پنج زبان وURLعمومی نمونه‌ها درmetrics/schema-root-fix-stage3.json.
- فقط گزارش، شواهد حداقلی عمومی وpatch اختصاصی سایت سینک شده؛ نشستcPanel، اطلاعات ورود، nonce، کوکی، کدکامل افزونه و دادهخامDB/GSC منتشر نشده‌اند.
