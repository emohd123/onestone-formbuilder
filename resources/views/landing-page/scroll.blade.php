@verbatim
<!doctype html>
<html lang="en"><head><meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/><title>OneStone FormBuilder — Your future form designer</title><meta name="description" content="OneStone FormBuilder — build forms field by field with AI, share by link or QR code, deliver clean PDFs to WhatsApp or email, and track every response from your dashboard."/><link rel="icon" type="image/png" href="/scroll-world/assets/favicon.png"/></head><body><style>
  @font-face{
    font-family:'Open Sans';font-style:normal;font-weight:300 800;font-display:swap;
    src:url(/scroll-world/assets/opensans.woff2) format('woff2');
  }
  :root, .sw-root {
    --sw-bg:#F5EDE0;            /* must match the generated scenes' background */
    --sw-ink:#22242C;           /* site ink */
    --sw-ink-soft:#808191;      /* site grey */
    --sw-accent:#9B3E9E;        /* brand purple from the logo */
    --brand-grad:linear-gradient(120deg,#E0608E 0%,#9B45A6 46%,#3E93D4 100%);
    --sw-font-display:'Open Sans','Segoe UI',system-ui,sans-serif;
    --sw-font-body:'Open Sans','Segoe UI',system-ui,sans-serif;
  }
  html,body{margin:0;background:#F5EDE0;}
  .sw-brand img{height:48px;display:block;}
  .sw-brand__mark,.sw-brand__name{display:none;}
  /* ---- post-flight sections — DARK PREMIUM (scroll over the world after the flight) ---- */
  .os-after{position:relative;z-index:30;background:#1B1C22;font-family:var(--sw-font-body);color:#C9CAD4;}
  /* clean, quick cover into the dark sections — no long see-through that bleeds the video */
  .os-after::before{content:'';position:absolute;top:-64px;left:0;right:0;height:64px;background:linear-gradient(to bottom,rgba(27,28,34,0) 0%,#1B1C22 72%);pointer-events:none;}
  .os-after section{max-width:1080px;margin:0 auto;padding:clamp(56px,9vw,110px) clamp(20px,5vw,48px);}
  .os-eyebrow{background:var(--brand-grad);-webkit-background-clip:text;background-clip:text;color:transparent;font-weight:800;font-size:.82rem;letter-spacing:.14em;text-transform:uppercase;margin:0 0 10px;}
  .os-h2{font-family:var(--sw-font-display);font-weight:800;font-size:clamp(1.9rem,3.9vw,2.9rem);line-height:1.06;letter-spacing:-.022em;margin:0 0 12px;text-wrap:balance;background:var(--brand-grad);-webkit-background-clip:text;background-clip:text;color:transparent;}
  .os-sub{color:#9A9BA8;max-width:58ch;margin:0 0 38px;font-size:1.04rem;line-height:1.62;}
  .os-grid{display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));}
  .os-card{background:#26272F;border:1px solid #34353F;border-radius:16px;padding:22px;box-shadow:0 12px 30px rgba(0,0,0,.28);}
  .os-card .dot{width:34px;height:34px;border-radius:10px;background:rgba(122,110,240,.18);color:#9A8FF5;display:flex;align-items:center;justify-content:center;font-size:1rem;margin-bottom:12px;}
  .os-card h3{margin:0 0 6px;font-size:1.04rem;font-weight:700;color:#F0F0F4;}
  .os-card p{margin:0;color:#9A9BA8;font-size:.93rem;line-height:1.5;}
  .os-note{margin-top:22px;color:#9A9BA8;font-size:.9rem;}
  .os-note b{background:var(--brand-grad);-webkit-background-clip:text;background-clip:text;color:transparent;font-weight:700;}
  .os-plans{display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));align-items:stretch;}
  .os-plan{background:#26272F;border:1px solid #34353F;border-radius:18px;padding:26px;display:flex;flex-direction:column;box-shadow:0 12px 30px rgba(0,0,0,.28);}
  .os-plan.pop{border:2px solid #D6407E;box-shadow:0 18px 52px rgba(214,64,126,.28);position:relative;background:#292A34;}
  .os-plan .badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--brand-grad);color:#fff;font-size:.68rem;font-weight:700;letter-spacing:.1em;padding:4px 12px;border-radius:999px;box-shadow:0 6px 16px rgba(122,110,240,.4);}
  .os-plan h3{margin:0 0 2px;font-size:1.02rem;color:#F0F0F4;}
  .os-price{font-family:var(--sw-font-display);font-weight:800;font-size:2rem;margin:4px 0 2px;color:#F5F3FA;}
  .os-price span{font-size:.9rem;color:#9A9BA8;font-weight:600;}
  .os-per{color:#9A9BA8;font-size:.85rem;margin-bottom:14px;}
  .os-plan ul{list-style:none;margin:0 0 20px;padding:0;flex:1;}
  .os-plan li{padding:5px 0 5px 24px;position:relative;font-size:.92rem;color:#C9CAD4;}
  .os-plan li::before{content:'✓';position:absolute;left:0;color:#3ED6B5;font-weight:700;}
  .os-btn{display:block;text-align:center;text-decoration:none;font-weight:700;border-radius:12px;padding:12px 18px;font-size:.95rem;}
  .os-btn.primary{background:var(--brand-grad);color:#fff;box-shadow:0 10px 26px rgba(155,69,166,.38);}
  .os-btn.ghost{border:1.5px solid #56566A;color:#E6A8C8;}
  .os-footer{background:#131319;color:#8A8B97;}
  .os-footer .inner{max-width:1080px;margin:0 auto;padding:56px clamp(20px,5vw,48px) 40px;display:flex;flex-wrap:wrap;gap:32px;justify-content:space-between;align-items:flex-start;}
  .os-footer img{height:56px;display:block;margin-bottom:14px;}
  .os-footer p{max-width:44ch;font-size:.92rem;line-height:1.55;margin:0;}
  .os-footer .links{display:flex;gap:28px;}
  .os-footer a{color:#EDEDF2;text-decoration:none;font-size:.94rem;}
  .os-footer .copy{max-width:1080px;margin:0 auto;padding:0 clamp(20px,5vw,48px) 28px;font-size:.8rem;color:#565766;}


  /* extra sections: features / app / templates / faq / final */
  .os-grid .os-card{display:flex;flex-direction:column;}
  .os-list{list-style:none;margin:0 0 26px;padding:0;display:grid;gap:11px;}
  .os-list li{padding-left:26px;position:relative;color:#C9CAD4;font-size:.98rem;line-height:1.5;}
  .os-list li::before{content:'✦';position:absolute;left:0;color:#9A8FF5;}
  .os-app{display:grid;grid-template-columns:1.15fr .85fr;gap:44px;align-items:center;}
  .os-app .qr{background:#26272F;border:1px solid #34353F;border-radius:20px;padding:40px 30px;text-align:center;}
  .os-badge{display:inline-block;font-size:.78rem;color:#3ED6B5;border:1px solid #2f4f45;background:rgba(62,214,181,.08);padding:5px 13px;border-radius:999px;margin-bottom:16px;}
  .os-tpl-btn{margin-top:auto;}
  .os-tpl-thumb{height:132px;border-radius:14px;margin:-2px 0 16px;display:flex;align-items:center;justify-content:center;border:1px solid #34353F;position:relative;overflow:hidden;}
  .os-tpl-thumb::after{content:"";position:absolute;inset:0;background:radial-gradient(80% 70% at 50% 28%,rgba(255,255,255,.07),transparent 72%);pointer-events:none;}
  .os-tpl-thumb svg{width:76px;height:76px;position:relative;filter:drop-shadow(0 10px 18px rgba(0,0,0,.42));}
  .os-tpl-thumb.t-travel{background:linear-gradient(135deg,rgba(62,147,212,.30),rgba(38,39,47,.65));}
  .os-tpl-thumb.t-contact{background:linear-gradient(135deg,rgba(224,96,142,.30),rgba(38,39,47,.65));}
  .os-tpl-thumb.t-feedback{background:linear-gradient(135deg,rgba(155,69,166,.32),rgba(38,39,47,.65));}
  .os-faq details{background:#26272F;border:1px solid #34353F;border-radius:14px;padding:0 22px;margin-bottom:12px;}
  .os-faq summary{cursor:pointer;list-style:none;padding:19px 0;font-weight:700;color:#F0F0F4;display:flex;justify-content:space-between;align-items:center;gap:16px;}
  .os-faq summary::-webkit-details-marker{display:none;}
  .os-faq summary::after{content:'+';color:#9A8FF5;font-size:1.35rem;line-height:1;}
  .os-faq details[open] summary::after{content:'–';}
  .os-faq p{margin:0 0 18px;color:#9A9BA8;line-height:1.6;}
  .os-final{text-align:center;}
  .os-final .os-h2,.os-final .os-sub{margin-left:auto;margin-right:auto;}
  .os-final .os-sub{max-width:52ch;}
  .os-final .os-btn{display:inline-block;margin:0 auto;padding:15px 36px;}
  @media(max-width:760px){.os-app{grid-template-columns:1fr;}}

</style>
<div id="top"></div>
<div id="world"></div>
<div class="os-after">
  <section id="ai">
    <p class="os-eyebrow">✨ Now AI-Powered</p>
    <h2 class="os-h2">Let AI do the heavy lifting</h2>
    <p class="os-sub">FormBuilder is now AI end-to-end — build, scan, translate and understand your forms in seconds.</p>
    <div class="os-grid">
      <div class="os-card"><div class="dot">✍</div><h3>Generate from a prompt</h3><p>Describe the form you need and AI builds the fields for you in seconds.</p></div>
      <div class="os-card"><div class="dot">📄</div><h3>Scan any document</h3><p>Snap a photo or upload a PDF, Word or Excel — AI turns it into a digital form.</p></div>
      <div class="os-card"><div class="dot">🌐</div><h3>Translate instantly</h3><p>Convert a whole form into another language in one click — labels and options.</p></div>
      <div class="os-card"><div class="dot">💡</div><h3>AI response insights</h3><p>Get a plain-language summary and key takeaways from all your responses.</p></div>
    </div>
    <p class="os-note">Available on any <b>Pro plan</b>.</p>
  </section>

  <section id="features">
    <p class="os-eyebrow">Everything built in</p>
    <h2 class="os-h2">One builder. Every form.</h2>
    <p class="os-sub">Create, publish, deliver and analyze forms without juggling spreadsheets or scattered tools.</p>
    <div class="os-grid">
      <div class="os-card"><div class="dot">🧱</div><h3>Drag &amp; drop builder</h3><p>Build multi-step forms with field types for text, files, ratings, choices and signatures.</p></div>
      <div class="os-card"><div class="dot">💬</div><h3>WhatsApp delivery</h3><p>Forward completed forms and customer responses to WhatsApp when the work needs to move fast.</p></div>
      <div class="os-card"><div class="dot">📄</div><h3>PDF &amp; email</h3><p>Generate branded PDFs from submissions and send them by email for easy records.</p></div>
      <div class="os-card"><div class="dot">🔗</div><h3>QR &amp; share links</h3><p>Share forms with links, QR codes, or embeds and collect responses from anywhere.</p></div>
    </div>
  </section>
  <section id="download">
    <div class="os-app">
      <div>
        <p class="os-eyebrow">Get the app</p>
        <h2 class="os-h2">Build forms from your phone</h2>
        <span class="os-badge">● Android — available now · iOS coming soon</span>
        <ul class="os-list">
          <li>AI form builder — describe, scan a doc, translate, insights</li>
          <li>Drag-and-drop builder with 15+ field types</li>
          <li>Photos, e-signatures &amp; file uploads in the field</li>
          <li>PDF reports + WhatsApp / email delivery</li>
          <li>QR &amp; link sharing, real-time responses, offline-friendly</li>
        </ul>
        <a class="os-btn primary" style="display:inline-block" href="https://app.onestoneads.com/download">Download for Android</a>
      </div>
      <div class="qr"><img src="/scroll-world/assets/download-qr.svg" alt="Scan to install FormBuilder for Android" width="190" height="190" style="display:block;width:190px;height:190px;border-radius:12px;background:#fff;padding:10px"/><p style="color:#9A9BA8;margin:16px 0 0;font-size:.9rem;line-height:1.5">Scan or tap to install<br>Direct install (.apk)</p></div>
    </div>
  </section>
  <section id="templates">
    <p class="os-eyebrow">Ready to use</p>
    <h2 class="os-h2">Start from a template</h2>
    <p class="os-sub">Choose a ready-made form for bookings, contact requests, or feedback, then customize it in minutes.</p>
    <div class="os-grid">
      <div class="os-card"><div class="os-tpl-thumb" style="background:url(/scroll-world/assets/card-travel.webp?v=2) center/cover"></div><h3>Travel Booking</h3><p>Capture travel requirements from your customers in one quick form.</p><a class="os-btn ghost os-tpl-btn" href="https://app.onestoneads.com/register">Create travel form</a></div>
      <div class="os-card"><div class="os-tpl-thumb" style="background:url(/scroll-world/assets/card-contact.webp?v=2) center/cover"></div><h3>Contact Form</h3><p>A classic contact form to collect general inquiries from anyone.</p><a class="os-btn ghost os-tpl-btn" href="https://app.onestoneads.com/register">Create contact form</a></div>
      <div class="os-card"><div class="os-tpl-thumb" style="background:url(/scroll-world/assets/card-feedback.webp?v=2) center/cover"></div><h3>Customer Feedback</h3><p>Collect feedback about your customers' experience and ratings.</p><a class="os-btn ghost os-tpl-btn" href="https://app.onestoneads.com/register">Create feedback form</a></div>
    </div>
  </section>
<section id="pricing">
    <p class="os-eyebrow">Simple, flexible pricing</p>
    <h2 class="os-h2">Plans that scale with you</h2>
    <p class="os-sub">Transparent pricing with no hidden charges. Start free, then upgrade when your forms grow.</p>
    <div class="os-plans">
      <div class="os-plan"><h3>Free</h3><div class="os-price">$0 <span>/lifetime</span></div><div class="os-per">Lifetime access</div>
        <ul><li>1 form</li><li>Multi-step forms</li><li>Shareable survey links</li><li>Unlimited submissions</li></ul>
        <a class="os-btn ghost" href="https://app.onestoneads.com/register">Get started</a></div>
      <div class="os-plan pop"><div class="badge">MOST POPULAR</div><h3>Pro — Monthly</h3><div class="os-price">$9.99 <span>/mo</span></div><div class="os-per">1 month duration</div>
        <ul><li>AI: build, scan, translate &amp; insights</li><li>Unlimited forms</li><li>Dashboard widgets &amp; charts</li><li>Export submissions (CSV)</li><li>Custom branding &amp; priority support</li></ul>
        <a class="os-btn primary" href="https://app.onestoneads.com/register">Subscribe</a></div>
      <div class="os-plan"><h3>Pro — Yearly</h3><div class="os-price">$35 <span>/yr</span></div><div class="os-per">Save ~70% · 1 year</div>
        <ul><li>Everything in Pro Monthly</li><li>All AI features included</li><li>Custom branding</li><li>Priority support</li></ul>
        <a class="os-btn ghost" href="https://app.onestoneads.com/register">Subscribe</a></div>
    </div>
  </section>
  <section id="faq" class="os-faq">
    <p class="os-eyebrow">FAQ</p>
    <h2 class="os-h2">Questions, answered</h2>
    <details><summary>What is OneStone FormBuilder?</summary><p>A no-code form builder for creating forms, sharing them by link or QR code, delivering PDF responses, and tracking submissions.</p></details>
    <details><summary>Can I share responses on WhatsApp or as a PDF?</summary><p>Yes. Every submission can become a clean PDF that is easy to send by WhatsApp or email.</p></details>
    <details><summary>How do I share my form?</summary><p>Publish a shareable link, generate a QR code, or embed the form on your website.</p></details>
    <details><summary>Is there a free plan?</summary><p>Yes, the Free plan gives lifetime access to one form with unlimited submissions and real-time responses.</p></details>
    <details><summary>Do I need to install anything?</summary><p>No installs. OneStone runs entirely in your browser — just sign in and start building.</p></details>
  </section>
  <section id="get-started" class="os-final">
    <h2 class="os-h2">Build your next form with confidence.</h2>
    <p class="os-sub">Sign up with Google, choose a template or start from scratch, and publish your first form in minutes.</p>
    <a class="os-btn primary" href="https://app.onestoneads.com/register">Build your first form free</a>
  </section>
  <div class="os-footer">
    <div class="inner">
      <div><img src="/scroll-world/assets/brand-logo.png" alt="OneStone FormBuilder"/><p>Create forms, collect responses, share PDFs, and keep customer data organized in one easy FormBuilder.</p></div>
      <div class="links"><a href="https://onestoneads.com">About us</a><a href="https://onestoneads.com">Contact</a><a href="https://app.onestoneads.com">Support</a></div>
    </div>
    <div class="copy">© OneStone · FormBuilder — your future form designer.</div>
  </div>
</div>
<script src="/scroll-world/scrub-engine.js"></script>
<script>
mountScrollWorld(document.getElementById('world'), {"brand":{"name":"OneStone FormBuilder","href":"#top"},"cta":{"label":"Start free","href":"https://app.onestoneads.com/register"},"hint":"scroll to fly in","diveScroll":1.9,"connScroll":0.8,"sections":[{"id":"build","label":"Build","still":"/scroll-world/assets/poster1.webp","clip":"/scroll-world/assets/vid/hdloop1.mp4","accent":"#3E93D4","scroll":2.1,"linger":0.35,"eyebrow":"✨ NOW AI-POWERED","title":"Your future form designer.","body":"Describe it, snap a photo of a paper form, or drag & drop — AI builds your form in seconds.","tags":["AI builder","Drag & drop","15+ field types"]},{"id":"collect","label":"Share","still":"/scroll-world/assets/poster2.webp","clip":"/scroll-world/assets/vid/hdloop2.mp4","accent":"#D6407E","scroll":2.1,"linger":0.35,"eyebrow":"SHARE ANYWHERE","title":"A link, a QR code, or embed.","body":"Publish forms anywhere your customers are — filled in seconds on any device, no setup.","tags":["Share link","QR code","Embed"]},{"id":"convert","label":"Track","still":"/scroll-world/assets/poster3.webp","clip":"/scroll-world/assets/vid/dive3.mp4","accent":"#9B3E9E","scroll":2.2,"linger":0.35,"eyebrow":"DELIVER & ANALYZE","title":"Clean PDFs, straight to WhatsApp.","body":"Every submission becomes a branded PDF on WhatsApp or email — tracked live on your dashboard with charts and CSV export.","tags":["WhatsApp","Branded PDF","Live dashboard"],"cta":{"primary":{"label":"Start free","href":"https://app.onestoneads.com/register"},"secondary":{"label":"Browse templates","href":"https://app.onestoneads.com/"}}}],"connectors":["/scroll-world/assets/vid/conn1.mp4","/scroll-world/assets/vid/conn2.mp4"]});
// Swap the generic brand mark for the real FormBuilder logo,
// and flip logo/topbar text to light once the dark sections reach the top bar.
(function(){
  var b = document.querySelector('.sw-brand');
  if (!b) return;
  var DARK = "/scroll-world/assets/brand-logo-dark.png", WHITE = "/scroll-world/assets/brand-logo.png";
  var img = document.createElement('img');
  img.src = DARK; img.alt = 'OneStone FormBuilder';
  b.insertBefore(img, b.firstChild);
  var after = document.querySelector('.os-after');
  var topbar = document.querySelector('.sw-topbar');
  if (!after || !topbar) return;
  var isDark = false;
  function sync(){
    var dark = after.getBoundingClientRect().top < 72;
    if (dark === isDark) return;
    isDark = dark;
    img.src = dark ? WHITE : DARK;
    topbar.style.setProperty('--sw-ink', dark ? '#F0F0F4' : '#22242C');
  }
  window.addEventListener('scroll', sync, { passive: true });
  sync();
})();
// Add a "Sign in" link next to the "Start free" CTA in the top bar. Group the
// two on the right so the centered nav stays put. Colour uses --sw-ink so it
// flips light/dark with the top bar just like the logo above.
(function(){
  var cta = document.querySelector('.sw-topcta');
  if (!cta) return;
  var grp = document.createElement('div');
  grp.style.cssText = 'display:flex;align-items:center;gap:18px;';
  var si = document.createElement('a');
  si.href = 'https://app.onestoneads.com/login';
  si.textContent = 'Sign in';
  si.style.cssText = 'color:var(--sw-ink);text-decoration:none;font-weight:600;font-size:.9rem;white-space:nowrap;transition:opacity .2s;';
  si.addEventListener('mouseenter', function(){ si.style.opacity = '.7'; });
  si.addEventListener('mouseleave', function(){ si.style.opacity = '1'; });
  cta.parentNode.insertBefore(grp, cta);
  grp.appendChild(si);
  grp.appendChild(cta);
})();
// Typography polish + always-vivid top CTA — injected AFTER the engine CSS so it wins.
(function(){
  var ov = document.createElement('style');
  ov.textContent = ''
    + '.sw-root .sw-topcta{background:var(--brand-grad);box-shadow:0 8px 22px rgba(155,69,166,.34);}'
    // legibility scrim: a soft, feathered cream wash behind the copy so text stays readable
    // over the busy/moving diorama — matches the scene bg so it blends invisibly.
    // Strengthen the engine's left scrim panel so copy is always readable over the busy scene.
    + '.sw-root .sw-copylayer::before{width:min(70vw,940px)!important;'
    +   'background:linear-gradient(90deg,var(--sw-bg) 0%,color-mix(in srgb,var(--sw-bg) 94%,transparent) 34%,color-mix(in srgb,var(--sw-bg) 66%,transparent) 60%,transparent 100%)!important;}'
    // The engine writes an inline transform each frame, which clobbers its own
    // translateY(-50%) centering — with our taller copy the title fell off-screen.
    // Anchor the copy to the bottom-left of the fixed copy layer so the whole block
    // stays in view AND clears the top-bar logo. Must be position:absolute (not
    // relative) — relative offsets `bottom` up from the static top, which rode the
    // title up under the brand logo; absolute anchors it to the layer's bottom.
    + '.sw-root .sw-copy{position:absolute;top:auto!important;bottom:clamp(84px,15vh,150px)!important;'
    +   'left:clamp(20px,5vw,64px);width:min(44vw,520px);}'
    + '.sw-root .sw-copy::before{content:"";position:absolute;z-index:-1;inset:-38px -110px -38px -80px;'
    +   'background:radial-gradient(130% 125% at 22% 50%, color-mix(in srgb,var(--sw-bg) 97%,transparent) 0%, color-mix(in srgb,var(--sw-bg) 82%,transparent) 44%, transparent 74%);'
    +   'filter:blur(4px);pointer-events:none;}'
    + '.sw-root .sw-copy__title{font-weight:800;letter-spacing:-.022em;line-height:1.01;'
    +   'text-shadow:0 2px 30px var(--sw-bg),0 1px 2px color-mix(in srgb,var(--sw-bg) 85%,transparent);}'
    + '.sw-root .sw-copy__eyebrow{letter-spacing:.18em;font-weight:800;}'
    + '.sw-root .sw-copy__body{line-height:1.62;max-width:42ch;font-weight:500;'
    +   'color:color-mix(in srgb,var(--sw-ink) 90%,#000);text-shadow:0 1px 14px var(--sw-bg);}'
    + '.sw-root .sw-copy__num{letter-spacing:.2em;}'
    + '.sw-root .sw-nav__item{font-weight:600;}';
  document.head.appendChild(ov);
})();
</script></body></html>
@endverbatim
