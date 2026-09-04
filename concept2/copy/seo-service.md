# SEO, AEO & GEO — service page copy (draft, 2026-09-04)

Post type: Service · Slug: `seo` · Menu order: 5 · Status: draft until approved

## Excerpt (Services page cell)
Your customers ask Google, Siri, and ChatGPT before they ever call you. We help your business show up in all three places.

## Row 1
**Title** (textarea; the `<strong>` line sets in the red script)
```
Get Found
<strong>Everywhere They Search</strong>
```
**Content**
Your customers don't just Google anymore. They ask Siri, they ask ChatGPT, and they read the answer at the top of the page without ever clicking a link. If your website isn't part of that answer, you're invisible at the exact moment someone is ready to buy.

We help your business show up in all three places: the classic search results (SEO), the answer boxes and voice assistants (AEO), and the AI tools that write their own answers (GEO). Same website, same great copy, three ways to get found.

## Row 2 (red)
**Content Left**
### Search Engine Optimization (SEO)
Want to be found online? Search engine optimization (SEO) can help you get there. We've learned over the years that websites trying to outsmart or trick search engine algorithms with changing techniques fail. Good SEO is a marathon, not a sprint. Strategies too often focus on short-term gains instead of long-term growth. We don't have a secret SEO solution up our sleeve for an instant #1 spot.

What we do have is 15 years of watching what works: a site that loads fast, pages built around the questions your customers actually ask, and copy worth reading. Every Bellaworks site starts with keyword research folded into the copywriting, so SEO isn't an add-on. It's in the foundation.

**Content Right** (no heading = script pull quote; this is the existing Digital Marketing callout, moved)
We've found SEO success lies in a content-based strategy that ramps up organic traffic and boosts your brand online. It's the perfect mix of killer content, great copywriting, and spot-on messaging that doesn't just get clicks.

## Row 3 (brown)
**Content Left**
### Answer Engine Optimization (AEO)
Ever asked Google a question and gotten the answer right at the top, no clicking needed? That's an answer engine at work, and voice assistants like Siri and Alexa read from the same playbook.

AEO means writing your pages so they answer real questions clearly and directly. Short answer up top, details below, and the behind-the-scenes markup that tells search engines exactly what each page is about. When your site is the clearest answer, it gets picked.

**Content Right**
### Generative Engine Optimization (GEO)
ChatGPT, Gemini, and Google's AI Overviews don't just point to websites anymore. They write their own answers, and they pull from the sites they trust. GEO is how you become one of those sources.

We make sure your business, your services, and your expertise are spelled out plainly, backed by real detail, and easy for AI tools to read and quote. Think of it as introducing your business to the newest, fastest-growing referral source out there.

## FAQs — Section Title: "SEO, AEO & GEO FAQs"
1. **What's the difference between SEO, AEO, and GEO?**
   SEO helps your website rank in the classic list of search results. AEO helps it get picked for the answer boxes and voice assistants that answer a question outright. GEO helps AI tools like ChatGPT and Google's AI Overviews mention your business when they write an answer. They overlap a lot, and the same good habits feed all three: a fast site, clear pages, and copy that actually answers questions.
2. **How long does it take to see results?**
   SEO is a marathon, not a sprint. Most sites see movement in three to six months, and the gains keep building from there. Answer engines and AI tools can pick up a well-written page faster, but there's no switch we can flip for an instant #1 spot. Anyone promising one is selling something.
3. **Do I need a new website for this?**
   Not necessarily. If your site is fast, mobile-friendly, and easy to update, we can build on it. If it's slow or hard to edit, fixing that usually comes first, because no amount of optimization helps a site search engines can't read well. We'll tell you honestly which one you're working with.
4. **Is this included when Bellaworks builds my website?**
   The foundation is. Every site we build starts with keyword research folded into the copywriting, clean code, and the behind-the-scenes markup search engines look for. Ongoing SEO, AEO, and GEO work, like new content, tracking, and tuning, is a separate service we tailor to your goals.
5. **Do you do the work in-house?**
   Yes. Our small but mighty Charlotte team handles the research, writing, and technical work ourselves. Nothing is farmed out.
6. **How do you measure success?**
   We track what matters to your business: rankings for the terms you care about, traffic from search and AI referrals, and the calls and form submissions that traffic turns into. You'll get a plain-language report, not a spreadsheet that needs a decoder ring.

## Yoast
- Title: `SEO, AEO & GEO Services in Charlotte, NC - Bellaworks Web Design`
- Description: `Get found in Google, the answer box, and AI tools like ChatGPT. Bellaworks helps Charlotte businesses with SEO, AEO, and GEO, all done in-house.`

---

# Live-site checklist (after the theme is deployed and activated)

Theme activation runs the field-group migration by itself. If the theme was already active before this build lands, visit `/wp-admin/?bw_migrate_services=1` once as an admin. It rewires the four existing service posts to the shared "Service Content" group and trashes the four old groups (reversible from the ACF trash).

Then, by hand in the admin:
1. Services → Digital Marketing: change the title to **Marketing & Automation** (leave the slug `digital-marketing`). Replace its SEO section with the new CRM / automation / AI copy when ready.
2. Services → Add New: **SEO, AEO & GEO**, slug `seo`, fields and FAQs from above, excerpt, Yoast title/description.
3. Pages → Services → Services repeater: rename the Digital Marketing row to `Marketing` / `+ Automation`, add a row `SEO, AEO` / `& GEO` linked to the new post.
4. Appearance → Menus → Primary Menu: add the new service under Services.
