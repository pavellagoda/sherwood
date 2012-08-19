package {
	import flash.display.*;
	import flash.net.*;
	import flash.external.ExternalInterface;

	public class GetAMFData {
		private var method:String;
		private var responder:Responder;
		private var connection:NetConnection;
		private var params:Object;
		private var resList:Function;

		public function GetAMFData() {
		}

		private function onFault(param1:Object):void {
			trace(String(param1.description) + "error");
		}

		public function getParams(method, resultList, params = null) {
			this.resList=resultList;
			this.responder=new Responder(this.onResult,this.onFault);
			this.connection = new NetConnection();
			this.connection.connect("/gateway/amf");
			var way:String =String("FW_Gateway_Amf."+method);
			this.connection.call(way, this.responder, params);
		}

		private function onResult(resultData):void {
			this.resList(resultData);
		}

	}
}