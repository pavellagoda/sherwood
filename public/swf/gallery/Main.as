package 
{
	import flash.display.MovieClip;
	import GetAMFData;
	import flash.display.Loader;
	import flash.display.Stage;
	import flash.events.MouseEvent;
	import flash.external.ExternalInterface;
	import com.greensock.TweenNano;
	import flash.utils.Timer;
	import flash.events.TimerEvent;

	public class Main extends MovieClip
	{
		//public static var hostName = 'http://sherwood.dev.com';
		public static var hostName = '';
		public static var imageList = new Array("/i/galleries/previews/15.jpg","/i/galleries/previews/18.jpg","/i/galleries/previews/19.jpg","/i/galleries/previews/20.jpg","/i/galleries/previews/23.jpg","/i/galleries/previews/26.jpg");
		private static var currentItems = new Array();
		private static var itemsList:Array = new Array();
		private static var loadedImage = 0;
		private static var imageContainer = new MovieClip();
		private static var defaultWidth;
		private static var defaultHeight;
		private static var imageOnStage = 5;
		private static var currentImage = 0;
		private static var leftArrow;
		private static var rightArrow;
		private static var imageScaling = new Array(0.56,0.76,1,0.76,0.56);
		private static var imageX = new Array();
		private static var timer:Timer = new Timer(5000);

		public function Main()
		{
			defaultWidth = stage.stageWidth;
			defaultHeight = stage.stageHeight;
			imageContainer.visible = false;
			arrow_left.buttonMode = arrow_right.buttonMode = true;
			leftArrow = arrow_left;
			rightArrow = arrow_right;
			//var amf  = new GetAMFData()
			//amf.getParams('getImageList', onAmfData)
			var flashvars = this.loaderInfo.parameters;
			if (flashvars.images != undefined) {
				imageList = flashvars.images.split(',');
			} else {
				hostName = 'http://sherwood.dev.com';
			}
			onAmfData(imageList);
		}

		private function onAmfData(res)
		{
			for (var i = 0; i<res.length; i++) {
				var item = new Image(hostName+res[i], i);
				imageContainer.addChild(item);
				itemsList.push(item);
			}
			addChild(imageContainer);
		}

		public static function onImageLoaded()
		{
			loadedImage++;
			if (loadedImage == imageList.length) {

				timer.addEventListener(TimerEvent.TIMER, incrementView);

				imageX[0] = 0;
				imageX[1] = 258 - 450 * 0.56 / 2;
				imageX[2] = 425 - 450 * 0.56 / 2;
				imageX[3] = 592 - 450 * 0.56 / 2;
				imageX[4] = 730 - 450 * 0.56 / 2;

				imageContainer.visible = true;
				imageContainer.x = itemsList[0].width * 0.56 / 2;
				imageContainer.y = defaultHeight / 2;
				defaultImageSetup(currentImage);
				leftArrow.addEventListener(MouseEvent.CLICK, decrementView);
				rightArrow.addEventListener(MouseEvent.CLICK, incrementView);
			}
		}

		private static function decrementView(evt)
		{
			
			if (currentImage == 1) {
				currentImage = itemsList.length;
			} else {
				currentImage--;
			}
			defaultImageSetup(currentImage%itemsList.length);
		}

		private static function incrementView(evt)
		{
			defaultImageSetup(currentImage%itemsList.length+1);
			currentImage++;
		}

		public static function defaultImageSetup(first)
		{
			timer.reset();
			timer.start()
			for (var j = 0; j< itemsList.length; j++) {
				itemsList[j].visible = false;
			}

			currentItems = new Array();

			if ((first+imageOnStage) > (itemsList.length)) {
				for (var t = first; t < itemsList.length; t++) {
					itemsList[t].visible = true;
					currentItems.push(itemsList[t]);
				}
				var stayedImages = (imageOnStage - (itemsList.length - first));
				for (var p = 0; p < stayedImages; p++) {
					itemsList[p].visible = true;
					currentItems.push(itemsList[p]);
				}

			} else {
				for (var m = first; m < first + imageOnStage; m++) {
					itemsList[m].visible = true;
					currentItems.push( itemsList[m]);
				}
			}

			/*TweenNano.to(currentItems[0], 0.3, {scaleX:0.25, scaleY:0.25});
			TweenNano.to(currentItems[4], 0.3, {scaleX:0.25, scaleY:0.25});
			TweenNano.to(currentItems[1], 0.3, {scaleX:0.5, scaleY:0.5});
			TweenNano.to(currentItems[3], 0.3, {scaleX:0.5, scaleY:0.5});
			TweenNano.to(currentItems[2], 0.3, {scaleX:1, scaleY:1});*/

			/*currentItems[0].scaleX = currentItems[0].scaleY = currentItems[4].scaleX = currentItems[4].scaleY = 0.25;
			currentItems[1].scaleX = currentItems[1].scaleY = currentItems[3].scaleX = currentItems[3].scaleY = 0.5;
			currentItems[2].scaleX = currentItems[2].scaleY = 1;*/
			//currentItems[0].x = 0;
			for (var i = 0; i< imageOnStage; i++) {
				//var _x = currentItems[i - 1].x + 0.5 * currentItems[i - 1].width + 0.5 * currentItems[i].width / 2;
				TweenNano.to(currentItems[i], 0.5, {x : imageX[i], scaleX:imageScaling[i], scaleY:imageScaling[i]});
			}

			TweenNano.delayedCall(0.25, function(){
			setDefaultDepth();
			});
		}

		private static function setCurrentItems(first)
		{

		}

		private static function setDefaultDepth()
		{
			var centerNum = imageOnStage % 2 == 1 ? (imageOnStage + 1) / 2:imageOnStage / 2;
			var topPosition:uint = imageContainer.numChildren - 1;
			for (var i = imageOnStage-1; i>= centerNum; i--) {
				imageContainer.setChildIndex(currentItems[i], topPosition);
			}
			for (var j = 0; j< centerNum; j++) {
				imageContainer.setChildIndex(currentItems[j], topPosition);
			}
		}

	}

}