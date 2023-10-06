let canvas = document.getElementById("c");
let canvas2 = document.getElementById("c2");
let ctx = canvas.getContext("2d");
let ctx2=canvas2.getContext("2d");

let inputnumber,button,ask1,ask2,bscoretext,rscoretext,whowin,again,goal,bskill,rskill,bcdtime,rcdtime,skill;
let bscore=0,rscore=0;
let win;
let begingame=false;
let nwidth,nheight,ntop,nleft,bw,bh,bt,bl,a1l,aw,a2l,ah,at,st,sw,sh,bsl,rsl;
let wint,winl,winh,winw,againt,againl,againh,againw;
let ballin=false;
let oldh=window.innerHeight,oldw=window.innerWidth;
let over=false;
let rcd=10,bcd=10,bpercd=20,rpercd=20;
let ronskill=false,bonskill=false;
let bignore=-1,rignore=-1;
window.onload=function(){
  document.documentElement.style.overflowY="hidden";
  document.documentElement.style.overflowX="hidden";
  inputnumber=document.getElementById("in");
  button=document.getElementById("button");
  ask1=document.getElementById("ask");
  ask2=document.getElementById("ask2");
  bscoretext=document.getElementById("b");
  rscoretext=document.getElementById("r");
  goal=document.getElementById("goal");
  whowin=document.getElementById("whowin");
  again=document.getElementById("again");
  bskill=document.getElementById("bskill");
  rskill=document.getElementById("rskill");
  bcdtime=document.getElementById("bcd");
  rcdtime=document.getElementById("rcd");
  skill=document.getElementById("skill");

  button.onclick=function(){
    win=inputnumber.value;
    begingame=true;
    inputnumber.style.visibility=button.style.visibility=ask1.style.visibility=ask2.style.visibility="hidden";
    bscoretext.style.visibility=rscoretext.style.visibility=bskill.style.visibility=rskill.style.visibility=rcdtime.style.visibility=bcdtime.style.visibility="visible";
    sizechange();

  }
  resizediv();
  sizechange();

}
window.onresize=function(){
  let oldch=courth,oldcw=courtw;
  sizechange();
  ballx=window.innerWidth/2+(ballx-oldw/2)/oldcw*courtw;
  bally=window.innerHeight/2+(bally-oldh/2)/oldch*courth;
  oldh=window.innerHeight;
  oldw=window.innerWidth;
  resizediv();
}

let finish=true;
let rtime=0,btime=0,t=6;
let courth;
let courtw;
let blueleft,blueright,db,redleft,redright,dr;
let positionx=[],positiony=[];
let b1u=false;
let b2u=false;
let b3u=false;
let r1u=false;
let r2u=false;
let r3u=false;
let b1d=false;
let b2d=false;
let b3d=false;
let r1d=false;
let r2d=false;
let r3d=false;
let bkl=false;
let bkr=false;
let rkl=false;
let rkr=false;
let b1=0;
let b2=0;
let b3=0;
let r1=0;
let r2=0;
let r3=0;
let speed=10;

let ballx=window.innerWidth/2;
let bally=window.innerHeight/2;
let ballsize;
let xroll=0,yroll=1;
let addballspeed=1.2;

function sizechange(){
canvas.height=canvas2.height=window.innerHeight;
canvas.width=canvas2.width=window.innerWidth;
if(!begingame||over){
  ctx.beginPath()
  ctx.strokeStyle="#9999CC";
  ctx.fillStyle="#9999CC";
  ctx.rect(0,0,window.innerWidth/2,window.innerHeight);
  ctx.fill()
  ctx.stroke()
  ctx.beginPath()
  ctx.strokeStyle="#B87070";
  ctx.fillStyle="#B87070";
  ctx.rect(window.innerWidth/2,0,window.innerWidth/2,window.innerHeight);
  ctx.fill()
  ctx.stroke()
  ctx.beginPath()
}
if((window.innerWidth-100)*0.5>=window.innerHeight-100){
courth=window.innerHeight-100;
courtw=(window.innerHeight-100)/0.5;
}else{
courth=(window.innerWidth-100)*0.5;
courtw=window.innerWidth-100;
}


ballsize=courth/20;
blueleft=(window.innerWidth-courtw)/2+courth/5;
blueright=window.innerWidth/2-courth/6;
db=(blueright-blueleft)/2;
redright=(window.innerWidth-courtw)/2+courtw-courth/5;
redleft=window.innerWidth/2+courth/6;
dr=(redright-redleft)/2;
rskill.style.left=rcdtime.style.left=(redright+courth/20).toString()+'px';
bskill.style.left=bcdtime.style.left=(blueleft-courth*3/20).toString()+'px';
rskill.style.top=rcdtime.style.top=(window.innerHeight/2-courth/2+courth/20).toString()+'px';
bskill.style.top=bcdtime.style.top=(window.innerHeight/2-courth/2+courth/20).toString()+'px';
bskill.style.width=bskill.style.height=rskill.style.width=rskill.style.height=rcdtime.style.height=rcdtime.style.width=bcdtime.style.height=bcdtime.style.width=(courth/10).toString()+'px';
rcdtime.style.fontSize=(courth/10*0.8).toString()+'px';
bcdtime.style.fontSize=(courth/10*0.8).toString()+'px';

skill.style.fontSize=(courth/10*0.8).toString()+'px';
skill.style.top=(window.innerHeight/2-courth/2).toString()+'px';
skill.style.left=(window.innerWidth/2-courth*3/10).toString()+'px';
skill.style.height=(courth/10).toString()+'px';
skill.style.width=(courth*6/10).toString()+'px';

st=(window.innerHeight-courth)/2+courth/2-courth/5/Math.pow(Math.round(Math.pow(win,0.1)+0.5)*Math.round(Math.pow(win,0.1)+0.5)+1,0.5)/2;
sh=courth/5/Math.pow(Math.round(Math.pow(win,0.1)+0.5)*Math.round(Math.pow(win,0.1)+0.5)+1,0.5);
sw=sh*Math.round(Math.pow(win,0.1)+0.5);
bsl=blueleft;
rsl=redright-sw;
bscoretext.style.color='#FFFFFF';
bscoretext.style.top=st.toString()+'px';
bscoretext.style.left=bsl.toString()+'px';
bscoretext.style.width=sw.toString()+'px';
bscoretext.style.height=sh.toString()+'px';
bscoretext.style.fontSize=sh.toString()+'px';
rscoretext.style.top=st.toString()+'px';
rscoretext.style.left=rsl.toString()+'px';
rscoretext.style.width=sw.toString()+'px';
rscoretext.style.height=sh.toString()+'px';
rscoretext.style.fontSize=sh.toString()+'px';
rscoretext.style.color='#FFFFFF';

goal.style.top=(window.innerHeight/2-courth/30).toString()+"px";
goal.style.left=(window.innerWidth/2-courth/6).toString()+"px";
goal.style.height=(courth/15).toString()+"px";
goal.style.width=(courth/3).toString()+"px";
goal.style.fontSize=(courth/15).toString()+"px";


winh=courth/3;
winw=winh*6;
wint=window.innerHeight/2-3*winh/4;
winl=window.innerWidth/2-winw/2;
whowin.style.top=wint.toString()+'px';
whowin.style.left=winl.toString()+'px';
whowin.style.height=winh.toString()+'px';
whowin.style.width=winw.toString()+'px';
whowin.style.fontSize=(winh*0.8).toString()+'px';
againh=winh/2;
againw=againh*6;
againl=window.innerWidth/2-againw/2;
againt=window.innerHeight/2+againh/2;
again.style.top=againt.toString()+'px';
again.style.left=againl.toString()+'px';
again.style.height=againh.toString()+'px';
again.style.width=againw.toString()+'px';
again.style.fontSize=(againh*0.5).toString()+'px';
}
document.onkeydown=function(e){
  var c=e||event; 
  if(!ballin&&begingame){
    if(c.keyCode==81){//藍一往上
    b1u=true;
  }
  if(c.keyCode==65){//藍一往下
    b1d=true;
  }
  if(c.keyCode==87){//藍二往上
    b2u=true;
  }
  if(c.keyCode==83){//藍二往下
    b2d=true;
  }
  if(c.keyCode==69){//藍三往上
    b3u=true;
  }
  if(c.keyCode==68){//藍三往下
    b3d=true;
  }
  if(c.keyCode==103){//紅一往上
    r1u=true;
  }
  if(c.keyCode==100){//紅一往下
    r1d=true;
  }
  if(c.keyCode==104){//紅二往上
    r2u=true;
  }
  if(c.keyCode==101){//紅二往下
    r2d=true;
  }
  if(c.keyCode==105){//紅三往上
    r3u=true;
  }
  if(c.keyCode==102){//紅三往下
    r3d=true;
  }
  if(c.keyCode==90){//藍左踢
    if(btime==0||bkr){

      bluekick(-1);
      bkr=false;
      bkl=true;
      btime=t;
    }
  }
  if(c.keyCode==67){//藍右踢
    if(btime==0||bkl){

      bluekick(1);
      bkl=false;
      bkr=true;
      btime=t;
    }
  }
  if(c.keyCode==97){//紅左踢
    if(rtime==0||rkr){

      redkick(-1);
      rkr=false;
      rkl=true;
      rtime=t;
    }
  }
  if(c.keyCode==99){//紅右踢
    if(rtime==0||rkl){

      redkick(1);
      rkl=false;
      rkr=true;
      rtime=t;
    }
  }
  if(c.keyCode==86&&bcd==0){
    bonskill=true;
    bcd=10;
    bignore=-1;
    skill.style.color="#484891";
    skill.style.visibility="visible";
    setTimeout(() => {
      skill.style.visibility="hidden";
    }, 2000);
  }
  if(c.keyCode==96&&rcd==0){
    ronskill=true;
    rcd=10;
    rignore=-1;
    skill.style.color="#613030";
    skill.style.visibility="visible";
    setTimeout(() => {
      skill.style.visibility="hidden";
    }, 2000);
  }
  }
  
}
document.onkeyup=function(e){
  var c=e||event; 
  if(c.keyCode==81){//藍一往上
    b1u=false;
  }
  if(c.keyCode==65){//藍一往下
    b1d=false;
  }
  if(c.keyCode==87){//藍二往上
    b2u=false;
  }
  if(c.keyCode==83){//藍二往下
    b2d=false;
  }
  if(c.keyCode==69){//藍三往上
    b3u=false;
  }
  if(c.keyCode==68){//藍三往下
    b3d=false;
  }
  if(c.keyCode==103){//紅一往上
    r1u=false;
  }
  if(c.keyCode==100){//紅一往下
    r1d=false;
  }
  if(c.keyCode==104){//紅二往上
    r2u=false;
  }
  if(c.keyCode==101){//紅二往下
    r2d=false;
  }
  if(c.keyCode==105){//紅三往上
    r3u=false;
  }
  if(c.keyCode==102){//紅三往下
    r3d=false;
  }
}
setInterval(function(){
  if(begingame&&finish){
    if(b1u){
    if(b1>-courth*3/20/speed+1){
      b1--;
    }else{
      b1=-courth*3/20/speed;
    }
  }
  if(b2u){
    if(b2>-courth*4/20/speed+1){
      b2--;
    }else{
      b2=-courth*4/20/speed;
    }
  }
  if(b3u){
    if(b3>-courth*4/20/speed+1){
      b3--;
    }else{
      b3=-courth*4/20/speed;
    }
  }
  if(b1d){
    if(b1<courth*3/20/speed-1){
      b1++;
    }else{
      b1=courth*3/20/speed;
    }
  }
  if(b2d){
    if(b2<courth*4/20/speed-1){
      b2++;
    }else{
      b2=courth*4/20/speed;
    }
  }
  if(b3d){
    if(b3<courth*4/20/speed-1){
      b3++;
    }else{
      b3=courth*4/20/speed;
    }
  }
  if(r1u){
    if(r1>-courth/5/speed+1){
      r1--;
    }else{
      r1=-courth/5/speed;
    }
  }
  if(r2u){
    if(r2>-courth/5/speed+1){
      r2--;
    }else{
      r2=-courth/5/speed;
    }
  }
  if(r3u){
    if(r3>-courth*3/20/speed+1){
      r3--;
    }else{
      r3=-courth*3/20/speed;
    }
  }
  if(r1d){
    if(r1<courth/5/speed-1){
      r1++;
    }else{
      r1=courth/5/speed;
    }
  }
  if(r2d){
    if(r2<courth/5/speed-1){
      r2++;
    }else{
      r2=courth/5/speed;
    }
  }
  if(r3d){
    if(r3<courth*3/20/speed-1){
      r3++;
    }else{
      r3=courth*3/20/speed;
    }
  }
     game();
  if(bcd>0){
    if(bpercd>0){
      bpercd--;
    }else{
      bcd--;
      bcdtime.innerHTML=bcd.toString();
      bpercd=20;
    }
  }else{
    bcdtime.innerHTML="";
  }
  if(rcd>0){
    if(rpercd>0){
      rpercd--;
    }else{
      rcd--;
      rcdtime.innerHTML=rcd.toString();
      rpercd=20;
    }
  }else{
    rcdtime.innerHTML="";
  }
  if(btime>0){
    if(bkl)
    bluekick(-1);
    else if(bkr)
    bluekick(1);

    btime--;
  }else{
    bkl=false;
    bkr=false;
  }
  if(rtime>0){
    if(rkl)
    redkick(-1);
    else if(rkr){
      redkick(1);
    }
    rtime--;
  }else{
    rkl=false;
    rkr=false;
  }
  }
  

},50)
function bluekick(d){
//藍一上的身體
ctx.beginPath()
ctx.strokeStyle="#9999CC"
ctx.fillStyle="#9999CC"
ctx.rect(blueleft+d*courth/20,(window.innerHeight-courth)/2+7*courth/40+b1*speed,d*courth/20,courth/20)
ctx.stroke()
ctx.fill()

ctx.beginPath()
ctx.rect(blueleft+d*courth/10,(window.innerHeight-courth)/2+courth*3/16+b1*speed,d*courth/20,courth/40)
ctx.stroke()
ctx.fill()
  //藍一下身體
ctx.beginPath()
ctx.rect(blueleft+d*courth/20,(window.innerHeight-courth)/2+courth*31/40+b1*speed,d*courth/20,courth/20)
ctx.stroke()
ctx.fill()
ctx.beginPath()
ctx.rect(blueleft+d*courth/10,(window.innerHeight-courth)/2+courth*63/80+b1*speed,d*courth/20,courth/40)
ctx.stroke()
ctx.fill()
//藍二身體
for(let i=1;i<4;i++){
  ctx.beginPath()
  ctx.rect(blueleft+db+d*courth/20,(window.innerHeight-courth)/2+courth*i/4-courth/40+b2*speed,d*courth/20,courth/20)
  ctx.stroke()
  ctx.fill()
  
  ctx.beginPath()
  ctx.rect(blueleft+db+d*courth/10,(window.innerHeight-courth)/2+courth*i/4+b2*speed-courth/80,d*courth/20,courth/40)
  ctx.stroke()
  ctx.fill()
}
//藍三身體
for(let i=1;i<4;i++){
  ctx.beginPath()
  ctx.rect(blueleft+2*db+d*courth/20,(window.innerHeight-courth)/2+courth*i/4+b3*speed-courth/40,d*courth/20,courth/20)
  ctx.stroke()
  ctx.fill()

  ctx.beginPath()
  ctx.rect(blueleft+2*db+d*courth/10,(window.innerHeight-courth)/2+courth*i/4+b3*speed-courth/80,d*courth/20,courth/40)
  ctx.stroke()
  ctx.fill()
}
}
function redkick(d){
//紅一身體
ctx.strokeStyle="#B87070"
ctx.fillStyle="#B87070"
for(let i=1;i<4;i++){
  ctx.beginPath()
  ctx.rect(redleft+d*courth/20,(window.innerHeight-courth)/2+courth*i/4+r1*speed-courth/40,d*courth/20,courth/20)
  ctx.stroke()
  ctx.fill()
  
  ctx.beginPath()
  ctx.rect(redleft+d*courth/10,(window.innerHeight-courth)/2+courth*i/4+r1*speed-courth/80,d*courth/20,courth/40)
  ctx.stroke()
  ctx.fill()
}
//紅二身體
for(let i=1;i<4;i++){
  ctx.beginPath()
  ctx.rect(redleft+dr+d*courth/20,(window.innerHeight-courth)/2+courth*i/4+r2*speed-courth/40,d*courth/20,courth/20)
  ctx.stroke()
  ctx.fill()

  ctx.beginPath()
  ctx.rect(redleft+dr+d*courth/10,(window.innerHeight-courth)/2+courth*i/4+r2*speed-courth/80,d*courth/20,courth/40)
  ctx.stroke()
  ctx.fill()
}
//紅三上身體
ctx.beginPath()
ctx.rect(redright+d*courth/20,(window.innerHeight-courth)/2+courth/5+r3*speed-courth/40,d*courth/20,courth/20)
ctx.stroke()
ctx.fill()

ctx.beginPath()
ctx.rect(redright+d*courth/10,(window.innerHeight-courth)/2+courth/5+r3*speed-courth/80,d*courth/20,courth/40)
ctx.stroke()
ctx.fill()
//紅三下身體
ctx.beginPath()
ctx.rect(redright+d*courth/20,(window.innerHeight-courth)/2+courth*4/5+r3*speed-courth/40,d*courth/20,courth/20)
ctx.stroke()
ctx.fill()
ctx.beginPath()
ctx.rect(redright+d*courth/10,(window.innerHeight-courth)/2+courth*4/5+r3*speed-courth/80,d*courth/20,courth/40)
ctx.stroke()
ctx.fill()
}

function game(){
finish=false;
canvas.height=canvas2.height=window.innerHeight;
canvas.width=canvas2.width=window.innerWidth;
ctx2.fillStyle=ctx2.strokeStyle="rgb(1,1,1)";
ctx2.globalAlpha=0.5;
ctx.lineWidth = 3;

if(rcd>0){
  ctx2.rect(redright+courth/20,window.innerHeight/2-courth/2+courth/20,courth/10,courth/10);
  ctx2.stroke()
  ctx2.fill()
  ctx2.beginPath()
}

if(bcd>0){
  ctx2.rect(blueleft-courth*3/20,window.innerHeight/2-courth/2+courth/20,courth/10,courth/10)
  ctx2.stroke()
  ctx2.fill()
  ctx2.beginPath()
}


ctx.fillStyle="#006030"
ctx.strokeStyle="#006030"
ctx.rect(0,0,window.innerWidth,window.innerHeight)
ctx.stroke()
ctx.fill()
ctx.beginPath()

ctx.fillStyle="#00BB00"
ctx.strokeStyle="#00BB00"
ctx.rect((window.innerWidth-courtw)/2,(window.innerHeight-courth)/2,courtw,courth)
ctx.stroke()
ctx.fill()

ctx.beginPath()
ctx.strokeStyle="#FFFFFF"
ctx.rect((window.innerWidth-courtw)/2,(window.innerHeight-courth)/2+courth/5,courth/5,courth*3/5)
ctx.stroke()

ctx.beginPath()
ctx.arc(blueleft,(window.innerHeight-courth)/2+courth/2,courth/5,-Math.PI/2,Math.PI/2)
ctx.stroke()

ctx.beginPath()
ctx.rect((window.innerWidth-courtw)/2,(window.innerHeight-courth)/2+courth/3,courth/12,courth/3)
ctx.stroke()

ctx.beginPath()
ctx.rect((window.innerWidth-courtw)/2+courtw-courth/5,(window.innerHeight-courth)/2+courth/5,courth/5,courth*3/5)
ctx.stroke()

ctx.beginPath()
ctx.arc(redright,(window.innerHeight-courth)/2+courth/2,courth/5,Math.PI/2,-Math.PI/2)
ctx.stroke()

ctx.beginPath()
ctx.rect((window.innerWidth-courtw)/2+courtw-courth/12,(window.innerHeight-courth)/2+courth/3,courth/12,courth/3)
ctx.stroke()

ctx.beginPath()
ctx.moveTo(window.innerWidth/2,(window.innerHeight-courth)/2)
ctx.lineTo(window.innerWidth/2,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.arc(window.innerWidth/2,window.innerHeight/2,courth/5,-Math.PI/2,3*Math.PI/2)
ctx.stroke()
//籃隊的竿子
ctx.beginPath()
ctx.strokeStyle="#484891"
ctx.moveTo(blueleft,(window.innerHeight-courth)/2)
ctx.lineTo(blueleft,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.moveTo(blueleft+db,(window.innerHeight-courth)/2)
ctx.lineTo(blueleft+db,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.moveTo(blueleft+2*db,(window.innerHeight-courth)/2)
ctx.lineTo(blueleft+2*db,(window.innerHeight+courth)/2)
ctx.stroke()
//紅隊的竿子
ctx.beginPath()
ctx.strokeStyle="#613030"
ctx.moveTo(redleft,(window.innerHeight-courth)/2)
ctx.lineTo(redleft,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.moveTo(redleft+dr,(window.innerHeight-courth)/2)
ctx.lineTo(redleft+dr,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.moveTo(redleft+2*dr,(window.innerHeight-courth)/2)
ctx.lineTo(redleft+2*dr,(window.innerHeight+courth)/2)
ctx.stroke()

ctx.beginPath()
ctx.strokeStyle="#9999CC"
ctx.fillStyle="#9999CC"
positionx[0]=blueleft;
positiony[0]=(window.innerHeight-courth)/2+courth/5+b1*speed;
ctx.arc(blueleft,(window.innerHeight-courth)/2+courth/5+b1*speed,courth/20,2*Math.PI,0)
ctx.stroke()
ctx.fill()

ctx.beginPath()
positionx[1]=blueleft;
positiony[1]=(window.innerHeight-courth)/2+courth*4/5+b1*speed;
ctx.arc(blueleft,(window.innerHeight-courth)/2+courth*4/5+b1*speed,courth/20,2*Math.PI,0)
ctx.stroke()
ctx.fill()


for(let i=1;i<4;i++){
  ctx.beginPath()
  positionx[i+1]=blueleft+db;
  positiony[i+1]=(window.innerHeight-courth)/2+courth*i/4+b2*speed;
  ctx.arc(blueleft+db,(window.innerHeight-courth)/2+courth*i/4+b2*speed,courth/20,2*Math.PI,0)
  ctx.stroke()
  ctx.fill()
}

for(let i=1;i<4;i++){
  ctx.beginPath()
  positionx[i+4]=blueleft+2*db;
  positiony[i+4]=(window.innerHeight-courth)/2+courth*i/4+b3*speed;
  ctx.arc(blueleft+2*db,(window.innerHeight-courth)/2+courth*i/4+b3*speed,courth/20,2*Math.PI,0)
  ctx.stroke()
  ctx.fill()
}

ctx.beginPath()
ctx.strokeStyle="#B87070"
ctx.fillStyle="#B87070"
for(let i=1;i<4;i++){
  positionx[i+7]=redleft;
  positiony[i+7]=(window.innerHeight-courth)/2+courth*i/4+r1*speed;
  ctx.arc(redleft,(window.innerHeight-courth)/2+courth*i/4+r1*speed,courth/20,2*Math.PI,0)
  ctx.stroke()
  ctx.fill()
  ctx.beginPath()
}
for(let i=1;i<4;i++){
  positionx[i+10]=redleft+dr;
  positiony[i+10]=(window.innerHeight-courth)/2+courth*i/4+r2*speed;
  ctx.arc(redleft+dr,(window.innerHeight-courth)/2+courth*i/4+r2*speed,courth/20,2*Math.PI,0)
  ctx.stroke()
  ctx.fill()
  ctx.beginPath()
}

positionx[14]=redright;
positiony[14]=(window.innerHeight-courth)/2+courth*4/5+r3*speed;
ctx.arc(redright,(window.innerHeight-courth)/2+courth*4/5+r3*speed,courth/20,2*Math.PI,0)
ctx.stroke()
ctx.fill()

ctx.beginPath()
positionx[15]=redright;
positiony[15]=(window.innerHeight-courth)/2+courth/5+r3*speed;
ctx.arc(redright,(window.innerHeight-courth)/2+courth/5+r3*speed,courth/20,2*Math.PI,0)
ctx.stroke()
ctx.fill()

ctx.beginPath()

if(!ballin){
  collision();
}else{
  ballx+=xroll;
  bally+=yroll;
}

if(Math.pow(xroll*xroll+yroll*yroll,0.5)>courth/20){
  xroll/=Math.pow(xroll*xroll+yroll*yroll,0.5)/courth*20;
  yroll/=Math.pow(xroll*xroll+yroll*yroll,0.5)/courth*20;
}

if(!ballin){
  ctx.strokeStyle="#FFFFFF"
  ctx.fillStyle="#FFFFFF"
}else{
  ctx.strokeStyle="#FFFF6F"
  ctx.fillStyle="#FFFF6F"
}
ctx.arc(ballx,bally,ballsize,0,Math.PI*2)
ctx.stroke()
ctx.fill()
finish=true;
}

function collision(){
    ballx+=xroll;
    bally+=yroll;

    if(ballx<(window.innerWidth-courtw)/2+courth/20){
        if(bally<(window.innerHeight-courth)/2+courth/3+courth/20||bally>(window.innerHeight-courth)/2+2*courth/3-courth/20){
            ballx=(window.innerWidth-courtw)/2+courth/20;
            xroll=-xroll;
        }else if(ballx<(window.innerWidth-courtw)/2){
            rscore++;
            rscoretext.innerHTML=rscore.toString();
            
            ballin=true;
            xroll/=Math.pow(xroll*xroll+yroll*yroll,0.5);
            yroll/=Math.pow(xroll*xroll+yroll*yroll,0.5);
            goal.innerHTML="紅隊得分!";
            goal.style.color="#613030";
            goal.style.visibility="visible";

            setTimeout(function(){
              goal.style.visibility="hidden";
              init();
              ballin=false;
            },3000)
                
            if(rscore==win){
              setTimeout(function(){
                gameover();
                whowin.innerHTML="紅隊"+whowin.innerHTML;
                whowin.style.color="#613030";
                new Audio('music/win.mp3').play();
              },3000)

            }
        }
      }else if(ballx>(window.innerWidth+courtw)/2-courth/20){
        if(bally<(window.innerHeight-courth)/2+courth/3+courth/20||bally>(window.innerHeight-courth)/2+2*courth/3-courth/20){
            xroll=-xroll;
            ballx=(window.innerWidth+courtw)/2-courth/20;
        }else if(ballx>(window.innerWidth+courtw)/2){
            bscore++;
            bscoretext.innerHTML=bscore.toString();

            ballin=true;
            xroll/=Math.pow(xroll*xroll+yroll*yroll,0.5);
            yroll/=Math.pow(xroll*xroll+yroll*yroll,0.5);
            goal.innerHTML="藍隊得分!";
            goal.style.color="#484891";
            goal.style.visibility="visible";

            setTimeout(function(){
              goal.style.visibility="hidden";
              init();
              ballin=false;
            },3000)
            if(bscore==win){
              setTimeout(function(){
                gameover();
                whowin.innerHTML="藍隊"+whowin.innerHTML;
                whowin.style.color="#484891";
                new Audio('music/win.mp3').play();
              },3000)
                
            }
            
        }
        
      }
      if(bally<(window.innerHeight-courth)/2+courth/20){
        bally=(window.innerHeight-courth)/2+courth/20;
        yroll=-yroll;
      }else if(bally>(window.innerHeight+courth)/2-courth/20){
        bally=(window.innerHeight+courth)/2-courth/20;
        yroll=-yroll;
      }
  for(let i=0;i<16;i++){
    
    if(i<8&&btime!=0){
      if(bkl){
        if(btime==t&&(ballx>=positionx[i]-courth/10-courth/20&&ballx<=positionx[i]-(Math.pow(7,0.5))*courth/40&&bally>positiony[i]-courth/10&&bally<positiony[i]+courth/10)||(ballx>=positionx[i]-courth/10-courth/10&&ballx<=positionx[i]-courth/10-courth/20&&bally>positiony[i]-3*courth/40&&bally<positiony[i]+3*courth/40)){
          if(ronskill&&i<8){
            if(rignore==-1){
              rignore=i;
            }
            if(rignore==i){
              break;
            }else{
              rignore=-1;
              ronskill=false;
            }
          }
        let dx=Math.abs(courth/10-Math.abs(ballx-positionx[i]+3*courth/20));
        xroll-=dx*addballspeed;
        break;
        }
      }else if(bkr){
        if(btime==t&&(ballx<=positionx[i]+courth/10+courth/20&&ballx>=positionx[i]+(Math.pow(7,0.5))*courth/40&&bally>positiony[i]-courth/10&&bally<positiony[i]+courth/10)||(ballx<=positionx[i]+courth/10+courth/10&&ballx>=positionx[i]+courth/10+courth/20&&bally>positiony[i]-3*courth/40&&bally<positiony[i]+3*courth/40)){
          if(ronskill&&i<8){
            if(rignore==-1){
              rignore=i;
            }
            if(rignore==i){
              break;
            }else{
              rignore=-1;
              ronskill=false;
            }
          }
        let dx=Math.abs(courth/10-Math.abs(ballx-positionx[i]-3*courth/20));
        xroll+=dx*addballspeed;
        break;
        }
      }
    }else if(i>7&&rtime!=0){
      if(rkl){
        if(rtime==t&&(ballx>=positionx[i]-courth/10-courth/20&&ballx<=positionx[i]-(Math.pow(7,0.5))*courth/40&&bally>positiony[i]-courth/10&&bally<positiony[i]+courth/10)||(ballx>=positionx[i]-courth/10-courth/10&&ballx<=positionx[i]-courth/10-courth/20&&bally>positiony[i]-3*courth/40&&bally<positiony[i]+3*courth/40)){
          if(bonskill&&i>7){
            if(bignore==-1){
              bignore=i;
            }
            if(bignore==i){
              break;
            }else{
              bignore=-1;
              bonskill=false;
            }
        
          }
        let dx=Math.abs(courth/10-Math.abs(ballx-positionx[i]+3*courth/20));
        xroll-=dx*addballspeed;
        break;
        }
      }else if(rkr){
        if(rtime==t&&(ballx<=positionx[i]+courth/10+courth/20&&ballx>=positionx[i]+(Math.pow(7,0.5))*courth/40&&bally>positiony[i]-courth/10&&bally<positiony[i]+courth/10)||(ballx<=positionx[i]+courth/10+courth/10&&ballx>=positionx[i]+courth/10+courth/20&&bally>positiony[i]-3*courth/40&&bally<positiony[i]+3*courth/40)){
          if(bonskill&&i>7){
            if(bignore==-1){
              bignore=i;
            }
            if(bignore==i){
              break;
            }else{
              bignore=-1;
              bonskill=false;
            }
        
          }
        let dx=Math.abs(courth/10-Math.abs(ballx-positionx[i]-3*courth/20));
        xroll+=dx*addballspeed;
        break;
        }
      }
    }
    if(Math.pow(ballx-positionx[i],2)+Math.pow(bally-positiony[i],2)<=courth*courth/100){
      if(bonskill&&i>7){
        if(bignore==-1){
          bignore=i;
        }
        if(bignore==i){
          break;
        }else{
          bignore=-1;
          bonskill=false;
        }
    
      }
      if(ronskill&&i<8){
        if(rignore==-1){
          rignore=i;
        }
        if(rignore==i){
          break;
        }else{
          rignore=-1;
          ronskill=false;
        }
      }
      let dx=ballx-positionx[i];
      let dy=bally-positiony[i];
      ballx=positionx[i]+courth/10*dx/Math.pow(dx*dx+dy*dy,0.5);
      bally=positiony[i]+courth/10*dy/Math.pow(dx*dx+dy*dy,0.5);
      if(dx!=0){
        let rebound=-addballspeed*(dy/dx*yroll-xroll)/(dy*dy/dx-dx);
        xroll+=rebound*dx;
        yroll+=rebound*dy;
      }
      else if(dy!=0){
        let rebound=-addballspeed*(dx/dy*xroll-yroll)/(dx*dx/dy-dy);
        xroll+=rebound*dx;
        yroll+=rebound*dy;
        }
        break;
      
    }
    
  
  }
}

function init(){
    ballx=window.innerWidth/2;
    bally=window.innerHeight/2;
    xroll=0;
    yroll=1;
}

function resizediv(){//設定一開始的input、按鈕位置
    nwidth=window.innerWidth/4;
    nheight=window.innerHeight/20;
    nleft=window.innerWidth/2-nwidth/2;
    ntop=window.innerHeight/2-nheight/2-nheight*0.75;
    bt=window.innerHeight/2-nheight/2+nheight*0.75;
    bw=window.innerWidth/10;
    bh=nheight;
    bl=window.innerWidth/2-bw/2;
    ah=nheight;
    at=ntop;
    aw=ah*3;
    a1l=nleft-aw;
    a2l=nleft+nwidth;

    button.style.width=bw.toString()+'px';
    button.style.height=bh.toString()+'px';
    button.style.top=bt.toString()+'px';
    button.style.left=bl.toString()+'px';
    
    inputnumber.style.top=ntop.toString()+'px';
    inputnumber.style.left=nleft.toString()+'px';
    inputnumber.style.width=nwidth.toString()+'px';
    inputnumber.style.height=nheight.toString()+'px';
    inputnumber.style.fontSize=nheight.toString()+'px';

    ask1.style.top=at.toString()+'px';
    ask1.style.left=a1l.toString()+'px';
    ask1.style.width=aw.toString()+'px';
    ask1.style.height=ah.toString()+'px';
    ask1.style.fontSize=(ah*0.8).toString()+'px';
    ask2.style.top=at.toString()+'px';
    ask2.style.left=a2l.toString()+'px';
    ask2.style.width=aw.toString()+'px';
    ask2.style.height=ah.toString()+'px';
    ask2.style.fontSize=(ah*0.8).toString()+'px';
}
function gameover(){
    over=true;
    sizechange();
    begingame=false;
    bskill.style.visibility=bcdtime.style.visibility="hidden";
    rskill.style.visibility=rcdtime.style.visibility="hidden";
    whowin.style.visibility="visible";
    again.style.visibility="visible";
    again.onclick=function(){

        location.reload();
    }
}