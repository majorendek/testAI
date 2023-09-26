/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 29.11.2019

functions for forgot
*/


/////// VARIABLES

/////// FUNCTIONS

function fncForgot_start(){
		fncGeneral_log( "[forgot.js / fncForgot_start() ] ... " );
		
		//general init
		fncGeneral_basicInit();
		
		
		//SUBMIT FORGOT
		$("#btnSubmitSend_ID").click(function(){
			
				  fncGeneral_log("Submitting FORGOT ...");
				  
				  //show loader
				  fncGeneral_loaderShow();
						
					var myEmail = $("#email_ID").val();
						
							if (fncGeneral_validateEmail(myEmail)){
									
								var myCallURL = location.href;
								
							
									
											//JSON	
											var postJSON =  { 
													    	"data" : { 
													        "email" : myEmail
													    	},
													    	"info" : {
													    		"callURL" : myCallURL,
													    	}
															};
								
									
									fncCalls_ajaxPostJSON(gURL_PHP_forgot,JSON.stringify(postJSON), "fncForgot_mailSuccess", "fncForgot_mailFailure");
							
							} else {
								
									errorMessageSet("Vyplňte správnu e-mailovú adresu.",["#email_ID"]);
								
							}
				
		});
		
			//SUBMIT SIGNUP
		$("#btnTabSignin_ID").click(function(){
				  fncGeneralRedirect(gURL_MODULE_login);
		});
		
}

/////// CALLS
function fncForgot_mailSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
		
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							errorMessageSet("Na Vašu e-mailovú adresu boli odoslané nové prihlasovacie údaje.",null,["#email_ID"]);	
							
					} else {
						fncForgot_mailFailure("");
					}
			
		} catch(err) {
		  fncForgot_mailFailure("");
		}
		
		
}
//
function fncForgot_mailFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
		//fncGeneral_log("fail");	
}


