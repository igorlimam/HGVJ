function curriculo(str,id) {
    idCpf = document.getElementById(str).value;
    url = 'visao/AjaxCurriculo.php?id='+idCpf;

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(id).innerHTML=xmlhttp.responseText;
            document.getElementById(str).value = "";
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function medico(str,id) {
    
    console.log(id);
    url = 'visao/AjaxMedico.php?cpf='+str;
    
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(id).innerHTML=xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
function seretaria(str,id) {
    
    url = 'visao/AjaxSecretaria.php?cpf='+str;

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(id).innerHTML=xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function paciente(str,id,value){
    idCpf = document.getElementById(str).value;
    if(document.getElementById(str).value == "" && !document.getElementById('editCpf') == ""){
        console.log(document.getElementById('editCpf'));
        idCpf = document.getElementById('editCpf').value;
    }
    if(!(value == null || value == '')){
        url = 'visao/AjaxPaciente.php?id='+idCpf+'&cpf='+value;
    }else{
        url = 'visao/AjaxPaciente.php?id='+idCpf+'&cpf=""';
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }

    else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(id).innerHTML=xmlhttp.responseText;
            document.getElementById(str).value = "";
        }
    }

    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}