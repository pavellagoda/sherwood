package com.artvision{

	import com.artvision.Main;
	import com.greensock.TweenNano;
	import flash.display.MovieClip;
	import flash.events.MouseEvent;


	public class Selector extends MovieClip {

		private var url:String;
		private var num:String;
		private var startX:Number;
		private var startY:Number;

		public function Selector() {
			num=String(this.name).substr(String(this.name).length-4,1);
			this.alpha=0.6;
		}
		public function init(url,stx=null,sty=null) {
			this.url=url;
			this.startX=stx;
			this.startY=sty;
			this.buttonMode=true;
			this.addEventListener(MouseEvent.ROLL_OVER,rollOvered);
			this.addEventListener(MouseEvent.ROLL_OUT,rollOuted);
			this.addEventListener(MouseEvent.CLICK,released);
		}
		private function rollOvered(evt:MouseEvent) {
			TweenNano.to(this, 0.3,{alpha:1})
		}
		private function rollOuted(evt:MouseEvent) {
			TweenNano.to(this, 0.3,{alpha:0.6})
		}
		private function released(evt:MouseEvent) {
			Main.loadScene(this.url,startX,startY);
			//_global.loadScene(_this.url);
		}
	}
}