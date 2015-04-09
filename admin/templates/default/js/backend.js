// JavaScript Document
$(document).ready(function() { 

   // CK Editor
   editor = document.getElementById("editor");
   if (editor) {
       CKEDITOR.replace( 'editor', {
         enterMode : CKEDITOR.ENTER_BR,
         entities_latin : false,
         entities_greek : false,
         uiColor : '#ffffff',
         extraPlugins : 'autogrow',
         autoGrow_minHeight : 400,
         toolbar: [
            [ 'Source'],
            [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
            [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ],
            [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
            [ 'Link', 'Unlink' ],
            [ 'Image', 'Table', 'SpecialChar' ], '/',
            [ 'Format', 'Font', 'FontSize' ],
            [ 'TextColor', 'BGColor' ]
         ]
      });
   }
   
   $('header').prepend($('.tools').html()).css("padding-top","10px");
   
   var datepicker = $('.datepicker').pikaday({
        firstDay: 1,
        yearRange: [2014,2030],
        format: 'YYYY-MM-DD'
   });
   
   $('.delete-confirm').hide();
   
   loaded();
});

function openKCFinder(field, subfolder) {
    window.KCFinder = {
        callBack: function(url) {
            $('#'+field).val(url);
            window.KCFinder = null;
            finder_file_selected();
        }
    };
    kc = window.open(_C.livesite+'/plugins/finder/browse.php?type=files&dir=/uploads/files'+subfolder, 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=1000, height=700'
    );
}
function finder_file_selected(){
   kc.close();
   $('#browse_button').addClass('success');
   $('#browse_button').html('<i class="fa fa-check"></i> Fájl ki lett jelölve!');
}

// Convert Input value to URL ID
function convert_url_id(input_id, url_input_id){ 
   var dirty_url_id = $(input_id).val();
   var clean_url_id = dirty_url_id.toLowerCase();
   clean_url_id = clean_url_id.replace(/á/gi,'a');
   clean_url_id = clean_url_id.replace(/é/gi,'e');
   clean_url_id = clean_url_id.replace(/ú/gi,'u');
   clean_url_id = clean_url_id.replace(/ű/gi,'u');
   clean_url_id = clean_url_id.replace(/ü/gi,'u');
   clean_url_id = clean_url_id.replace(/ó/gi,'o');
   clean_url_id = clean_url_id.replace(/ö/gi,'o');
   clean_url_id = clean_url_id.replace(/ő/gi,'o');
   clean_url_id = clean_url_id.replace(/í/gi,'i');
   clean_url_id = clean_url_id.replace(/ä/gi,'a');
   clean_url_id = clean_url_id.replace(/ß/gi,'ss');
   clean_url_id = clean_url_id.replace(/\./g,'');
   clean_url_id = clean_url_id.replace(/\,/g,'');
   clean_url_id = clean_url_id.replace(/[^a-z0-9]+/gi,'-');
   $(url_input_id).val(clean_url_id);
};

function loading() {
   $('.loading').fadeIn(50);
}
function loaded() {
   $('.loading').fadeOut(50);
}

function del_confirm(id){
   $('#delete-confirm-button-'+id).hide();
   $('#delete-confirm-'+id).fadeIn(200);
}

function disable_controls() {
   $("a.button").attr("disabled", "disabled");
   $("button.button").attr("disabled", "disabled");
   $("input").attr("readonly", true);
   $("input[type='file']").attr("disabled", "disabled");
   $("input[type='submit']").attr("disabled", "disabled");
}

function enable_controls() {
   $("a.button").removeAttr("disabled");
   $("button.button").removeAttr("disabled");
   $("input").removeAttr("readonly");
   $("input.readonly").attr("readonly", true);
   $("input[type='file']").removeAttr("disabled");
   $("input[type='submit']").removeAttr("disabled");
}

// Check Field
function check(field_id, table) {
   field = $('#'+field_id).val();
   loading();
   $.ajax({
     type: "POST",
     url: _C.liveadmin+"/modules/"+_C.module+"/ajax.php",
     data: {secure : _C.secure, command : 'check_'+field_id, table:table, field : field},
     dataType : 'json',
   }).done(function(data) {
      loaded();
      if (data.response=='false') {
         notify('alert', data.notify_false, 1500);
         $("#submit").attr("disabled", "true");
      } else {
         if (data.notify_true!='') {
            notify('success', data.notify_true, 1500);
         }
         $("#submit").removeAttr("disabled");
      }
   });
}

// Save Document
function save(form_id, id, table, re) {
   re = typeof re !== 'undefined' ? re : 'not-reload';
   CKupdate();
   loading();
   $("#submit").off().attr('onclick', 'save('+form_id+', '+id+', '+table+', '+re+')');
   $('#'+form_id).on('valid', function () {
      var submitdata = $("#"+form_id).serializeArray();
      disable_controls();
      $.ajax({
        type: "POST",
        url: _C.liveadmin+"/modules/"+_C.module+"/ajax.php",
        data: {secure : _C.secure, command : 'save', id : id, table:table, submitdata : submitdata},
        dataType : 'json',
      }).done(function(data) {
        loaded();
        enable_controls();
        if (data.response=='true'){
           notify('success', data.notify, 1500);
        } else {
           notify('alert', data.notify, 1500);
        }
        if (re!='not-reload') {
           location.href = _C.liveadmin+data.reload_url;
        }
      });
   });
}

// Remove Document
function del(table, id){
   loading();
   $.ajax({
     type: "POST",
     url: _C.liveadmin+"/modules/"+_C.module+"/ajax.php",
     data: {secure : _C.secure, command : 'delete', id : id, table:table},
     dataType : 'json',
   }).done(function(data) {
     loaded();
     $('#object_'+id).fadeOut(300);
   });
}

// Change user password
function change_user_password(id) {
   loading();
   password = $('#password').val();
   if (password!='') {
      $.ajax({
        type: "POST",
        url: _C.liveadmin+"/modules/users/ajax.php",
        data: {secure : _C.secure, command : 'change_user_password', id : id, password : password},
        dataType : 'json',
      }).done(function(data) {
        loaded();
        if (data.response=='true'){
           notify('success', data.notify, 1500);
        } else {
           notify('alert', data.notify, 1500);
        }
      });
   }
};