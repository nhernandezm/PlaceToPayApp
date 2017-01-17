$(document).ready(function() {

	var url = "http://localhost:8080/PlaceToPayApp/web/app_dev.php/";
	if (typeof(Storage) !== "undefined") {
	 
	} else {
	    alert("No se puede ralizar la transacciòn, este navegador no soporta localStorage");
	}

	var userAgentTransaction = navigator.userAgent;
	localStorage.setItem("userAgentTransaction",userAgentTransaction);
	localStorage.setItem("urlPrincipalPlaceTopay",url);
	$.getJSON('//freegeoip.net/json/?callback=?', function(data) {
	  var dataIp = data;
	  localStorage.setItem("ipAddressTransaction",dataIp["ip"]);
	});
});

// Realizar ajax
function doAjax(url,type,data,fnSucces){

    var urlPrincipal = localStorage.getItem("urlPrincipalPlaceTopay");
    var allUrlPrincipal = urlPrincipal+""+url;
    if(type == "POST" && data){
        data = JSON.stringify(data);
    }
    $.ajax({
        type: type,     
        url: allUrlPrincipal,
        data: data,
        contentType: 'application/json',
        dataType: "json",                       
        success: function (data) {
            fnSucces.call(this,data);
        },
        error: function(xhr, status, error) {   
            if (xhr.responseJSON)
            {
                alert(hxr.responseJSON.message);
            }
        }
    });
}