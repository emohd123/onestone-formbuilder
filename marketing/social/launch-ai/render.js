const { chromium } = require('playwright-core');
(async () => {
  const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium-1194/chrome-linux/chrome', args:['--no-sandbox','--font-render-hinting=none'] });
  const p = await b.newPage({ viewportSize:{width:1200,height:1200}, deviceScaleFactor:1 });
  await p.goto('file://' + __dirname + '/posts/design.built.html');
  await p.waitForTimeout(1200);
  for (const [id,name] of [['feed','onestone-post-feed-1080x1080.png'],['story','onestone-post-story-1080x1920.png']]) {
    await p.locator('#'+id).screenshot({ path: 'posts/'+name });
    console.log('saved', name);
  }
  await b.close();
})();
