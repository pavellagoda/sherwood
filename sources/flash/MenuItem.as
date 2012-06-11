package {
	import flash.display.MovieClip;
	import flash.events.MouseEvent;
	import flash.text.TextFieldAutoSize;
	import com.greensock.TweenNano;
	import com.greensock.easing.Sine;
	import com.artvision.Main

	class MenuItem extends MovieClip {
		
		private static var items:Array=new Array("МЕНЮ1","МЕНЮ2","МЕНЮ3","МЕНЮ4");

		public function MenuItem() {
		}
		
		public function create(i) {
			this.x = (i-1)*(this.width+4);
			this.text_txt.text=items[i-1];
			this.text_txt.mouseEnabled=false;
			this.buttonMode=true;

			this.addEventListener(MouseEvent.ROLL_OVER,this.rollOvered);
			this.addEventListener(MouseEvent.ROLL_OUT,this.rollOuted);
			this.addEventListener(MouseEvent.CLICK,Main.loadMenu);
		}

		protected function released(evt:MouseEvent) {
		}
		
		protected function rollOvered(evt:MouseEvent) {
			TweenNano.killTweensOf(this.text_txt);
			TweenNano.to(this.text_txt,0.5,{alpha:0.3});
		}
		
		protected function rollOuted(evt:MouseEvent) {
			TweenNano.killTweensOf(this.text_txt);
			TweenNano.to(this.text_txt,0.5,{alpha:1});
		}

	}
}