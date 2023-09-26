/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 29.11.2019

functions for signup
*/


/////// VARIABLES

/////// FUNCTIONS

function fncSignup_start(){
		fncGeneral_log( "[signup.js / fncSignup_start() ] ... " );
		
		//general init
		fncGeneral_basicInit();
		
		//SUBMIT LOGIN
		$("#btnSubmitLogin_ID").click(function(){
			
				  fncGeneral_log("Submitting SIGN UP ...");
				  
				  //show loader
				  fncGeneral_loaderShow();
				
					var myEmail = $("#email_ID").val();
					var myUsername = $("#username_ID").val();
					
							if (myUsername.length < 1){myUsername = myEmail;}
					
					var myPasswordNew = $("#password_ID").val();
					var myPasswordNew2 = $("#password2_ID").val();
					var myCallURL = location.href;
					
					if (myPasswordNew.length > 0) {
					
						if (myEmail.length > 0) {
							
								if (fncGeneral_validateEmail(myEmail)){
								
									if (myPasswordNew == myPasswordNew2) {
									
										
											var myClient = new ClientJS();
													with (myClient) {
															//JSON	
															var postJSON =  { 
																	    	"data" : { 
																	        
																	        "email": myEmail,
																	        "username": myUsername,
																	        "wenrowssap": myPasswordNew
																	        
																	    	},
																	    	"info" : {
																	    		"callURL" : myCallURL,
																	    		"getOS" : getOS(),
																	    		"getOSVersion" : getOSVersion(),
																	    		"getBrowser" : getBrowser(),
																	    		"getBrowserVersion" : getBrowserVersion(),
																	    		"getEngine" : getEngine(),
																	    		"getDevice" : getDevice(),
																	    		"getDeviceType" : getDeviceType(),
																	    		"getDeviceVendor" : getDeviceVendor(),
																	    		"getUserAgent" : getUserAgent(),
																	    		"getCurrentResolution" : getCurrentResolution(),
																	    		"getColorDepth" : getColorDepth(),
																	    	}
																			};		
												}
									
										
											fncCalls_ajaxPostJSON(gURL_PHP_signup,JSON.stringify(postJSON), "fncSignup_signupSuccess", "fncSignup_signupFailure");
										
										
									} else {
										errorMessageSet("Heslá nie sú rovnaké.",["#password_ID","#password2_ID"], ["#email_ID"]);	
									}
									
								} else {
									
									errorMessageSet("Zadajte správnu e-mailovú adresu",["#email_ID"],["#password_ID","#password2_ID"]);	
								}
								
						} else {
								errorMessageSet("Zadajte e-mailovú adresu",["#email_ID"],["#password_ID","#password2_ID"]);	
						}
								
					} else {
							errorMessageSet("Zadajte heslo.",["#password_ID"],["#email_ID","#password2_ID"]);	
					}
					
					
					
					
					
				
		});
		
		
		//SUBMIT SIGNUP
		$("#btnTabSignin_ID").click(function(){
				  fncGeneralRedirect(gURL_MODULE_login);
		});
		
		
}


/////// CALLS
function fncSignup_signupSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
	

		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							fncGeneralSetSessionID(resultObj["data"]["sessionid"]);
						
							if (resultObj["data"]["type"] == "child"){
							
										fncGeneralRedirectWithSessionID(gURL_MODULE_superschopnosti);
							
							} else if (resultObj["data"]["type"] == "parent"){
						
									//PARENT with CHILDREN
									//fncGeneral_modalInfoSetAndShow("Som rodic a mam " + resultObj["data"]["children"] + " deti");	
									
									if ( makeNumber(resultObj["data"]["children"]) > 0){
											fncGeneralRedirectWithSessionID(gURL_MODULE_dashboard);
									} else {
										fncGeneralRedirectWithSessionID(gURL_MODULE_admin);
									}
								
							} else {
								errorMessageSet("Nie je jasné, či ide o rodiča alebo dieťa.",null, ["#email_ID","#password_ID","#password2_ID"]);
							}
						
					} else {
						errorMessageSet("Uživateľ, ktorého chcete zaregistrovať už existuje.",null, ["#email_ID","#password_ID","#password2_ID"]);
					}
			
		} catch(err) {
		  errorMessageSet("Vyskytla sa chyba.",null, ["#email_ID","#password_ID","#password2_ID"]);
		}	
		
}
//
function fncSignup_signupFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
		//fncGeneral_log("fail");	
}