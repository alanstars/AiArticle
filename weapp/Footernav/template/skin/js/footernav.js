function a(){
	var div=document.getElementById("d1_Footernav");
	div.style.display="block"
	}

$(document).ready(function(){
    $('#agree_Footernav').click(function(){
        if($("input[type='checkbox']").is(':checked')){
           	$("input.btn_Footernav").click(function() {
           		window.open("weixin://")
           	} )
        }else{

        }
    });
});
