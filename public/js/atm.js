$(document).ready(function(){
    var token = $('#searchForm input[name="_token"]').val();
    var prefix = "https://atm.technomegaparteners.com/atm/public";
   // var prefix = "https://localhost:8003/";
    var taxeListe = '';
    var total = 0;
    function displayContribTaxes(search, container){
        $.ajax({
            type: "POST",
            url: prefix+"/getListesTaxes",
            data: {
                contribuable : search,
                _token : token
            },
            success: function(r){
                $(container).html("");
                if(r){
                    if(r.length){
                        total = 0;                        
                        var penalite = 0;  
                        taxeListe = '';                      
                        r.forEach(function(item){
                            total +=  item.pivot.montant;
                             var line = "<tr><td>"+item.code_taxe+"</td><td>"+item.libelle_taxe+"</td><td>"+item.pivot.montant+"</td></tr>";
                            $(container).append(line);
                            taxeListe += item.id+' ';
                        });
                        $("#penalite").html(penalite);
                        $("#total").html(total+penalite);
                        $("#montantEnc").html(total+penalite);
                        $("#idContribuable").val(search);
                    }else{
                        var line = "<tr ><td colspan=3 style='color: dodgerblue; font-style:italic'>Aucune taxe renseignee pour ce contribuable</td></tr>";
                        $(container).append(line);
                    }
                }else{
                    var line = "<tr><td colspan=3 style='color: red; font-style:italic'>La recherche a echoue; Actualisez la page SVP</td></tr>";
                    $(container).append(line);
                }
            },
            dataType: 'json'
        });
    }

    function resetData(){
        $("#penalite").html("0");
        $("#total").html( " 0");
        $("#contribuable-table-body").html("");
        $("#listetaxe-table-body").html("");
        $("#montantRecu").val(0);
        $("#reliquat").val(0);
    }


    $( "#find" ).keyup(function(e) {

        resetData();
        $.ajax({
            type: "POST",
            url: prefix+"/chercherContribuable",
            data: {
                searchval : $(e.target).val(),
                _token : token
            },
            success: function(res){
                $("#contribuable-table-body").html("");
                if(res){
                    if(res.length){
                        res.forEach(function(item){
                            var line = "<tr id='"+item.id+"'><td>"+item.matricule+"</td><td>"+item.nom+' '+item.prenoms+"</td><td>"+item.tel+"</td></tr>";
                            $("#contribuable-table-body").append(line);
                            $("#"+item.id).click(function(e){
                                console.log(item);
                                displayContribTaxes(item.id,"#listetaxe-table-body");
                            });                      
                        });
                    }else{
                        var line = "<tr ><td colspan=3 style='color: dodgerblue; font-style:italic'>Aucun enregistrement ne correspond</td></tr>";
                        $("#contribuable-table-body").append(line);
                    }                    
                }else{
                    var line = "<tr><td colspan=3 style='color: red; font-style:italic'>La recherche a echoue; Actualisez la page SVP</td></tr>";
                    $("#contribuable-table-body").append(line);
                }
            },
            dataType: 'json'
        });
    });

    $("#montantRecu").keyup(function(e){
        $("#montantRecu").val(parseFloat($("#montantRecu").val()));        
         $("#reliquat").val(parseFloat($("#montantRecu").val()) - parseFloat($("#total").html()) );
    });

    $("#btnSendData").click(function(e){
        e.preventDefault();
         var dataPayload = {
            idUser : $("#idUser").val(),
            idContribuable : $("#idContribuable").val(),
            idHotel : $("#idHotel").val(),
            idTaxe :  taxeListe.trim() ,
            montantEnc : $("#montantEnc").html(),
            penalite : $("#penalite").html(),
            _token : token
        };

        console.log($('#montantRecu').val());
        console.log(total);
        if($('#montantRecu').val() > total){
            $.ajax({
                type: "POST",
                url: prefix+"/saveContribuable",
                data: dataPayload,
                success: function(res){            
                    if(res){
                        $('#modalMessage').html("Encaissement enregistré avec succes"); 
                        $('#myModal').modal('show'); 
                        resetData();
                    }else{
                        $('#modalMessage').html("Erreur : L'encaissement n'est pas enregistre"); 
                        $('#myModal').modal('show'); 
                    }
                },
                dataType: 'json'
            });
        }else{
            alert('Montant encaissé incorrect');
        }
    });


    $('#print-stats').on('click',function(){
        $("#framepdf").attr("src",prefix + "printstats");
        $(".pdfcontainer").show();
    });

})


