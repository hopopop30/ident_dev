
function itemMenuOver(img) {
    var source = img.src;
    if (source.indexOf('_current', 0) > 0) {
        var spliter = source.split('_current');

        img.src = spliter[0] + spliter[1];
    }
    else {
        var spliter = source.split('.');
		var length = spliter.length;
		var sourceNew = ""; 
		for(var i = 0; i< length-1; i++){
			if(i != length-2){
			sourceNew = sourceNew + spliter[i] + ".";
			}
			else sourceNew = sourceNew + spliter[i];
		}
        img.src = sourceNew + "_current.png";
    }
}