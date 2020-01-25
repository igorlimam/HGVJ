function setDate(idCampo){
	var date = new Date();
	
	document.getElementById(idCampo).value = date.getFullYear()+'-'+date.getMonth()+1+'-'+date.getDate()+' '+date.getHours()+":"+date.getMinutes()+':'+date.getSeconds();
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