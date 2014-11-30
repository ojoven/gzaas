// avconv -r 60 -f image2 -s 1920x1080 -i frames/gzaas%03d.png -vcodec libx264 -crf 15 out.mp4

var start = new Date().getTime();

// Retrieve params
var args = require('system').args;
var gzaasKey = args[1];
var url = args[2];
var pathToImage = args[3];
var width = args[4];
var height = args[5];
var page = require('webpage').create();
page.viewportSize = { width: width, height: height };

page.open(url, function () {
	// Render an image with the frame name
	setTimeout(function() {
	
		page.render(pathToImage, { format: "png" });
		// Exit after 60 images
		var end = new Date().getTime();
		var time = end - start;
		console.log(time);
		phantom.exit();
		
	},100);
});
