//------------------------------------------------------------------
// version 1.0
// create by tw.jason.chen@gmail.com
//------------------------------------------------------------------
class SlideCountdownClock extends MovieClip {
	//---------------------------------------------------------------------------------------
	//define vars
	//---------------------------------------------------------------------------------------
	private var __tickId:Number;
	private var __targetTimeText:String;
	private var __targetTimeZone:Number;
	private var __targetTime:Date;
	private var __oldTime:Date;
	private var __currentTime:Date;
	private var __slideWidth:Number;
	private var __slideHeight:Number;
	private var __labelHeight:Number;
	private var __labelDay:TextField;
	private var __labelHour:TextField;
	private var __labelMin:TextField;
	private var __labelSec:TextField;
	private var __border1:MovieClip;
	private var __border2:MovieClip;
	private var __mask:MovieClip;
	private var __day1:MovieClip;
	private var __day2:MovieClip;
	private var __day3:MovieClip;
	private var __hour1:MovieClip;
	private var __hour2:MovieClip;
	private var __min1:MovieClip;
	private var __min2:MovieClip;
	private var __sec1:MovieClip;
	private var __sec2:MovieClip;
	private var __innerGlow:MovieClip;
	private var __shadow:MovieClip;
	private var __bgColor:Number;
	private var __textColor:Number;
	private var __innerGlowAlpha:Number;
	private var __bgLightAlpha:Number;
	private var __bgShadowAlpha:Number;
	private var __showLabel:Boolean;
	private var __strDay:String;
	private var __strHour:String;
	private var __strMin:String;
	private var __strSec:String;
	private var __labelColor:Number;
	private var __labelShadowColor:Number;
	private var __textSpace:Number;
	private var __showDay:Boolean;
	private var __showHour:Boolean;
	private var __showMin:Boolean;
	private var __showSec:Boolean;
	private var __config_xml:XML;
	public var onFinish:Function;
	public var onConfigLoad:Function;
	//---------------------------------------------------------------------------------------
	//constructor
	//---------------------------------------------------------------------------------------
	public function SlideCountdownClock() {
		//---------------------------------------------------------------------------------------
		//init vars
		//---------------------------------------------------------------------------------------
		__slideWidth = 55;
		__slideHeight = 70;
		__labelHeight = 20;
		__textSpace = 15;
		__showLabel = true;
		__showDay = true;
		__showHour = true;
		__showMin = true;
		__showSec = true;
		__strDay = "DAYS";
		__strHour = "HOURS";
		__strMin = "MINUTES";
		__strSec = "SECONDS";
		__bgColor = 0x262626;
		__textColor = 0xFFFFFF;
		__labelColor = 0xFFFFFF;
		__labelShadowColor = 0x262626;
		__innerGlowAlpha = 100;
		__bgLightAlpha = 100;
		__bgShadowAlpha = 100;
		
		refreshUI();

		var target = this;
		__config_xml = new XML();
		__config_xml.ignoreWhite = true;
		//parse config on config loaded
		__config_xml.onLoad = function(success){
			if(success){
				target._visible = true;

				var config = target.parseXml(this.firstChild);
				var targetTimeText = config.targetTimeText[0]["@value"];
				var targetTimeZone =  parseFloat(config.targetTimeZone[0]["@value"]);
				var textColor =  parseInt(config.textColor[0]["@value"],16);
				var bgColor =  parseInt(config.bgColor[0]["@value"],16);
				var bgLightAlpha =  parseFloat(config.bgLightAlpha[0]["@value"]);
				var bgShadowAlpha =  parseFloat(config.bgShadowAlpha[0]["@value"]);
				var innerGlowAlpha =  parseFloat(config.innerGlowAlpha[0]["@value"]);
				var textSpace = parseFloat( config.textSpace[0]["@value"]);
				var showLabel = config.showLabel[0]["@value"]=="true";
				var showDay = config.showDay[0]["@value"]=="true";
				var showHour = config.showHour[0]["@value"]=="true";
				var showMin = config.showMin[0]["@value"]=="true";
				var showSec = config.showSec[0]["@value"]=="true";
				if (config.labelDay)
					target.strDay = config.labelDay[0]["@value"];
				if (config.labelHour)
					target.strHour = config.labelHour[0]["@value"];
				if (config.labelMin)
					target.strMin = config.labelMin[0]["@value"];
				if (config.labelSec)
					target.strSec = config.labelSec[0]["@value"];
				if (config.labelColor)
					target.labelColor = config.labelColor[0]["@value"];
				if (config.labelShadowColor)
					target.labelShadowColor = config.labelShadowColor[0]["@value"];
				/*>>By COG IT*/

				var __currentTime = new Date();//trace(targetTimeText);
				var targetTimeTextChars = targetTimeText.split("-");
				//trace(__currentTime);trace(__currentTime.getDate()+".."+targetTimeTextChars[0]);
				__currentTime.setDate(__currentTime.getDate()+parseInt(targetTimeTextChars[0]));
				__currentTime.setHours(__currentTime.getHours()+parseInt(targetTimeTextChars[1]));
				__currentTime.setMinutes(__currentTime.getMinutes()+parseInt(targetTimeTextChars[2]));
				__currentTime.setSeconds(__currentTime.getSeconds()+parseInt(targetTimeTextChars[3])+1);
				//trace(__currentTime);trace(__currentTime.getMonth());
				targetTimeText = __currentTime.getFullYear()+"-"+target.textFormat(__currentTime.getMonth()+1, 2, "0")+"-"+target.textFormat(__currentTime.getDate(), 2, "0")+"-"+target.textFormat(__currentTime.getHours(), 2, "0")+"-"+target.textFormat(__currentTime.getMinutes(), 2, "0")+"-"+target.textFormat(__currentTime.getSeconds(), 2, "0");
				//trace(targetTimeText);
				/*By COG IT <<*/
				target.targetTimeText = targetTimeText;
				if(!isNaN(targetTimeZone)){
					target.targetTimeZone = targetTimeZone;
				}
				if(!isNaN(textColor)){
					target.textColor = textColor;
				}
				if(!isNaN(bgColor)){
					target.bgColor = bgColor;
				}
				if(!isNaN(bgLightAlpha)){
					target.bgLightAlpha = bgLightAlpha;
				}
				if(!isNaN(bgShadowAlpha)){
					target.bgShadowAlpha = bgShadowAlpha;
				}
				if(!isNaN(innerGlowAlpha)){
					target.innerGlowAlpha = innerGlowAlpha;
				}
				if(!isNaN(textSpace)){
					target.textSpace = textSpace;
				}
				target.showLabel = showLabel;
				target.showDay = showDay;
				target.showHour = showHour;
				target.showMin = showMin;
				target.showSec = showSec;
				
				target.startTrace();
				target.onConfigLoad();
			}
		}
		__targetTimeZone = 0;
	}
	public function onLoad() {
		bgColor = bgColor;
		textColor = textColor;
		innerGlowAlpha = innerGlowAlpha;
		bgLightAlpha = bgLightAlpha;
		bgShadowAlpha = bgShadowAlpha;
	}
	//---------------------------------------------------------------------------------------
	//method
	//---------------------------------------------------------------------------------------
	//parse xml
	private function parseXml(node:XMLNode):Object {
		var nodeData:Object = {};
		switch (node.nodeType) {
		case 1 :
		case 4 :
			var nodeData = {};
			var attr = {};
			for (var varName in node.attributes) {
				attr[varName] = node.attributes[varName];
			}
			nodeData["@attributes"] = attr;
			var childNodeData:Object;
			var childNode:XMLNode;
			var childNodesLength = node.childNodes.length;
			for (var i = 0; i<childNodesLength; i++) {
				childNode = node.childNodes[i];
				var childNodeData = parseXml(childNode);
				switch (childNode.nodeType) {
				case 1 :
				case 4 :
					if (nodeData[childNode.nodeName] == undefined) {
						nodeData[childNode.nodeName] = [];
					}
					nodeData[childNode.nodeName].push(childNodeData);
					break;
				case 3 :
					nodeData["@value"] = childNodeData;
					break;
				}
			}
			break;
		case 3 :
			nodeData = node.nodeValue;
			break;
		}
		return nodeData;
	}
	//check time
	private function checkTime(target, update) {
		target.__currentTime = new Date();
		//if(target.__targetTime.getTime()<(target.__currentTime.getTime()+target.__currentTime.getTimezoneOffset()*60*1000)){
		if(target.__targetTime.getTime()<(target.__currentTime.getTime())){
			target.__day1.text = "0"
			target.__day2.text = "0"
			target.__day3.text = "0"
			target.__hour1.text = "0"
			target.__hour2.text = "0"
			target.__min1.text = "0"
			target.__min2.text = "0"
			target.__sec1.text = "0"
			target.__sec2.text = "0"
			target.onFinish();
			target.stopTrace();
			return false;
		}
		/* >> By COG IT - commented two lines and added two new lines*/
		/*var oldTimeText = target.timeFormat(target.__targetTime.getTime()-(target.__oldTime.getTime()+target.__oldTime.getTimezoneOffset()*60*1000));
		var currentTimeText = target.timeFormat(target.__targetTime.getTime()-(target.__currentTime.getTime()+target.__currentTime.getTimezoneOffset()*60*1000));*/
		var oldTimeText = target.timeFormat(target.__targetTime.getTime()-(target.__oldTime.getTime()));
		var currentTimeText = target.timeFormat(target.__targetTime.getTime()-(target.__currentTime.getTime()));
		/* By COG IT << */
		var oldTimeChars = oldTimeText.split("");
		var currentTimeChars = currentTimeText.split("");
		if (update && !isNaN(target.__targetTime)) {
			target.__day1.text = currentTimeChars[0];
			target.__day2.text = currentTimeChars[1];
			target.__day3.text = currentTimeChars[2];
			target.__hour1.text = currentTimeChars[4];
			target.__hour2.text = currentTimeChars[5];
			target.__min1.text = currentTimeChars[7];
			target.__min2.text = currentTimeChars[8];
			target.__sec1.text = currentTimeChars[10];
			target.__sec2.text = currentTimeChars[11];
		} else {
			if (currentTimeChars[0] != oldTimeChars[0]) {
				target.__day1.updateText(currentTimeChars[0]);
			}
			if (currentTimeChars[1] != oldTimeChars[1]) {
				target.__day2.updateText(currentTimeChars[1]);
			}
			if (currentTimeChars[2] != oldTimeChars[2]) {
				target.__day3.updateText(currentTimeChars[2]);
			}
			if (currentTimeChars[4] != oldTimeChars[4]) {
				target.__hour1.updateText(currentTimeChars[4]);
			}
			if (currentTimeChars[5] != oldTimeChars[5]) {
				target.__hour2.updateText(currentTimeChars[5]);
			}
			if (currentTimeChars[7] != oldTimeChars[7]) {
				target.__min1.updateText(currentTimeChars[7]);
			}
			if (currentTimeChars[8] != oldTimeChars[8]) {
				target.__min2.updateText(currentTimeChars[8]);
			}
			if (currentTimeChars[10] != oldTimeChars[10]) {
				target.__sec1.updateText(currentTimeChars[10]);
			}
			if (currentTimeChars[11] != oldTimeChars[11]) {
				target.__sec2.updateText(currentTimeChars[11]);
			}
		}
		target.__oldTime = target.__currentTime;
		return true;
	}
	//time format
	private function timeFormat(mTime) {
		var time = Math.floor(mTime/1000);
		var s = time%60;
		var i = Math.floor(time%(60*60)/60);
		var h = Math.floor(time%(24*60*60)/(60*60));
		var d = Math.floor(time/(24*60*60));
		return textFormat(d, 3, "0")+"-"+textFormat(h, 2, "0")+"-"+textFormat(i, 2, "0")+"-"+textFormat(s, 2, "0");
	}
	//text format
	private function textFormat(text, length, fillChar) {
		text = text.toString();
		while (text.length<length) {
			text = fillChar+text;
		}
		if(text.length>length){
			text = text.substr(text.length-length,length);
		}
		return text;
	}
	//start
	private function startTrace(){
		var flag = checkTime(this, true);
			stopTrace();
		if(flag){
			__tickId = setInterval(checkTime, 100, this, false);
		}
	}
	//stop
	private function stopTrace(){
		clearInterval(__tickId);
	}
	//loadConfig
	public function loadConfig(value){
		_visible = false;
		__config_xml.load(value);
	}
	//refreshUI
	private function refreshUI(){
		var x = 0;

		if(__showDay){
			__labelDay._visible = true;
			__labelDay._x = x;
			__border1.__day._visible =  true;
			__border1.__day._x = x;
			__border2.__day._visible =  true;
			__border2.__day._x = x;
			__innerGlow.__day._visible =  true;
			__innerGlow.__day._x = x;
			__mask.__day._y = 0;
			__mask.__day._x = x;
			__shadow.__day._visible = true;
			__shadow.__day._x = x;
			__day1._x = x;
			__day1._visible = true;
			__day1._x = x;
			x+= __slideWidth;
			__day2._visible = true;
			__day2._x = x;
			x+= __slideWidth;
			__day3._visible = true;
			__day3._x = x;
			x+= __slideWidth;
			x+= __textSpace;
		}else{
			__labelDay._visible = false;
			__border1.__day._visible =  false;
			__border2.__day._visible =  false;
			__innerGlow.__day._visible =  false;
			__mask.__day._y = __slideHeight;
			__shadow.__day._visible = false;
			__day1._visible = false;
			__day2._visible = false;
			__day3._visible = false;
		}

		if(__showHour){
			__labelHour._visible = true;
			__labelHour._x = x;
			__border1.__hour._visible =  true;
			__border1.__hour._x = x;
			__border2.__hour._visible =  true;
			__border2.__hour._x = x;
			__innerGlow.__hour._visible =  true;
			__innerGlow.__hour._x = x;
			__mask.__hour._y = 0;
			__mask.__hour._x = x;
			__shadow.__hour._visible = true;
			__shadow.__hour._x = x;
			__hour1._x = x;
			__hour1._visible = true;
			__hour1._x = x;
			x+= __slideWidth;
			__hour2._visible = true;
			__hour2._x = x;
			x+= __slideWidth;
			x+= __textSpace;
		}else{
			__labelHour._visible = false;
			__border1.__hour._visible =  false;
			__border2.__hour._visible =  false;
			__innerGlow.__hour._visible =  false;
			__mask.__hour._y = __slideHeight;
			__shadow.__hour._visible = false;
			__hour1._visible = false;
			__hour2._visible = false;
		}

		if(__showMin){
			__labelMin._visible = true;
			__labelMin._x = x;
			__border1.__min._visible =  true;
			__border1.__min._x = x;
			__border2.__min._visible =  true;
			__border2.__min._x = x;
			__innerGlow.__min._visible =  true;
			__innerGlow.__min._x = x;
			__mask.__min._y = 0;
			__mask.__min._x = x;
			__shadow.__min._visible = true;
			__shadow.__min._x = x;
			__min1._x = x;
			__min1._visible = true;
			__min1._x = x;
			x+= __slideWidth;
			__min2._visible = true;
			__min2._x = x;
			x+= __slideWidth;
			x+= __textSpace;
		}else{
			__labelHour._visible = false;
			__border1.__min._visible =  false;
			__border2.__min._visible =  false;
			__innerGlow.__min._visible =  false;
			__mask.__min._y = __slideHeight;
			__shadow.__min._visible = false;
			__min1._visible = false;
			__min2._visible = false;
		}

		if(__showSec){
			__labelSec._visible = true;
			__labelSec._x = x;
			__border1.__sec._visible =  true;
			__border1.__sec._x = x;
			__border2.__sec._visible =  true;
			__border2.__sec._x = x;
			__innerGlow.__sec._visible =  true;
			__innerGlow.__sec._x = x;
			__mask.__sec._y = 0;
			__mask.__sec._x = x;
			__shadow.__sec._visible = true;
			__shadow.__sec._x = x;
			__sec1._x = x;
			__sec1._visible = true;
			__sec1._x = x;
			x+= __slideWidth;
			__sec2._visible = true;
			__sec2._x = x;
			x+= __slideWidth;
			x+= __textSpace;
		}else{
			__labelSec._visible = false;
			__border1.__sec._visible =  false;
			__border2.__sec._visible =  false;
			__innerGlow.__sec._visible =  false;
			__mask.__sec._y = __slideHeight;
			__shadow.__sec._visible = false;
			__sec1._visible = false;
			__sec2._visible = false;
		}
		
		if(__showLabel){
			__border1._y = __labelHeight;
			__border2._y = __labelHeight;
			__innerGlow._y = __labelHeight;
			__mask._y = __labelHeight;
			__shadow._y = __labelHeight;
			__day1._y = __labelHeight;
			__day2._y = __labelHeight;
			__day3._y = __labelHeight;
			__hour1._y = __labelHeight;
			__hour2._y = __labelHeight;
			__min1._y = __labelHeight;
			__min2._y = __labelHeight;
			__sec1._y = __labelHeight;
			__sec2._y = __labelHeight;
			
			__labelDay._visible = __day1._visible;
			__labelHour._visible = __hour1._visible;
			__labelMin._visible = __min1._visible;
			__labelSec._visible = __sec1._visible;
			var TF:TextFormat = __labelDay.getTextFormat(0,1);
			var myList:Array = __labelDay.filters;
			myList[0].color = __labelShadowColor;
			TF.color = __labelColor;
			__labelDay.text = __strDay;
			__labelDay.setTextFormat(TF);
			__labelDay.filters = myList;
			__labelHour.text = __strHour;
			__labelHour.setTextFormat(TF);
			__labelHour.filters = myList;
			__labelMin.text = __strMin;
			__labelMin.setTextFormat(TF);
			__labelMin.filters = myList;
			__labelSec.text = __strSec;
			__labelSec.setTextFormat(TF);
			__labelSec.filters = myList;
		}else{
			__border1._y = 0;
			__border2._y = 0;
			__innerGlow._y = 0;
			__mask._y = 0;
			__shadow._y = 0;
			__day1._y = 0;
			__day2._y = 0;
			__day3._y = 0;
			__hour1._y = 0;
			__hour2._y = 0;
			__min1._y = 0;
			__min2._y = 0;
			__sec1._y = 0;
			__sec2._y = 0;

			__labelDay._visible = false;
			__labelHour._visible = false;
			__labelMin._visible = false;
			__labelSec._visible = false;
		}
	}
	//---------------------------------------------------------------------------------------
	//properties
	//---------------------------------------------------------------------------------------
	//targetTimeText
	public function set targetTimeText(value) {
		__targetTimeText = value;
		var times = __targetTimeText.split("-");
		var y = parseInt(times[0]);
		var m = parseInt(times[1])-1;
		var d = parseInt(times[2]);
		var h = parseInt(times[3])
		var i = parseInt(times[4])-__targetTimeZone*60;
		var s = parseInt(times[5]);
		__targetTime = new Date(y, m, d, h, i, s, 0);
	}
	//targetTimeText
	public function get targetTimeText() {
		return __targetTimeText;
	}
	//targetTimeZone
	public function set targetTimeZone(value) {
		__targetTimeZone = value;
		var times = __targetTimeText.split("-");
		var y = parseInt(times[0]);
		var m = parseInt(times[1])-1;
		var d = parseInt(times[2]);
		var h = parseInt(times[3]);
		var i = parseInt(times[4])-__targetTimeZone*60;
		var s = parseInt(times[5]);
		__targetTime = new Date(y, m, d, h, i, s, 0);
	}
	//targetTimeZone
	public function get targetTimeZone() {
		return __targetTimeZone;
	}
	//textColor
	public function set textColor(value){
		__textColor = value;
		__bgColor = value;
		__day1.textColor = __textColor;
		__day2.textColor = __textColor;
		__day3.textColor = __textColor;
		__hour1.textColor = __textColor;
		__hour2.textColor = __textColor;
		__min1.textColor = __textColor;
		__min2.textColor = __textColor;
		__sec1.textColor = __textColor;
		__sec2.textColor = __textColor;
	}
	//textColor
	public function get textColor(){
		return __textColor;
	}
	//bgColor
	public function set bgColor(value){
		__bgColor = value;
		__day1.bgColor = __bgColor;
		__day2.bgColor = __bgColor;
		__day3.bgColor = __bgColor;
		__hour1.bgColor = __bgColor;
		__hour2.bgColor = __bgColor;
		__min1.bgColor = __bgColor;
		__min2.bgColor = __bgColor;
		__sec1.bgColor = __bgColor;
		__sec2.bgColor = __bgColor;
	}
	//bgColor
	public function get bgColor(){
		return __bgColor;
	}
	//bgLightAlpha
	public function set bgLightAlpha(value){
		__bgLightAlpha = value;
		__day1.lightAlpha = __bgLightAlpha;
		__day2.lightAlpha = __bgLightAlpha;
		__day3.lightAlpha = __bgLightAlpha;
		__hour1.lightAlpha = __bgLightAlpha;
		__hour2.lightAlpha = __bgLightAlpha;
		__min1.lightAlpha = __bgLightAlpha;
		__min2.lightAlpha = __bgLightAlpha;
		__sec1.lightAlpha = __bgLightAlpha;
		__sec2.lightAlpha = __bgLightAlpha;
	}
	//bgLightAlpha
	public function get bgLightAlpha(){
		return __bgLightAlpha;
	}
	//bgShadowAlpha
	public function set bgShadowAlpha(value){
		__bgShadowAlpha = value;
		__day1.shadowAlpha = __bgShadowAlpha;
		__day2.shadowAlpha = __bgShadowAlpha;
		__day3.shadowAlpha = __bgShadowAlpha;
		__hour1.shadowAlpha = __bgShadowAlpha;
		__hour2.shadowAlpha = __bgShadowAlpha;
		__min1.shadowAlpha = __bgShadowAlpha;
		__min2.shadowAlpha = __bgShadowAlpha;
		__sec1.shadowAlpha = __bgShadowAlpha;
		__sec2.shadowAlpha = __bgShadowAlpha;
	}
	//bgShadowAlpha
	public function get bgShadowAlpha(){
		return __bgShadowAlpha;
	}
	//innerGlowAlpha
	public function set innerGlowAlpha(value){
		__innerGlowAlpha = value;
		__innerGlow._alpha = __innerGlowAlpha;
	}
	//innerGlowAlpha
	public function get innerGlowAlpha(){
		return __innerGlowAlpha;
	}
	//showLabel
	public function set showLabel(value){
		__showLabel = value;
		refreshUI();
	}
	//showLabel
	public function get showLabel(){
		return __showLabel;
	}
	//textSpace
	public function set textSpace(value){
		__textSpace = value;
		refreshUI();
	}
	//textSpace
	public function get textSpace(){
		return __textSpace;
	}
	//showDay
	public function set showDay(value){
		__showDay = value;
		refreshUI();
	}
	//showDay
	public function get showDay(){
		return __showDay;
	}
	//showHour
	public function set showHour(value){
		__showHour = value;
		refreshUI();
	}
	//showHour
	public function get showHour(){
		return __showHour;
	}
	//showMin
	public function set showMin(value){
		__showMin = value;
		refreshUI();
	}
	//showMin
	public function get showMin(){
		return __showMin;
	}
	//showSec
	public function set showSec(value){
		__showSec = value;
		refreshUI();
	}
	//showSec
	public function get showSec(){
		return __showSec;
	}
	//labelDay
	public function set strDay(value){
		__strDay = value;
		refreshUI();
	}
	//labelDay
	public function get strDay(){
		return __strDay;
	}
	//labelHour
	public function set strHour(value){
		__strHour = value;
		refreshUI();
	}
	//labelHour
	public function get strHour(){
		return __strHour;
	}
	//labelMin
	public function set strMin(value){
		__strMin = value;
		refreshUI();
	}
	//labelMin
	public function get strMin(){
		return __strMin;
	}
	//labelSec
	public function set strSec(value){
		__strSec = value;
		refreshUI();
	}
	//labelSec
	public function get strSec(){
		return __strSec;
	}
	//labelColor
	public function set labelColor(value){
		__labelColor = value;
		refreshUI();
	}
	//labelColor
	public function get labelColor(){
		return __labelColor;
	}
	//labelShadowColor
	public function set labelShadowColor(value){
		__labelShadowColor = value;
		refreshUI();
	}
	//labelShadowColor
	public function get labelShadowColor(){
		return __labelShadowColor;
	}

}
