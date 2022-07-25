
$(document).ready(function(){
        console.log("register")
        $("#register_pro").on("click", function (){

            if($('#register_pro').is(":checked")) {
                console.log("pro");
                $('#suivant_register').empty();
                //$('#suivant_register').innerHTML = '''<button style="margin: 20px" class="btn btn-lg btn-primary" type="submit"> Inscription </button>''';
                $('#suivant_register').append("<button style=" + "margin: 20px class=" + '"btn btn-lg btn-primary"' + 'type="submit">' + 'Suivant </button>');
                // $('form[name="register"]').append("<div>form stripe</div>");
            } else {
                console.log("pas pro")
                $('#suivant_register').empty();
                //$('#suivant_register').innerHTML = '''<button style="margin: 20px" class="btn btn-lg btn-primary" type="submit"> Inscription </button>''';
                //$('#suivant_register').append("<button style=" + "margin: 20px class=" + '"btn btn-lg btn-primary"' + 'type="submit">' + 'Suivant </button>');
                $('#suivant_register').append("<button style=" + "margin: 20px class=" + '"btn btn-lg btn-primary"' + 'type="submit">' + 'Inscription </button>');

            }
        })
    }
);

