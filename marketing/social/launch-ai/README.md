# Launch campaign — "AI builds the form"

Social assets for advertising OneStone FormBuilder, built on the live brand
system used by the landing page (`resources/views/landing-page/scroll.blade.php`).

## Files

| File | Use |
| --- | --- |
| `onestone-post-feed-1080x1080.png` | Instagram / Facebook / LinkedIn feed post (1:1) |
| `onestone-post-story-1080x1920.png` | Instagram & Facebook story, TikTok, WhatsApp status (9:16) |
| `design.html` | Editable source for both frames |
| `render.js` | Re-renders the PNGs from `design.html` |

## Brand tokens used

- Gradient: `#E0608E → #9B45A6 → #3E93D4`
- Surface: `#1B1C22`, cards `#26272F`, borders `#34353F`
- Success accent: `#3ED6B5`
- Type: Open Sans 300–800 (`public/scroll-world/assets/opensans.woff2`)
- Logo: `public/scroll-world/assets/brand-logo.png` (light lockup, for dark backgrounds)

## Re-rendering

`design.html` contains `__FONT__` and `__LOGO__` placeholders that are replaced
with base64 of the font and logo before rendering, so the output PNGs need no
network access.

```bash
cd marketing/social/launch-ai
npm i playwright-core
python3 - <<'PY'
import base64
h = open('design.html').read()
enc = lambda p: base64.b64encode(open(p,'rb').read()).decode()
h = h.replace('__FONT__', enc('../../../public/scroll-world/assets/opensans.woff2'))
h = h.replace('__LOGO__', enc('../../../public/scroll-world/assets/brand-logo.png'))
open('design.built.html','w').write(h)
PY
node render.js
```

Edit copy directly in `design.html` (the two `.frame` blocks) and re-render to
produce campaign variants.

## Caption copy

See `captions.md`.
