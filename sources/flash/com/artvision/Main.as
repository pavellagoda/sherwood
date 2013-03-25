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
	import com.greensock.TweenNano;
	import com.greensock.easing.*;

	public class Main extends MovieClip {

		private static var viewport1:Loader = new Loader();
		private static var viewport2:Loader = new Loader();
		private static var viewports:Sprite= new Sprite();
		private static var menu_ldr:Loader = new Loader();
		private static var bg_mc:MovieClip= new MovieClip();
		private static var logo_mc:MovieClip= new MovieClip();
		private static var gotoMenu_mc:MovieClip= new MovieClip();
		private static var rectView:Shape= new Shape();
		private static var menu_mc:Sprite= new Sprite();
		private static var numLoads:Boolean=true;
		private static var isMenuActive:Boolean=false;
		private static var currLoader;
		private static var lfVenzel:Sprite = new Sprite();
		private static var rtVenzel:Sprite = new Sprite();
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

			//добавление бекграунда
			
			var parameters = this.loaderInfo.parameters;

			if(this.loaderInfo.parameters.object != null)
				project = this.loaderInfo.parameters.object
			if(this.loaderInfo.parameters.language != null)	
				language = this.loaderInfo.parameters.language

			//bg_mc=createBg();
			addChild(bg_mc);

			//добавление вензелей

			//lfVenzel=addVenzels();
			//rtVenzel=addVenzels(-1);
			lfVenzel.cacheAsBitmap=rtVenzel.cacheAsBitmap=true;
			addChild(lfVenzel);
			addChild(rtVenzel);


			//Добавление логотипа

			//logo_mc = new logo();
			addChild(logo_mc);

			//добавление меню
			//menu_mc=createMenuItem();
			addChild(menu_mc);

			//Добавление вьюпортов

			viewport1.alpha=viewport2.alpha=0;
			viewport1.contentLoaderInfo.addEventListener(Event.COMPLETE,onLoadPano);
			viewport2.contentLoaderInfo.addEventListener(Event.COMPLETE,onLoadPano);
			//rectView=createViewRect();
			addChild(rectView);
			viewports.addChild(viewport1);
			viewports.addChild(viewport2);
			addChild(viewports);

			//добавление лоадера меню

			menu_ldr.alpha=0;
			addChild(menu_ldr);
			menu_ldr.contentLoaderInfo.addEventListener(Event.COMPLETE,onLoadMenu);

			//добавление цепи

			//gotoMenu_mc = new gotoMenu();
			//gotoMenu_mc.cep_mc.zona_mc.buttonMode=true;
			//gotoMenu_mc.cep_mc.zona_mc.addEventListener(MouseEvent.MOUSE_DOWN, gotoMenuAction);
			addChild(gotoMenu_mc);
			
			loadScene(firstScene);
			onResize(null);
		}
		/*private function addVenzels(side:int=1):Sprite {
			var allvnz:Sprite = new Sprite();
			var simplVnz:MovieClip;
			for (var i=1; i<=11; i++) {
				simplVnz = new venzel();
				simplVnz.scaleX=side;
				simplVnz.y = (i-1)*simplVnz.height;
				allvnz.addChild(simplVnz);
			}
			return allvnz;
		}

		private function createBg():MovieClip {
			var bg:MovieClip = new MovieClip();
			var simplBG:MovieClip;
			for (var i=1; i<=11; i++) {
				for (var j=1; j<=11; j++) {
					simplBG = new bgItem();
					simplBG.x = (i-1)*simplBG.width;
					simplBG.y = (j-1)*simplBG.height;
					bg.addChild(simplBG);
				}
			}
			bg.cacheAsBitmap=true;
			return bg;
		}

		private function createViewRect():Shape {
			var rect:Shape = new Shape();
			rect.graphics.beginFill(0xffffff);
			rect.graphics.drawRoundRect(0,0,918,558,10);
			return rect;
		}

		private function createMenuItem():Sprite {
			var items:Array=new Array("МЕНЮ1","МЕНЮ2","МЕНЮ3","МЕНЮ4");
			for (var i=1; i<=items.length; i++) {
				var item = new menuItem();
				item.create(i);
				menu_mc.addChild(item);
			}
			return menu_mc;
		}

		private static function gotoMenuAction(evt:MouseEvent) {
			TweenNano.killTweensOf(gotoMenu_mc.cep_mc);
			var time=1;
			if (! isMenuActive) {
				TweenNano.to(gotoMenu_mc.cep_mc, time,{y:-100,ease:Sine.easeOut});
				for (var i=1; i<=menu_mc.numChildren; i++) {
					TweenNano.to(menu_mc.getChildAt(i-1), time,{y:60,ease:Sine.easeOut});
				}
			} else {
				TweenNano.to(gotoMenu_mc.cep_mc,time,{y:0,ease:Sine.easeOut});
				for (var j=1; j<=menu_mc.numChildren; j++) {
					TweenNano.to(menu_mc.getChildAt(j-1), time,{y:0,ease:Sine.easeOut});
				}
			}
			isMenuActive=! isMenuActive;
		}*/

		public static function loadScene(url:String,xpos=null,ypos=null):void {
			startX=xpos;
			startY=ypos;
			numLoads=! numLoads;
			if (numLoads) {
				viewports.setChildIndex(viewport2,viewports.numChildren-1);
				viewport2.load(new URLRequest("pano/"+project+"/"+url));
			} else {
				viewports.setChildIndex(viewport1,viewports.numChildren-1);
				viewport1.load(new URLRequest("pano/"+project+"/"+url));
			}
		}
		private function onResize(evt:Event=null) {
			viewports.x=stage.stageWidth/2-900/2;
			viewports.y=stage.stageHeight/2-540/2;
			bg_mc.x=stage.stageWidth/2-bg_mc.width/2;
			bg_mc.y=stage.stageHeight/2-bg_mc.height/2;
			lfVenzel.x=0;
			rtVenzel.x=stage.stageWidth;
			lfVenzel.y=rtVenzel.y=stage.stageHeight/2-lfVenzel.height/2;
			rectView.x=stage.stageWidth/2-rectView.width/2;
			rectView.y=stage.stageHeight/2-rectView.height/2;
			logo_mc.x=stage.stageWidth/2;
			logo_mc.y=viewports.y/2-logo_mc.height/2;
			gotoMenu_mc.x=rectView.x+rectView.width+20;
			menu_mc.x=stage.stageWidth/2-menu_mc.width/2;
			menu_mc.y=rectView.y+rectView.height-110;
			menu_ldr.x=viewports.x;
			menu_ldr.y=viewports.y;
		}

		public static function loadMenu(evt:MouseEvent) {
			menu_ldr.load(new URLRequest("menu/contacts.swf"));
		}
		
		public static function unloadMenu(evt:MouseEvent) {
			TweenNano.to(menu_ldr,0.8,{alpha:0,onComplete:function(){menu_ldr.unload()}});
		}

		private function onLoadMenu(evt:Event) {
			TweenNano.to(menu_ldr,0.8,{alpha:1});
		}

		private function onLoadPano(evt:Event=null) {
			if (numLoads) {
				TweenNano.to(viewport2,0.8,{alpha:1,onComplete:hideViewport});
			} else {
				TweenNano.to(viewport1,0.8,{alpha:1,onComplete:hideViewport});
			}
		}
		
		public static function showNote(titleText){
		}
		
		public static function hideNote(){
		}
		
		public static function openDoor(door_mc){
			TweenNano.to(door_mc,0.3,{alpha:1});
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