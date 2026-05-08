# Project Assessment & Refactor Plan (Arabic)

## 1) شو نوع المشروع الحالي؟

المشروع هو **تطبيق PHP تقليدي (Vanilla PHP + MySQL + Bootstrap)** مبني بأسلوب صفحات متعددة (Multi-Page Application)، وفيه:

- واجهات مستخدم عامة (عرض قصص/صور/فيديو).
- لوحة تحكم Admin لإدارة المحتوى.
- رفع ملفات (صور/فيديو) مباشرة داخل مجلدات محلية.
- قاعدة بيانات MySQL باسم `Basma`.

## 2) الوضع الحالي بسرعة

من قراءة الملفات، الملاحظات الأساسية:

1. **المنطق والواجهة مختلطين** داخل نفس الملفات (HTML + SQL + Session + CSS Inline).
2. **أسماء الملفات عشوائية نسبيًا** وفيها تكرار أنماط مثل `addX.php` و`addX_logic.php`.
3. **الـ assets (صور/فيديو) موجودة داخل نفس الشجرة** مع كود التطبيق.
4. **بيانات حساسة موجودة مباشرة في الكود** (اعتماد الاتصال بقاعدة البيانات hardcoded).
5. **لا يوجد فصل واضح لطبقات التطبيق** (Routes / Controllers / Services / Views / Config).

## 3) الهيكلة المقترحة (أفضل شكل عملي)

> هدفنا: هيكلة واضحة بدون ما نكسر المشروع، وبشكل تدريجي.

### 3.1 مجلدات مقترحة

```text
GraduationProject/
├── app/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── StoryController.php
│   │   ├── PhotoController.php
│   │   ├── VideoController.php
│   │   └── TeamController.php
│   ├── Services/
│   │   ├── StoryService.php
│   │   ├── PhotoService.php
│   │   ├── VideoService.php
│   │   └── UploadService.php
│   ├── Repositories/
│   │   ├── StoryRepository.php
│   │   ├── PhotoRepository.php
│   │   ├── VideoRepository.php
│   │   └── TeamRepository.php
│   ├── Middleware/
│   │   └── AuthMiddleware.php
│   └── Support/
│       ├── Validator.php
│       ├── Response.php
│       └── Helpers.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── constants.php
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/
│       ├── photos/
│       ├── videos/
│       ├── team/
│       └── stories/
├── resources/
│   └── views/
│       ├── layout/
│       ├── admin/
│       ├── stories/
│       ├── photos/
│       └── videos/
├── routes/
│   ├── web.php
│   └── admin.php
├── storage/
│   ├── logs/
│   └── cache/
├── database/
│   ├── schema.sql
│   └── seeds/
├── tests/
├── .env.example
├── composer.json
└── README.md
```

### 3.2 ربط الملفات القديمة بالهيكلة الجديدة

- `addStory.php` + `addStory_logic.php` ⟵ `StoryController::create/store`.
- `updateStory.php` + `updateStory_logic.php` ⟵ `StoryController::edit/update`.
- `deleteStory.php` ⟵ `StoryController::delete`.
- نفس النمط يتطبق على Photo/Video/Member.

## 4) Clean Code Rules للمشروع

1. **قاعدة ملف واحد = مسؤولية واحدة**.
2. **لا SQL داخل View**؛ كل الاستعلامات في Repository/Service.
3. **لا CSS inline كبير داخل الصفحات**؛ انقل التصميم إلى ملفات CSS.
4. **التحقق من المدخلات مركزيًا** (Validation Layer).
5. **التعامل مع الرفع عبر خدمة واحدة** (UploadService) مع:
   - فحص MIME type
   - حد للحجم
   - أسماء ملفات آمنة
6. **أسماء ثابتة وواضحة**:
   - Controllers بصيغة `XController`
   - Services بصيغة `XService`
   - Repositories بصيغة `XRepository`
7. **أخطاء موحدة** (رسائل عربية مناسبة + logging داخلي).
8. **فصل الصلاحيات**: أي صفحة Admin لازم تمر عبر Middleware.
9. **تعريف الثوابت والإعدادات في config/.env فقط**.
10. **إضافة README واضح** للتشغيل + الاستيراد + الحسابات التجريبية.

## 5) خطة تنفيذ تدريجية (بدون تعطيل المشروع)

### المرحلة 1 (سريعة وآمنة)
- إنشاء `config/database.php` وسحب بيانات الاتصال من `.env`.
- نقل CSS الكبيرة إلى `public/assets/css`.
- توحيد include/requires في bootstrap مبسط.

### المرحلة 2
- إدخال Router بسيط + Controllers.
- فصل منطق CRUD لكل Module داخل Services/Repositories.

### المرحلة 3
- نقل صفحات العرض إلى `resources/views` مع Layout موحد.
- إضافة Validation وإدارة أخطاء أفضل.

### المرحلة 4
- اختبار أساسي للعمليات الحرجة (إضافة/تعديل/حذف/رفع ملف).
- تحسين الأمان والأداء (Prepared Statements, limits, indexing).

## 6) Quick Wins فورية

1. نقل بيانات `dbConnection` إلى `.env`.
2. استبدال أي استعلامات ديناميكية بـ Prepared Statements.
3. إصلاح أخطاء إملائية/منطقية بسيطة (مثل فحص متغير خاطئ بعد query).
4. توحيد أسماء الملفات:
   - `*_logic.php` → `store/update handlers` داخل Controller.
5. إنشاء ملف `CONTRIBUTING.md` بمعايير الكود.

## 7) تعريف النجاح بعد الترتيب

- أي مطور جديد يفهم المشروع خلال 20–30 دقيقة.
- إضافة ميزة جديدة بدون نسخ/لصق ملفات.
- تقليل Bugs الناتجة عن تداخل HTML/PHP/SQL.
- سهولة اختبار وتوسعة لوحة التحكم.

---

إذا بدك، الخطوة الجاية أقدر أعمل **Migration فعلية للهيكل** على دفعات صغيرة مع المحافظة على السلوك الحالي 100%.
