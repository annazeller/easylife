//var attendee_template = Handlebars.compile($('#attendee-template').html());

jQuery(function(){
 jQuery('#datetime_start').datetimepicker({
  format:'d.m.Y H:i',
  formatDate:'d.m.Y',
  formatTime:'H:i',
  dayOfWeekStart:1,
  onShow:function( ct ){
   this.setOptions({
    maxDateTime:jQuery('#datetime_end').val()?jQuery('#datetime_end').val():false,
    format:'d.m.Y H:i',
    formatDate:'d.m.Y',
    formatTime:'H:i',
    dayOfWeekStart:1,
   })
  }
 });
 jQuery('#datetime_end').datetimepicker({
  format:'d.m.Y H:i',
  formatDate:'d.m.Y',
  formatTime:'H:i',
  dayOfWeekStart:1,
  onShow:function( ct ){
   this.setOptions({
    minDateTime:jQuery('#datetime_start').val()?jQuery('#datetime_start').val():false,
    format:'d.m.Y H:i',
    formatDate:'d.m.Y',
	formatTime:'H:i',
	dayOfWeekStart:1,
   })
  }
 });
});

$.datetimepicker.setLocale('de');

$('#attendees').on('blur', '.email', function(){

    var attendee_row = $('.attendee-row:last');
    var name = attendee_row.find('.name').val();
    var email = attendee_row.find('.email').val();

    var attendeeTemplate = "<div class='attendee-row'><input type='text' name='attendee_name[]' class='half-input name' placeholder='Name' autocomplete='name'><input type='email' name='attendee_email[]' class='half-input email' placeholder='Email' autocomplete='email'></div>"

    if(name && email){
        $( '#attendees' ).append( attendeeTemplate );
    }
});