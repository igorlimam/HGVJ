//Consultas
function addHorarios(idTabela) {
	var time = document.getElementById('horario').value;
        console.log();
	url='visao/ajaxHorario.php?time='+time;
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
            document.getElementById(idTabela).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
function excluirHorario(idHorario, idTabela){
	url='visao/ajaxHorario.php?id='+idHorario;
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
            document.getElementById(idTabela).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

//Exames
function addHorariosE(idTabela) {
	var time = document.getElementById('horario').value;
        console.log();
	url='visao/ajaxHorarioE.php?time='+time;
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
            document.getElementById(idTabela).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
function excluirHorarioE(idHorario, idTabela){
	url='visao/ajaxHorarioE.php?id='+idHorario;
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
            document.getElementById(idTabela).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}