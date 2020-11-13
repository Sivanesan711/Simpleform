<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<div class="main">
		<div class="main-overlay">
			<div class="main-container">
				<div class="flex-container">
					  <div class="flex-item-left">
					  	<form action="process.php"  method="POST" id="captcha_form">
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" class="form-control" required>
								<span id="name_error" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="text" name="email" class="form-control" required>
								<span id="email_error" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label>Phone. no</label>
								<input type="text" name="phone" class="form-control" required>
								<span id="phone_error" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label>Date of Birth</label>
								<input type="text" id="dob" name="dob" placeholder="DD/MM/YYYY" class="form-control" required><br>
								<p>Your age: <span id="age"></span></p>
								<span id="dob_error" class="text-danger"></span>
							</div>
							<div class="form-group">
						       <div class="g-recaptcha" data-sitekey="6LfVZOIZAAAAAC1l9vRvyTWr0pbB5zP438vYs2wO"></div>
						       <span id="captcha_error" class="text-success"></span>
						    </div>
							<div class="form-group">
								<button class="btn btn-primary" name="register" id="register">Submit</button>
							</div>
						</form>
					  </div>
					  <div class="flex-item-right">
					  	<table class="table">
						    <thead>
						      <tr>
						        <th>Firstname</th>
						        <th>Lastname</th>
						        <th>Email</th>
						      </tr>
						    </thead>
						    <tbody>
						     
						    </tbody>
						  </table>
					  </div>
				</div>
			</div><br>
		</div>
	</div>

	<script type="text/javascript">
		(function(){
  
		  // Declare global variable
		  var elem = document.getElementById('dob'),
		      age  = document.getElementById('age');
		  
		  // Step to step
		  // Step 01: declare input events (change)
		  elem.addEventListener("change", function(){
		    if (checkInput(elem.value)){
		      var ageCount = calculateAge(parseDate(elem.value), new Date());
		      elem.style.borderColor = '#44b2f8';
		      elem.style.boxShadow = '0px 0px 4px green';
		      age.innerHTML = ageCount[0] + ' years old and ' + ageCount[1] + ' days';
		      age.classList.remove('wrong');
		      age.classList.add('success');
		    } else {
		      elem.style.borderColor = 'red';
		      elem.style.boxShadow = '0px 0px 4px red';
		      age.innerHTML = 'Please enter the correct syntax';
		      age.classList.remove('success');
		      age.classList.add('wrong');
		    } 
		  }, false);
		  
		  // Step 02: Check input is not undifined & correct syntax
		  function checkInput(textDate){
		    var getTextDate = textDate;
		    if(getTextDate == '') {
		      // If input when change is empty => result return true (NaN)
		      return true;
		    } else {
		      
		      // Declare regular expression 
		      var regularDate = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
		      // Search regular expression and return Array
		      // it's return every elem ( ex: 27/12/1992 => array [27/12/1992,27,/,12,/,1992] )
		      var matchArray = getTextDate.match(regularDate); // is format OK?
		      if (matchArray == null) {
		        // When input center is Alpha return false -Please enter the correct syntax-
		        return false;
		      } else {
		        
		        // Checks for dd/mm/yyyy format.
		        var matchDay = matchArray[1];
		        var matchMonth = matchArray[3];
		        var matchYear = matchArray[5];
		        
		        // Check input year large year now3
		        if(new Date(matchYear).getFullYear() >= new Date().getFullYear()) {
		          return false;
		        }
		        
		        if (matchDay > 31 || matchDay < 1) {
		          return false;
		        } else if (matchMonth > 12 || matchMonth < 1) {
		          return false;
		        } else if ((matchMonth == 2 || matchMonth == 4 || matchMonth == 6 || matchMonth == 9 || matchMonth == 11) && matchDay == 31) {
		          return false;
		        } else if (matchMonth == 2) {
		          var isleap = (matchYear % 4 == 0 && (matchYear % 100 != 0 || matchYear % 400 == 0));
		          if (matchDay > 29 || (matchDay == 29 && !isleap)) {
		           return false; 
		          } else {}
		        }
		        
		      }
		      
		    }
		    
		    return true;
		    
		  }
		  
		  // Step 03: convert value from input(string) to format date dd/mm/yyyy
		  function parseDate(stringText){
		    var formatText = stringText.split('/');
		    return new Date(formatText[2], (formatText[1] - 1), formatText[0]);
		  }
		  
		  // Step 04: call function calculate (result how old years & date)
		  function calculateAge(DateFromInput, DateNow){
		    var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
		    var age = Math.round(Math.abs((DateFromInput.getTime() - DateNow.getTime())/(oneDay)));
		    var resultYear = Math.ceil(age / 365) - 1;
		    var resultDay = age - (resultYear*365);
		    var resultage = [];
		    resultage.push(resultYear, resultDay);
		    return resultage;
		    
		  }
		  
		})();
	</script>

	<script>
			$(document).ready(function(){

			 $('#captcha_form').on('submit', function(event){
			  event.preventDefault();
			  $.ajax({
			   url:"process_data.php",
			   method:"POST",
			   data:$(this).serialize(),
			   dataType:"json",
			   beforeSend:function()
			   {
			    $('#register').attr('disabled','disabled');
			   },
			   success:function(data)
			   {
			    $('#register').attr('disabled', false);
			    if(data.success)
			    {
			     $('#captcha_form')[0].reset();
			     $('#name_error').text('');
			     $('#email_error').text('');
			     $('#phone_error').text('');
			     $('#dob_error').text('');
			     $('#captcha_error').text('');
			     g-recaptcha.reset();
			     alert('Form Successfully validated');
			    }
			    else
			    {
			     $('#name_error').text(data.name_error);
			     $('#email_error').text(data.email_error);
			     $('#phone_error').text(data.phone_error);
			     $('#dob_error').text(data.dob_error);
			     $('#captcha_error').text(data.captcha_error);
			    }
			   }
			  })
			 });

			});
	</script>
</body>
</html>