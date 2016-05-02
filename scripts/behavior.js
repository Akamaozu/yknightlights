function toggleTrain() {
trainBlock = document.getElementById('recent-tweets');

if (trainBlock.style.height == "0px" || trainBlock.style.height == "") {
trainBlock.style.height = "auto";
} else {
trainBlock.style.height = "0px";
}

}

function findPos(obj) {

var curleft = curtop = 0;
if (obj.offsetParent) {
        curleft = obj.offsetLeft
        curtop = obj.offsetTop
        while (obj = obj.offsetParent) {
                curleft += obj.offsetLeft
                curtop += obj.offsetTop
        }
}
return [curleft,curtop];
}

function getStyle(el, cssprop){
 if (el.currentStyle) //IE
  return el.currentStyle[cssprop]
 else if (document.defaultView && document.defaultView.getComputedStyle) //Firefox
  return document.defaultView.getComputedStyle(el, "")[cssprop]
 else //try and get inline style
  return el.style[cssprop]
}

function yAxisScrollSetup() {

yOff = window.pageYOffset;

var body = document.body, 
    html = document.documentElement;

var bodyHeight = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );

sections = ["headerWrap","contentWrap","titleBlock","contentBlock"];
output = [];

for (var i = 0; i < sections.length; i++) {
output[sections[i]] = document.getElementById(sections[i]);
output[sections[i]+"Height"] = output[sections[i]].offsetHeight;
output[sections[i]+"MarginTop"] = parseInt(getStyle(output[sections[i]], 'marginTop'), 10);
output[sections[i]+"YDepth"] = findPos(output[sections[i]]);
output[sections[i]+"YDepth"] = output[sections[i]+"YDepth"][1];
}

output["bodyHeight"] = bodyHeight;

return output;
}


function scrollUp() {
scrollCalcs = yAxisScrollSetup();

headerHeight = scrollCalcs["headerWrapHeight"];
headerMargin = scrollCalcs["headerWrapMarginTop"];
headerDepth = scrollCalcs["headerWrapYDepth"];
contentHeight = scrollCalcs["contentWrapHeight"];
contentMargin = scrollCalcs["contentWrapMarginTop"];
titleHeight = scrollCalcs["titleBlockHeight"];
titleMargin = scrollCalcs["titleBlockMarginTop"];
titleDepth = scrollCalcs["titleBlockYDepth"];
contentBlockHeight = scrollCalcs["contentBlockHeight"];
contentBlockMargin = scrollCalcs["contentBlockMarginTop"];
contentBlockDepth = scrollCalcs["contentBlockYDepth"];
bodyHeight = scrollCalcs["bodyHeight"];


if (yOff < (headerDepth + headerHeight)) {

	newFocus = "header";
	yMove = yOff;
	
} else if ((headerDepth + headerHeight) < yOff && yOff < titleDepth) {
	
	newFocus = "nav";
	yMove = yOff - (headerDepth + headerHeight);

} else if (titleDepth < yOff && yOff < (contentBlockDepth + (contentBlockHeight / 2)) ) {

	newFocus = "content";
	yMove = yOff - titleDepth; 
	
}

switch (newFocus) {

	case "header":
		currentY = 0;
		
		while (currentY < yMove) {

			if (currentY > (3 *yMove / 4)) {
				setTimeout("window.scrollBy(0,-1)", 50);
				currentY += 1;
			} else { 
				setTimeout("window.scrollBy(0,-3)", 50);
				currentY += 3;
			} 

			clearTimeout();
		}	
	
	break;
	
	case "nav":
		currentY = 0;
		
		while (currentY < yMove) {

			if (currentY > (3 *yMove / 4)) {
				setTimeout("window.scrollBy(0,-1)", 50);
				currentY += 1;
			} else { 
				setTimeout("window.scrollBy(0,-3)", 50);
				currentY += 3;
			} 

			clearTimeout();
		}
		
	break;
	
	case "content":
		currentY = 0;
		
		while (currentY < yMove) {

			if (currentY > (3 *yMove / 4)) {
				window.scrollBy(0,-1);
				currentY += 1;
			} else { 
				window.scrollBy(0,-3);
				currentY += 3;
			} 

		}
		
	break;


}

}

function scrollDown() {
scrollCalcs = yAxisScrollSetup();

headerHeight = scrollCalcs["headerWrapHeight"];
headerMargin = scrollCalcs["headerWrapMarginTop"];
contentHeight = scrollCalcs["contentWrapHeight"];
contentMargin = scrollCalcs["contentWrapMarginTop"];
titleHeight = scrollCalcs["titleBlockHeight"];
titleMargin = scrollCalcs["titleBlockMarginTop"];
titleDepth = scrollCalcs ["titleBlockYDepth"];
bodyHeight = scrollCalcs["bodyHeight"];

if (yOff < headerHeight) {
	
	newFocus = "nav";
	yMove = (headerHeight + headerMargin) - yOff;

} else if (headerHeight < yOff < titleDepth) {

	newFocus = "content";
	yMove = titleDepth - yOff; 

} 

switch (newFocus) {
	
	case "nav":
		currentY = 0;
		
		while (currentY < yMove) {

			if (currentY > (3 *yMove / 4)) {
				setTimeout("window.scrollBy(0,1)", 50);
				currentY += 1;
			} else { 
				setTimeout("window.scrollBy(0,3)", 50);
				currentY += 3;
			} 

			clearTimeout();
		}
		
	break;
	
	case "content":
		currentY = 0;
		
		while (currentY < yMove) {

			if (currentY > (3 *yMove / 4)) {
				setTimeout("window.scrollBy(0,1)", 50);
				currentY += 1;
			} else { 
				setTimeout("window.scrollBy(0,3)", 50);
				currentY += 3;
			} 

			clearTimeout();
			
		}
		
	break;

}

}

function scrollContentIntoView() {

myPos = findPos(document.getElementById('titleBlock'));
yDepth = myPos[1];
yDepth = yDepth -= 10;

var y = 0;

while (y < yDepth) {

if (y > (3 *yDepth / 4)) {
window.setTimeout("window.scrollBy(0,5)", 50);
y += 5;
} else { 
window.setTimeout("window.scrollBy(0,15)", 50);
y += 15;
} 

}

clearTimeout();

}


function scrollRight()
{
var elemScroll = 216;
var x = 0;

while (x < elemScroll) 
{
window.setTimeout("document.getElementById('postPortals').scrollLeft += 6", 50);
x+=6;
}

clearTimeout();

}

function scrollLeft () 
{
var elemScroll = 216;
var x = 0;
portalWidth = document.getElementById('postPortals').offsetWidth; 

while (x < elemScroll) 
{
window.setTimeout("document.getElementById('postPortals').scrollLeft -= 6", 50);
x+=6;
}

clearTimeout();
} 


function handleArrowKeys(evt) {
    evt = (evt) ? evt : ((window.event) ? event : null);
    if (evt) {
        switch (evt.keyCode) {
		
			case 38: 
				scrollUp();
				break;
			
			case 40: 
				scrollDown();
				break;
		
            case 37:
				scrollLeft();
				break; 	

			case 39:
                scrollRight();
                break;    

         }
    }
}

document.onkeyup = handleArrowKeys;

(function(i) {var u =navigator.userAgent;var e=/*@cc_on!@*/false; var st = 
setTimeout;if(/webkit/i.test(u)){st(function(){var dr=document.readyState;
if(dr=="loaded"||dr=="complete"){i()}else{st(arguments.callee,10);}},10);}
else if((/mozilla/i.test(u)&&!/(compati)/.test(u)) || (/opera/i.test(u))){
document.addEventListener("DOMContentLoaded",i,false); } else if(e){     (
function(){var t=document.createElement('doc:rdy');try{t.doScroll('left');
i();t=null;}catch(e){st(arguments.callee,0);}})();}else{window.onload=i;}})(scrollContentIntoView());

