$(document).ready(function() {    
    $(document).foundation({
        abide : {
            live_validate : true,
            focus_on_invalid : true,
            error_labels: true, // labels with a for="inputId" will recieve an `error` class
            timeout : 1000,
            patterns : {
               url_id: /^[a-zA-Z0-9-]+$/
            }
        }
    });
    
    console.log( "C3KAITEN document is ready!" );
});

// Notify
function notify(type, note, delay) {
    $('.notify').html('<div data-alert class="alert-box '+type+'" align="center">'+note+'</div>');
    $('.notify').fadeIn(200).delay(delay).fadeOut(200);
}

function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}