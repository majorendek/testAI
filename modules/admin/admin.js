/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 11.01.2020

functions for admin
*/


/////// MESSAGES

var adminMsg_changeChildSuccess = "Profil dieťaťa bol úspešne aktualizovaný.";



/////// VARIABLES

/////// FUNCTIONS

function fncAdmin_start(){
		fncGeneral_log( "[asdmin.js / fncAdmin_start() ] ... " );
		
		//general init
		fncGeneral_basicInit();
		
		//check login
		fncGeneral_checkLogin();
		
		//load children data
		fncAdmin_loadChildsData();
		
		
		
		//SUBMIT
		$("#btnSubmitParent_ID").click(function(){
			
				  fncGeneral_log("Submitting ADMIN - change parrent ...");
		
					
					 //show loader
				  fncGeneral_loaderShow();
				
						var myUserID = DBData["parent"]["userid"];
						var myEmail = $("#email_ID").val();
						var myUsername = $("#username_ID").val();
						
							if (myUsername.length < 1){myUsername = myEmail;}
						
						var myPasswordNew = $("#password_ID").val();
						var myPasswordNew2 = $("#password2_ID").val();
						var myCallURL = location.href;
						
							if (myEmail.length > 0) {
							
								if (fncGeneral_validateEmail(myEmail)){
						
									if ((myPasswordNew.length > 0)) {
										
										if (myPasswordNew == myPasswordNew2) {
											
													var myClient = new ClientJS();
														with (myClient) {
																//JSON	
																var postJSON =  { 
																		    	"data" : {  
																		        "userid":myUserID,
																		        "email": myEmail,
																	        	"username": myUsername,
																		        "wenrowssap": myPasswordNew,
																		        "sessionid": gSessionID,
																		    	}
																				};		
													}
											
													fncCalls_ajaxPostJSON(gURL_PHP_changeParent,JSON.stringify(postJSON), "fncAdmin_changeParentSuccess", "fncAdmin_changeParentFailure");
											
												
										} else {
											errorMessageSet("Nové heslá nie sú rovnaké.", ["#password_ID", "#password2_ID"], ["#email_ID", "#username_ID"]);
										}
										
									} else {
											errorMessageSet("Vyplňte heslo.",["#password_ID"], ["#email_ID", "#username_ID","#password2_ID"]);
									}
								
								} else {
											errorMessageSet("Zadajte správnu e-mailovú adresuZadajte e-mailovú adresu.", ["#email_ID"], ["#password_ID", "#username_ID","#password2_ID"]);
								}
		
							} else {
											errorMessageSet("Zadajte e-mailovú adresu.", ["#email_ID"], ["#password_ID", "#username_ID","#password2_ID"]);
							}
				  
		});
		
		$("#btnAddChild_ID").click(function(){
			
				  fncGeneral_log("Adding ADMIN - add child ...");
		
					
					 //show loader
				  fncGeneral_loaderShow();
				
					var myParentID = DBData["parent"]["userid"];
					var myFirstname = $("#firstname_ID").val();
					var myLastname = $("#lastname_ID").val();
					var myChildUsername = $("#childUsername_ID").val();
					
					var myPasswordNew = $("#childPassword_ID").val();
					var myClass = $("#class_ID").val();
					var myCallURL = location.href;
					
						if (myChildUsername.length > 0) {
						
							if ((myPasswordNew.length > 0)){
					
										if (myClass.length > 0) {
												
												var myClient = new ClientJS();
													with (myClient) {
															//JSON	
															var postJSON =  { 
																	    	"data" : {  
																	    		"parentid":myParentID,
																	        "firstname": myFirstname,
																        	"lastname": myLastname,
																	        "username": myChildUsername,
																	        "wenrowssap": myPasswordNew,
																	        "class": myClass,
																	    	}
																			};		
												}
										
												fncCalls_ajaxPostJSON(gURL_PHP_addChild,JSON.stringify(postJSON), "fncAdmin_addChildSuccess", "fncAdmin_addChildFailure");
										
											
										} else {
												errorMessageSet("Vyplňte triedu.",["#class_ID"], ["#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);
										}
							
							} else {
										errorMessageSet("Vyplňte heslo.",["#childPassword_ID"], ["#firstname_ID", "#lastname_ID","#childUsername_ID", "#class_ID"]);
							}
	
						} else {
										errorMessageSet("Zadajte prihlasovacie meno.", ["#childUsername_ID"], ["#firstname_ID", "#lastname_ID","#childPassword_ID", "#class_ID"]);
						}
				  
		});
		
		$("#btnSubmitChild_ID").click(function(){
			
				  fncGeneral_log("Changing ADMIN - changing child ...");
					
					//show loader
					fncGeneral_loaderShow();
					 
					 		
					var myParentID = DBData["parent"]["userid"];
					var myChildID = $("#childid_ID").val();
					var myFirstname = $("#firstname_ID").val();
					var myLastname = $("#lastname_ID").val();
					var myChildUsername = $("#childUsername_ID").val();
					
					var myPasswordNew = $("#childPassword_ID").val();
					var myClass = $("#class_ID").val();
					var myCallURL = location.href;
					
						if (myChildUsername.length > 0) {
						
							if ((myPasswordNew.length > 0)){
					
								if (myClass.length > 0) {
										
										var myClient = new ClientJS();
											with (myClient) {
													//JSON	
													var postJSON =  { 
															    	"data" : {  
															    		"parentid":myParentID,
															    		"userid":myChildID,
															        "firstname": myFirstname,
														        	"lastname": myLastname,
															        "username": myChildUsername,
															        "wenrowssap": myPasswordNew,
															        "class": myClass,
															    	}
																	};		
										}
								
										fncCalls_ajaxPostJSON(gURL_PHP_changeChild,JSON.stringify(postJSON), "fncAdmin_changeChildSuccess", "fncAdmin_changeChildFailure");
								
									
								} else {
										errorMessageSet("Vyplňte triedu.",["#class_ID"], ["#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);
								}
							
							} else {
										errorMessageSet("Vyplňte heslo.",["#childPassword_ID"], ["#firstname_ID", "#lastname_ID","#childUsername_ID", "#class_ID"]);
							}
	
						} else {
										errorMessageSet("Zadajte prihlasovacie meno.", ["#childUsername_ID"], ["#firstname_ID", "#lastname_ID","#childPassword_ID", "#class_ID"]);
						}
				  
		});
		
	
		//parent DELETE
		//
		$("#parentModal_btnDeleteParent_ID").click(function(){
			
					fncGeneral_log("ADMIN - removing parent ...");
				
					//hide modal
				  fncGeneral_elementHide("parentModal");
				  
				  //show loader
				  fncGeneral_loaderShow();
				  
			var myParentID = DBData["parent"]["userid"];
			var myCallURL = location.href;
				  
				  if (myParentID.length > 0) {
										
										var myClient = new ClientJS();
											with (myClient) {
													//JSON	
													var postJSON =  { 
															    	"data" : {  
															    		"parentid":myParentID															    		
															    	}
																	};		
										}
								
										fncCalls_ajaxPostJSON(gURL_PHP_removeParent,JSON.stringify(postJSON), "fncAdmin_removeParentSuccess", "fncAdmin_removeParentFailure");
						
							} else {
									errorMessageSet("Chcete zmazať nezadané dieťa.");
							}
				  
			
		});
		
		
		//child DELETE
		$("#btnRemoveChild_ID").click(function(){				  
				  fncGeneral_elementShow("childModal");
		});
		//
		$("#childModal_btnNo_ID").click(function(){
				  fncGeneral_elementHide("childModal");
		});
		//
		$("#childModal_btnYes_ID").click(function(){
				  
				  fncGeneral_log("ADMIN - removing child ...");
				  
				  //hide modal
				  fncGeneral_elementHide("childModal");
				  
				  //show loader
				  fncGeneral_loaderShow();
				  
				  
				  var myParentID = DBData["parent"]["userid"];
					var myChildID = $("#childid_ID").val();
					var myCallURL = location.href;
				  
						  if (myChildID.length > 0) {
										
										var myClient = new ClientJS();
											with (myClient) {
													//JSON	
													var postJSON =  { 
															    	"data" : {  
															    		"parentid":myParentID,
															    		"userid":myChildID,
															    	}
																	};		
										}
								
										fncCalls_ajaxPostJSON(gURL_PHP_removeChild,JSON.stringify(postJSON), "fncAdmin_removeChildSuccess", "fncAdmin_removeChildFailure");
						
							} else {
									errorMessageSet("Chcete zmazať nezadané dieťa.");
							}
				  
		});
		
			
}
//



//
function fncAdmin_removeParentSuccess(myDataJSON){
	
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
	
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							fncGeneralSetSessionID("");
							
							fncGeneralRedirectWithSessionID(gURL_MODULE_login);
								
					} else {
				
						errorMessageSet("Nepodarilo sa zmazať profil rodiča.");
					}
			
		} catch(err) {
		  errorMessageSet("Vyskytla sa chyba.",null, ["#email_ID","#password_ID","#password2_ID", "#username_ID"]);
		}	

}
//
function fncAdmin_removeParentFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
}

//
function fncAdmin_removeChildSuccess(myDataJSON){
	
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
	
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							fncGeneralSetSessionID(resultObj["data"]["sessionid"]);
							
							fncGeneralRedirectWithSessionID(gURL_MODULE_admin);
								
					} else {
				
						errorMessageSet("Nepodarilo sa zmazať profil dieťaťa.");
					}
			
		} catch(err) {
		  errorMessageSet("Vyskytla sa chyba.",null, ["#email_ID","#password_ID","#password2_ID", "#username_ID"]);
		}	

}
//
function fncAdmin_removeChildFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
}
//
function fncAdmin_changeParentSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
	

		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							fncGeneralSetSessionID(resultObj["data"]["sessionid"]);
							
							successMessageSet("Váš profil bol úspešne aktualizovaný.", null, ["#email_ID","#password_ID","#password2_ID", "#username_ID"]);					
							
								//fncGeneralRedirectWithSessionID(gURL_MODULE_admin);
								
						
					} else {
						//TODO: spracovanie, ak je update PARENT udajov zly
						errorMessageSet("Niečo sa pri aktualizovaní pokazilo :(",null, ["#email_ID","#password_ID","#password2_ID", "#username_ID"]);						
					}
			
		} catch(err) {
		  errorMessageSet("Vyskytla sa chyba.",null, ["#email_ID","#password_ID","#password2_ID", "#username_ID"]);
		}	
		
}
//
function fncAdmin_changeParentFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
}
//
function fncAdmin_addChildSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);	

		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
							
							successMessageSet("Vaše dieťa bolo úspešne pridané.", null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);					
							
							setTimeout(fncGeneralRedirectWithSessionID, 1000, gURL_MODULE_admin);
						
					} else {						
						errorMessageSet("Prihlasovacie meno už existuje.",null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);								
					}
			
		} catch(err) {
		  errorMessageSet("Vyskytla sa chyba :(",null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);
		}	
		
}
function fncAdmin_addChildFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
}
//
function fncAdmin_changeChildSuccess(myDataJSON){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_log(myDataJSON);
	

		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
							
							successMessageSet(adminMsg_changeChildSuccess, null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);					
							
								//fncGeneralRedirectWithSessionID(gURL_MODULE_admin);
								
						
					} else {
						
//TODO: spracovanie, ak je update PARENT udajov zly
						errorMessageSet("Nastala chyba pri aktualizácii :(",null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);						
					}
			
		} catch(err) {
		  errorMessageSet("Nastala chyba.",null, ["#class_ID", "#firstname_ID", "#lastname_ID","#childUsername_ID", "#childPassword_ID"]);
		}	
		
}
function fncAdmin_changeChildFailure(myMessage){
		//hide loader
		fncGeneral_loaderHide();
	
		fncGeneral_modalInfoSetAndShow(myMessage);
}
//
//
function fncAdmin_loadChildsData() {	
	//show loader
	fncGeneral_loaderShow();

	//JSON	
		ResultsJSON =  { 
				    	"data" : { 
				        "sessionid" : gSessionID
				    	}
						};
						
		//fncGeneral_log(ResultsJSON);
		
		fncCalls_ajaxPostJSON(gURL_PHP_admin,JSON.stringify(ResultsJSON), "fncAdmin_loadChildSuccess", "fncAdmin_loadChildFailure");
}//
function fncAdmin_loadChildSuccess(myDataJSON) {
	//hide loader
	fncGeneral_loaderHide();


	fncGeneral_log(myDataJSON);
	
	if(myDataJSON["result"]["status"] == "OK") {
		// save children data
		DBData = myDataJSON["data"]["DBData"];		
		
		// generate buttons
		var counter = 0;
		
			$.each( DBData, function( key, value ) {
				counter++;
				if(value["firstname"])
			  	$("#adminSelectButtons").append("<button id='"+value["firstname"]+"' class='w3-bar-item w3lt-tab-button-frame tablink w3-theme-d3' onclick='fncAdmin_clickChildButton(this)'>"+value["firstname"]+"</button>");
			});
		
			if (counter < 4) {
				$("#adminSelectButtons").append("<button id='addChild_id' class='w3-button w3lt-tab-button-frame w3-bar-item tablink onclik w3-theme-d3 w3-right'>Registruj dieťa</button>");
			}
		
			if (counter == 1){
				//show message
					errorMessageSet("Pridajte dieťa stlačením tlačítka '+'.");
			}
			
			fncAdmin_clickParentButton();
			
	} else {
		fncAdmin_loadChildFailure();
	}
}
function fncAdmin_loadChildFailure() {
	errorMessageSet("Nenašli sa žiadne výsledky.");
}
//
function fncAdmin_clickParentButton() {
	
	errorMessageHide();
	
	$("#email_ID").val(DBData["parent"]["email"]);
	$("#username_ID").val(DBData["parent"]["login"]);
	
	$("#parentForm_ID").removeClass( "w3-hide" );
	$("#childForm_ID").addClass( "w3-hide" );
	
	// change taps look
	var adminSelectButtons = $( "#adminSelectButtons button" );
	
	$.each(adminSelectButtons, function(index, item) {
			if(0 != index)
				$(item).addClass("w3-theme-d3 w3-button").addClass("w3-theme-d3 w3-button").attr("onclick", "fncAdmin_clickChildButton(this)");
	});
}
//
function fncAdmin_clickChildButton(button) {
	
	
	
	
	if (button.id != "addChild_id") {
		
		errorMessageHide();
		
		$("#childid_ID").val(DBData[button.id]["userid"]);
		$("#firstname_ID").val(DBData[button.id]["firstname"]);
		$("#lastname_ID").val(DBData[button.id]["lastname"]);
		$("#childUsername_ID").val(DBData[button.id]["login"]);
		$("#childPassword_ID").val(DBData[button.id]["password"]);
		$("#class_ID").val(DBData[button.id]["class"]);
		$("#btnSubmitChild_ID").removeClass("w3-hide");
		$("#btnAddChild_ID").addClass("w3-hide");
		$("#btnRemoveChild_ID").removeClass("w3-hide");
		
	} else {
		
		errorMessageHide();
		
		$("#childid_ID").val("");
		$("#firstname_ID").val("");
		$("#lastname_ID").val("");
		$("#childUsername_ID").val("");
		$("#childPassword_ID").val("");
		$("#class_ID").val("");
		$("#btnSubmitChild_ID").addClass("w3-hide");
		$("#btnAddChild_ID").removeClass("w3-hide");
		
		$("#btnRemoveChild_ID").addClass("w3-hide");
		
		errorMessageSet("Pridanie dieťaťa: Vyplňte všetky políčka a stlačte 'Zaregistrovať'");
		
		//select 1 rocnik
		
		$('#class_ID').val( 1 );
		
	}
	
	$("#parentForm_ID").addClass( "w3-hide" );
	$("#childForm_ID").removeClass( "w3-hide" );
	
	// change taps look
		var adminSelectButtons = $( "#adminSelectButtons button" );
		
		$.each(adminSelectButtons, function(index, item) {
			if(0 == index)
				$(item).addClass("w3-theme-d3 w3-button").addClass("w3-theme-d3 w3-button").attr("onclick", "fncAdmin_clickParentButton(this)");
			else
				$(item).addClass("w3-theme-d3 w3-button").addClass("w3-theme-d3 w3-button").attr("onclick", "fncAdmin_clickChildButton(this)");
			fncGeneral_log(0 == index);	
		});
		$(button).removeClass("w3-theme-d3 w3-button").addClass(" w3-theme-l4").removeAttr("onclick");
}
/////// CALLS