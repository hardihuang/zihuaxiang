// show comment
window.onload = function (){
	$(".comment").hide();
	var id=getUrlId()
	if(id){
		id_slide="#"+id;

		// jquery平滑滚动
		slideDown(id_slide);

		setTimeout('showComment('+id+');', 1000);
		// showComment(id);
	}
}

function getUrlId() {
	var r = window.location.search.substr(1).match('commentId=[\\d]+');
	// return r;
	if(r){
		var r_string = r.toString();
		var id=r_string.substr(10);
		return id
	}else{
		return null;
	}
}

// jquery平滑滚动
function slideDown(id){
	$("html, body").animate({
		scrollTop: $(id).offset().top-65 + "px"
	}, {
		duration: 1000,
		easing: "swing"
	});
};



function showComment(id){
	var name="#comment"+id
	$(name).slideToggle("fast");
}