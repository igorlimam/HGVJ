function selectMedicoP(str, id){
    document.getElementById('medico_id').innerHTML = '<option selected="selected" value="">Selecione</option>';
    var mes = document.getElementById('mes').options;
    mes.selectedIndex = "0";
    document.getElementById('dia').innerHTML = '<option selected="selected" value="">Selecione</option>';
    document.getElementById('horario').innerHTML = '<option selected="selected" value="">Selecione</option>';
    url = "visao/ajaxAgendaSelect.php?id="+str;
    //console.log("localhost/hospital_hgvj/visao/ajaxAgendaSelect.php?id="+str);
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function selectMedico(str, id){
    url = "visao/ajaxAgendaSelect.php?id="+str;
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function exameVerifica(idUsuario){
    if(!String.IsNullOrEmpty(Request.Form["idUsuarioExame"]))
         IgnoreComment();
    if(idUsuario != ""){
        var form = document.getElementById("form");
        var elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].setAttribute("disabled",true);
        }
    }
    
}

function selectExame(str, id){
    
    url = "visao/ajaxAgendaSelectE.php?id="+str;
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

//select Dia da semana consulta
function selectDia(str, id){
    
    
    var especialidade = document.getElementById('especialidade_id').value;
    var medico = document.getElementById('medico_id').value;
    
    url = "visao/ajaxSelectDia.php?timeMes="+str+"&medico_id="+medico+"&especialidade_id="+especialidade;
    console.log("localhost/hospital_hgvj/visao/ajaxSelectDia.php?timeMes="+str+"&medico_id="+medico+"&especialidade_id="+especialidade);
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function selectDiaMes(value){
    document.getElementById('horario').innerHTML = '<option selected="selected" value="">Selecione</option>';
    document.getElementById('dia').innerHTML = '<option selected="selected" value="">Selecione</option>';
    var mes = document.getElementById('mes').options;
    mes.selectedIndex = "0";
    if(value != ""){
        document.getElementById('mes').removeAttribute('disabled');
        document.getElementById('dia').removeAttribute('disabled');
    }else{
        document.getElementById('mes').setAttribute('disabled',true);
        document.getElementById('dia').setAttribute('disabled',true);
    }
    
}

//Seleciona horário Consulta
function selectHorario(str, id){
    
    document.getElementById(id).removeAttribute('disabled');
    
    url = "visao/ajaxSelectHorario.php?diaMesAgendaId="+str;
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function setDate(idCampo){
	var date = new Date();
	
	document.getElementById(idCampo).value = date.getFullYear()+'-'+date.getMonth()+1+'-'+date.getDate()+' '+date.getHours()+":"+date.getMinutes()+':'+date.getSeconds();
}

function examePaciente(){
    
    var mes = document.getElementById('mes').options;
    mes.selectedIndex = "0";
    document.getElementById('dia').innerHTML = '<option selected="selected" value="">Selecione</option>';
    document.getElementById('horario').innerHTML = '<option selected="selected" value="">Selecione</option>';
    
}

//select Dia da semana exame
function selectDiaExame(str, id){
    
    
    var exame = document.getElementById('exame_id').value;
    
    url = "visao/ajaxSelectDiaExame.php?timeMes="+str+"&exame_id="+exame;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

//Seleciona horário Consulta
function selectHorarioExame(str, id){
    
    document.getElementById(id).removeAttribute('disabled');
    
    url = "visao/ajaxSelectHorarioExame.php?diaMesAgendaId="+str;
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}