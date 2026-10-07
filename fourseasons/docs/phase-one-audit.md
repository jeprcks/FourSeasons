# Four Seasons Canada — Phase One Audit

## Reference findings

Reference: https://www.four-seasons.ca/ (reviewed 6 October 2026)

### Navigation tree observed

- Education
  - Study Permit
  - Post Graduation Work Permit
  - Spouse Open Work Permit
  - Status Extension
- Immigration
  - Express Entry
  - Canadian Experience Class
  - Federal Skilled Worker
  - Provincial Nominee Programs
  - Pilot Programs
- Sponsorship
  - Family Sponsorship
  - Parents and Grandparents
  - Other Relatives
- Visit
  - Family or Leisure
  - Super Visa
  - Business or Exploratory
- Others
  - Citizenship
  - PR Renewal
  - Status Restoration
  - LMIA
  - Work Permit
  - Visa Refusals
- About Us
  - Who We Are
  - What We Do
  - Where We Are

The reference homepage content sequence is: callback inquiry/contact area; education and immigration promotional banners; mission and vision with credibility statistics; service cards; featured schools grouped by province; team; seasonal events; school promotion; testimonials and additional contact content. The top area also shows contact details and account links. The supplied project brief says public visitors should not need accounts, so the implementation should retain the lead form and avoid reproducing the reference login/register flow.

## Current repository inventory

Present:

- Custom PHP MVC bootstrap, router, controllers for public content, core utilities and middleware.
- Models for services, categories, schools/programs, team, events, blog, leads, navigation, settings, and homepage sections.
- MySQL schema and seed data, including the core public content entities and example content.
- Public/admin route declarations, including service categories, detail pages, inquiry submission, and CMS sections.

Missing or incomplete:

- `app/views` is absent, so every rendered route currently lacks its template and layout.
- `public/assets` is absent, so styles/scripts and visual assets are not present.
- `app/controllers/admin` contains only `BaseAdminController.php`; route targets such as `AuthController`, `DashboardController`, and content-admin controllers are missing.
- No `README.md` or local setup instructions are present.
- The reference has account links, while the requested product flow explicitly excludes customer accounts; public account links should not be carried over.

## Site map and page inventory

- `/`: home, with inquiry CTA, promotions, mission/vision and stats, services, schools, team, events, testimonials.
- `/education`, `/immigration`, `/sponsorship`, `/visit`, `/others`: service-category landing pages.
- `/{category}/{slug}`: service detail pages for the five categories.
- `/about/{slug}`: Who We Are, What We Do, Where We Are.
- `/schools`, `/school/{slug}`: school directory and details.
- `/team`, `/team/{slug}`: team listing and profiles.
- `/events`, `/event/{slug}`: event listing and details.
- `/blog`, `/blog/{slug}`: posts and details.
- `/contact`, `/search`, `/sitemap.xml`, `/robots.txt`.
- `/admin/login`, `/admin/dashboard`, then leads, pages, services/categories, schools, team, events, blog/categories, testimonials, FAQs, media, homepage, navigation, settings, users, and audit.

## Database entities and relationships

The current schema/seed files cover roles/permissions, users, menu items, pages, service categories/services, service FAQs/packages, schools/programs, team members, events, blog categories/posts, testimonials, FAQs, media/gallery items, homepage sections, settings, leads/lead notes, login attempts, and audit logs. Primary relationships include services to categories; school programs to schools; blog posts to categories; leads to services and users/notes; menu items to parent menu items; role permissions to roles and permissions. Confirm exact foreign keys and indexes against `database/schema.sql` during implementation.

## Recommended next implementation sequence

1. Add the shared public/admin layouts, page templates, CSS, and vanilla JS so existing public controllers can render.
2. Implement the missing admin authentication/dashboard/controllers to match declared routes and protect mutations with the existing CSRF/auth middleware.
3. Exercise the existing lead submission path end to end, then fill CMS CRUD gaps and document XAMPP setup.

## Access note

Workspace was read-only during this audit. No application files were modified in this pass.
