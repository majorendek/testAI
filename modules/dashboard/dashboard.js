/*
company: Forward Thinking s.r.o.
devloper: Marian Rendek
date: 10.01.2020

functions for dashboard
*/


/////// VARIABLES
var checkWindowWidth = 1000;
var childsData;
var chart = null;
var selectChildButton;

/////// FUNCTIONS

function fncDashboard_start(){
		fncGeneral_log( "[dashboard.js / fncDashboard_start() ] ... " );
		
		//general init
		fncGeneral_basicInit();
		fncGeneral_registerResize("fncDashboard_resize");
		
		//check login
		fncGeneral_checkLogin();
		
		//resize
		fncDashboard_resize();
		
		// take childs data from DB
		fncDashboard_loadChildsData();
		
		
		$("#dashboardChilExerciseSelector_ID").change(function(){
			fncDashboard_selectExampleType($(this).val())
		});
}
//
function fncSetModuleExtern(){
		$("#btnTab_Parent_Dashboard_ID").css("opacity", 0);		
		$("#btnTab_Parent_Dashboard_ID").attr("onclick","");	
		$("#btnTab_Parent_Logout_ID").css("opacity", 0);		
		$("#btnTab_Parent_Logout_ID").attr("onclick","");	
}
//
function fncDashboard_prepareDataAndGenerateGraf(button) {
		// hide alert if som exist
		$( "#dashboardGetDataAlert_ID" ).addClass( "w3-hide" );
		
		// change taps look
		var dashboardChildButtons = $( "#dashboardChildButtons_ID button" );
		
		$.each(dashboardChildButtons, function(index, item) {
			$(item).removeClass("w3-theme-d3 w3-button").addClass("w3-theme-d3 w3-button").attr("onclick", "fncDashboard_prepareDataAndGenerateGraf(this)");
			fncGeneral_log($(item));
		});
		$(button).removeClass("w3-theme-d3 w3-button").addClass(" w3-theme-l4").removeAttr("onclick");
		
		selectChildButton = button;
		
		var optionsFromChildData = fncDashboard_arrayCountValues(childsData[button.id],"testCode");
		
		$("#dashboardChilExerciseSelector_ID option").each(function() {
		    $(this).remove();
		});
	
		$.each(optionsFromChildData, function(index, value){
			
			try {
				
				//default set
				let myTestCode = "";
				let mySchoolType = "ZS";
				let myClass = "1";
				let myTestDefObj = {};
				let myTestName = "";
				let myTestDefArray = index.split("_");
				
				
					myTestCode = index;
					mySchoolType = myTestDefArray[0].toUpperCase();
					myClass = myTestDefArray[1];
					myTestDefObj = testZSObj;
						if (mySchoolType == "SS"){myTestDefObj = testSSObj;}
					myTestName = myTestDefObj[myClass][myTestCode];
				
				
					$("#dashboardChilExerciseSelector_ID").append('<option value="' + myTestCode + '">' + myTestName +  '</option>');	
				
				
			} catch (err){
				//$("#dashboardChilExerciseSelector_ID").append('<option value="' + index + '">Nedefinovaný test</option>');	
			}	
			
			
		});
		
		$("#dashboardChilExerciseSelector_ID").val(Object.keys(optionsFromChildData)[0]).trigger('change');
		
}
//
function fncDashboard_selectExampleType(option) {
		// destroy chart when tabs changing
		
		var gNumberOfSets = 20;  			//maximal 1000 sets of 16 exercises counted
		var gNumberOfBars = 8;		 		//maximal bar shown in graph
		var gNumberOfRealSets = 0;		//realSetsMade
		
			if (chart){ 
				chart.destroy() 
			};
				
				
		// prepare data for chart
		var exercisesResultGoodCounter = new Array(gNumberOfSets).fill(0);
		var exercisesResultCounter = new Array(gNumberOfSets).fill(0);
		var exercisesTimeTotalSeconds = new Array(gNumberOfSets).fill(0);
	
		var exercisesResultCounterFull = 0;
		var exercisesResultGoodCounterFull = 0;
		var exercisesTimeTotalSecondsFull = 0;	
		
				for (var i = 0, j = 0; i < childsData[selectChildButton.id].length && i < gNumberOfSets; i++) {
					
					if (childsData[selectChildButton.id][i]["testCode"] == option){
					
						exercisesResultGoodCounter[j] = (childsData[selectChildButton.id][i]["testResultGoodCounter"]) != 0 ? (childsData[selectChildButton.id][i]["testResultGoodCounter"]) : -1;
						exercisesResultCounter[j] = (childsData[selectChildButton.id][i]["testResultCounter"]);
						exercisesTimeTotalSeconds[j] = (childsData[selectChildButton.id][i]["testTimeTotalSeconds"]);
						
						
						exercisesResultCounterFull +=  parseInt(exercisesResultCounter[j]);
						exercisesResultGoodCounterFull += parseInt(exercisesResultGoodCounter[j]);
						exercisesTimeTotalSecondsFull += parseInt(exercisesTimeTotalSeconds[j]);
						
						j++;
						gNumberOfRealSets = j;
					}
					
				}
		
		// change taps look
		var dashboardSumResultsP = $( "#dashboardSumResults_ID p.result" );
		
		/*
		$.each(childsData[selectChildButton.id], function (key, value){	
			
			if (key == gNumberOfSets) {return false;}
			
			exercisesResultCounterFull += parseInt(value["exerciseResultCounter"])
			exercisesResultGoodCounterFull += parseInt(value["exerciseResultGoodCounter"]);
			exercisesTimeTotalSecondsFull += parseInt(value["exerciseTimeTotalSeconds"]);
			
		});
		*/
		
		$(dashboardSumResultsP[0]).text(exercisesResultCounterFull);
		$(dashboardSumResultsP[1]).text(exercisesResultGoodCounterFull);
		$(dashboardSumResultsP[2]).text(fncDashboard_secondsToHms(exercisesTimeTotalSecondsFull));
		
		// error if child don`t do some exercise
		if(exercisesResultGoodCounter.length == 0){
			$( "#dashboardGetDataAlert_ID p" ).text("Nenačítali sa žiadne výsledky");
			$( "#dashboardGetDataAlert_ID" ).removeClass( "w3-hide" );
		}
		
		// generate chart
		//generateGraph(exercisesResultGoodCounter.reverse(), exercisesResultCounter.reverse(), exercisesTimeTotalSeconds.reverse());
		
		var barsShown = gNumberOfRealSets;
				if (gNumberOfBars > gNumberOfRealSets){
					barsShown = gNumberOfBars;
				}
		
		exercisesResultGoodCounter = exercisesResultGoodCounter.slice(0, barsShown);
		exercisesResultCounter = exercisesResultCounter.slice(0, barsShown);
		exercisesTimeTotalSeconds = exercisesTimeTotalSeconds.slice(0, barsShown);
		
		generateGraph(exercisesResultGoodCounter, exercisesResultCounter, exercisesTimeTotalSeconds);
}
//
function generateGraph(exercisesResultGoodCounter, exercisesResultCounter, exercisesTimeTotalSeconds){
	
	var options = {
	 	series: [{
		name: 'Počet správnych odpovedí',
		type: 'column',
		data: exercisesResultGoodCounter
    },{
      name: 'Počet testovaných otázok',
      type: 'column',
      data: exercisesResultCounter
    }],
    chart: {
	    type: 'line',
	    height: 250,
	    stacked: true,
	    toolbar: {
	      show: false
	    }
    },  
		stroke: {
		    show: true,
		    width: 3,     
		},  
    colors: ['#5488c2', '#a9c3dc', 'red'],
    
    xaxis: {
      type: 'category',
      categories: exercisesResultGoodCounter,
      labels: {
      	formatter: function(value) {
      		if(value == -1)
      			return value + 1;
          return value;
        }
      }
    },
    yaxis: [
          {
          	axisTicks: {
              show: true,
            },
            
          	axisBorder: {
              show: true,
              color: '#5488c2'
            },
            
            labels: {
              style: {
                color: '#5488c2',
              }
            },
            max: 16,
            min: 0
          }
        ],
    legend: {
    	show: false,
      position: 'top',
      offsetX: 0,
			offsetY: 0,
			formatter: function() {
		      return null;
		  }
    },
    fill: {
      opacity: 1,
    },
    dataLabels: {
    	enabled: false,
    },
    tooltip: {
      enabled: true,
      enabledOnSeries: [0],
      x: {
      	show: false
      },
      y: {
      	formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
      		if(series[seriesIndex][dataPointIndex] == -1)
      			return value+1;
		      return value;
		    }
		  }
    },
    plotOptions: {
      bar: {      	
        horizontal: false,
        dataLabels: {
          position: 'bottom'
        },
      }
    }
};

chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
}
//
function fncDashboard_resize(){
	
		fncGeneral_log("[dashboard.js / fncDashboard_resize() ] ================= ");

		if (gGlobalDeviceObject["innerWidth"] > checkWindowWidth){
					$("#chart").css("width", "60vw");
				
		} else {
				//MOBIL	
				$("#chart").css("width", "90vw");
		}
}
//
function fncDashboard_loadChildsData() {	
	//show loader
	fncGeneral_loaderShow();

	//JSON	
		ResultsJSON =  { 
				    	"data" : { 
				        "sessionid" : gSessionID
				    	}
						};
						
		fncGeneral_log(ResultsJSON);
		
		fncCalls_ajaxPostJSON(gURL_PHP_dashboard,JSON.stringify(ResultsJSON), "fncDashboard_loadChildSuccess", "fncDashboard_loadChildFailure");
}//
function fncDashboard_loadChildSuccess(myDataJSON) {
	//hide loader
	fncGeneral_loaderHide();

	fncGeneral_log(myDataJSON);
	
	if(myDataJSON["result"]["status"] == "OK") {
		// save children data
		childsData = myDataJSON["data"]["childrenData"];		
		
		// generate buttoms
		$.each( childsData, function( key, value ) {
		  $("#dashboardChildButtons_ID").append("<button id='"+key+"' class='w3-bar-item w3lt-tab-button-frame tablink w3-theme-d3 w3-button' onclick='fncDashboard_prepareDataAndGenerateGraf(this)'>"+key+"</button>");
		});		
		
		$( "#dashboardChildButtons_ID button" )[0].click();
		
	} else {
		fncDashboard_loadChildFailure();
	}
}//
function fncDashboard_loadChildFailure() {
	fncGeneral_loaderHide();
	errorMessageSet("Neexistujú žiadne výsledky na zobrazenie.");
}
//
//
function fncDashboard_secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var hDisplay = h > 0 ? h + " hod. " : "";
    var mDisplay = m > 0 ? m + " min. " : "";
    var sDisplay = s > 0 ? s + " sek. " : "";
    return hDisplay + mDisplay + sDisplay; 
}

function fncDashboard_arrayCountValues(myCurrentArray,exerciseType) {

	var counts = {};

	for(var i=0;i< myCurrentArray.length;i++)
	{
	  var key = myCurrentArray[i][exerciseType];
	  counts[key] = (counts[key])? counts[key] + 1 : 1 ;	    
	}
	
	return counts;
}
/////// CALLS