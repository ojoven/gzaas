// Example for generating video from frames
// avconv -r 60 -f image2 -s 1920x1080 -i frames/gzaas%03d.png -vcodec libx264 -crf 15 out.mp4
var start = new Date().getTime();
var page = require('webpage').create();
page.viewportSize = { width: 600, height: 400 };

page.open('http://gzaas.local.host/AAyQq2', function () {
    var frame = 1;
    // Add an interval every 25th second
    setInterval(function() {
      // Render an image with the frame name
      var framestring = (frame<10) ? "0" + frame : frame;
      page.render('jpg/gzaas0'+framestring+'.png', { format: "png" }); // Phantom creates the images much faster in jpg but avconv creates corrupted video if JPG inputs
      frame++;
      // Exit after 50 images
      if(frame > 50) {
        var end = new Date().getTime();
		var time = end - start;
		console.log(time);
        phantom.exit();
      }
    }, 2);
});
