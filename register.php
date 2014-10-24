<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: ../user/dashboard.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($first_name,$last_name,$password,$email);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}

require_once("models/header.php");
?>

<style>
	.show {
		display: block;
	}
	.hide {
		display: none;
	}
</style>

<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container"
		<div class="row">
			<?php echo resultBlock($errors,$successes); ?>
			<form name='newUser' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				<h1>Account Registration</h1>
				<div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
          <div class="form-group">
              <label>First name</label>
              <input type="text" class="form-control" name="first_name" placeholder="First name" />
          </div>
          <div class="form-group">
              <label>Last name</label>
              <input type="text" class="form-control" name="last_name" placeholder="Last name" />
          </div>

          <div class="form-group">
              <label>Email address</label>
              <input type="text" class="form-control" name="email" />
          </div>

          <div class="form-group">
              <label>Password</label>
                  <input type="password" class="form-control" name="password" />
          </div>

          <div class="form-group">
              <label>Retype password</label>
              <input type="password" class="form-control" name="passwordc" />
          </div>
            
					 <div class="form-group">
              <label id="captchaOperation"></label>
              <input type="text" class="form-control" name="captcha" placeholder="Enter answer" />
          </div>
					
					<input type='submit' value='Register' class="btn btn-success"/>
				</div>
			</form>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
<script>
$(document).ready(function() {
    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    
    
    $('.forms').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
            email: {
	            notEmpty: {
                      message: 'Email address is required'
                  },
                validators: {
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            passwordc: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            }
        }
    });
});	
</script>
</html>
