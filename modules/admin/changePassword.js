/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 20.01.2020

functions for changePassword
*/


/////// VARIABLES


/////// FUNCTIONS

function fncChangePassword_start(){
		fncGeneral_log( "[changePassword.js / fncChngePassword_start() ] ... " );
			
		
		//general init
		fncGeneral_basicInit();
		
		//alert("gSessionID = " + gSessionID);
		
		gInputPassword = ($.urlParam('p') == null)?"":$.urlParam('p');
		
		if (gInputPassword != null){
			$("#passwordOld_ID").val(gInputPassword);
			$("#passwordOld_ID").prop('disabled', true);
			$('#passwordOld_ID').prop('type', 'text');
		}
		
		
		//SUBMIT
		$("#btnSubmitChangePassword_ID").click(function(){
			
				  fncGeneral_log("Submitting CHANGE PASSWORD...");
				  
				  //show loader
				  fncGeneral_loaderShow();
				
						var myPasswordOld = $("#passwordOld_ID").val();
						var myPasswordNew = $("#password_ID").val();
						var myPasswordNew2 = $("#password2_ID").val();
						var myCallURL = location.href;
						
							if ((myPasswordNew.length > 0) && (myPasswordOld.length > 0)) {
								
								if (myPasswordNew == myPasswordNew2) {
									
									if (myPasswordNew != myPasswordOld) {
								
											var myClient = new ClientJS();
												with (myClient) {
														//JSON	
														var postJSON =  { 
																    	"data" : { 
																        
																        "dlodrowssap": myPasswordOld,
																        "wenrowssap": myPasswordNew,
																        "sessionid": gSessionID,
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
									
										
											fncCalls_ajaxPostJSON(gURL_PHP_changePassword,JSON.stringify(postJSON), "fncChangePassword_changePasswordSuccess", "fncChangePassword_changePasswordFailure");
										
											
									} else {
											fncChangePassword_changePasswordFailure("Staré heslo nesmie byť rovnaké s novým heslom.");
									}
										
								} else {
									fncChangePassword_changePasswordFailure("Nové heslá nie sú rovnaké.");
								}
								
							} else {
									fncChangePassword_changePasswordFailure("Vyplňte správne heslá.");
							}
				
		});
		
		
}


/////// CALLS
function fncChangePassword_changePasswordSuccess(myDataJSON){
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
								fncChangePassword_changePasswordFailure("Nie je jasné, či ide o rodiča alebo dieťa.");
							}
						
					} else {
						fncChangePassword_changePasswordFailure("Uživateľ, ktorému chcete zmeniť heslo neexistuje.");
					}
			
		} catch(err) {
		  fncChangePassword_changePasswordFailure("Vyskytla sa chyba.");
		}	
		
}
//
function fncChangePassword_changePasswordFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
		//fncGeneral_log("fail");	
}