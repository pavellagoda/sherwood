package com.artvision{
	import flash.display.MovieClip;
	import flash.events.Event
	import com.artvision.PanoSettings;
	import com.artvision.Main;

	public class Pano extends MovieClip {

		public var totalAngle:Number;
		public var startpositionX:Number;
		public var startpositionY:Number;
		
		private var pano2_mc:MovieClip = new MovieClip();
		private var ekran_mc:MovieClip = new MovieClip();
		private var prevSpeedX:Number= 0;
		private var nextSpeedX:Number= 0;
		private var prevX:Number= 0;
		private var nextX:Number=0;
		private var prevSpeedY:Number= 0;
		private var nextSpeedY:Number= 0;
		private var prevY:Number= 0;
		private var nextY:Number=0;
		private var nextX2:Number= 0;
		private var x0:Number = 0;
		private var y0:Number = 0;

		public function Pano(){
		}
		
		public function init() {
			if (Main.startX!=null) {
				this.startpositionX=Main.startX;
			}
			if (Main.startY!=null) {
				this.startpositionY=Main.startY;
			}
			nextX = -startpositionX;
			nextY = -startpositionY;
			ekran_mc = (parent as MovieClip).ekran_mc;
			if (totalAngle==360) {
				pano2_mc=duplicateDisplayObject(pano_mc);
				pano2_mc.x=pano_mc.x+pano_mc.width;
			}
			this.addEventListener(Event.ENTER_FRAME, mover);
			/*var mov:Timer = new Timer(1000/30);
			mov.addEventListener(TimerEvent.TIMER, mover);
			mov.start()*/
			mover();

		}
		private function duplicateDisplayObject(target:MovieClip):MovieClip {
			var targetClass:Class = Object(target).constructor;
			var duplicate:MovieClip = new targetClass();
			target.parent.addChild(duplicate);
			return duplicate;
		}
		private function mover(evt:Event=null) {
			var isMoveX=false;
			var isMoveY=false;
			var _mouseX=parent.mouseX;
			var _mouseY=parent.mouseY;
			if (_mouseX<0||_mouseX>ekran_mc.width) {
				isMoveX=false;
			} else {
				isMoveX=true;
			}
			if (_mouseY<0||_mouseY>ekran_mc.height) {
				isMoveY=false;
			} else {
				isMoveY=true;
			}
			var mouseIn=isMoveX&&isMoveY;
			if (mouseIn) {
				if (_mouseX<PanoSettings.activezonex) {
					nextSpeedX = (1-_mouseX/PanoSettings.activezonex)*PanoSettings.xspeed;

				} else if (_mouseX>ekran_mc.width-PanoSettings.activezonex) {
					nextSpeedX = -(1-(ekran_mc.width-_mouseX)/PanoSettings.activezonex)*PanoSettings.xspeed;
				} else {
					nextSpeedX=0;
				}
				if (_mouseY<PanoSettings.activezoney) {
					nextSpeedY = (1-_mouseY/PanoSettings.activezoney)*PanoSettings.yspeed;
				} else if (_mouseY>ekran_mc.height-PanoSettings.activezoney) {
					nextSpeedY = -(1-(ekran_mc.height-_mouseY)/PanoSettings.activezoney)*PanoSettings.yspeed;
				} else {
					nextSpeedY=0;
				}
			} else {
				nextSpeedX=0;
				nextSpeedY=0;
			}
			if (nextSpeedX>prevSpeedX) {
				nextSpeedX = Math.min(prevSpeedX+PanoSettings.accelerate, nextSpeedX);
				} else if (nextSpeedX<prevSpeedX) {
					nextSpeedX = Math.max(prevSpeedX-PanoSettings.accelerate, nextSpeedX);
				}
				if (nextSpeedY>prevSpeedY) {
					nextSpeedY = Math.min(prevSpeedY+PanoSettings.accelerate, nextSpeedY);
				} else if (nextSpeedX<prevSpeedX) {
					nextSpeedY = Math.max(prevSpeedY-PanoSettings.accelerate, nextSpeedY);
			}
			prevSpeedX=nextSpeedX;
			prevX=nextX;
			nextX=nextX+nextSpeedX;
			prevSpeedY=nextSpeedY;
			prevY=nextY;
			nextY=nextY+nextSpeedY;
			moveOnY();
			this.totalAngle == 360 ? (this.panoIs360()) : (this.panoIs180());
		}
		private function panoIs360() {
			pano2_mc.y = pano_mc.y
			nextX = Math.round(nextX);
			if (nextX > x0) {
				nextX2 = nextX - pano_mc.width;
			}else if (nextX < -pano_mc.width + x0 + pano_mc.width) {
				nextX2 = nextX + pano_mc.width;
			}
			else {
				nextX2 = ekran_mc.width + x0;
			} 
			if (nextX > x0 + pano_mc.width || nextX < x0 - pano_mc.width) {
				nextX = nextX2;
			}   
			pano_mc.x = nextX;
			pano2_mc.x = nextX2;
		}
		private function panoIs180() {
			nextX = Math.round(nextX);
			if (nextX > 0) {
				nextX = 0;
			}
			if (nextX < x0 - pano_mc.width+ekran_mc.width ) {
				nextX = - pano_mc.width+ekran_mc.width;
			}         
			pano_mc.x = nextX;
		}
		function moveOnY(){
			nextY = Math.round(nextY);
				if (nextY > 0) {
					nextY = 0;
				}
				if (nextY < y0 - pano_mc.height+ekran_mc.height ) {
					nextY = - pano_mc.height+ekran_mc.height;
				}         
			pano_mc.y = nextY;
		}
	}
}