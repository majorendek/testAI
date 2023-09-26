/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 13.3.2020

functions for superschopnosti
*/


/////// VARIABLES


/////// FUNCTIONS

function fncTestStart_start(){
		fncGeneral_log( "[testStart.js / fncTestStart_start() ] ... " );
	
		//show loader
		fncGeneral_loaderShow();
		
		//general init
		fncGeneral_basicInit();
		
		//checkLogin
		fncGeneral_checkLogin();
			
		fncGeneral_getUserInfo("fncTestStart_getUserInfoSuccess");
			
			
		$("#superschopnostButtonNone_ID").css({ 'opacity' : 0 });
		
		$("#superschopnostButtonNext_ID").click(function(){
			
				  fncGeneral_log("Submitting NEXT ...");
				  
				  var myFunctionName = $("#superschopnostSelect_ID").val();
				  
				  		fncGeneralRedirectWithSessionIDAndParam(gURL_MODULE_testovanie ,"test", myFunctionName);
				  
		});	 
		
		$("#superschopnostButtonLogout_ID").click(function(){
			
				  fncGeneral_log("Submitting LOGOUT ...");
				  
				  fncGeneralRedirect(gURL_MODULE_login);
				  
		});	  
			
}
//
function fncSetModuleExtern(){
		$("#superschopnostButtonLogout_ID").css("opacity", 0);		
		$("#superschopnostButtonLogout_ID").attr("onclick","");
}
//
function fncTestStart_getUserInfoSuccess(myDataJSON){
	
		fncGeneral_log(myDataJSON);
		

		
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
							
								//generate SUPERVLASTNOSTI
					
									var myClass = 0;
							
										try {
												if (Number(resultObj["data"]["class"]) > 0){
														myClass = resultObj["data"]["class"];
												} 
										} catch (err){}
							
									var myClassObj = testZSObj[myClass.toString()];
							
										try {
												if (resultObj["data"]["schoolType"] == "SS"){
														myClassObj = testSSObj[myClass.toString()];
												} 
													
										} catch (err){}
								
							
											for (var myFunctionName in myClassObj){
												
														//var myFunctionName = "fncName";
														var myName = myClassObj[myFunctionName];
														
														$("#superschopnostSelect_ID").append(
																new Option(myName, myFunctionName)
														);
											}
							
							
							//hide loader
							fncGeneral_loaderHide();
		
						
					} else {
						fncGeneral_checkLoginFailure("");
					}
					
			
		} catch(err) {
		  fncGeneral_checkLoginFailure("");
		}
}