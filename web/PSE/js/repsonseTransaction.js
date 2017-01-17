$(document).ready(function() {
	$("#buttonEesponseTransaction").kendoButton();
    $("#textTransactionId").kendoMaskedTextBox({});

    $("#buttonEesponseTransaction").click(function(){
        getStateTransaction(1444379358);
    });
});

function getStateTransaction(transactionID){
	$("#div_loading").show();
    doAjax(
        "placetopay/transaction/info/"+transactionID,
        "GET",
        null,
        function(data){
        	if(data.getTransactionInformationResult){
	        	if(data.getTransactionInformationResult.responseReasonText){
	        		$("div#div_text_response").html(data.getTransactionInformationResult.responseReasonText);
	        	}
        	}
        	$("#div_loading").hide();
        	console.log(data);
        }
    );
}