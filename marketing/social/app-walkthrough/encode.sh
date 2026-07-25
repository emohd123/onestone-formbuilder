#!/usr/bin/env bash
set -e
FF=$(python3 -c "import imageio_ffmpeg;print(imageio_ffmpeg.get_ffmpeg_exe())")
OUT=posts/onestone-app-walkthrough-1080x1920.mp4
"$FF" -y -hide_banner -loglevel error \
  -framerate 30 -i frames/f%04d.png \
  -f lavfi -i anullsrc=channel_layout=stereo:sample_rate=44100 \
  -c:v libx264 -profile:v high -level 4.1 -pix_fmt yuv420p -crf 19 -preset slow \
  -c:a aac -b:a 128k -shortest -movflags +faststart "$OUT"
ls -la "$OUT"
"$FF" -hide_banner -i "$OUT" 2>&1 | grep -E "Duration|Stream"
