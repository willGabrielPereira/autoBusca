function generateXMLHttp() {
	if (typeof XMLHttpRequest != "undefined"){
		return new XMLHttpRequest();
	}
	else{	
	 	if (window.ActiveXObject){
			var versions = ["MSXML2.XMLHttp.5.0", 
		                 "MSXML2.XMLHttp.4.0", 
                         "MSXML2.XMLHttp.3.0",
		                 "MSXML2.XMLHttp", 
		                 "Microsoft.XMLHttp"
		               	];
		}
	}
	for (var i=0; i < versions.length; i++){
		try{
			return new ActiveXObject(versions[i]);
		}catch(e){}
	}
	alert('Seu navegador não pode trabalhar com Ajax!');
}

function cidadePorEstado(){
	var formInsert   = document.forms[0];
	var fieldsValues = generateFieldsValues(formInsert);
	var result       = document.getElementById("cidade");
 
	var XMLHttp = generateXMLHttp();
	XMLHttp.open("post", "ajax/cidadePorEstado.php", true);
	XMLHttp.setRequestHeader("Content-Type", 
	          "application/x-www-form-urlencoded");
 
	XMLHttp.onreadystatechange = function (){
		if(XMLHttp.readyState == 4)
			result.innerHTML = XMLHttp.responseText;
		else
			result.innerHTML = "Um erro ocorreu: " + XMLHttp.statusText;
	};
	XMLHttp.send(fieldsValues);
}

function generateFieldsValues(formInsert){
	var strReturn = new Array();
 
	for(var i=0; i < formInsert.elements.length; i++){
		var str = encodeURIComponent(formInsert.elements[i].name);
		str    += "=";
		str    += encodeURIComponent(formInsert.elements[i].value);
		strReturn.push(str);
	}
	return strReturn.join("&");
}