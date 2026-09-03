# Bellaworks 2026 — Style Guide

Read this before building any new page. Everything below is lifted from the approved homepage and is the vocabulary every other page extends. Tokens and components live in `bw-retro.css`; working markup lives in `Main.dc.html` (desktop), `Mobile.dc.html`, and the generated `hero.html`.

## 1. Direction in one line

Retro diner poster brought to the web: three flat colors, chunky condensed caps with a brush-script accent, rubber-stamp and starburst devices, dotted and dashed rules, faint halftone textures, and hand-drawn retro illustrations of "old" objects with an info-icon decoder. Sections stack conventionally, full width, alternating tan / red / brown. No photography of people. No gradients, no drop shadows, no rounded-card-with-left-border patterns.

## 2. Palette (only these three)

| Name | Hex | Use |
|---|---|---|
| Brown | `#2b0b0a` | text on tan, brown sections, all linework, dark buttons |
| Red | `#df0118` | script accents, highlighted words, red sections, red buttons, starbursts, small stars |
| Tan | `#efdec4` | page and light sections, text on brown/red, tan buttons |

Derived: link hover on tan `#b20013`; dashed rules on red/brown `rgba(239,222,196,.55)`; icon-strip rules on brown `rgba(239,222,196,.35)`; dashed rules on tan `rgba(43,11,10,.35)`. Never add a fourth color. Illustrations are brown line art, tan fills, red only on small accents (knobs).

## 3. Type

- Display: **Anton**, uppercase, `letter-spacing: .005em`, `line-height: .9`. Headlines only.
- Script: **Kaushan Script**, `line-height: 1`. One accent per section at most: "Simple.", "(We Got You Covered)", "Get Started in", the band sub-line.
- Body and labels: **DM Sans** 400 / 500 / 700. Body 19–20px at `line-height: 1.6`. Labels 12px, 700, `letter-spacing: .22em`, uppercase. Nav 13px / `.14em`. Buttons 13px / `.16em`.
- Fluid sizes: h1 `clamp(72px, 11.4vw, 164px)`; big h2 `clamp(56px, 8.9vw, 128px)`; standard h2 `clamp(48px, 6.7vw, 96px)`; band `clamp(36px, 5vw, 72px)`; script beside a heading 52px.
- Highlight one word in a heading by wrapping it in a red span ("to the TECHIES", "that also drive results.").

Font link: `https://fonts.googleapis.com/css2?family=Anton&family=Kaushan+Script&family=DM+Sans:wght@400;500;700&display=swap`

## 4. Layout rhythm

- Container `.wrap`: `min(1240px, calc(100% - 80px))`, centered. Content grids are 12 columns, `gap: 40px`.
- Section padding 110px top and bottom (Solutions 100px, the tagline band 64px, hero 72px top / 64px bottom).
- Section order on the homepage: nav → hero (tan) → tagline band (red) → Techies (tan) → Solutions (brown) → Work (tan) → About (red) → Steps (brown) → Footer (red). Keep alternating on new pages; never two of the same color in a row.
- Two-column sections put the device (stamp, starburst) in a 4-col or 5-col column and the copy in the remaining 7–8 columns, `align-items: center`.
- Nav is fixed at the top, 88px tall, tan, no rule beneath it. Logo 44px tall (brown monogram); nav CTA is `.btn--red.btn--sm`. Footer logo 48px cream, left-aligned above the address.
- Breakpoints: 1000px (single column, 2-col work grid, nav text links hidden), 800px (icon strip 2×2, steps stack), 640px (1-col work grid).

## 5. Components

**Button** `.btn` + color variant. Pill, 52px tall, 26px side padding, and the signature inset dotted ring 5px in, drawn in the text color. Arrow icon 16px, stroke 2.6, round caps. One primary action per section. Brown on tan for hero, red for most sections, tan on brown/red. Never an outlined button; the "Explore our services" button is solid tan.

**Star** — the 24-box path below, filled, 18–44px. Small stars flank headings and sit in eyebrows. Never emoji.
```
M12 1.6l2.9 6.6 7.1.7-5.4 4.8 1.6 7.1L12 17.2l-6.2 3.6 1.6-7.1L2 8.9l7.1-.7z
```

**Star rule** — dashed line, star, dashed line (`.star-rule`). Used above and below the tagline band.

**Stamp (round seal)** — 300px SVG, viewBox 0 0 300 300, tilted −8°: outer circle r142 stroke 5; dotted circle r130 stroke 2 `dasharray 3 6`; inner circle r78 stroke 4; ring text on a circle of r97 in DM Sans 700 21px `letter-spacing 5` reading `SIMPLE • BEAUTIFUL • SECURE •`; the red bw monogram in the center at 112px wide. Source in `Main.dc.html` under the Techies section.

**Starburst** — 16-point burst (140 viewBox, points in `b16.txt`) or 20-point (180 viewBox, `b20.txt`), filled, with a dotted inner circle (`stroke-dasharray 2 4`) in the text color. Red bursts hold step numbers in Anton 52px; the brown burst holds "15+ / YEARS". Tilt −10° when decorative.

**Icon strip** `.icon-strip` — four columns, 64px stroke icons in tan, dotted rules top/bottom, solid rules between. Labels 12px caps.

**Work thumbnail** `.thumb-card` — 22px radius, 2px brown border, 3×3 grid at 280px rows, 24px gap.

**Retro decoder** `.retro-info` — a 24px brown-ringed "i" in Anton placed just outside the top-left of the drawn object. Every illustration is its own object: wrap it in `.retro-object.retro-object--{name}` and position its icon with a dedicated `.retro-info--{name}` rule in **percentages of the artwork box** (rolodex 15.7% / 7.9%, typewriter 13.5% / 11.5%), never shared pixel offsets, so the icon rides with the image at any width. Call `bellaworks_retro_info( $sentence, $name )`. Hover or focus shows a tan tooltip: 2px brown border, 12px radius, 1.5px dotted inset ring, small tail, DM Sans 13px, one plain sentence ("This is what used to be known as a Rolodex."). No heading, no default browser tooltip.

**Watermarks** `.wm` — faint texture in the section's foreground color at 6–20% opacity, placed with negative offsets so they crop at the edges: outlined star, dashed ring set, halftone dot patch (SVG pattern of r2.2 dots on a 10px grid masked by a radial gradient), the bw monogram, a starburst outline. One or two per section, never over the copy column, always `z-index:-1` inside an isolated section.

**Vertical label** — 11px label rotated with `writing-mode: vertical-rl` on the right edge of the hero: "Simple • Beautiful • Secure".

## 6. Illustration rules

- Style: 1930s rubber-hose / vintage print. Thick brown outlines, halftone shading, tan fills, red only for small mechanical accents. No people. Generated on Higgsfield with the mascot (`mascot-white-a.png`) as the style reference, then keyed to transparency.
- Every retro object gets a decoder icon and a one-line tooltip explaining what it is.
- Video assets: transparent WebM (VP9 alpha, `-g 6`, ~1120px) as the primary source, a tan-baked MP4 as the fallback, no `poster` attribute. Scrubbed by scroll, never autoplayed.

## 7. Motion

- Lenis smooth scroll feeding GSAP ScrollTrigger (`lenis.on('scroll', ScrollTrigger.update)`, Lenis driven by `gsap.ticker`).
- Hero: section pinned for 1000px starting 88px below the top (under the nav), `pinSpacing: true`, `scrub: 0.5`. "WE MAKE" exits left and "WEBSITES." exits right (`xPercent ±320`, `power2.in`, first 75% of the scroll); the eyebrow fades in the first 30%; "Simple." scales to 1.65 from its left edge and rises 150px over the full scroll; the video's `currentTime` follows progress (seek directly in `onUpdate`, guarded by `seeking`).
- Pinned sections need `z-index: 5` or later sections paint over them. The page root must be `display: block` (GSAP drops pin spacing inside flex containers).
- Buttons and tooltips transition in 180ms ease. No other micro-animations.

## 8. Assets

`logo-dark.svg` / `logo-cream.svg` (bw monogram, filled), `hero-rolodex-alpha.webm`, `hero-rolodex-tan.mp4`, `hero-poster-tan.jpg`, `work-*.jpg` (portfolio thumbs), `b16.txt` / `b20.txt` (starburst points), `mascot-white-a.png` (style reference only, not on the page).

## 9. Copy rules

Copy comes from the client verbatim. Never invent stats, testimonials, or headings. Highlight one word per heading in red; keep script lines short (2–5 words).

## 10. Inner pages (added with About Us)

- **Page hero** `.page-hero`: same anatomy as the homepage hero minus the animation. Eyebrow = red star + the page title as a label; H1 in Anton at `clamp(56px, 7.2vw, 104px)` with the second thought in red (`<strong>` in the ACF title becomes `.text-red`); lede copy max 640px; a retro illustration in the right column with its decoder icon; the vertical label on the right edge.
- **Retro object per page** (illustrated on Higgsfield with the mascot as style reference, keyed to transparency, palette PNG): Home = rolodex ("This is what used to be known as a Rolodex."), About = typewriter ("This is what used to be known as a typewriter."). Pick one object per page; keep the tooltip to one sentence in that pattern.
- **Two-column statement** `.approach` (red): H2 + copy left (cols 1–7), a dashed vertical rule and a Kaushan Script pull quote at 34px right (cols 8–12), star above the quote.
- **Team list** `.team`: rows separated by dashed brown rules; photo (4:3, 22px radius, 2px brown border, `grayscale(1) contrast(1.05)`) and Anton name in cols 1–4, bio paragraphs at 17px in cols 5–12.
- **Closing band** `.closer` (brown): star rule, the homepage tagline with the red highlight, and a large red Book A Call. Use it to end any inner page that has no CTA of its own.
- **Template pattern**: `page-{slug}.php` reads ACF with `get_field()`, guards every section with `if ( $value )`, and composes devices from `inc/template-tags.php`. Field groups live in `acf-json/`.

## 11. Forms (Gravity Forms)

The plugin's own stylesheets are switched off (`gform_disable_css` in `inc/theme.php`); `assets/sass/_forms.scss` styles every form on the site against Gravity Forms' stable classes, legacy `<ul><li>` and modern `<div>` markup alike.

- Fields: 54px tall, 2px brown border, 12px radius, tan fill, DM Sans 16px; focus turns the border red with an inset red ring. Textareas 180px, resizable. Selects get a brown chevron. On red/brown sections fields go transparent with tan borders.
- Labels: the site label style (12px, 700, .22em caps); sub-labels (First/Last) 11px sentence case; required marks red; descriptions 14px at 80%.
- Layout: a 12-column grid with 26/24px gaps; `gfield--width-half/third/quarter` and legacy `gf_left_half`-style classes span columns; name and address complex fields split into two columns from 600px.
- Submit: `gform_submit_button` is filtered into a real `<button>` carrying `.btn.btn--red.btn--lg`, so it inherits the pill and dotted ring. A plain `<input type=submit>` fallback is styled too.
- Validation: red 2px summary box, red labels and borders on errored fields, red 14px messages; the confirmation message is Anton in red.
- Page: `page-lets-do-this.php` puts the form in cols 1–8 with the stamp, address and phone/email in cols 9–12; hero is text only ("The start of something big!" with "big!" in script).
- **Peeking eyes**: every text field gets a small rubber-hose face (`.field-eyes`, injected by `custom.js`) hidden behind its top-right edge. On focus it rises with a little overshoot, pupils look down at the field, and it blinks every few seconds; it drops back on blur. Reduced-motion users get it without the animation. Keep it on forms only.
