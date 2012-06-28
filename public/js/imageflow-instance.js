$(function(){
    var Instance3 = new ImageFlow();
    Instance3.init({ 
        ImageFlowID:'instance_imageflow', 
        captions:false, 
        slider:false, 
        reflections:false, 
        imageFocusMax:2,
        reflectionP:0.4, 
        opacity:true, 
        startID:3, 
        startAnimation:true, 
        imageFocusM:1.5 ,
        circular:true,
        onClick: function(){return false;}
    });
})