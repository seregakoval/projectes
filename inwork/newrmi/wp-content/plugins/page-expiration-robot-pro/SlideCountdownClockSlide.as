class SlideCountdownClockSlide extends MovieClip{
	private var __currentText:String;
	private var __oldText:String;
	private var __text:String;
	private var __content:TextField;
	private var __bg:MovieClip;
	private var __bgColor:Number;
	private var __textColor:Number;
	private var __light:MovieClip;
	private var __shadow:MovieClip;
	private var __lightAlpha:Number;
	private var __shadowAlpha:Number;
	public function SlideCountdownClockSlide(){
		__oldText = "";
		__currentText = "";
		__lightAlpha = 100;
		__shadowAlpha = 100;
		__bgColor = 0x000000;
		__textColor = 0xFFFFFF;
		text = "";
	}
	public function onLoad(){
		bgColor = bgColor;
		textColor = textColor;
		lightAlpha = lightAlpha;
		shadowAlpha = shadowAlpha;
	}
	private function freshText(){
		var fmt:TextFormat = __content.__text.__oldText.getTextFormat();
		fmt.color = __textColor;

		__content.__text.__oldText.text = __oldText;
		__content.__text.__currentText.text = __currentText;

		__content.__text.__oldText.setTextFormat(fmt);
		__content.__text.__currentText.setTextFormat(fmt);
	}
	public function set text(value){
		__oldText = __currentText;
		__currentText = value;
		freshText();
		gotoAndStop(_totalframes);
	}
	public function get text(){
		return __currentText;
	}
	public function updateText(value){
		__oldText = __currentText;
		__currentText = value;
		freshText();
		gotoAndPlay(1);
	}
	public function set bgColor(value){
		__bgColor = value;
		var c = new Color(__bg.color);
		c.setRGB(__bgColor);
	}
	public function get bgColor(){
		return __bgColor;
	}
	public function set textColor(value){
		__textColor = value;

		var fmt:TextFormat = __content.__text.__oldText.getTextFormat();
		fmt.color = __textColor;

		__content.__text.__oldText.setTextFormat(fmt);
		__content.__text.__currentText.setTextFormat(fmt);
	}
	public function get textColor(){
		return __textColor;
	}
	public function set lightAlpha(value){
		__lightAlpha = value;
		__light._alpha = __lightAlpha;
	}
	public function get lightAlpha(){
		return __lightAlpha;
	}
	public function set shadowAlpha(value){
		__shadowAlpha = value;
		__shadow._alpha = __shadowAlpha;
	}
	public function get shadowAlpha(){
		return __shadowAlpha;
	}
}