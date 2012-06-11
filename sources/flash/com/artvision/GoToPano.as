package com.artvision{

	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	import com.artvision.Main;
	public class GoToPano extends MovieClip {

		private var link:String;
		private var startX;
		private var startY;

		public function GoToPano() {
		}
		public function init(url:String,xp=null,yp=null) {
			this.link=url;
			this.startX=xp;
			this.startY=yp;
			this.buttonMode=true;
			this.addEventListener(MouseEvent.CLICK, gotoPano);
		}
		private function gotoPano(evt:MouseEvent=null) {
			Main.loadScene(link,startX,startY);
			//trace(Main.loadScene);
		}
	}
}