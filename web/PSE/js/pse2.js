$(document).ready(function() {

    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("clientPayerId","");
        localStorage.setItem("clientPayerDocument","");
        localStorage.setItem("clientPayerDocumentType","");

        localStorage.setItem("clientBuyerId","");
        localStorage.setItem("clientBuyerDocument","");
        localStorage.setItem("clientBuyerDocumentType","");
    } else {
        alert("No se puede ralizar la transacciòn, este navegador no soporta localStorage");
    }

	$("#bank").kendoComboBox({
        dataTextField: "bankName",
        dataValueField: "bankCode",
        dataSource: [],
        filter: "contains",
        suggest: true,
        index: 3
    });

    $("#typePerson").kendoComboBox({
        dataTextField: "text",
        dataValueField: "value",
        dataSource: [{text:"Persona natural",value:0},{text:"Persona juridica",value:1}],
        filter: "contains",
        suggest: true,
        index: 3,
        change: function(e) {
            /*var value = this.value();
            if(value == 0){
                $("#labelIde").html("Idetificaciòn:");
            }
            if(value == 1){
                $("#labelIde").html("NIT:");
            }*/
        }
    });

    $("#buttonCreateTran").kendoButton();
    $("#buttonNewClient").kendoButton();
    $("#textIdentificationPayer").kendoMaskedTextBox({});
    $("#textIdentificationBuyer").kendoMaskedTextBox({});
    $("#textValue").kendoNumericTextBox({
        decimals: 1
    });
    $("#textReference").kendoMaskedTextBox({});
    doAjax("placetopay/listbanks","GET",null,function(data){
        loadBankToCombo(data);
    });

    $("#buttonNewClient").click(function(){
        newClient();
    });

    $("#buttonCreateTran").click(function(){
        validateDataTransaction();
    });
});

function validateDataTransaction(){
    var documentClientBuyer = $("#textIdentificationBuyer").data("kendoMaskedTextBox");
    var documentClientBuyerV = $.trim(documentClientBuyer.value());

    var documentClientPayer = $("#textIdentificationPayer").data("kendoMaskedTextBox");
    var documentClientPayerV = $.trim(documentClientPayer.value());

    var value = $("#textValue").data("kendoNumericTextBox");
    var valueV = value.value();

    var reference = $("#textReference").data("kendoMaskedTextBox");
    var referenceV = $.trim(reference.value());


    var bank = $("#bank").data("kendoComboBox");
    var typePerson = $("#typePerson").data("kendoComboBox");

    var bankV = bank.value();
    var typePersonV = typePerson.value();

    if(bankV){
        if(typePersonV){
            if(documentClientBuyerV && documentClientPayerV){
                if(valueV){
                    if(referenceV){
                        validateBuyerAndPayer(
                            documentClientBuyerV,
                            documentClientPayerV,
                            bankV,
                            typePersonV,
                            valueV,
                            referenceV);
                     }else{
                        alert("Ingresar la referencia de pago");
                    }
                }else{
                    alert("Ingresar el valor");
                }
            }else{
                alert("Ingrese la identificaciòn del Pagador y del Comprador");
            }   
        }else{
            alert("Debe seleccionar el tipo de Persona");
        }
    }else{
        alert("Debe seleccionar un banco");
    }
}

//Cargar comboBox de banco
function loadBankToCombo(data){
    var listOK = false;
    if(data){
        if(data.getBankListResult){
            if(data.getBankListResult.item){
                if(data.getBankListResult.item.length > 0){
                    var bankList = data.getBankListResult.item;
                    var dataSource = new kendo.data.DataSource({
                      data: bankList
                    });
                    var combobox = $("#bank").data("kendoComboBox");
                    combobox.setDataSource(dataSource);
                }else{
                   listOK = true; 
                }
            }
        }
    }
    if(listOK){
        alert("No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde");
    }
}

//Nuevo cliente
function newClient(){

    $("#typeIdentification").kendoComboBox({
        dataTextField: "text",
        dataValueField: "value",
        dataSource: [{text:"Cedula de Ciudadania",value:"CC"},{text:"NIT",value:"NIT"}],
        filter: "contains",
        suggest: true,
        index: 3
    });
    $("#identification").kendoMaskedTextBox({});
    $("#name").kendoMaskedTextBox({});
    $("#lastName").kendoMaskedTextBox({});
    $("#email").kendoMaskedTextBox({});
    $("#address").kendoMaskedTextBox({});
    $("#phone").kendoMaskedTextBox({});
    $("#telephone").kendoMaskedTextBox({});
    $("#company").kendoMaskedTextBox({});
    $("#city").kendoMaskedTextBox({});
    $("#province").kendoMaskedTextBox({});
    $("#country").kendoMaskedTextBox({});

    $("#buttonCreateClient").kendoButton();

    var myWindow = $("#windowNewClient");
    myWindow.kendoWindow({
        width: "800px",
        title: "Nuevo Cliente",
        visible: false,
        actions: [
            "Pin",
            "Minimize",
            "Maximize",
            "Close"
        ],
        close: function(){
            console.log("Cancelar cliente");
        }
    }).data("kendoWindow").center().open();

    $("#buttonCreateClient").click(function(){
        saveClient();
    });
}

function saveClient(){
    var validateJson = validateClient();
    if(validateJson){
        doAjax(
            "placetopay/person/create",
            "POST",
            validateJson,
            function(data){
                if(data.id){
                    alert("Cliente guardado.");
                    var windowNewClient = $("#windowNewClient").data("kendoWindow");
                    windowNewClient.close();
                    localStorage.setItem("clientId",data.id);
                    localStorage.setItem("clientDocument",data.document);
                    localStorage.setItem("clientDocumentType",data.documentType);
                }
            }
        );
    }
}

function validateClient(){

    var jsonClient = {};
    var isOkFrom = true;

    var typeIdentification = $("#typeIdentification").data("kendoComboBox");
    var identification = $("#identification").data("kendoMaskedTextBox");
    var name = $("#name").data("kendoMaskedTextBox");
    var lastName = $("#lastName").data("kendoMaskedTextBox");
    var email = $("#email").data("kendoMaskedTextBox");
    var address = $("#address").data("kendoMaskedTextBox");
    var phone = $("#phone").data("kendoMaskedTextBox");
    var telephone = $("#telephone").data("kendoMaskedTextBox");
    var company = $("#company").data("kendoMaskedTextBox");
    var city = $("#city").data("kendoMaskedTextBox");
    var province = $("#province").data("kendoMaskedTextBox");
    var country = $("#country").data("kendoMaskedTextBox");

    var typeIdentificationV =  $.trim(typeIdentification.value());
    var identificationV =  $.trim(identification.value());
    var nameV =  $.trim(name.value());
    var lastNameV =  $.trim(lastName.value());
    var emailV =  $.trim(email.value());
    var addressV = $.trim(address.value()); 
    var phoneV =  $.trim(phone.value());
    var telephoneV = $.trim(telephone.value()); 
    var companyV =  $.trim(company.value());
    var cityV =  $.trim(city.value());
    var provinceV = $.trim(province.value()); 
    var countryV =  $.trim(country.value());


    jsonClient.documentType = typeIdentificationV;
    jsonClient.document = identificationV;
    jsonClient.firstName = nameV;
    jsonClient.lastName = lastNameV;
    jsonClient.emailAddress = emailV;
    jsonClient.address = addressV;
    jsonClient.mobile = phoneV;
    jsonClient.phone = telephoneV;
    jsonClient.company = companyV;
    jsonClient.city = cityV;
    jsonClient.province = provinceV;
    jsonClient.country = countryV;

    if(typeIdentificationV){

    }else{
        alert("Tipo de Idetificaciòn es requerida.");
        isOkFrom = false;
    }

    if(identificationV  || !isOkFrom){

    }else{
        alert("Idetificaciòn es requerida.");
        isOkFrom = false;
    }

    if(nameV || !isOkFrom){

    }else{
        alert("Nombre es requerida.");
        isOkFrom = false;
    }

    if(lastNameV || !isOkFrom){

    }else{
        alert("Apellidos es requerida.");
        isOkFrom = false;
    }

    if(emailV || !isOkFrom){

    }else{
        alert("Email es requerida.");
        isOkFrom = false;
    }
    if(isOkFrom){
        return jsonClient;
    }else{
        return false;
    }
}

function validateBuyerAndPayer(documentClientBuyer,documentClientPayer,bank,typePerson,value,reference){
    $("#div_loading").show();
    doAjax(
        "placetopay/person/validate/"+documentClientBuyer+"/"+documentClientPayer,
        "GET",
        null,
        function(data){
            if(data.buyer && data.payer){            
                localStorage.setItem("clientId",data.id);
                localStorage.setItem("clientDocument",data.document);
                localStorage.setItem("clientDocumentType",data.documentType);

                localStorage.setItem("clientPayerId",data.payer.id);
                localStorage.setItem("clientPayerDocument",data.payer.document);
                localStorage.setItem("clientPayerDocumentType",data.payer.documentType);

                localStorage.setItem("clientBuyerId",data.payer.id);
                localStorage.setItem("clientBuyerDocument",data.payer.document);
                localStorage.setItem("clientBuyerDocumentType",data.payer.documentType);
                data.value = value;
                data.reference = reference;
                data.bank = bank;
                data.typePerson = typePerson;
                data.ipAddressClient = localStorage.getItem("ipAddressTransaction");
                data.userAgent = localStorage.getItem("userAgentTransaction");
                createTransaction(data);
            }else{
                $("#div_loading").hide();
                alert(data.mensaje);
            }
        }
    );
}

function createTransaction(dataClient){
    doAjax(
        "placetopay/createtransaction",
        "POST",
        dataClient,
        function(data){
            if(data.returnCode == "SUCCESS"){
                $("#div_loading").hide();
                window.location.href = data.bankURL;
            }else{
                alert(data.responseReasonText);                
            }
            $("#div_loading").hide();
        }
    );
    
}