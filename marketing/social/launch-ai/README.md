# Launch campaign — "Snap the paper. Get the form."

Social assets for advertising OneStone FormBuilder, built on the live brand
system used by the landing page (`resources/views/landing-page/scroll.blade.php`).

A six-slide carousel plus a matching story. One idea per slide, type sized to
stay readable at feed-thumbnail scale.

## Files

| File | Format | Use |
| --- | --- | --- |
| `carousel-01-hook.png` … `carousel-06-cta.png` | 1080×1350 (4:5) | Instagram / Facebook / LinkedIn carousel, in order |
| `carousel-story.png` | 1080×1920 (9:16) | Story, TikTok, WhatsApp status |
| `carousel.html` | — | Editable source for all seven frames |
| `build.py` | — | Inlines font, logos and QR into `carousel.built.html` |
| `render.js` | — | Screenshots each frame to PNG |
| `captions.md` | — | Per-platform caption copy and posting notes |

## Slide order

1. **Hook** — paper form → phone. The transformation, no explanation needed.
2. **AI prompt** — describe a form in one line, AI writes the fields.
3. **Share** — link, QR, embed. Carries a real scannable QR to `/register`.
4. **WhatsApp** — every submission arrives as a branded PDF.
5. **Dashboard** — live counts, charts, CSV export.
6. **CTA** — free plan, Pro pricing, link.

## Brand tokens used

- Gradient: `#E0608E → #9B45A6 → #3E93D4`
- Cream ground: `#F5EDE0` · ink `#22242C` · dark slab `#1B1C22`
- Type: Open Sans 300–800 (`public/scroll-world/assets/opensans.woff2`)
- Logos: `brand-logo-dark.png` on cream, `brand-logo.png` on dark

## Re-rendering

```bash
cd marketing/social/launch-ai
npm i playwright-core qrcode   # qrcode via pip: pip install qrcode
python3 build.py               # writes carousel.built.html
node render.js                 # writes the PNGs
```

`carousel.html` holds `__FONT__`, `__LOGO__`, `__LOGOD__` and `__QR__`
placeholders that `build.py` fills with base64 assets and a generated QR, so
the output PNGs need no network access.

Each slide's visual sits in a `.vis` wrapper and is auto-scaled to fit the
space left by the headline, so you can edit copy freely without the artwork
overflowing the frame.

## Note on the QR

`build.py` generates a genuine QR pointing at
`https://app.onestoneads.com/register`. If that URL changes, edit the
`add_data(...)` call and re-render — don't hand-edit the SVG.
