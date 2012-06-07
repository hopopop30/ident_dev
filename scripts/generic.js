function Hour() {
	d = new Date();
	day = d.getDate();
	if(day < 10){day="0"+day;}
	month = d.getMonth() +1;
	if(month < 10){month="0"+month;}
	year = d.getFullYear();
	h = d.getHours();
	if(h < 10){h="0"+h;}
	min = d.getMinutes();
	if(min < 10){min="0"+min;}
	s = d.getSeconds();
	if(s < 10){s="0"+s;}
	txtDate = "<span class='textColor'>" + day + "</span>/" + month;
	txtAnnee = year;
	txtHeure = h + ":" + min + ":" + s;
	
	document.getElementById('OI_line1').innerHTML = txtDate;
	document.getElementById('OI_line2').innerHTML = txtAnnee;
	document.getElementById('OI_line3').innerHTML = txtHeure;
	setTimeout("Hour()", 1000);
}

function InitHeader(imgSource, text1, text2, user_button_enabled){
	document.getElementById('user_icon').src = imgSource;
	document.getElementById('userName').innerHTML = text1;
	document.getElementById('userLocation').innerHTML = text2;
        if(user_button_enabled == false){
            document.getElementById('bout_profil').setAttribute("disabled", "disabled");
            document.getElementById('bout_profil').setAttribute("style", "background-color:grey");
            document.getElementById('bout_deco').setAttribute("disabled", "disabled");
            document.getElementById('bout_deco').setAttribute("style", "background-color:grey");
        }
}