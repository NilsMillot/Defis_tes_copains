$(document).ready(function() {

    var usersToAdd = [];

    $('.search_result').on("click", function() { usersToAdd.push($(this).prop("innerText")); console.log("usersToAdd", usersToAdd);});
    
    //var tab = valueInit.split(',');

    /*$(tab).each(function (index, element) {
        if (element !== '') {
            $('.chips').prepend("<div class=\"chip\" tabindex=\"0\">" + element + "<i class=\"material-icons close\">close</i></div>")
        }
    })
    $('.tag-input').val('');
    $('.chips').chips({
        placeholder: 'Enter a tag',
        secondaryPlaceholder: '+Tag',
    });*/

});
