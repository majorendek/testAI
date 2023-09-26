/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 29.11.2019

call functions
*/

/////// VARIABLES

//JS MODULES calls
gURL_MODULES = "../../modules/";
gURL_MODULE_test = gURL_MODULES + "test/test.html";
gURL_MODULE_startSiteAll = gURL_MODULES + "../index_testovanie_zs.php"

gURL_MODULE_login = gURL_MODULES + "login/login.html";
gURL_MODULE_signup = gURL_MODULES + "login/signup.html";
gURL_MODULE_forgot = gURL_MODULES + "login/forgot.html";

gURL_MODULE_testovanie_start = gURL_MODULES + "test/testStart.html";
gURL_MODULE_testovanie = gURL_MODULES + "test/test.html";

gURL_MODULE_dashboard = gURL_MODULES + "dashboard/dashboard.html";
gURL_MODULE_admin = gURL_MODULES + "admin/admin.html";

gURL_MODULE_teacher = gURL_MODULES + "teacher/teacher.html";

//PHP calls
gURL_PHP = "../../php/";
//gURL_PHP_loadTest = gURL_PHP + "loadTest.php";
gURL_PHP_saveClientInfo = gURL_PHP + "saveClientInfo.php";
gURL_PHP_saveTestResults = gURL_PHP + "saveTestResults.php";
gURL_PHP_login = gURL_PHP + "login.php";
gURL_PHP_signup = gURL_PHP + "signup.php";
gURL_PHP_addChild = gURL_PHP + "addChild.php";
gURL_PHP_removeChild = gURL_PHP + "removeChild.php";
gURL_PHP_changeChild = gURL_PHP + "changeChild.php";
gURL_PHP_forgot = gURL_PHP + "forgot.php";
gURL_PHP_changePassword = gURL_PHP + "changePassword.php";
gURL_PHP_changeParent = gURL_PHP + "changeParent.php";
gURL_PHP_removeParent = gURL_PHP + "removeParent.php";
gURL_PHP_superschopnosti = gURL_PHP + "superschopnosti.php";
gURL_PHP_checkLogin = gURL_PHP + "checkLogin.php";
gURL_PHP_checkLoginExternUser = gURL_PHP + "checkLoginExternUser.php";
gURL_PHP_dashboard = gURL_PHP + "dashboard.php";
gURL_PHP_admin = gURL_PHP + "admin.php";
gURL_PHP_getUserInfo = gURL_PHP + "getUserInfo.php";
gURL_PHP_superschopnostiGetLastTest = gURL_PHP + "getLastTest.php";
gURL_PHP_teacher = gURL_PHP + "teacher.php";

gURL_PHP_logData = gURL_PHP + "logData.php";


/////// FUNCTIONS
function fncCalls_ajaxPostJSON(myURL,myJSON, myFunctionSuccess, myFunctionFailure){

		$.ajax({
		    type: "POST",
		    url: myURL,
		    data: myJSON,
		    contentType: "application/json; charset=utf-8",
		    dataType: "json",
		    success: function(data){
		    		
		    		if (myFunctionSuccess != ""){
		    			window[myFunctionSuccess](data);
		    		}
		    		
		    	},
		    failure: function(errMsg) {
		    	
		    	if (myFunctionFailure != ""){
		        window[myFunctionFailure]();
		      }
		      
		    }
		});
}

//
function fncCalls_ajaxLoadJSON(myURL, myFunctionSuccess, myFunctionFailure){

	$.getJSON( myURL, function() {
	  //console.log( "also success" );
	}).done(function(data) {
	    window[myFunctionSuccess](data);
	}).fail(function() {
			window[myFunctionFailure]();
	})
  
}