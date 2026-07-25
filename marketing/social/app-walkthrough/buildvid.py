import base64, qrcode, re
enc=lambda p: base64.b64encode(open(p,'rb').read()).decode()
A='/home/user/onestone-formbuilder/public/scroll-world/assets/'
q=qrcode.QRCode(error_correction=qrcode.constants.ERROR_CORRECT_M,border=1)
q.add_data('https://app.onestoneads.com/register'); q.make(fit=True)
m=q.get_matrix(); n=len(m)
rects=''.join(f'<rect x="{x}" y="{y}" width="1.02" height="1.02" rx="0.2" fill="#22242C"/>' for y,row in enumerate(m) for x,v in enumerate(row) if v)
svg=f'<svg viewBox="0 0 {n} {n}" xmlns="http://www.w3.org/2000/svg">{rects}</svg>'
dl=open(A+'download-qr.svg').read()
dl=re.sub(r'<\?xml[^>]*\?>','',dl).replace('width="220" height="220"','width="250" height="250"')
h=open('posts/video.html').read()
h=(h.replace('__FONT__',enc(A+'opensans.woff2'))
    .replace('__MARK__',enc('posts/appmark-light.png'))
    .replace('__QR__',svg).replace('__DLQR__',dl))
open('posts/video.built.html','w').write(h)
print('built', len(h))
