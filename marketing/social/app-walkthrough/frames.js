const { chromium } = require('playwright-core');
const FPS = 30, DUR = 30.0, N = Math.round(FPS*DUR);
(async () => {
  const b = await chromium.launch({ executablePath:'/opt/pw-browsers/chromium-1194/chrome-linux/chrome',
    args:['--no-sandbox','--font-render-hinting=none','--disable-lcd-text'] });
  const p = await b.newPage({ viewport:{width:1080,height:1920}, deviceScaleFactor:1 });
  await p.goto('file://' + __dirname + '/posts/video.built.html');
  await p.waitForTimeout(1500);
  const fs=require('fs');
  const t0 = Date.now();
  for (let i=0;i<N;i++){
    const fp=`frames/f${String(i).padStart(4,'0')}.png`;
    if(fs.existsSync(fp) && fs.statSync(fp).size>0){continue;}
    await p.evaluate(t => window.render(t), i/FPS);
    await p.screenshot({ path:fp });
    if(i%150===0) console.log(i+'/'+N, ((Date.now()-t0)/1000).toFixed(0)+'s');
  }
  console.log('frames done', ((Date.now()-t0)/1000).toFixed(0)+'s');
  await b.close();
})();
