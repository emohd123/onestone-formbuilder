# App walk-through video — 30s vertical

A 30-second walk-through of the **FormBuilder Android app**, built for Instagram
Reels, TikTok and Stories.

`onestone-app-walkthrough-1080x1920.mp4` — 1080×1920, 30fps, H.264 High,
silent AAC track, ~4.4 MB.

## Design constraints that drive the layout

The device is deliberately **near full-bleed** — 960px wide in a 1080px frame,
cropped off the bottom. A reel is watched at roughly 400px wide on a phone, so a
device inset in the frame shrinks the app UI past the point of legibility. At
this scale a 44px label in-app renders around 18px on a real screen, which reads
comfortably.

Motion is continuous rather than a sequence of fades:

- a **camera** wraps the device and pushes in or pulls back once per beat, with
  a slow handheld drift underneath so no frame is ever static
- screens **hard-cut** with a scale pop instead of crossfading
- the scan → built cut is hidden behind a **white flash**, so the paper form
  appears to become the digital one
- captions are **kinetic** — words stagger in individually
- **tap ripples** mark the moments a finger would hit the screen

Camera push-ins are capped so the device top never rises into the caption band.

## Beats

| Time | Beat | On screen |
| --- | --- | --- |
| 0.0–3.5 | Still typing these up? | Camera over a paper form, scan line, capture |
| 3.5–8.3 | AI rebuilds it in seconds. | Match cut to the built form, fields landing |
| 8.3–13.3 | Just describe what you need. | Prompt typed, AI writing the fields |
| 13.3–17.9 | Share by link or QR. | Share screen, push-in on a scannable QR |
| 17.9–22.7 | PDFs land on WhatsApp. | Chat thread with the branded PDF |
| 22.7–27.1 | Track it all live. | Counters running, chart growing, CSV export |
| 26.5–30.0 | Free on Android. | App icon, the real download QR, install link |

The end card carries the genuine `download-qr.svg` from
`public/scroll-world/assets/`, so it installs the actual APK when scanned.

## How it is made

The animation is deterministic: `video.html` exposes `window.render(t)` which
sets every element's state purely as a function of time. No CSS transitions or
`requestAnimationFrame` are involved, so a given `t` always produces an
identical frame and the render can be paused, resumed or re-run safely.

```bash
cd marketing/social/app-walkthrough
npm i playwright-core
pip install qrcode pillow imageio-ffmpeg

python3 buildvid.py    # inlines font, app icon and both QRs -> video.built.html
mkdir -p frames
node frames.js         # renders 900 PNG frames at 1080x1920 (~3.5 min)
./encode.sh            # encodes frames -> MP4
```

To change timing or copy, edit `video.html` — the beat windows live in the `B` array,
the screen cuts in `SCR` and the camera moves in `CAM` — then re-run `frames.js`
and `encode.sh`. `frames.js` skips frames that already exist, so delete `frames/`
when you change anything visual.

## Notes

- `appmark-light.png` is the app icon mark, cropped from
  `public/scroll-world/assets/brand-logo.png` and squared for use as a tile.
- The video is intentionally silent. On Reels and TikTok, adding trending audio
  inside the app reaches more people than a baked-in track, and the piece is
  designed to be understood with sound off.
- Nothing important sits in the bottom ~250px, which platform UI covers.
- The screens are designed recreations of the app flow, not literal screen
  captures. If you want captured footage, record the current app at 1080p or
  higher and it can be cut against these captions.

## Caption

See `caption.md`.
