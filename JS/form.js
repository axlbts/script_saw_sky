$("form").submit(function (e) {
    e.preventDefault();
    var donnees = $(this).serialize();

    var inPrix = $("#input-prix").val();
    var inDistance = $("#input-distance").val();
    var inNbet = $("#input-nbet").val();

    if( !inPrix | !inDistance | !inNbet ){
		alert('erreur remplissage');
	}else 
	if( inPrix + inDistance + inNbet != 100){
	alert('erreur égalité');
	}else{
		$.get("./Php/requete.php", donnees, function (data) {
    	if(data == 'Erreur somme'){
    		alert('Erreur somme');
    	}
    })
	}

});

function reg(){
	if(event.keyCode <= 48 | 57 >= event.keyCode){
		return true;
	}else{
		return false;
	}
};

$('#input-prix').keypress(function(e){
	console.log(e.keyCode);
	var reg = new RegExp('^[0-9]+$');
	if(e.keyCode == reg){
		return true;
	}else{
		return false;
	}
});