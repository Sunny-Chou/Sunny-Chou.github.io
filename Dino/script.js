var character=document.getElementById("character");
var block=document.getElementById("block");
var block2=document.getElementById("block2");
var block3=document.getElementById("block3");
var block4=document.getElementById("block4");
var ground=document.getElementById("ground");
var r=document.getElementById("r");
var go=document.getElementById("go");
var hs=document.getElementById("hs");
var score=document.getElementById("score");
var end=true;
var i1=0;
var b1=0,b2=0,b3=0,b4=0;
var timerate=2000;
var d1=0,d2=0,d3=0,d4=0;
function jump(){
    if(character.classList!="animate"&&end){
        character.classList.add("animate");
        setTimeout(function(){
            character.classList.remove("animate");
        },500);
    }
}
var m=0;
var b=setInterval(function(){
    if(parseInt(score.innerHTML)<999){
        m=6-parseInt(score.innerHTML)/333;
    }
    var n=Math.round(Math.random()*m);
    if(end){
        if(n==0){
            if(block.classList!="animate2"){
                b1=0;
                block.src="p/21.png";
                block.classList.add("animate2");
                d1=0;
                setTimeout(function(){
                    if(end){
                        block.classList.remove("animate2");
                    }
                },timerate);
            }else if(block2.classList!="animate2"){
                b2=0;
                block2.src="p/21.png";
                block2.classList.add("animate2");
                d2=0;
                setTimeout(function(){
                    if(end){
                        block2.classList.remove("animate2");
                    }
                },timerate);
            }else if(block3.classList!="animate2"){
                b3=0;
                block3.src="p/21.png";
                block3.classList.add("animate2");
                d3=0;
                setTimeout(function(){
                    if(end){
                        block3.classList.remove("animate2");
                    }
                },timerate);
            }else if(block4.classList!="animate2"){
                b4=0;
                block4.src="p/21.png";
                block4.classList.add("animate2");
                d4=0;
                setTimeout(function(){
                    if(end){
                        block4.classList.remove("animate2");
                    }
                },timerate);
            }
        }else if(n==1){
            if(block.classList!="animate2"){
                b1=1;
                block.src="p/22.png";
                block.classList.add("animate2");
                d1=0;
                setTimeout(function(){
                    if(end){
                        block.classList.remove("animate2");
                    }
                },timerate);
            }else if(block2.classList!="animate2"){
                b2=1;
                block2.src="p/22.png";
                block2.classList.add("animate2");
                d2=0;
                setTimeout(function(){
                    if(end){
                        block2.classList.remove("animate2");
                    }
                },timerate);
            }else if(block3.classList!="animate2"){
                b3=1;
                block3.src="p/22.png";
                block3.classList.add("animate2");
                d3=0;
                setTimeout(function(){
                    if(end){
                        block3.classList.remove("animate2");
                    }
                },timerate);
            }else if(block4.classList!="animate2"){
                b4=1;
                block4.src="p/22.png";
                block4.classList.add("animate2");
                d4=0;
                setTimeout(function(){
                    if(end){
                        block4.classList.remove("animate2");
                    }
                },timerate);
            }
        }else if(n==2){
            if(block.classList!="animate2"){
                b1=2;
                block.src="p/23.png";
                block.classList.add("animate2");
                d1=0;
                setTimeout(function(){
                    if(end){
                        block.classList.remove("animate2");
                    }
                },timerate);
            }else if(block2.classList!="animate2"){
                b2=2;
                block2.src="p/23.png";
                block2.classList.add("animate2");
                d2=0;
                setTimeout(function(){
                    if(end){
                        block2.classList.remove("animate2");
                    }
                },timerate);
            }else if(block3.classList!="animate2"){
                b3=2;
                block3.src="p/23.png";
                block3.classList.add("animate2");
                d3=0;
                setTimeout(function(){
                    if(end){
                        block3.classList.remove("animate2");
                    }
                },timerate);
            }else if(block4.classList!="animate2"){
                b4=2;
                block4.src="p/23.png";
                block4.classList.add("animate2");
                d4=0;
                setTimeout(function(){
                    if(end){
                        block4.classList.remove("animate2");
                    }
                },timerate);
            }
        }
    }
    
},timerate/3);
var plus=setInterval(function(){
    if(end&&parseInt(score.innerHTML)<99999){
        score.innerHTML=(parseInt(score.innerHTML)+1).toString();
        if(parseInt(score.innerHTML)<9999){
            score.innerHTML='0'+score.innerHTML;
        }
        if(parseInt(score.innerHTML)<999){
            score.innerHTML='0'+score.innerHTML;
            
        }
        if(parseInt(score.innerHTML)<99){
            score.innerHTML='0'+score.innerHTML;
        }
        if(parseInt(score.innerHTML)<9){
            score.innerHTML='0'+score.innerHTML;
        }
    }
    if(d1<2){
        d1++;
    }
    if(d2<2){
        d2++;
    }
    if(d3<2){
        d3++;
    }
    if(d4<2){
        d4++;
    }
},100);
var run=setInterval(function(){
    if(end){
        if(i1==0){
            character.src="p/12.png";
            i1++;
        }else if(i1==1){
            character.src="p/13.png";
            i1++;
        }else if(i1==2){
            character.src="p/12.png";
            i1++;
        }else{
            character.src="p/11.png";
            i1=0;
        }
    }
    
    
},100);
var checkDead=setInterval(function(){
    var characterTop=parseInt(window.getComputedStyle(character).getPropertyValue("top"));
    var blockLeft=parseInt(window.getComputedStyle(block).getPropertyValue("left"));
    var blockLeft2=parseInt(window.getComputedStyle(block2).getPropertyValue("left"));
    var blockLeft3=parseInt(window.getComputedStyle(block3).getPropertyValue("left"));
    var blockLeft4=parseInt(window.getComputedStyle(block4).getPropertyValue("left"));
    if(b1==0){
        if(blockLeft<54&&blockLeft>2&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b1==1){
        if(blockLeft<54&&blockLeft>-18&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b1==2){
        if(blockLeft<50&&blockLeft>-40&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    if(b2==0){
        if(blockLeft2<54&&blockLeft2>2&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b2==1){
        if(blockLeft2<54&&blockLeft2>-18&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b2==2){
        if(blockLeft2<50&&blockLeft2>-40&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    if(b3==0){
        if(blockLeft3<54&&blockLeft3>2&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b3==1){
        if(blockLeft3<54&&blockLeft3>-18&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b3==2){
        if(blockLeft3<50&&blockLeft3>-40&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    if(b4==0){
        if(blockLeft4<54&&blockLeft4>2&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b4==1){
        if(blockLeft4<54&&blockLeft4>-18&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
    else if(b4==2){
        if(blockLeft4<50&&blockLeft4>-40&&characterTop>=80){
            block.style.animationPlayState="paused";
            block2.style.animationPlayState="paused";
            block3.style.animationPlayState="paused";
            block4.style.animationPlayState="paused";
            ground.style.animationPlayState="paused";
            end=false;
            if(parseInt(hs.innerHTML.substring(3,8))<parseInt(score.innerHTML)){
                hs.innerHTML="HI "+score.innerHTML;
            }
            hs.style.visibility="visible";
            go.style.visibility="visible";
            r.style.visibility="visible";
        }
    }
},1);
r.onclick=function(){
    if(block.classList=="animate2"&&d1==2){
        block.classList.remove("animate2");
    }
    if(block2.classList=="animate2"&&d2==2){
        block2.classList.remove("animate2");
    }
    if(block3.classList=="animate2"&&d3==2){
        block3.classList.remove("animate2");
    }
    if(block4.classList=="animate2"&&d4==2){
        block4.classList.remove("animate2");
    }
    score.innerHTML="00000";
    block.style.animationPlayState="running";
    block2.style.animationPlayState="running";
    block3.style.animationPlayState="running";
    block4.style.animationPlayState="running";
    ground.style.animationPlayState="running";
    go.style.visibility="hidden";
    r.style.visibility="hidden";
    end=true;
};