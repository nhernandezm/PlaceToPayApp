$(document).ready(function() {
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
            var value = this.value();
            if(value == 0){
                $("#labelIde").html("Idetificaciòn:");
            }
            if(value == 1){
                $("#labelIde").html("NIT:");
            }
        }
    });

    $("#buttonCreateTran").kendoButton();
    $("#buttonNewClient").kendoButton();
    $("#textIdentification").kendoMaskedTextBox({});
    doAjax("http://localhost:8080/PlaceToPayApp/web/app_dev.php/placetopay/listbanks","GET",null,function(data){
        loadBankToCombo(data);
    });

    $("#buttonNewClient").click(function(){
        newClient();
    });


});

// Realizar ajax
function doAjax(url,type,data,fnSucces){

    if(type == "POST" && data){
        data = JSON.stringify(data);
    }
    $.ajax({
        type: type,     
        url: url,
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

//Cargar comboBox de banco
function loadBankToCombo(data){
    console.log("combo",data);
    if(data){
        if(data.getBankListResult){
            if(data.getBankListResult.item){
                var bankList = data.getBankListResult.item;
                var dataSource = new kendo.data.DataSource({
                  data: bankList
                });
                var combobox = $("#bank").data("kendoComboBox");
                combobox.setDataSource(dataSource);

            }
        }
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
            "http://localhost:8080/PlaceToPayApp/web/app_dev.php/placetopay/person/create",
            "POST",
            validateJson,
            function(data){
                if(data.id){
                    alert("Cliente guardado.");
                    var windowNewClient = $("#windowNewClient").data("kendoWindow");
                    windowNewClient.close();
                }
            });
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