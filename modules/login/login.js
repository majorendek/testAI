/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 29.11.2019

functions for login
*/


/////// VARIABLES

/////// FUNCTIONS

function fncLogin_start(){
		fncGeneral_log( "[login.js / fncLogin_start() ] ... " );
		
		//general init
		fncGeneral_basicInit();
		
		//SUBMIT LOGIN
		$("#btnSubmitLogin_ID").click(function(){
			
				  fncGeneral_log("Submitting LOGIN ...");
				  
				  //show loader
				  fncGeneral_loaderShow();
				
						var myUsername = $("#username_ID").val();
						var myPassword = $("#password_ID").val();
						
							if ((myUsername.length > 3) && (myPassword.length > 3)) {
								
								var myCallURL = location.href;
								var myPasswordH = CryptoJS.SHA256(myPassword).toString();
						
								var myClient = new ClientJS();
									with (myClient) {
									
											//JSON	
											var postJSON =  { 
													    	"data" : { 
													        "nigol" : myUsername,
													        "drowssap": myPasswordH,
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
									
									fncCalls_ajaxPostJSON(gURL_PHP_login,JSON.stringify(postJSON), "fncLogin_loginSuccess", "fncLogin_loginFailure");
							
							} else {
								
									errorMessageSet("Vyplňte správne prihlasovacie údaje.",["#username_ID", "#password_ID"]);
								
							}
				
					
				
		});
		
		
		//SUBMIT FORGET PASSWORD
		$("#btnTabForgot_ID").click(function(){
				  fncGeneralRedirect(gURL_MODULE_forgot);
		});
		
		
		//SUBMIT SIGNUP
		$("#btnTabSignup_ID").click(function(){
				  fncGeneralRedirect(gURL_MODULE_signup);
		});
		
}


/////// CALLS
function fncLogin_loginSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
		
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							fncGeneralSetSessionID(resultObj["data"]["sessionid"]);
						
							if (resultObj["data"]["type"] == "child"){
										
										if (resultObj["data"]["inclog"] < 3){
											fncGeneralRedirectWithSessionID(gURL_MODULE_testovanie_start);
										} else {
											errorMessageSet("Použíté nesprávne heslo viac ako 3 krát! Popros rodiča o zmenu hesla.");
										}
							
							} else if (resultObj["data"]["type"] == "parent"){
						
									//PARENT with CHILDREN
									//fncGeneral_modalInfoSetAndShow("Som rodic a mam " + resultObj["data"]["children"] + " deti");	
									
									if ( makeNumber(resultObj["data"]["children"]) > 0){
											fncGeneralRedirectWithSessionID(gURL_MODULE_dashboard);
									} else {
										fncGeneralRedirectWithSessionID(gURL_MODULE_admin);
									}
								
							} else if (resultObj["data"]["type"] == "teacher"){
								
									fncGeneralRedirectWithSessionID(gURL_MODULE_teacher);
								
							} else {
								errorMessageSet("Nie je jasné, či ste učiteľ, rodič alebo dieťa.");
							}
						
					} else {
						errorMessageSet("Prihlasovacie meno alebo heslo nie je správne vyplnené.",["#username_ID", "#password_ID"]);
					}
			
		} catch(err) {
		  fncLogin_loginFailure("");
		}
		
		
}
//
function fncLogin_loginFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		errorMessageSet( "Vyplňte správne prihlasovacie údaje.", ["#username_ID", "#password_ID"]);
		//fncGeneral_log("fail");	
}


