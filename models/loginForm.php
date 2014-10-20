<form name='login' action='login.php' method='post' class="forms text-centered" id="loginForm">
	<h3>Login</h3>
  <div class="form-group">
      <label>Email address</label>
      <input type="text" class="form-control" name="email" />
  </div>

  <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" name="password" />
  </div>
	<input type='submit' value='Login' class="btn btn-success" /> 
	<a href='register.php' class='small'>Register</a> | <a href='forgot-password.php' class='small'>Forgot Password</a>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        //group: '.form-group',
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Your email is required to log in'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required to login'
                    }
                }
            }
        }
    });
});
</script>