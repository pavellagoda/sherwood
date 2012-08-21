package 
{
	import flash.display.MovieClip;
	import flash.display.Loader;
	import flash.net.URLRequest;
	import flash.events.Event;
	import flash.external.ExternalInterface;
	import flash.events.MouseEvent;

	public class Image extends MovieClip
	{

		private var loader:Loader = new Loader();
		private var num = 0;

		public function Image(url, num)
		{
			this.num = num;
			loader.load(new URLRequest(url));
			loader.contentLoaderInfo.addEventListener(Event.COMPLETE, onImageLoaded);
		}
		private function onImageLoaded(evt)
		{
			evt.target.content.width = 450;
			evt.target.content.height = 300;
			evt.target.content.x =  -  evt.target.content.width / 2;
			evt.target.content.y =  -  evt.target.content.height / 2;
			this.addChild(evt.target.content);
			var frame  = new ImageFrame();
			frame.x =  -  frame.width / 2;
			frame.y =  -  frame.height / 2;
			addChild(frame);
			this.addEventListener(MouseEvent.CLICK, function(){
								  
				var tmp = num-2;
				var number = 0;
				if(tmp>=0) {
					number = tmp
				} else {
					number = Main.imageList.length + tmp;
				}
								  
				ExternalInterface.call('showFancybox', number)
				Main.defaultImageSetup(number)
			});
			this.buttonMode = true;
			Main.onImageLoaded();
		}
	}

}