package com.artvision{

	import flash.display.Loader;
	import flash.display.MovieClip;
	import flash.display.Shape;
	import flash.display.Sprite;
	import flash.display.StageAlign;
	import flash.display.StageScaleMode;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.media.Sound;
	import flash.net.URLRequest;
	import com.artvision.PanoSettings;
	import com.greensock.TweenNano;
	import com.greensock.easing.*;
	import flash.display.FrameLabel;

	public class Main extends MovieClip {

		private static var viewport1:Loader = new Loader();
		private static var viewport2:Loader = new Loader();
		private static var viewports:Sprite= new Sprite();
		private static var bg_mc:MovieClip= new MovieClip();
		private static var frame;
		private static var preloader_mc:MovieClip= new preloader();
		private static var numLoads:Boolean=true;
		private static var currLoader;
		private static var masknote:Shape = new Shape();
		private static var note_mc:MovieClip = new MovieClip();
		private static var firstScene:String="scene_first.swf";
		public static var startX=null;
		public static var startY=null;
		private static var project = 'lotos';
		public static var language = 'ru';

		public function Main() {
			stage.addEventListener(Event.RESIZE, onResize);
			stage.align=StageAlign.TOP_LEFT;
			stage.scaleMode=StageScaleMode.NO_SCALE;
			createWorkSpace();
		}
		private function createWorkSpace():void {


			var parameters = this.loaderInfo.parameters;

			
			project = this.loaderInfo.parameters.object

			language = this.loaderInfo.parameters.language
			
			if(language == 'ua') {
				language = 'ukr';
			}

			//добавление бекграунда

			bg_mc=new bg();
			addChild(bg_mc);

			

			//Добавление вьюпортов

			viewport1.alpha=viewport2.alpha=0;
			viewport1.contentLoaderInfo.addEventListener(Event.COMPLETE,onLoadPano);
			viewport2.contentLoaderInfo.addEventListener(Event.COMPLETE,onLoadPano);
			viewports.addChild(viewport1);
			viewports.addChild(viewport2);
			addChild(viewports);

			//добавление прелоадера
			
			addChild(preloader_mc);
			preloader_mc.alpha = 0;

			masknote.graphics.beginFill(4095);
            masknote.graphics.drawRect(0, 0, 900, 540);
            addChild(masknote);
            note_mc = new notation();
			addChild(note_mc);
            note_mc.mask = masknote
			
			//добавление рамки
			frame = new Frame();
			addChild(frame)

			loadScene(firstScene);
			onResize(null);
		}

		public static function loadScene(url:String,xpos=null,ypos=null):void {
			preloader_mc.alpha = 1;
			startX=xpos;
			startY=ypos;
			numLoads=! numLoads;

			if (numLoads) {
				viewports.setChildIndex(viewport2,viewports.numChildren-1);
				viewport2.load(new URLRequest("/swf/pano/"+project+"/"+url));
			} else {
				viewports.setChildIndex(viewport1,viewports.numChildren-1);
				viewport1.load(new URLRequest("/swf/pano/"+project+"/"+url));
			}
		}
		private function onResize(evt:Event=null) {
			viewports.x=stage.stageWidth/2-900/2;
			viewports.y=stage.stageHeight/2-540/2;
			bg_mc.x=stage.stageWidth/2-bg_mc.width/2;
			bg_mc.y=stage.stageHeight/2-bg_mc.height/2;
			preloader_mc.x = frame.x = stage.stageWidth/2;
			preloader_mc.y = frame.y = stage.stageHeight/2;
			note_mc.x = stage.stageWidth / 2;
            note_mc.y = viewports.y + 540;
			masknote.x = viewports.x;
			masknote.y = viewports.y;
		}

		private function onLoadPano(evt:Event=null) {
			preloader_mc.alpha = 0;
			if (numLoads) {
				TweenNano.to(viewport2,0.8,{alpha:1,onComplete:hideViewport});
			} else {
				TweenNano.to(viewport1,0.8,{alpha:1,onComplete:hideViewport});
			}
		}
		
		public static function hideNote()
        {
         TweenNano.killTweensOf(note_mc.note_mc);
            TweenNano.to(note_mc.note_mc, 0.5, {y:0});
        }

        public static function openDoor(param1)
        {
            TweenNano.killTweensOf(param1);
            TweenNano.to(param1, 0.3, {alpha:1});
        }

        public static function showNote(param1:String)
        {
            TweenNano.killTweensOf(note_mc.note_mc);
            TweenNano.to(note_mc.note_mc, 0.5, {y:-45});
            note_mc.note_mc.title_txt.text = param1;
        }
		
		public static function closeDoor(door_mc){
			TweenNano.to(door_mc,0.3,{alpha:0});
		}
		
		private function hideViewport() {
			if (! numLoads) {
				viewport2.alpha=0;
				viewport2.unload();
			} else {
				viewport1.alpha=0;
				viewport1.unload();
			}
		}
	}
}