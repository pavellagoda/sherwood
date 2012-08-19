package 
{
	import flash.display.MovieClip;
	import flash.display.Loader;
	import flash.net.URLRequest;
	import flash.events.Event;
	import flash.external.ExternalInterface;
	
	public class Image extends MovieClip
	{
	
		private var loader:Loader = new Loader();
	
		public function Image(url)
		{
			loader.load(new URLRequest(url))
			loader.contentLoaderInfo.addEventListener(Event.COMPLETE, onImageLoaded)
		}
		private function onImageLoaded(evt) {
			evt.target.content.width = 450;
			evt.target.content.height = 300;
			evt.target.content.x = -evt.target.content.width/2;
			evt.target.content.y = -evt.target.content.height/2;
			this.addChild(evt.target.content)
			
			var frame  = new ImageFrame()
			frame.x = -frame.width/2;
			frame.y = -frame.height/2
			addChild(frame)
			
			Main.onImageLoaded();
		}
	}

}