/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 16.09.20

general functions
*/

/////// VARIABLES

var gSessionID = "";
var gSessionID_special = "liberaterraFree";

var gGeneralCanLog = false;
var gGlobalResizeFunctionsArray = [];

var gImagesPath = "../../images/";
var gResultImages = ["sova.gif"];

var gExternUser = "";
var gExternUserID = "";


//testovanie - základná škola
var testZSObj = {
			
			//NULL
			"0" : {
				"zs_0_test" : "Skúšobný test",
				"kod" : "nazov",
				"kod" : "nazov"
			},
			
			
			//1. rocnik
			"1" : {
				
			},
			
			//2. rocnik
			"2" : {
				
			},
			
			//3. rocnik
			"3" : {
				
			},
			
			//4. rocnik
			"4" : {
				
			},
			
			//5. rocnik
			"5" : {
						"zs_5_PM" : "Piatacké minimum",
						"zs_5_CO" : "Číselná os",
						"zs_5_PCz" : "Zaokrúhľovanie prirodzených čísel",
						"zs_5_ZC" : "Zápis čísel v desiatkovej sústave",
						"zs_5_SR" : "Sčítanie a odčítanie prirodzených čísel",
						"zs_5_SU1" : "Slovné úlohy I",
						"zs_5_SU2" : "Slovné úlohy II",
						"zs_5_SP" : "Násobenie a delenie prirodzených čísel",
						"zs_5_SU3" : "Slovné úlohy III",
						"zs_5_SU4" : "Slovné úlohy IV",
						"zs_5_OZ" : "Poradie matematických operácií a zátvorky",
						"zs_5_ZL" : "Zlomky",
						"zs_5_RY1" : "Rysovanie I",
						"zs_5_RY2" : "Rysovanie II",
						"zs_5_SK" : "Stavby z kociek a telesá",
						"zs_5_SU" : "Stredová a osová súmernosť",
						"zs_5_EUR" : "Eurá",
						"zs_5_APL" : "Aplikované úlohy",
						"zs_5_PR" : "Porovnávanie rozdielom"
			},
			
			//6. rocnik
			"6" : {
						"zs_6_SM" : "Šiestacké minimum",
						"zs_6_DC" : "Desatinné čísla",
						"zs_6_DCo" : "Číselná os a desatinné čísla",
						"zs_6_DCp" : "Porovnávanie a usporadúvanie desatinných čísel",
						"zs_6_DCz" : "Zaokrúhľovanie desatinných čísel"
						
			},
			
			//7. rocnik
			"7" : {
						"zs_7_SM" : "Siedmacké minimum"
			},
			
			//8. rocnik
			"8" : {
						"zs_8_CC" : "Kladné a záporné čísla",
						"zs_8_CCo" : "Číselná os, opačná hodnota, absolútna hodnota",
						"zs_8_CCp" : "Porovnávanie a usporadúvanie celých čísel",
						"zs_8_CCsoc" : "Sčítanie a odčítanie celých čísel",
						"zs_8_CCsocsl" : "Slovné úlohy na sčítanie a odčítanie celých číslel",
						"zs_8_CC_nd" : "Násobenie a delenie celých čísel",
						"zs_8_CC_ndsl" : "Slovné úlohy na násobenie a delenie celých čísel"
			}
			
		}

//testovanie - stredná škola		
var testSSObj = {
			
			//NULL
			"0" : {
				"zs_0_test" : "Skúšobný test",
				"kod" : "nazov",
				"kod" : "nazov"
			},
			
			 //1. rocnik
			"1" : {
				
			},
			
			//2. rocnik
			"2" : {
						"ss_2_KO1" : "Kombinatorika I",
						"ss_2_KO2" : "Kombinatorika II",
						"ss_2_KO3" : "Kombinatorika III"
						
			},
			
			//3. rocnik
			"3" : {
				
			},
			
			//4. rocnik
			"4" : {
				
			},
			
			
		}


//prevody
var gGlobalJednotkyDlzky4RObj = {mm:1, cm:10, dm:100, m:1000, km:1000000};
var gGlobalJednotkyHmotnosti4RObj = {g:1, kg:1000, t:1000000};
var gGlobalJednotkyObjemy4RObj = {ml:1, cl:10, dl:100, l:1000};
var gGlobalJednotkyCasy4RObj = {s:1, min:60, hod:3600};

var gGlobalJednotkyDlzkyAllObj = {mm:1, cm:10, dm:100, m:1000, km:1000000};
var gGlobalJednotkyHmotnostiAllObj = {g:1, kg:1000, q:100000, t:1000000};
var gGlobalJednotkyObjemyAllObj = {ml:1, cl:10, dl:100, l:1000, hl:100000};
var gGlobalJednotkyCasyAllObj = {s:1, min:60, hod:3600};

var gGlobalJednotkyObsahyHighObj = {m2:1, a:100, ha:10000, km2:1000000};
var gGlobalJednotkyObsahyLowObj = {mm2:1, cm2:100, dm2:10000, m2:1000000};

var gGlobalJednotkyUhlyHighObj = {uhol_min:1, uhol_st:60};
var gGlobalJednotkyUhlyLowObj = {uhol_sec:1, uhol_min:60};

var gGlobalJednotkyObjem7HighObj = {'mm³':1,'cm³':1000,'ml':1000,'cl':10000,'dl':100000, 'dm³':1000000, 'l':1000000,'hl':100000000, 'm³':1000000000};
var gGlobalJednotkyObjem7LowObj = {'m³':1, 'km³':1000000000};

var gGlobalJednotka = "";

//detection
var gGlobalDeviceObject = {};
var gGlobalOrientation = "landscape"; //portrait, landscape
var gUserAgent = navigator.userAgent;

var gInnerWindowsWidth = 0;
var gInnerWindowsHeight = 0;

var isMobileTouchDevice = false; //false, true

var iPhone = ~gUserAgent.indexOf('iPhone') || ~gUserAgent.indexOf('iPod');
var iPad = ~gUserAgent.indexOf('iPad');
var iMac = navigator.platform.toUpperCase().indexOf('MAC')>=0;

var ios = iPhone || iPad;
var android = ~gUserAgent.indexOf('Android');
var windows = false;

var isAndroidStandardBrowser = ((gUserAgent.indexOf('Mozilla/5.0') > -1 && gUserAgent.indexOf('Android ') > -1 && gUserAgent.indexOf('AppleWebKit') > -1) && !(gUserAgent.indexOf('Chrome') > -1));		
var isChrome	= (gUserAgent.indexOf('Chrome') > -1);	

/////// OBJECTS

// Create Base64 Object
//var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
// Base64.encode(string); // Encode the String
// Base64.decode(encodedString); // Decode the String



//detect system = jquery extention
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

window.onresize=function(){
	fncGeneral_deviceDetection();
	fncGeneral_callRegisterdResizeAfter();
};

/////// FUNCTIONS
function fncGeneral_log(myMessage){
	if (gGeneralCanLog){
		console.log(myMessage);
	}
}
//
function fncGeneral_elementShow(myID){
	$("#" + myID).removeClass("w3-hide");
	$("#" + myID).addClass("w3-show");
}
//
function fncGeneral_elementHide(myID){
	$("#" + myID).removeClass("w3-show");
	$("#" + myID).addClass("w3-hide");
}
//
function fncGeneral_basicInit(){
	fncGeneral_log("[general.js / fncGeneral_basicInit() ] ================= ");
	
	fncGeneral_deviceDetection();
	
	gSessionID = ($.urlParam('sessionid') == null)?"":$.urlParam('sessionid');
	gExternUserID = ($.urlParam('extUsr') == null)?"":$.urlParam('extUsr');
	
}
//
//
function fncGeneral_getUserInfo(myFunctionSuccess){
	
	if (gSessionID == ""){
			fncGeneralRedirect(gURL_MODULE_login);		
	}
	
	//JSON	
		var postJSON =  { 
				    	"data" : { 
				        "sessionid" : gSessionID,
				    	}
						};
						
		fncGeneral_log(postJSON);
		
		
		fncCalls_ajaxPostJSON(gURL_PHP_getUserInfo,JSON.stringify(postJSON), myFunctionSuccess, "fncGeneral_checkLoginFailure");	
}
//majo
function fncGeneral_checkLogin(){
	
	if (gExternUserID != ""){
		
		var postJSON =  { 
							"data" : { 
								"externuserid" : gExternUserID,
							}
						};
							
			fncGeneral_log(postJSON);
			
			fncCalls_ajaxPostJSON(gURL_PHP_checkLoginExternUser,JSON.stringify(postJSON), "fncGeneral_checkLoginExternUserSuccess", "fncGeneral_checkLoginExternUserFailure");	
		
		
	} else {
	
		if (gSessionID == ""){
			
				//fncGeneralRedirect(gURL_MODULE_login);		
				
		} else if (gSessionID == gSessionID_special){
			
			isLog = true;
			$("#loggedUser_ID").html("prihlásený <i>tester");
			fncSetModuleExtern();		
			
		} else {
				
			//call php to check login
			//JSON	
			var postJSON =  { 
								"data" : { 
									"sessionid" : gSessionID,
								}
							};
							
			fncGeneral_log(postJSON);
			
			fncCalls_ajaxPostJSON(gURL_PHP_checkLogin,JSON.stringify(postJSON), "fncGeneral_checkLoginSuccess", "fncGeneral_checkLoginFailure");	
		}
	}
}
//
function fncGeneral_getSuperschopnostiName(myFunctionName){
			
			for (myClass in testZSObj) {
			  
			  	if (myFunctionName in testZSObj[myClass]){
			  			return testZSObj[myClass][myFunctionName];
			  	}
			}
			
			for (myClass in testSSObj) {
			  
			  	if (myFunctionName in testSSObj[myClass]){
			  			return testSSObj[myClass][myFunctionName];
			  	}
			}
			
	return "Nenájdený test";
}
//
function fncGeneral_makeDateForSQL(myDate){
	
	var myDateString = "";
	
			myDateString = myDateString + myDate.getFullYear() + "-" ;
			myDateString = myDateString + ('0' + (myDate.getMonth() + 1) ).slice(-2) + "-" ;
			myDateString = myDateString + ('0' + myDate.getDate()).slice(-2) + " " ;
			myDateString = myDateString + ('0' + myDate.getHours()).slice(-2) + ":" ;
			myDateString = myDateString + ('0' + myDate.getMinutes()).slice(-2) + ":" ;
			myDateString = myDateString + ('0' + myDate.getSeconds()).slice(-2) ;
					
	return myDateString;
}
//
function fncGeneral_checkLoginSuccess(myDataJSON){
	
		fncGeneral_log(myDataJSON);
		
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							isLog = true;
							
							$("#loggedUser_ID").html("prihlásený <i>" + resultObj["data"]["login"]);
							
							gExternUser = resultObj["data"]["extern"];
					
					
							if (gExternUser == "yes"){
								
										try {
										  fncSetModuleExtern();
										} catch (err) {
										  //console.log(err); // Error: "printMessage is not defined"
										}
								
							}
						
					} else {
						fncGeneral_checkLoginFailure("");
					}
			
		} catch(err) {
		  fncGeneral_checkLoginFailure("");
		}
}
function fncGeneral_checkLoginFailure(myDataJSON){
		isLog = false;
		fncGeneralRedirect(gURL_MODULE_login);
}
//
function fncGeneral_checkLoginExternUserSuccess(myDataJSON){
	
		fncGeneral_log(myDataJSON);
		
		try {
			
			//var resultObj = jQuery.parseJSON(myDataJSON);
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							isLog = true;
							
							$("#loggedUser_ID").html("prihlásený <i>" + resultObj["data"]["login"]);
							
							gExternUser = resultObj["data"]["extern"];
							gSessionID = resultObj["data"]["sessionid"];
					
							if (gExternUser == "yes"){
								
										try {
										  fncSetModuleExtern();
										} catch (err) {
										  //console.log(err); // Error: "printMessage is not defined"
										}
								
							}
						
					} else {
						fncGeneral_checkLoginFailure("");
					}
			
		} catch(err) {
		  fncGeneral_checkLoginFailure("");
		}
}
function fncGeneral_checkLoginExternUserFailure(myDataJSON){
	gExternUserID ="";
	fncGeneral_checkLogin();		
}
//
function fncGeneral_registerResize(myFncName){
	gGlobalResizeFunctionsArray.push(myFncName);
}
//
function fncGeneral_callRegisterdResizeAfter(){
	
	fncGeneral_log("[general.js / fncGeneral_callRegisterdResizeAfter() ] ================= ");
	
	gGlobalResizeFunctionsArray.forEach(function(myFunctionName){
  		
  		try {
  			if (typeof window[myFunctionName] === "function") {
  				window[myFunctionName]();
  			} else {
  				fncGeneral_log( "[general.js / fncGeneral_callRegisterdResizeAfter() ] '" + myFunctionName + "' is not a function.");
  			}
  		} catch (err){
  				fncGeneral_log( "[general.js / fncGeneral_callRegisterdResizeAfter() ] '" + myFunctionName + "' is not a function.");
  		}
  		
	});
}
//
function fncGeneral_deviceDetection(){
	fncGeneral_log("[general.js / fncGeneral_basicInit() ] ================= ");
	
		
	//detect system
	isWindows = /windows/i.test(navigator.userAgent.toLowerCase());
	isIos = /ipad|iphone|ipod/i.test(navigator.userAgent.toLowerCase());
	isAndroid = /android/i.test(navigator.userAgent.toLowerCase());

		if (isWindows){gGlobalDeviceObject["system"]="windows";}
			else if (isIos){gGlobalDeviceObject["system"]="ios";}
			else if (isAndroid){gGlobalDeviceObject["system"]="android"}
		
	//detect mobile device
	isPhone = jQuery.browser.mobile;
	isMobileTouchDevice = (jQuery.support.touch);
	
	//detect device
	var isIPhone = /iphone|ipod/i.test(navigator.userAgent.toLowerCase());
	var isIPad = /ipad/i.test(navigator.userAgent.toLowerCase());
	var isTablet = /tablet/i.test(navigator.userAgent.toLowerCase());
	
	//device
			if (isIPhone){gGlobalDeviceObject["device"]="iphone"}
				else if (isIPad){gGlobalDeviceObject["device"]="ipad"}
				else if (isTablet){gGlobalDeviceObject["device"]="tablet"}
				else if (isAndroid && isPhone){gGlobalDeviceObject["device"]="phone"}
				else if (isAndroid && !isPhone){gGlobalDeviceObject["device"]="tablet"}
	
	
	//window size
		gInnerWindowsWidth = window.innerWidth;
		gInnerWindowsHeight = window.innerHeight;
		
		if (isAndroid){
			
			gInnerWindowsWidth = $( window ).width();
			gInnerWindowsHeight = $( window ).height();
				
			if (isPhone && isChrome){
					// android PHONE	
					if (window.outerHeight > 0){
							gInnerWindowsHeight = window.outerHeight; 
					}
					
			}
		}	
			
	//orientation 
	if (gInnerWindowsWidth<gInnerWindowsHeight){ gGlobalOrientation = "portrait";	}

	//global object	
	gGlobalDeviceObject["orientation"] = gGlobalOrientation;
	gGlobalDeviceObject["innerWidth"] = gInnerWindowsWidth;
	gGlobalDeviceObject["innerHeight"] = gInnerWindowsHeight;


	fncGeneral_log(gGlobalDeviceObject);
}

///////// LOADER
//
function fncGeneral_loaderShow(){
		$("#generalLoader").removeClass("w3-hide");
}
//
function fncGeneral_loaderHide(){
	//if ($("#generalModalInfo").hasClass("w3-show")){
		//$("#generalLoader").removeClass("w3-show");
		$("#generalLoader").addClass("w3-hide");
	//}
}
//
///////// MODAL INFO
function fncGeneral_modalInfoShow(){
		$("#generalModalInfo").addClass("w3-show");
}
//
function fncGeneral_modalInfoSetAndShow(myContent){
	fncGeneral_modalInfoShow();
	$("#generalModalInfo_content").html("<p>" + myContent);
}
//
function fncGeneral_modalInfoHide(){
		$("#generalModalInfo").removeClass("w3-show");
}
//
///////// HTTP
function fncGeneralRedirect(myURL){
	// Simulate a mouse click:
	window.location.href = myURL;

	// Simulate an HTTP redirect:
	//window.location.replace(myURL);
}
//
function fncGeneralRedirectWithSessionID(myURL){
	// Simulate a mouse click:
	window.location.href = myURL + "?sessionid=" + gSessionID;

	// Simulate an HTTP redirect:
	//window.location.replace(myURL);
}
//
function fncGeneralRedirectWithSessionIDAndParam(myURL, paramName, param){
	// Simulate a mouse click:
	window.location.href = myURL + "?sessionid=" + gSessionID + "&" + paramName + "=" + encodeURIComponent(param);

	// Simulate an HTTP redirect:
	//window.location.replace(myURL);
}
// 
function fncGeneralParseJSONFromUrl() {
	var searchParams = new URLSearchParams(window.location.search);
	var JSONparam = jQuery.parseJSON(searchParams.get('JSON'));
	return JSONparam;
}
//
function fncGeneralSetSessionID(mySessionID){
	gSessionID = mySessionID;
}
//
function makeNumber(myNumber){
	
	var myResult = 0;
	
	try {
		var myNewNumber = parseFloat(myNumber);
	
		if (!isNaN(myNewNumber)){
			myResult = myNewNumber;
		}
		
	} catch(error) {
	  //
	}
	
	return myResult;
}

/////////////////////// FORMATTING

function numberWithSpaces(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "&nbsp;");
}

/////////////////////// VALIDATION

function fncGeneral_validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

////////////////////// URL

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

////////////////////// ERROR MESSAGING

function errorMessageSet(errorMessage, borderingErrorInputs = null, unborderingErrorInputs = null){
	
		$( "#errorMessage_ID p" ).html(errorMessage);
		$( "#errorMessage_ID" ).removeClass( "w3-hide" );
		$( "#successMessage_ID" ).addClass( "w3-hide" );
		
		$.each(borderingErrorInputs, function(index, value){
			$(value).removeClass("w3-border-green").addClass("w3-border-orange");
		});
		
		$.each(unborderingErrorInputs, function(index, value){
			$(value).removeClass("w3-border-green").removeClass("w3-border-orange");
		});
		
		fncGeneral_loaderHide();
}
//
function errorMessageHide(){
	
		$( "#errorMessage_ID" ).removeClass( "w3-show" );
		$( "#errorMessage_ID" ).addClass( "w3-hide" );
}

////////////////////// SUCCES MESSAGING

function successMessageSet(successMessage, borderingSuccessInputs = null, unborderingSuccessInputs = null){
	
		$( "#successMessage_ID p" ).text(successMessage);
		$( "#successMessage_ID" ).removeClass( "w3-hide" );
		$( "#errorMessage_ID" ).addClass( "w3-hide" );
		
		$.each(borderingSuccessInputs, function(index, value){
			$(value).removeClass("w3-border-orange").addClass("w3-border-green");
		});
		
		$.each(unborderingSuccessInputs, function(index, value){
			$(value).removeClass("w3-border-orange").removeClass("w3-border-green");
		});
		
		fncGeneral_loaderHide();
}

////////////////////// NEW PROTOTYPES


// Warn if overriding existing method
if (!Array.prototype.equals)
    console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");
		// attach the .equals method to Array's prototype to call it on any array
		Array.prototype.equals = function (array) {
		    // if the other array is a falsy value, return
		    if (!array)
		        return false;

		    // compare lengths - can save a lot of time 
		    if (this.length != array.length)
		        return false;

		    for (var i = 0, l=this.length; i < l; i++) {
		        // Check if we have nested arrays
		        if (this[i] instanceof Array && array[i] instanceof Array) {
		            // recurse into the nested arrays
		            if (!this[i].equals(array[i]))
		                return false;       
		        }           
		        else if (this[i] != array[i]) { 
		            // Warning - two different object instances will never be equal: {x:20} != {x:20}
		            return false;   
		        }           
		    }       
		    return true;
		}
// Hide method from for-in loops
Object.defineProperty(Array.prototype, "equals", {enumerable: false});