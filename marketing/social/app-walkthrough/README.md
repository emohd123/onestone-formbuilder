# App walk-through video — 35s vertical

A 35-second walk-through of the **FormBuilder Android app**, built for Instagram
Reels, TikTok and Stories. Every screen sits inside a persistent phone frame, so
it reads as a product demo rather than a slideshow.

`onestone-app-walkthrough-1080x1920.mp4` — 1080×1920, 30fps, H.264 High,
silent AAC track, ~2.7 MB.

## Beats

| Time | Beat | On screen |
| --- | --- | --- |
| 0.0–5.0 | The whole builder. On your phone. | App icon with the AI badge |
| 4.6–10.6 | Snap a paper form. | Camera view over a paper form → scan → fields built |
| 10.2–16.4 | Describe it. AI writes it. | Prompt typed, fields generated one by one |
| 16.0–21.8 | Share by link or QR. | Share screen with a scannable QR |
| 21.4–27.6 | PDFs land on WhatsApp. | Chat thread with the branded PDF |
| 27.2–31.6 | Track it all live. | Counters running, chart growing, CSV export |
| 31.2–35.0 | Get it free on Android. | App icon, the real download QR, install link |

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
node frames.js         # renders 1050 PNG frames at 1080x1920 (~4 min)
./encode.sh            # encodes frames -> MP4
```

To change timing or copy, edit `video.html` — the beat windows live in the `B`
array and the `S` map inside `render()` — then re-run `frames.js` and
`encode.sh`. `frames.js` skips frames that already exist, so delete `frames/`
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
