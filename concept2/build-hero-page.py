import re, time
# 1) artboards: rolodex block -> poster frame
s=open('Main.dc.html',encoding='utf-8').read()
if '<div class="rolodex"' in s:
    a=s.index('<div class="rolodex"'); e=s.index('</div>\n    </div>\n    <div class="label hero-vert"',a)
    s=s[:a]+'<img src="hero-poster-tan.jpg" alt="Rolodex of websites" style="width: 560px; height: 560px; display: block;">'+s[e:]
    s=re.sub(r'    @keyframes rolo-(slide|flip) \{[^\n]*\n','',s)
    open('Main.dc.html','w',encoding='utf-8').write(s)
m=open('Mobile.dc.html',encoding='utf-8').read()
if '<div class="rolodex"' in m:
    a=m.index('<div style="transform: scale(0.60); transform-origin: top center;">'); e=m.index('</div>\n    <a href="#book" class="btn"',a)
    m=m[:a]+'<img src="hero-poster-tan.jpg" alt="Rolodex of websites" style="width: 330px; height: 330px; display: block;">'+m[e:]
    m=m.replace('height: 330px; overflow: visible;','')
    m=re.sub(r'    @keyframes rolo-(slide|flip) \{[^\n]*\n','',m)
    open('Mobile.dc.html','w',encoding='utf-8').write(m)
print('artboards: poster in place', s.count('hero-poster.jpg'), m.count('hero-poster.jpg'))
# 2) hero.html prototype from Main
s=open('Main.dc.html',encoding='utf-8').read()
head=re.search(r'<helmet>(.*?)</helmet>',s,re.S).group(1)
body=s[s.index('</helmet>')+len('</helmet>'):s.index('</x-dc>')]
body=body.replace('min-height: 5720px;','').replace('background: #efdec4; display: flex; flex-direction: column;">','background: #efdec4; display: block;">',1)
# fixed nav: pin the bar to the top and leave a spacer so nothing jumps
body=body.replace('<div class="nav" style="background: #efdec4;">','<div class="nav" style="background: #efdec4; position: fixed; top: 0; left: 0; right: 0; z-index: 20;">',1)
body=body.replace('<!-- HERO -->','<div aria-hidden="true" style="height: 88px;"></div>\n  <!-- HERO -->',1)
# hero section id + video in place of the poster
body=body.replace('<!-- HERO -->\n  <div style="background: #efdec4;','<!-- HERO -->\n  <div id="hero" style="background: #efdec4;',1)
body=body.replace('<div style="display: flex; align-items: center; gap: 12px;">\n          <svg width="18"','<div class="hero-eyebrow" style="display: flex; align-items: center; gap: 12px;">\n          <svg width="18"',1)
body=re.sub(r'<img src="hero-poster-tan\.jpg" alt="Rolodex of websites" style="width: 560px; height: 560px; display: block;[^"]*">',
  '<video id="heroVideo" muted playsinline preload="auto" style="width: 560px; height: 560px; display: block;"><source src="hero-rolodex-alpha.webm?v=VIDEO_VERSION" type="video/webm; codecs=vp9"><source src="hero-rolodex-tan.mp4?v=VIDEO_VERSION" type="video/mp4"></video>', body)
# scroll hint under the hero button
body=body.replace('''        <div style="display: flex; align-items: center; gap: 26px;">
          <a href="#book" class="btn" style="background: #2b0b0a; color: #efdec4;">Book A Call''',
'''        <div style="display: flex; align-items: center; gap: 26px;">
          <a href="#book" class="btn" style="background: #2b0b0a; color: #efdec4;">Book A Call''')
scripts='''
<script src="vendor/gsap.min.js"></script>
<script src="vendor/ScrollTrigger.min.js"></script>
<script src="vendor/lenis.min.js"></script>
<script>
  gsap.registerPlugin(ScrollTrigger);
  const lenis = new Lenis({ lerp: 0.1, smoothWheel: true });
  lenis.on('scroll', ScrollTrigger.update);
  gsap.ticker.add((t) => lenis.raf(t * 1000));
  gsap.ticker.lagSmoothing(0);

  const video = document.getElementById('heroVideo');
  video.pause();
  let lastShown = -1;
  function showFrame(t) {
    if (video.readyState < 1) return;
    if (video.seeking) { pending = t; return; }
    if (Math.abs(t - lastShown) < 0.01) return;
    lastShown = t; video.currentTime = t;
  }
  let pending = null;
  video.addEventListener('seeked', () => { if (pending !== null) { const t = pending; pending = null; showFrame(t); } });

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: '#hero',
      start: 'top 88px',
      end: '+=1000',
      pin: true,
      pinSpacing: true,
      scrub: 0.5,
      anticipatePin: 1,
      onUpdate: (self) => { showFrame(self.progress * (video.duration || 5)); }
    }
  });
  tl.to('.hero-l1',     { xPercent: -320, ease: 'power2.in', duration: 0.75 }, 0)
    .to('.hero-l2',     { xPercent:  320, ease: 'power2.in', duration: 0.75 }, 0)
    .to('.hero-eyebrow',{ opacity: 0, ease: 'none', duration: 0.3 }, 0)
    .to('.hero-simple', { scale: 1.65, y: -150, transformOrigin: 'left center', ease: 'power1.inOut', duration: 1 }, 0);
  window.addEventListener('load', () => ScrollTrigger.refresh());
</script>
'''
html='<!doctype html>\n<html lang="en">\n<head>\n<meta charset="utf-8">\n<meta name="viewport" content="width=device-width, initial-scale=1">\n<title>Bellaworks — hero prototype</title>'+head+'<style>html.lenis, html.lenis body { height: auto; } .lenis.lenis-smooth { scroll-behavior: auto !important; } #hero { z-index: 5; } .hero-l1, .hero-l2, .hero-simple { will-change: transform; }</style>\n</head>\n<body>'+body+scripts+'</body>\n</html>\n'
html=html.replace('VIDEO_VERSION', str(int(time.time())))
open('hero.html','w',encoding='utf-8').write(html); print('hero.html written', len(html))
