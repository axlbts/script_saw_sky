$("form").submit(function (e) {
    e.preventDefault();
    var donnees = $(this).serialize();



    $.get("./Php/requete.php", donnees, function (data) {

    })

});


