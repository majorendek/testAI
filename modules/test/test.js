/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 30.03.2021

functions for test
*/


/////// VARIABLES
gTestExactOrder = 0; //testers define exact test order
gTestMode = "test"; //test,answers
var gTestName = "";
var gTestPopis = "Priprav si pero alebo ceruzku a papier na počítanie. Počítaj bez kalkulačky. Tvoje riešenie neohraničujeme časom, tak sa pokojne sústreď na každú úlohu.<br>V ponuke máš štyri možnosti označené písmenami A, B, C, D, pričom správna je vždy iba jedna z nich.<br>Na konci testu sa ti zobrazí vyhodnotenie.<br>Test môžeš zopakovať niekoľkokrát, vždy sa ti zobrazia iné úlohy.<br>";
var gTestJSON;
var gClientID = 0;
//var gTestDefinition = {}
var gTestSourcePath = "../../test_definitions/";
var gTestQuestionCounter = 0;
var gTestActualObject = {
			testCode: "",
			testName: "",
			startTime: "",
			endTime: "",
			duration: "", //in seconds
			nrOfQuestions: 0,
			goodAnswers: 0,
			clientId: 0,
			testQuestions: []
		}
var gStudyText = "Vráť sa na stranu STRANA v MENO.";
		
/////// FUNCTIONS

function fncTest_start(){
		
		//show loader
		fncGeneral_loaderShow();
		
		//general init
		fncGeneral_basicInit();
		fncGeneral_registerResize("fncTest_resize");
		
		//checkLogin
		fncGeneral_checkLogin();
		
		//resize
		fncTest_resize();
		
		//initialize page element
		fncTest_initializeElements();
		
		//find function
		gTestName = ($.urlParam('test') == null)?"":$.urlParam('test');
		
		//for testers - check = test with exact order
		gTestExactOrder = ($.urlParam('check') == null)?0:$.urlParam('check');
		
		//set test path
		gTestSourcePath = gTestSourcePath + gTestName + "/";
		
		//load JSON TEST
		if (gTestName != ""){
			fncCalls_ajaxLoadJSON(gTestSourcePath +  gTestName + ".json", "fncTest_loadJsonSuccess", "fncTest_loadJsonFailure");
		} else {
			fncTest_loadJsonFailure();
		}
				
}
//
function fncSetModuleExtern(){
		
}
//
function fncTest_resize(){
	//called when window is resized	
}
function fncTest_hideAllScreens(){
  // Array of element ids
  const elementsToHide = ["testStartPage", "testPage", "testResultPage", "testEndPage"];
  
  // Loop through the array and call fncGeneral_elementHide for each id
  for (let i = 0; i < elementsToHide.length; i++) {
    fncGeneral_elementHide(elementsToHide[i]);
  }
}
//
function fncTest_initializeElements(){

		//startPage
		$( "#testButtonBegin_ID" ).click(function() {fncTest_generateScreenTest();});
		
		//testPage
		$( "#testButtonAnswer_id_0" ).click(handleAnswerClick);
		$( "#testButtonAnswer_id_1" ).click(handleAnswerClick);
		$( "#testButtonAnswer_id_2" ).click(handleAnswerClick);
		$( "#testButtonAnswer_id_3" ).click(handleAnswerClick);
		
		$( "#testButtonPrevious_ID" ).click(function(){
			if (gTestMode == "test"){
				fncTest_btnTestPreviousPageClick();
			}	else  if (gTestMode == "answers"){
				fncTest_btnTestPreviousPageAnswersClick();
			}
		});
		$( "#testButtonNext_ID" ).click(function(){
			if (gTestMode == "test"){
				fncTest_btnTestNextPageClick();
			} else if (gTestMode == "answers"){
				fncTest_btnTestNextPageAnswersClick();
			}
		});
		$( "#testButtonEvaluate_ID" ).click(function(){fncTest_btnTestEvaluatePageClick();});
		
		//testResultPage
		$( "#testButtonAgain_ID" ).click(function() {fncTest_generateScreenTest();});
		$( "#testButtonShowResult_ID" ).click(function() {fncTest_generateScreenTestResultAnswers();});
		
		//testEndPage
		$( "#testButtonAgain2_ID" ).click(function() {fncTest_generateScreenTest();});
		$( "#testButtonEnd_ID" ).click(function() {
			window.location.href = "../../blank.html";
		});
		
		function handleAnswerClick() {
			if (gTestMode == "test") {
				var answerId = parseInt($(this).attr("id").split("_")[1]);
				fncTest_btnAnswerClick(answerId);
			}
		}
}
//
function fncTest_loadJsonSuccess(myJson){
	gTestJSON = myJson;
	fncTest_generateScreenStart();
}
//
function fncTest_loadJsonFailure(){
	fncGeneral_loaderHide();
	fncGeneral_modalInfoSetAndShow("Nastala chyba. Nemôžem vygenerovať test.");
}
//
function fncTest_generateScreenTestResultAnswers(){
	
		fncTest_hideAllScreens();
	
		gTestMode = "answers";
		gTestQuestionCounter = 0;
		fncTest_setScreenAnswers();
		
		fncGeneral_elementShow("testPage");
}
function fncTest_setScreenAnswers(){
	
	//buttons
	$("#testButtonPrevious_ID").hide();
	$("#testButtonNext_ID").hide();	
	$("#testButtonEvaluate_ID").hide();	
	
	if (gTestQuestionCounter>0){ $("#testButtonPrevious_ID").show();}
	if (gTestQuestionCounter<gTestActualObject["nrOfQuestions"]){ $("#testButtonNext_ID").show();}
	
	//counter
	$("#testPage_Counter_id").html("&nbsp;&nbsp;" + (gTestQuestionCounter+1) + "&nbsp;&nbsp;");

	//question
	//$("#testPage_Zadanie_id").html(gTestActualObject["testQuestions"][gTestQuestionCounter]["question"]);
	var $el = $('#testPage_Zadanie_id');
			$el.empty();
			$el.append(gTestActualObject["testQuestions"][gTestQuestionCounter]["question"]);
			
			//var $el = $('#dynamic-pan')
		  //$el.empty()
		  //$el.append('<span>\\(x = {-b \\pm \\sqrt{b^2-4ac} \\over 2a}\\)</span>')
  		MathJax.Hub.Queue(['Typeset', MathJax.Hub, $el[0]]);
  	
	
	//answer buttons
	 	fncTest_resetAnswerButtons();
	 	if (gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] > -1){
	 		$("#testButtonAnswer_id_" + gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"]).addClass("w3-theme-d5-red");
	 	}
	 	$("#testButtonAnswer_id_" + gTestActualObject["testQuestions"][gTestQuestionCounter]["goodAnswer"]).addClass("w3-theme-d5-green");
	 	
	//answers
	for (let myAnswerIndex = 0; myAnswerIndex < gTestActualObject["testQuestions"][gTestQuestionCounter]["answers"].length; myAnswerIndex++){
			
			
			let myAnswerText = gTestActualObject["testQuestions"][gTestQuestionCounter]["answers"][myAnswerIndex]
					$("#testPage_Odpoved_id_" + myAnswerIndex).removeClass();
					
					if (
							(gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] == myAnswerIndex)
							&& 
						 	(gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] != gTestActualObject["testQuestions"][gTestQuestionCounter]["goodAnswer"])
					){
							//red
							$("#testPage_Odpoved_id_" + myAnswerIndex).addClass("w3-theme-d5-text-red");
							myAnswerText = "<b>" + myAnswerText + "</b>";
							
					} else if (gTestActualObject["testQuestions"][gTestQuestionCounter]["goodAnswer"] == myAnswerIndex){
							//green
							$("#testPage_Odpoved_id_" + myAnswerIndex).addClass("w3-theme-d5-text-green");
							myAnswerText = "<b>" + myAnswerText + "</b>";
						
					} else {
							//normal
					}
					
					$("#testPage_Odpoved_id_" + myAnswerIndex).html("&nbsp;&nbsp;" + myAnswerText);
					MathJax.Hub.Queue(['Typeset', MathJax.Hub, $("#testPage_Odpoved_id_" + myAnswerIndex)[0]]);		
	}
	
	//study
	let myStudyStrana = gTestActualObject["testQuestions"][gTestQuestionCounter]["studyPage"];
	let myStudyMeno = gTestActualObject["testQuestions"][gTestQuestionCounter]["studyName"];
	let myStudyText = gStudyText.split("STRANA").join(myStudyStrana).split("MENO").join(myStudyMeno);
	
		$("#endPage_study_id").html(myStudyText);


		if (gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] == gTestActualObject["testQuestions"][gTestQuestionCounter]["goodAnswer"]){
			
			$("#endPage_study_id").hide();
			
		} else {
			
			if ((myStudyStrana === undefined) || (myStudyMeno === undefined)) {
		   
		   	$("#endPage_study_id").hide();
		   
			} else {
			
				$("#endPage_study_id").show();
				
			}
			
		}
	
	
}
//
function fncTest_generateScreenTestResult(){

	fncTest_hideAllScreens();
	
	$( "#testResultPage_good" ).html(gTestActualObject["goodAnswers"]);
	$( "#testResultPage_all" ).html(gTestActualObject["nrOfQuestions"]);
	
	$( "#testResultPage_study" ).hide();
	try { 
		
		if (gTestActualObject["testStudy"] != undefined){
			$( "#testResultPage_study" ).html(gTestActualObject["testStudy"]);
			$( "#testResultPage_study" ).show();
		}
		
	} catch (e){
	}
		
	
	
	
	fncGeneral_elementShow("testResultPage");
	
	gTestActualObject["sessionid"] = gSessionID;
	
	fncCalls_ajaxPostJSON(gURL_PHP_saveTestResults,JSON.stringify(gTestActualObject), "fncTest_resultsDBSuccess", "fncTest_resultsDBFailure");
	
}
//
function fncTest_btnTestEvaluatePageClick(){

	//update object
	gTestActualObject["endTime"] = new Date();
	gTestActualObject["duration"] = Math.floor((gTestActualObject["endTime"].getTime() - gTestActualObject["startTime"])/1000);
	
	gTestActualObject["goodAnswers"] = 0;
	
	//evaluate answers
	for (let myAnswerIndex = 0; myAnswerIndex < gTestActualObject["testQuestions"].length; myAnswerIndex++){
		
//console.log("chosen = " + gTestActualObject["testQuestions"][myAnswerIndex]["chosenAnswer"]);
//console.log("good = " + gTestActualObject["testQuestions"][myAnswerIndex]["goodAnswer"]);
		
				if (gTestActualObject["testQuestions"][myAnswerIndex]["chosenAnswer"] == gTestActualObject["testQuestions"][myAnswerIndex]["goodAnswer"]){
						gTestActualObject["goodAnswers"]++;	
				}
	}
	
	fncTest_generateScreenTestResult();
}
//
function fncTest_btnAnswerClick(myAnswer){
	
		//set answer
	 	gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] = myAnswer;
	 
	 	//reset button colors
	 	fncTest_resetAnswerButtons();
	 
		//change button color
	 	$("#testButtonAnswer_id_" + myAnswer).addClass("w3-theme-d5-chosenAnswer");
		
}
//
function fncTest_resetAnswerButtons(){
	$("#testButtonAnswer_id_0").removeClass();
	$("#testButtonAnswer_id_1").removeClass();
	$("#testButtonAnswer_id_2").removeClass();
	$("#testButtonAnswer_id_3").removeClass();
	
	$("#testButtonAnswer_id_0").addClass("w3-theme-d5");
	$("#testButtonAnswer_id_1").addClass("w3-theme-d5");
	$("#testButtonAnswer_id_2").addClass("w3-theme-d5");
	$("#testButtonAnswer_id_3").addClass("w3-theme-d5");
}
//
function fncTest_btnTestPreviousPageClick(){
	gTestQuestionCounter--;
	fncTest_setScreenTest();
}
//
function fncTest_btnTestNextPageClick(){
	gTestQuestionCounter++;
	fncTest_setScreenTest();
}
//
function fncTest_btnTestPreviousPageAnswersClick(){
	gTestQuestionCounter--;
	fncTest_setScreenAnswers();
}
//
function fncTest_btnTestNextPageAnswersClick(){
	gTestQuestionCounter++;
	
	if (gTestQuestionCounter < gTestActualObject["nrOfQuestions"]){
		fncTest_setScreenAnswers();
	} else {
		fncTest_generateScreenEnd();
	}
}
//
function fncTest_generateScreenEnd(){
	
	fncTest_hideAllScreens();
	
	$("#endPage_Thank_id").html(gTestActualObject["testThank"]);
	
	fncGeneral_elementShow("testEndPage");
	
}
//
function fncTest_generateScreenTest(){
	
	fncTest_hideAllScreens();
	
	//create test
		gTestActualObject["testCode"] = gTestJSON["testCode"];
		gTestActualObject["testName"] = gTestJSON["testName"];
		gTestActualObject["testThank"] = gTestJSON["testThank"];
		gTestActualObject["testStudy"] = gTestJSON["testStudy"];
		gTestActualObject["startTime"] = new Date();
		gTestActualObject["endTime"] = 0;
		gTestActualObject["duration"] = 0;
		gTestActualObject["nrOfQuestions"] = gTestJSON.testQuestions.length;
		gTestActualObject["goodAnswers"] = 0;
		gTestActualObject["testQuestions"] = [];
		
		let questionOrderArray = Array.from(Array(gTestActualObject["nrOfQuestions"]).keys()).sort(() => .5 - Math.random());
				

		//testers option
		if (gTestExactOrder != 0){
			questionOrderArray = Array.from(Array(gTestActualObject["nrOfQuestions"]).keys());
		}
		
		for (let indexQuestion = 0; indexQuestion < gTestActualObject["nrOfQuestions"]; indexQuestion++){
			
			let testQuestionObject = {};
			let questionNr = questionOrderArray[indexQuestion];
			let questionJsonObject = gTestJSON.testQuestions[questionNr];
			let questionModificationNr = Math.floor((Math.random() * questionJsonObject["modifications"].length)-0.0001);	
			
				//testers option
				if ((gTestExactOrder > 0) && (gTestExactOrder <= questionJsonObject["modifications"].length)){
					questionModificationNr = gTestExactOrder-1;
				}
				
			let questionModificationObject = questionJsonObject["modifications"][questionModificationNr];
		
		  //make question
			let myQuestion = questionJsonObject["question"];
					for (const myProperty in questionJsonObject["modifications"][questionModificationNr]["variables"]) {
				 		let myValue = questionModificationObject["variables"][myProperty]
				 				myQuestion = myQuestion.split(myProperty).join(myValue);
					}			
					testQuestionObject["question"] = myQuestion;
					
			//make answers	
			let myAnswers = [];
			let answerOrderArray = [0,1,2,3].sort(() => .5 - Math.random());	

				//testers option
				if (gTestExactOrder != 0){
					answerOrderArray = [0,1,2,3];
				}			
		
					testQuestionObject["goodAnswer"] = -1;
					
					for (let indexAnswer = 0; indexAnswer < answerOrderArray.length; indexAnswer++){
							let answer = questionModificationObject["answers"][answerOrderArray[indexAnswer]];
									myAnswers.push(answer);
									
									//set good answer index
									if (answerOrderArray[indexAnswer] == 0){testQuestionObject["goodAnswer"] = indexAnswer;}
					}
		
					testQuestionObject["answers"] = myAnswers;
					testQuestionObject["nrAnswers"] = myAnswers.length; 
					testQuestionObject["chosenAnswer"] = -1;
					
					try {
						testQuestionObject["studyPage"] = questionJsonObject["studium"]["STRANA"];
						testQuestionObject["studyName"] = questionJsonObject["studium"]["MENO"];
					} catch (err){
						testQuestionObject["studyPage"] = "";
						testQuestionObject["studyName"] = "";
					}
		
					gTestActualObject["testQuestions"].push(testQuestionObject);
		}
	
	//reset screen TEST
	gTestQuestionCounter = 0;
	gTestMode = "test";
	fncTest_setScreenTest();
	
	fncGeneral_elementShow("testPage");
}
//
function fncTest_setScreenTest(){
		
	//buttons
	$("#testButtonPrevious_ID").hide();
	$("#testButtonNext_ID").hide();	
	$("#testButtonEvaluate_ID").hide();	
	if (gTestQuestionCounter>0){ $("#testButtonPrevious_ID").show();}
	if (gTestQuestionCounter<gTestActualObject["nrOfQuestions"]-1){ 
		$("#testButtonNext_ID").show();
	} else {
		$("#testButtonEvaluate_ID").show();
	}
	
	//counter
	$("#testPage_Counter_id").html("&nbsp;&nbsp;" + (gTestQuestionCounter+1) + "&nbsp;&nbsp;");

	//question
	//$("#testPage_Zadanie_id").html(gTestActualObject["testQuestions"][gTestQuestionCounter]["question"]);
	
	var $el = $('#testPage_Zadanie_id');
			$el.empty();
			$el.append(gTestActualObject["testQuestions"][gTestQuestionCounter]["question"]);
			
			//var $el = $('#dynamic-pan')
		  //$el.empty()
		  //$el.append('<span>\\(x = {-b \\pm \\sqrt{b^2-4ac} \\over 2a}\\)</span>')
  		MathJax.Hub.Queue(['Typeset', MathJax.Hub, $el[0]]);		  
		  


//TODO:MRN	
		  
		 
			
			


	
	//answer buttons
	
	if (gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"] > -1){
		fncTest_btnAnswerClick(gTestActualObject["testQuestions"][gTestQuestionCounter]["chosenAnswer"]);
	} else {
		fncTest_resetAnswerButtons();	
	}
	
	//answers
	for (let myAnswerIndex = 0; myAnswerIndex < gTestActualObject["testQuestions"][gTestQuestionCounter]["answers"].length; myAnswerIndex++){
			
				$("#testPage_Odpoved_id_" + myAnswerIndex).removeClass();
				$("#testPage_Odpoved_id_" + myAnswerIndex).html("&nbsp;&nbsp;" + gTestActualObject["testQuestions"][gTestQuestionCounter]["answers"][myAnswerIndex]);
				
				MathJax.Hub.Queue(['Typeset', MathJax.Hub, $("#testPage_Odpoved_id_" + myAnswerIndex)[0]]);

//TODO:MRN	
/*				
				$("#testPage_Odpoved_id_" + myAnswerIndex).html(
				
							"&nbsp;&nbsp;" 
							+ "<img style='width:50%' src='" + gTestSourcePath + "tabulka_01.jpg'>"
							+ gTestActualObject["testQuestions"][gTestQuestionCounter]["answers"][myAnswerIndex]
				);
*/
				
	}
	
}
//
function fncTest_generateScreenStart(){
	
	fncTest_hideAllScreens();
	
	$("#startPage_TestName_id").html(gTestJSON.testName);
	
	try {
		if (gTestJSON.testPopis.trim().length > 0){
			gTestPopis = gTestJSON.testPopis.trim();
		}
	} catch (error){}
	$("#startPage_TestPopis_id").html(gTestPopis);
	
	fncGeneral_elementShow("testStartPage");
	
	let myCallURL = location.href;
	let myClient = new ClientJS();
		with (myClient) {
		
			//JSON	
					var postJSON =  { 
					    	"data" : { 
					       
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
		
		fncCalls_ajaxPostJSON(gURL_PHP_saveClientInfo,JSON.stringify(postJSON), "fncTest_ClientDBSuccess", "fncTest_ClientDBFailure");

	
	fncGeneral_loaderHide();
}


/////// CALLS

function fncTest_resultsDBSuccess(myDataJSON){
	//nothing
}
//
function fncTest_resultsDBFailure(myDataJSON){
	//nothing
}
//
function fncTest_ClientDBSuccess(myDataJSON){
	
		fncGeneral_log(myDataJSON);
		
		try {
			
			var resultObj = myDataJSON;
			
					if (resultObj["result"]["status"] == "OK"){
						
							gClientID = resultObj["data"]["clientid"];
							gTestActualObject["clientId"] = gClientID;
						
					} else {
						//nothing
					}
			
		} catch(err) {
		  fncLogin_loginFailure("");
		}
		
}
//
function fncTest_ClientDBFailure(myMessage){
		//nothing
		//fncGeneral_log("fail");	
}