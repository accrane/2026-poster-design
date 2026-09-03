# Bellaworks 2026 homepage — color palette

Three colors, taken from the retro poster reference. Use these exact values everywhere; no other colors are used in the concept.

| Name  | Hex       | RGB            | Used for |
|-------|-----------|----------------|----------|
| Brown | `#2b0b0a` | 43, 11, 10     | Darkest color. Body and headline text on tan, the Solutions and Steps section backgrounds, the stamp linework, the "15+ years" starburst, dark buttons, the mascot linework. |
| Red   | `#df0118` | 223, 1, 24     | Accent. Script headlines ("Simple.", "(We Got You Covered)", "Get Started in"), highlighted words ("techies", "that also drive results."), the Tagline, About and Footer section backgrounds, red buttons, the step starbursts, the speech bubble, the small stars. |
| Tan   | `#efdec4` | 239, 222, 196  | Page background and Hero, Techies and Work section backgrounds. Text and icons on brown or red. Cream buttons. |

## Derived values

- Dashed dividers and icon-strip rules on brown or red: tan at reduced opacity, `rgba(239,222,196,0.35)` for the icon strip and `rgba(239,222,196,0.55)` for the star dividers and footer rule.
- Link hover on tan: `#b20013` (red darkened one step).
- Dotted ring inside the starbursts and inside the buttons: the badge's own text color, tan on brown/red bursts, `currentColor` on buttons.

## Type

- Display: Anton (fallback Arial Narrow / Impact), uppercase, line-height 0.9
- Script: Kaushan Script (fallback Brush Script MT)
- Body and labels: DM Sans 400 / 500 / 700

## Where the palette lives

- `Main.dc.html` and `Mobile.dc.html` use the hex values inline.
- `logo-dark.svg` is the monogram filled brown, `logo-cream.svg` filled tan.
