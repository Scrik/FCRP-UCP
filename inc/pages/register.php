<span class="label label-inverse"><i class="icon-share-alt icon-white"></i>Register an account!</span>
<?php
if(isset($_SESSION['Logged'])) header("Location: ?page=ucp");
?>
<div class="jumbotron">
			<div style="font-size: 14px; font-weight: bold; padding-top: 2%; padding-left: 1%;">
			<form method="POST">
                <fieldset>
				<?php
				if(isset($_POST['register']))
				{	
					if(!isset($_POST['rules'])) 
					{
						echo GetMessage("ERROR:", "You did not read and understood the server rules.", 4);
					}
						
					else if(isset($_POST['username']) && !IsAvailableName($_POST['username']))
						echo GetMessage("ERROR:", "Username is already in-use.", 4);
						
					else if(strlen($_POST['username']) > 24)
						echo GetMessage("ERROR:", "Name is invalid (bigger than 24 characters)", 4);
						
					else if(isset($_POST['email']) && !IsAvailableEmail($_POST['email']))
						echo GetMessage("ERROR:", "Email Address is already in-use.", 4);
						
					else if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['question_1']) || !isset($_POST['question_2']) || !isset($_POST['question_3'])) 
						echo GetMessage("ERROR:", "You did not complete all the required fields or some of them are invalid.", 4);
						
					else 
					{
						$name = $_POST['username'];
						$email = xss_clean($_POST['email']);
						$password = xss_clean($_POST['password']);
						$password = hash('whirlpool', $password);
						$password = strtoupper($password);
						$name = mysql_real_escape_string($name);
						$password = mysql_real_escape_string($password);
						$email = mysql_real_escape_string($email);
						$question1 = mysql_real_escape_string($_POST['question_1']);
						$question2 = mysql_real_escape_string($_POST['question_2']);
						$question3 = mysql_real_escape_string($_POST['question_3']);
						mysql_query("INSERT INTO `players`(`Name`, `Password`, `Email`, `Question1`, `Question2`, `Question3`) VALUES ('$name', '$password', '$email', '$question1', '$question2', '$question3')");
						echo GetMessage("<img src='images/ajax-loader.gif'/> Success:", "Your account application has been submitted and will be reviewed by our testers shortly. Please wait a few minutes...", 7);
						echo "<meta http-equiv='refresh' content='1.0;url=?page=login'>";
					}		
				}
				?>
                    Username: <br />
                      <input type="text" name="username" class="form-control" id="inputEmail" placeholder="Username"><br />
					Password: <br />
                      <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password"><br />
					Email: <br />
                      <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email">
					  <span class="help-block" style="font-weight: bold; ">Why would you like to join Fort Carson Roleplay? Where did you first hear about the community? Explain in depth.</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_1" rows="5" id="textArea" placeholder="Your answer.."><?php if(isset($_POST['submit']) && isset($_POST['question_1'])) echo $_POST['question_1']; ?></textarea>
					  
					  <span class="help-block" style="font-weight: bold; ">What are our server policies/etiquette when it comes to robbing and scamming?</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_2" rows="5" id="textArea" placeholder="Your answer.."><?php if(isset($_POST['submit']) && isset($_POST['question_2'])) echo $_POST['question_2']; ?></textarea>

					  <span class="help-block" style="font-weight: bold;">How would you define roleplay and can you explain some of the elements in roleplaying, like powergaming and metagaming?:</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_3" rows="5" id="textArea" placeholder="Your answer.."><?php if(isset($_POST['submit']) && isset($_POST['question_3'])) echo $_POST['question_3']; ?></textarea>


					  <span class="help-block" style="font-weight: bold;">
                      <input type="checkbox" name="rules"> I have read and understood the server <a href="http://www.google.com">rules</a>!</span>
                    </div>
					<div class="form-actions" style="width: 94%;">
					  <input type="reset" value="Clear" class="btn btn-default" />
					  <input type="submit" name="register" value="Submit" class="btn btn-primary" />
					</div>
                </fieldset>
              </form>
            </div>