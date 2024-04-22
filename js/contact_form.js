//$("#contactForm").on("submit",function(event){event.preventDefault()})

$( '.js-input' ).keyup(function() {
    if( $(this).val() ) {
       $(this).addClass('not-empty');
    } else {
       $(this).removeClass('not-empty');
    }
});

function SendMail(){
   var name_ = $("#name").val();
   var email_ = $("#email").val();
   var subject_ = $("#subject").val();
   var message_ = $("#message").val();

   if(name_.replace(" ", "") != "" && email_.replace(" ", "") != "" && subject_.replace(" ", "") != "" && message_.replace(" ", "") != ""){

      $.ajax({
         url: "./inc/send_email.php",
         method: "POST",
         data: {name: name_, email: email_, subject: subject_, message: message_},
         success: function(data){
            $("#contactError").remove();
            $("#contactForm").after(data);
         }
      });

   }
}