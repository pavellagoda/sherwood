package com.artvision{

	import com.artvision.Main;
	//import com.greensock.TweenNano;
	import flash.display.MovieClip;
	import flash.events.MouseEvent;


	public class Note extends MovieClip {

		private var url:String;
		private var num:String;
		private var startX:Number;
		private var startY:Number;
		private var titleText:Array = new Array();
		private var is_go:Boolean;

		public function Note() {
			num=String(this.name).substr(String(this.name).length-4,1);
			this.zona_mc.alpha=0;
			if (this.parent["door"+num+"_mc"]!=undefined) {
				this.parent["door"+num+"_mc"].alpha=0;
			}
		}
		public function init(url,desription,stx=null,sty=null, isGo = true) {
			this.url=url;
			this.titleText=desription;
			this.startX=stx;
			this.startY=sty;
			this.is_go = isGo;
			this.buttonMode=true;
			this.addEventListener(MouseEvent.ROLL_OVER,rollOvered);
			this.circle_mc.addEventListener(MouseEvent.MOUSE_OVER,rollOvered);
			this.addEventListener(MouseEvent.ROLL_OUT,rollOuted);
			this.addEventListener(MouseEvent.CLICK,released);
		}
		private function rollOvered(evt:MouseEvent) {
			if (this.parent["door"+num+"_mc"]!=undefined) {
				//TweenNano.to(this.parent["door"+num+"_mc"],0.3,{alpha:1});
				Main.openDoor(this.parent["door"+num+"_mc"]);
			}
			if (evt.target.name=="circle_mc") {
				
				if(this.titleText is Array) {
					Main.showNote(this.titleText[Main.language]);
				} else {
					Main.showNote(this.titleText);
				}
			}
		}
		private function rollOuted(evt:MouseEvent) {
			if (this.parent["door"+num+"_mc"]!=undefined) {
				Main.closeDoor(this.parent["door"+num+"_mc"]);
			}
			Main.hideNote();
		}
		private function released(evt:MouseEvent) {
			if(this.is_go)
				Main.loadScene(this.url,startX,startY);
			//_global.loadScene(_this.url);
		}
	}
}