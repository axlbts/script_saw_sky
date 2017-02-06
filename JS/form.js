$("form").submit(function (e) {
    e.preventDefault();
    var donnees = $(this).serialize();

    $('#resultat_recherche').remove("");

    var inPrix = $("#input-prix").val();
    var inDistance = $("#input-distance").val();
    var inNbet = $("#input-nbet").val();

    console.log(inPrix);
    console.log(inDistance);
    console.log(inNbet);
    
    if( !inPrix | !inDistance | !inNbet ){
		alert('erreur remplissage');
	}else 
	    inPrix = parseInt($("#input-prix").val());
    	inDistance = parseInt($("#input-distance").val());
    	inNbet = parseInt($("#input-nbet").val());
    	var test = inPrix + inDistance + inNbet;
	if( test != 100){
	alert('erreur égalité');
	}else{
		$.ajax({
			url : './Php/requete.php',
			type : 'GET',
			data : donnees,
			dataType : 'json',
			success : function(data){
				if(data == 'Erreur somme'){
    		alert('Erreur somme');
    		}
    			//alert(data);

    			tab_resultat(data);
			}


	
})
/*		$.get("./Php/requete.php", donnees, function (data) {
    	if(data == 'Erreur somme'){
    		alert('Erreur somme');
    	}
    })*/
	}

});




$('#input-prix, #input-distance, #input-nbet').keydown(function(e){
	if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46){ 
		return true;
	}else{
		return false;
	}
});




function tab_resultat(data){


	$('.container').append("<div id='resultat_recherche'><h2>Résultat de votre recherche : </h2>");
	$('#resultat_recherche').append("<table id='tab_resultat' class='table table-bordered'>" +
								"<tr>" +
									"<th></th>" +
									"<th>Prix</th>" +
									"<th>Distance</th>" +
									"<th>NbEt</th>" +
								"</tr>" +
								"<tr>" +

								"</tr>" +
							"</table>");

	//alert(data.length);

	for(i=0; i<data.length;++i){
		$('#tab_resultat').append("<tr>" +
									"<th>"+ data[i].IdH +"</th>" +
									"<th>"+ data[i].Prix +"</th>" +
									"<th>"+ data[i].Distance +"</th>" +
									"<th>"+ data[i].NbEt +"</th>" +
								"</tr>")
	}
	$('.container').append("</div");

}