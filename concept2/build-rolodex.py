import re, math
def solve(A,b):
    n=len(A); M=[row[:]+[b[i]] for i,row in enumerate(A)]
    for c in range(n):
        p=max(range(c,n),key=lambda r:abs(M[r][c])); M[c],M[p]=M[p],M[c]
        for r in range(n):
            if r!=c and M[r][c]:
                f=M[r][c]/M[c][c]; M[r]=[a-f*b for a,b in zip(M[r],M[c])]
    return [M[i][n]/M[i][i] for i in range(n)]
def homography(src,dst):
    A=[];b=[]
    for (x,y),(X,Y) in zip(src,dst):
        A.append([x,y,1,0,0,0,-X*x,-X*y]); b.append(X)
        A.append([0,0,0,x,y,1,-Y*x,-Y*y]); b.append(Y)
    h=solve(A,b)
    return 'matrix3d(%.5f,%.5f,0,%.7f,%.5f,%.5f,0,%.7f,0,0,1,0,%.3f,%.3f,0,1)'%(h[0],h[3],h[6],h[1],h[4],h[7],h[2],h[5])
DISP=560; s=DISP/900.0
S=lambda p:(p[0]*s,p[1]*s)
HL=(214.5,339.5); HR=(546.5,403.0)
FBL=(120,520); FBR=(446,585)
dL=(FBL[0]-HL[0],FBL[1]-HL[1]); dR=(FBR[0]-HR[0],FBR[1]-HR[1])
bL=(-70,95); bR=(-62,105)
def quad(phi):
    r=math.radians(phi); c,sn=math.cos(r),math.sin(r)
    fl=(HL[0]+c*dL[0]+sn*bL[0], HL[1]+c*dL[1]+sn*bL[1])
    fr=(HR[0]+c*dR[0]+sn*bR[0], HR[1]+c*dR[1]+sn*bR[1])
    return [S(HL),S(HR),S(fr),S(fl)]
W,H=330,190
src=[(0,0),(W,0),(W,H),(0,H)]
M=lambda phi: homography(src,quad(phi))
B='#2b0b0a'; T='#efdec4'
def fill(x,y,w,h,r=2): return '<div style="position:absolute;left:%dpx;top:%dpx;width:%dpx;height:%dpx;background:%s;border-radius:%dpx;"></div>'%(x,y,w,h,B,r)
def box(x,y,w,h,r=3): return '<div style="position:absolute;left:%dpx;top:%dpx;width:%dpx;height:%dpx;border:2px solid %s;border-radius:%dpx;box-sizing:border-box;"></div>'%(x,y,w,h,B,r)
def line(x,y,w,h=3): return fill(x,y,w,h,2)
def lines(x,y,w,n,gap=6,h=3): return ''.join(line(x,y+i*gap,w-(10 if i==n-1 else 0),h) for i in range(n))
def chrome(): return fill(0,0,220,12,0)+''.join('<div style="position:absolute;left:%dpx;top:3px;width:6px;height:6px;border-radius:50%%;background:%s;"></div>'%(5+i*9,T) for i in range(3))+'<div style="position:absolute;left:40px;top:3px;width:120px;height:6px;border-radius:3px;background:%s;opacity:.6;"></div>'%T
def pill(x,y,w=34,h=9): return fill(x,y,w,h,5)
def nav(): return fill(6,18,18,7,2)+line(150,20,14)+line(170,20,14)+line(190,20,14)
W_=[]
W_.append(chrome()+nav()+line(6,34,90,7)+line(6,45,70,7)+lines(6,58,80,3)+pill(6,82)+box(112,32,102,64))
W_.append(chrome()+nav()+line(6,32,60,6)+''.join(box(6+i*54,42,48,34)+line(6+i*54,80,30) for i in range(4))+''.join(box(6+i*54,90,48,20) for i in range(4)))
W_.append(chrome()+nav()+line(6,32,120,7)+''.join(box(6,44+i*24,40,18)+lines(52,46+i*24,110,2,7) for i in range(3))+box(170,44,44,66))
W_.append(chrome()+nav()+box(6,32,100,48)+box(112,32,50,30)+box(168,32,46,30)+box(112,66,102,44)+box(6,84,48,26)+box(58,84,48,26))
W_.append(chrome()+nav()+line(6,32,80,7)+box(6,46,100,10,2)+box(6,60,100,10,2)+box(6,74,100,24,2)+pill(6,102,40)+box(120,32,94,66)+line(120,102,60))
W_.append(chrome()+nav()+line(70,30,80,7)+''.join(box(6+i*72,42,64,68)+line(14+i*72,50,30,5)+line(14+i*72,60,24,8)+lines(14+i*72,74,44,3,6)+pill(14+i*72,96,44,8) for i in range(3)))
W_.append(chrome()+fill(0,12,40,104,0)+''.join(line(6,22+i*10,28,4) for i in range(6))+line(50,20,50,6)+''.join(box(50+i*56,30,50,24) for i in range(3))+box(50,60,100,50)+''.join(fill(56+i*12,80+(i%3)*8,8,26-(i%3)*8,1) for i in range(7))+box(156,60,58,50))
W_.append(chrome()+nav()+line(60,30,100,9)+''.join(line(6,48+i*11,60)+line(150,48+i*11,20)+'<div style="position:absolute;left:70px;top:%dpx;width:76px;border-top:2px dotted %s;"></div>'%(49+i*11,B) for i in range(5))+box(6,104,208,8,4))
W_.append(chrome()+nav()+line(6,32,110,7)+lines(6,44,130,4)+''.join('<div style="position:absolute;left:%dpx;top:78px;width:26px;height:26px;border-radius:50%%;border:2px solid %s;box-sizing:border-box;"></div>'%(6+i*34,B)+line(6+i*34,108,24) for i in range(4))+box(150,32,64,44))
N=len(W_); STEP=1.2; CYC=N*STEP; slot=100.0/N
def K(pct,phi,op): return '%.2f%% { transform: %s; opacity: %d; }'%(pct,M(phi),op)
kf=[K(0,90,0),K(0.01,90,1)]
for f,phi in [(0.05,78),(0.10,62),(0.15,44),(0.20,26),(0.25,10),(0.30,-7),(0.34,3),(0.38,0)]: kf.append(K(slot*f,phi,1))
kf.append(K(slot*1.40,0,1)); kf.append(K(slot*1.42,0,0)); kf.append(K(100,0,0))
KEY='    @keyframes rolo-flip { '+' '.join(kf)+' }\n'
cards=''
for i,wf in enumerate(W_):
    cards+=('<div style="position:absolute;left:0;top:0;width:%dpx;height:%dpx;transform-origin:0 0;background:#f7ecd6;mix-blend-mode:multiply;'
            'animation: rolo-flip %.1fs linear infinite; animation-delay: %.1fs; animation-fill-mode: both; will-change: transform, opacity;">'
            '<div style="position:absolute;left:0;top:0;width:220px;height:116px;transform:translate(9px,40px) scale(1.42);transform-origin:0 0;">%s</div></div>')%(W,H,CYC,i*STEP,wf)
rolodex=('<div class="rolodex" style="position: relative; width: %dpx; height: %dpx;">'
         '<img src="rolodex.jpg" alt="Rolodex of websites" style="position:absolute;left:0;top:0;width:%dpx;height:%dpx;display:block;mix-blend-mode:multiply;">'%(DISP,DISP,DISP,DISP)
         + cards + '</div>')
for p,anchor,scale in [('Main.dc.html','    .wrap {',None),('Mobile.dc.html','    .foot a {',0.6)]:
    s_=open(p,encoding='utf-8').read()
    s_=re.sub(r'    @keyframes rolo-(slide|flip) \{[^\n]*\n','',s_)
    a=s_.index('<div class="rolodex"')
    if scale is None:
        e=s_.index('</div>\n    </div>\n    <div class="label hero-vert"',a)
    else:
        e=s_.index('</div>\n    <a href="#book" class="btn"',a)-len('</div>')
    s_=s_[:a]+rolodex+s_[e:]
    s_=s_.replace(anchor,KEY+anchor,1)
    open(p,'w',encoding='utf-8').write(s_); print(p,'ok',s_.count('rolo-flip'),s_.count('rolodex.jpg'),s_.count('class="rolodex"'))
