document.body.onload = function() {
	setTimeout(function() {
		document.getElementById("text_loading").style.animation = "1s opacity_to_0 1 linear";
		setTimeout(function() {
			document.getElementById("text_loading").style.display = "none";
			document.getElementById("button_loading").style.display = "block";
			document.getElementById("button_loading").style.animation = "1s opacity_to_1 1 linear";
		},1000);
	},1000);
}

function HidePreLoader() {
	document.getElementById("welcome").play();
	document.getElementById("preloader").style.animation = "1s opacity_to_0 1 linear";
		setTimeout(function() {
			document.getElementById("preloader").style.display = "none";
		},970);
}