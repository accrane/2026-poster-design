import re
STAR='M12 1.6l2.9 6.6 7.1.7-5.4 4.8 1.6 7.1L12 17.2l-6.2 3.6 1.6-7.1L2 8.9l7.1-.7z'
B16=open('b16.txt').read().strip()
LOGO=re.search(r'<path[^>]*\sd="([^"]+)"',open('logo-dark.svg').read()).group(1)
def wm(svg_inner,vb,style):
    return '<svg class="wm" aria-hidden="true" viewBox="%s" style="position: absolute; pointer-events: none; z-index: -1; %s">%s</svg>'%(vb,style,svg_inner)
def star(color,op,style): return wm('<path d="%s" fill="none" stroke="%s" stroke-width="0.55" stroke-linejoin="round"></path>'%(STAR,color),'0 0 24 24','opacity: %s; %s'%(op,style))
def rings(color,op,style): return wm('<circle cx="100" cy="100" r="94" fill="none" stroke="%s" stroke-width="1.5" stroke-dasharray="2 5"></circle><circle cx="100" cy="100" r="76" fill="none" stroke="%s" stroke-width="3"></circle><circle cx="100" cy="100" r="46" fill="none" stroke="%s" stroke-width="1.5" stroke-dasharray="2 5"></circle>'%(color,color,color),'0 0 200 200','opacity: %s; %s'%(op,style))
def burst(color,op,style): return wm('<polygon points="%s" fill="none" stroke="%s" stroke-width="1.6" stroke-linejoin="round"></polygon><circle cx="70" cy="70" r="52" fill="none" stroke="%s" stroke-width="1.2" stroke-dasharray="2 4"></circle>'%(B16,color,color),'0 0 140 140','opacity: %s; %s'%(op,style))
def mono(color,op,style): return wm('<path d="%s" fill="%s"></path>'%(LOGO,color),'0 0 1024 627','opacity: %s; %s'%(op,style))
_h=[0]
def halftone(color,op,style):
    _h[0]+=1; i=_h[0]
    inner=('<defs><pattern id="hp%d" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="2.2" fill="%s"></circle></pattern>'
           '<radialGradient id="hg%d" cx="50%%" cy="50%%" r="50%%"><stop offset="0" stop-color="#fff"></stop><stop offset="1" stop-color="#000"></stop></radialGradient>'
           '<mask id="hm%d"><rect width="200" height="200" fill="url(#hg%d)"></rect></mask></defs>'
           '<rect width="200" height="200" fill="url(#hp%d)" mask="url(#hm%d)"></rect>')%(i,color,i,i,i,i,i)
    return wm(inner,'0 0 200 200','opacity: %s; %s'%(op,style))
TAN='#efdec4'; BR='#2b0b0a'
def plan(mobile):
    k=0.6 if mobile else 1.0
    px=lambda v:'%dpx'%int(v*k)
    return {
     'HERO':    halftone(BR,0.12,'left: %s; bottom: %s; width: %s; height: %s;'%(px(-120),px(-140),px(460),px(460))),
     'TAGLINE BAND': star(TAN,0.16,'left: %s; top: %s; width: %s; height: %s; transform: rotate(-14deg);'%(px(-150),px(-150),px(560),px(560)))+star(TAN,0.12,'right: %s; bottom: %s; width: %s; height: %s; transform: rotate(18deg);'%(px(-90),px(-110),px(300),px(300))),
     'TECHIES': rings(BR,0.10,'right: %s; top: %s; width: %s; height: %s;'%(px(-160),px(-120),px(620),px(620))),
     'SOLUTIONS': halftone(TAN,0.20,'right: %s; top: %s; width: %s; height: %s;'%(px(-160),px(-160),px(640),px(640))),
     'WORK':    mono(BR,0.06,'right: %s; top: %s; width: %s; height: %s; transform: rotate(-8deg);'%(px(-140),px(40),px(760),px(465))),
     'ABOUT':   burst(TAN,0.16,'right: %s; bottom: %s; width: %s; height: %s; transform: rotate(-10deg);'%(px(-120),px(-160),px(520),px(520))),
     'STEPS':   rings(TAN,0.08,'left: 50%%; top: %s; width: %s; height: %s; margin-left: %s;'%(px(-40),px(900),px(900),px(-450)))+halftone(TAN,0.14,'left: %s; bottom: %s; width: %s; height: %s;'%(px(-180),px(-180),px(520),px(520))),
     'FOOTER':  halftone(TAN,0.16,'right: %s; bottom: %s; width: %s; height: %s;'%(px(-140),px(-160),px(480),px(480))),
    }
for p,mobile in [('Main.dc.html',False),('Mobile.dc.html',True)]:
    s=open(p,encoding='utf-8').read()
    s=re.sub(r'<svg class="wm"[^>]*>.*?</svg>','',s,flags=re.S)  # idempotent
    n=0
    for name,svg in plan(mobile).items():
        m=re.search(r'(<!-- %s -->\n\s*<div[^>]*style=")([^"]*)(")'%re.escape(name),s)
        if not m: print('missing',name,p); continue
        st=m.group(2)
        for prop in ['position: relative;','overflow: hidden;','isolation: isolate;']:
            if prop not in st: st=st.rstrip()+' '+prop
        s=s[:m.start(2)]+st+s[m.end(2):]
        # insert after the opening tag
        m2=re.search(r'<!-- %s -->\n\s*<div[^>]*>'%re.escape(name),s)
        s=s[:m2.end()]+svg+s[m2.end():]; n+=1
    open(p,'w',encoding='utf-8').write(s); print(p,'watermarks',n)
