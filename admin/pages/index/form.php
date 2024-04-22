<!-- Login Form -->
<form method="post">
	<div class="input-group custom input-group-lg">
		<input type="email" id="myemail" maxlength="75" name="email" class="form-control" placeholder="Email" onkeyup="mail_control()" value="<?php echo $cookie_email; ?>">
		<div class="input-group-append custom">
			<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
		</div>
	</div>
	<div class="input-group custom input-group-lg">
		<input type="password" name="password" maxlength="50" class="form-control" placeholder="Password">
		<div class="input-group-append custom">
			<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
		</div>
        <div class="form-check form-check-flat mt-0">
            <label class="form-check-label" style="font-size: 0.875rem;line-height: 1.5;padding-left: 10px;">
            <input type="checkbox" name="keep" class="form-check-input" value="Keep" checked> Keep me!</label>
        </div>
	</div>
	<div class="row" style="justify-content: center;">
		<div class="col-sm-6">
			<div class="input-group">
				<input class="btn btn-outline-primary btn-lg btn-block" type="submit" value="Sign Up">
			</div>
		</div>
	</div>
</form>

<!-- Mail Values Control -->
<script>
  function control(){
    var email = $("#myemail").val();
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
  
  function mail_control(){
    var a = control();
    if(a === true){
      $("#myemail").css("background-color","#19d89587");
    }else if(a != true) {
      $("#myemail").css("background-color","#ffe0de");
    }
  }
</script>
<!-- end Mail Values Control -->