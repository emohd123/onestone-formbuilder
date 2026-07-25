const { chromium } = require('playwright-core');
(async () => {
  const b = await chromium.launch({ executablePath:'/opt/pw-browsers/chromium-1194/chrome-linux/chrome', args:['--no-sandbox','--font-render-hinting=none'] });
  const p = await b.newPage({ viewportSize:{width:1200,height:1400}, deviceScaleFactor:1 });
  await p.goto('file://' + __dirname + '/posts/carousel.built.html');
  await p.waitForTimeout(1500);
  const names = ['01-hook','02-ai','03-share','04-whatsapp','05-dashboard','06-cta','story'];
  for (let i=0;i<7;i++){
    await p.locator('#s'+(i+1)).screenshot({ path:`posts/carousel-${names[i]}.png` });
  }
  console.log('done');
  await b.close();
})();
