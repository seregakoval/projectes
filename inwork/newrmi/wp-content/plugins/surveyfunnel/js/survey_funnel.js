var surveySFOpen = false;
var surveySFURL = '';
var mouseOnSFDiv = false;
var surveySFActive = false;
var surveyshortSFOpen = false;

/*

*/
function triggerLightBox(iImage, iKey, iURL) {
	jQuery("img[src$='" + iImage + "']").each(function() {
		if (jQuery(this).parent().attr('href') != '') { 
			jQuery(this).parent().attr('href', "#question_" + iKey);
			//jQuery(this).parent().addClass('fancybox') /*removed and replaced in 2.0.8 for multiple lightboxes*/
			jQuery(this).parent().fancybox({
		hideOnContentClick: false,
		transitionIn:	'elastic',
		transitionOut: 'elastic',
		speedIn: 600, 
		speedOut: 200, 
		overlayShow: true,
		afterLoad: function() {
		
			loadSFFunnel(iKey, -1, iURL, true);
	
		},

		onClosed: function() {
			/* Commented below as its conflicting in trigger+leftside SF display */
			//jQuery('.surveyFunnelDiv').html('<br><center><img src="' + iURL + '/survey_funnel/images/loading.gif"></center>');
		}
	});
		
		} else {
		
				
		}		
		
	});
	
	jQuery('a.fancybox').fancybox({
		hideOnContentClick: false,
		transitionIn:	'elastic',
		transitionOut: 'elastic',
		speedIn: 600, 
		speedOut: 200, 
		overlayShow: true,
		afterLoad: function() {
			loadSFFunnel(iKey, -1, iURL, true);
		},
		
		onClosed: function() {
			jQuery('.surveyFunnelDiv').html('<br><center><img src="' + iURL + '/images/loading.gif"></center>');
		}
	});
}



/*

*/
function prepareSFFunnel(iKey, iIndex, iURL) {
	if (surveySFOpen) {
		return false;
	}
	
	surveySFOpen = true;
	surveySFActive = true;
	surveySFURL = iURL;
	
	jQuery('.surveyFunnelDiv').hover(function() {
		//jQuery('#staticsurvey').hover(function() {
		mouseOnSFDiv = true; 
    }, function() {
        mouseOnSFDiv = false; 
    });

	jQuery("body").mouseup(function() {
		if ((surveySFOpen) && (!mouseOnSFDiv)) closeSFFunnel(iKey, false);
    });	
	
	jQuery('#' + iKey).css({'opacity' : 0.25});
	var tmpDiv = jQuery('#question_' + iKey);
	tmpDiv.show();
	tmpDiv.animate({left: 0}, 'slow', function() {
		loadSFFunnel(iKey, iIndex, iURL ,iLightBox='slide');
	});
}

function shortcodeSFFunnel(iKey, iIndex, iURL) {
	
	if (surveyshortSFOpen) {
		return false;
	}
	
	surveyshortSFOpen = true;
	surveySFActive = true;
	surveySFURL = iURL;
	
	jQuery('#' + iKey).css({'opacity' : 0.25});
	var tmpDiv = jQuery('#question_' + iKey);
	
	tmpDiv.show();
	
		loadSFFunnel(iKey, iIndex, iURL);
	
}

function loadSFFunnel(iKey, iIndex, iURL, iLightBox) {
	if (iLightBox == null) {
		iLightBox = false;
	}
		
		var r = jQuery.post(iURL + '/json.php?action=LOAD_FUNNEL', {survey_key: iKey, trigger_answer: iIndex, url: iURL, light_box: iLightBox}, function(data) {
				
		jQuery('#question_' + iKey).html(data.replace('|||eosf', ''));
		
		if (data.indexOf('|||eosf') > -1) {
			completeSFFunnel(iKey);
		}		
	});	
}

/*

*/
function submitSFAnswer(SurveyFunnelKey, iURL, iID, iQuestionID, iPriority, iAnswer, iExtra_answer, iColor, iAnswerIndex,iSurvey_theme) {
	var tmpHeight = jQuery('#question_' + SurveyFunnelKey).height();
	var tmpWidth = jQuery('#question_' + SurveyFunnelKey).width();
	
	//jQuery('#question_' + SurveyFunnelKey).prepend('<div style="width: ' + tmpWidth + 'px; height: ' + tmpHeight + 'px; position: absolute; background-color: #999; opacity:0.4; filter:alpha(opacity=40);"><br><center><img src="' + iURL + '/survey_funnel/images/loading.gif"></center></div>');
	jQuery('#question_' + SurveyFunnelKey).prepend('<div style="width: ' + tmpWidth + 'px; height: ' + tmpHeight + 'px; position: absolute;"><br><center><img src="' + iURL + '/images/loading.gif"></center></div>');
	
	jQuery.post(iURL + '/json.php?action=SUBMIT_ANSWER', {survey_key: SurveyFunnelKey, answer: iAnswer, extra_ans: iExtra_answer, url: iURL, survey_id: iID, survey_question_id: iQuestionID, survey_priority: iPriority, color: iColor, answer_index: iAnswerIndex, survey_theme: iSurvey_theme}, function(data) {		
		jQuery('#question_' + SurveyFunnelKey).html(data.replace('|||eosf', ''));
		
		if (data.indexOf('|||eosf') > -1) {
			completeSFFunnel(SurveyFunnelKey);
		}		
	});
}

//BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation

function mysfUserinfo(SurveyFunnelKey, iURL, iID, iQuestionID, iPriority, iAnswer, iColor){
   
	var uname= document.getElementById("uname").value;
	var email= document.getElementById("email").value;
    var form_values = jQuery('#usercontent form').serializeArray();
	if(validateEmail(email)){
	var tmpHeight = jQuery('#question_' + SurveyFunnelKey).height();
	var tmpWidth = jQuery('#question_' + SurveyFunnelKey).width();
	jQuery('#question_' + SurveyFunnelKey).prepend('<div style="width: ' + tmpWidth + 'px; height: ' + tmpHeight + 'px; position: absolute;"><br><center><img src="' + iURL + '/images/loading.gif"></center></div>');
	
	 jQuery.post(iURL + '/json.php?action=SUBMIT_USERINFO', {survey_key: SurveyFunnelKey, answer: iAnswer, url: iURL, survey_id: iID, survey_question_id: iQuestionID, survey_priority: iPriority, color: iColor,user_name:uname,email_id:email,form:form_values}, function(data) {		
		
		jQuery('#question_' + SurveyFunnelKey).html(data.replace('|||eosf', ''));
		if (data.indexOf('|||eosf') > -1) {
			completeSFFunnel(SurveyFunnelKey);
		}		
	});  
	}else {
		alert('Please Enter Valid Email address');
	}
}
function cancelUserInfo(SurveyFunnelKey, iURL, iID, iQuestionID, iPriority, iAnswer, iColor){


	var tmpHeight = jQuery('#question_' + SurveyFunnelKey).height();
	var tmpWidth = jQuery('#question_' + SurveyFunnelKey).width();
	jQuery('#question_' + SurveyFunnelKey).prepend('<div style="width: ' + tmpWidth + 'px; height: ' + tmpHeight + 'px; position: absolute;"><br><center><img src="' + iURL + '/images/loading.gif"></center></div>');
	
	 jQuery.post(iURL + '/json.php?action=CANCELUSERINFO', {survey_key: SurveyFunnelKey, answer: iAnswer, url: iURL, survey_id: iID, survey_question_id: iQuestionID, survey_priority: iPriority, color: iColor}, function(data) {		
		
		jQuery('#question_' + SurveyFunnelKey).html(data.replace('|||eosf', ''));
		if (data.indexOf('|||eosf') > -1) {
			completeSFFunnel(SurveyFunnelKey);
		}		
	});  
	
	}
// End By Arvind

function validateEmail(email) {         
           var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
           return re.test(email);
}


/*

*/

function completeSFFunnel(iKey) {
	surveySFActive = false;
	//jQuery('#question_' + iKey).prepend('[ <a href="javascript:void(0);" onclick="closeSFFunnel(\'' + iKey + '\');">Close</a> ]<br>');
}


/*

*/
function closeSFFunnel(iKey, iTotalHide) {
	if (iTotalHide == null) {
		iTotalHide = true;
	}
	
	if (surveySFActive == false) {
		iTotalHide = true;
	}
	
	surveySFActive = false;
	surveySFOpen = false;
	
	var tmpDiv = jQuery('#question_' + iKey);

	if (iTotalHide) {
		jQuery('#' + iKey).fadeOut('fast');
		tmpDiv.animate({left: '-=' + tmpDiv.width(), opacity: 0}, 'fast', function() {
			jQuery('.surveyFunnelDiv img').hide();
			jQuery(this).hide();
		});	
	
	} else {
		jQuery('#' + iKey).css({'opacity' : 1});
		tmpDiv.animate({left: '-=' + tmpDiv.width(), opacity: 0}, 'fast', function() {
			jQuery(this).html('<br><center><img src="' + surveySFURL + '/images/loading.gif"></center>');
			jQuery(this).hide();
			jQuery(this).css({'opacity' : 1});
		});
	}
}
