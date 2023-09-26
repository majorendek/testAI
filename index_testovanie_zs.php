<html>
	<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap 4.3.1 CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Own CSS -->
        <link rel="stylesheet" href="css/styles.css">
        
        <!-- JQuery -->
        <script src="js/jquery-3.5.1.min.js"></script>
        
        <!-- SUPERSCHOPNOSTI -->
        <script src="modules/general/general.js"></script>
        
        <script>
	        $( document ).ready(function() {
					   
					   
					   $("#submitButtonID" ).on( "click", function() {
							  
							  let specialSession = "liberaterraFree";
							  let choosenFunction = $('#powerID').val();
							  let myLink = "https://customers.turnpages.sk/liberaterra/apps/test/modules/test/test.html?sessionid=" + specialSession + "&test=" + choosenFunction;
							  
							  //console.log(myLink);
							  
							  window.location.href = myLink;
							  
							} );
					   
					   
					   
					   $('#rocnikID').on('change', function (e) {
					   	
						    var optionSelected = $("option:selected", this);
						    var valueSelected = this.value;						    
						    
									//destroy options
									$('#powerID').find('option').remove().end();
									
									
									//generate options
									for (const testik in testZSObj[valueSelected]) { 
									  $('#powerID').append('<option value="' + testik + '">' + testZSObj[valueSelected][testik] + '</option>');
									}			

						 });
							
						$('#rocnikID').val('5').trigger('change');
					   
					});										
							
        </script>

        <title>Testovanie skúšač</title>
	</head>
    <body>


       
        <div class="container-fluid mt-5">
            <div class="row mb-5">
                <h1 class="text-center m-auto">Skús sa otestovať.</h1>
            </div>
            
            	<div class="row mb-5">
            		<h3 class="text-center mb-3 w-100">Vyber si svoj ročník základnej školy</h3>
                		<select class="m-auto" name="rocnik" id="rocnikID">
                			<option value="1">1. ročník</option>
                			<option value="2">2. ročník</option>
                			<option value="3">3. ročník</option>
                			<option value="4">4. ročník</option>
                			<option value="5">5. ročník</option>
                			<option value="6">6. ročník</option>
                			<option value="7">7. ročník</option>
                			<option value="8">8. ročník</option>
                	 </select>
              </div>		
              
                
              <div class="row mb-5">
                  <h3 class="text-center mb-3 w-100">Vyber si svoj test</h3>
                  <select class="m-auto" name="power" id="powerID">       
                  </select>
              </div>
              
              <div class="row">
                  <button type="submit" id="submitButtonID" class="btn btn-primary m-auto">
                      Otestuj sa!
                  </button>
              </div>
            
            
        </div>

    </body>
</html>