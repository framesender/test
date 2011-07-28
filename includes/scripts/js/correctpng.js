function correctPNG()
{
for(var i=0; i<document.images.length; i++)
{
var img = document.images[i]
var imgName = img.src.toUpperCase()
if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
{
var imgID = (img.id) ? "id='" + img.id + "' " : ""
var imgClass = (img.className) ? "class='" + img.className + "' " : ""
var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
var imgStyle = "display:inline-block;" + img.style.cssText
var imgAttribs = img.attributes;
var onMouseOver = "", onMouseOut = "";
for (var j=0; j<imgAttribs.length; j++)
{
var imgAttrib = imgAttribs[j];
if (imgAttrib.nodeName == "align")
{
if (imgAttrib.nodeValue == "left") imgStyle = "float:left;" + imgStyle
if (imgAttrib.nodeValue == "right") imgStyle = "float:right;" + imgStyle
break
}
}
if (img.name && !img.id) imgID= "id='" + img.name + "' "
if ((pos=img.outerHTML.toUpperCase().indexOf("ONMOUSEOVER="))>0) {
	onMouseOver=img.outerHTML.substring(pos);
	pos=onMouseOver.indexOf(");");
	if (onMouseOver.substr(12,1)== "\"") pos=onMouseOver.indexOf(");\"");
	onMouseOver=" " + onMouseOver.substring(0,pos+2).replace("MM_swap","MM_PNGswap") + ((onMouseOver.substr(12,1)== "\"") ? "\"":"") + " ";
}
pos=0
if ((pos=img.outerHTML.toUpperCase().indexOf("ONMOUSEOUT="))>0) {
	onMouseOut=img.outerHTML.substring(pos);
	pos=onMouseOut.indexOf(");");
	if (onMouseOut.substr(11,1)== "\"") pos=onMouseOut.indexOf(");\"");
	onMouseOut=" " + onMouseOut.substring(0,pos+2).replace("MM_swap","MM_PNGswap") + ((onMouseOut.substr(11,1)== "\"") ? "\"":"") + " ";
}
pos=0
var strNewHTML = "<span " + imgID + imgClass + imgTitle
strNewHTML += " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
strNewHTML += "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
strNewHTML += "(src=\'" + img.src + "\', sizingMethod='scale');\"";
strNewHTML += onMouseOver + onMouseOut + "></span>"
img.outerHTML = strNewHTML
i = i-1
}
}

for(var i=0; i<document.links.length; i++)
{
var lnk = document.links[i];
var tStr="";
if ((pos=lnk.outerHTML.indexOf("MM_swapImage("))>0) {
	tStr=lnk.outerHTML.substring(pos+13);
	pos=tStr.indexOf(");");
	if (pos>0) {
		pos=tStr.substring(0,pos).toUpperCase().indexOf(".PNG");
		if (pos>0) lnk.outerHTML = lnk.outerHTML.replace(/MM_swap/g,"MM_PNGswap");
	}
}
}

}

function MM_PNGswapImage() { //v3.0
	var i,j=0,x,a=MM_PNGswapImage.arguments;
	document.MM_sr=new Array;
	for(i=0;i<(a.length-2);i+=3)
		if ((x=MM_findObj(a[i]))!=null){
			document.MM_sr[j++]=x;
			if(!x.oSrc) x.oSrc=x.filters(0).src; 
			x.filters(0).src=a[i+2];
		}
}

function MM_PNGswapImgRestore() { //v3.0
	var i,x,a=document.MM_sr;
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.filters(0).src=x.oSrc;
}

window.attachEvent("onload", correctPNG);
