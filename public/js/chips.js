$(document).ready(function(){


    var valueInit = $('.tag-input').val()

    var tab = valueInit.split(',');
    console.log(tab);

    $(tab).each(function(index, element){
        console.log(index,element)
        if(element !== '') {
            $('.chips').prepend("<div class=\"chip\" tabindex=\"0\">" + element + "<i class=\"material-icons close\">close</i></div>")
        }
    })
    $('.tag-input').val('');
    $('.chips').chips({
        placeholder: 'Enter a tag',
        secondaryPlaceholder: '+Tag',
    });


    $('.save').on("click", function(e){
        var valueFinal = ""
        $('.chip').each(function(i){
            var value = $(this).text()
            values = value.replace('close','')
            valueFinal += values + ','
        })
        $('.tag-input').val(valueFinal)
    });

    $('.chip').on("click", function(){
        console.log($(this));
         $(this).remove();
    })
    
});