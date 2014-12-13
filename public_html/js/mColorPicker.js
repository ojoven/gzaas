/*
  mColorPicker
  Version: 1.0 r33

  Copyright (c) 2010 Meta100 LLC.
  http://www.meta100.com/

  Licensed under the MIT license
  http://www.opensource.org/licenses/mit-license.php
*/

// After this script loads set:
// $.fn.mColorPicker.init.replace = '.myclass'
// to have this script apply to input.myclass,
// instead of the default input[type=color]
// To turn of automatic operation and run manually set:
// $.fn.mColorPicker.init.replace = false
// To use manually call like any other jQuery plugin
// $('input.foo').mColorPicker({options})
// options:
// imageFolder - Change to move image location.
// swatches - Initial colors in the swatch, must an array of 10 colors.
// init:
// $.fn.mColorPicker.init.enhancedSwatches - Turn of saving and loading of swatch to cookies.
// $.fn.mColorPicker.init.allowTransparency - Turn off transperancy as a color option.
// $.fn.mColorPicker.init.showLogo - Turn on/off the meta100 logo (You don't really want to turn it off, do you?).


(function($){

  $.fn.mColorPicker = function(options) {

    if ($.browser.msie) $.fn.mColorPicker.attributeChangedEvent = 'propertychange';
    else if ($.browser.webkit) $.fn.mColorPicker.attributeChangedEvent = 'DOMSubtreeModified';

    $o = $.extend($.fn.mColorPicker.defaults, options);

    if ($o.swatches.length < 10) $o.swatches = $.fn.mColorPicker.defaults.swatches;
    if ($("div#mColorPicker").length < 1) $.fn.mColorPicker.drawPicker();

    if ($('#css_disabled_color_picker').length < 1) $('head').prepend('<style id="css_disabled_color_picker" type="text/css">.mColorPicker[disabled] + span, .mColorPicker[disabled="disabled"] + span, .mColorPicker[disabled="true"] + span {filter:alpha(opacity=50);-moz-opacity:0.5;-webkit-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;}</style>');

    $('.mColorPicker').live('keyup', function () {

      try {

        $(this).css({
          'background-color': $(this).val()
        }).css({
          'color': $.fn.mColorPicker.textColor($(this).css('background-color'))
        }).trigger('change');
      } catch (r) {}
    });

    $('.mColorPickerTrigger').live('click', function () {

    $(".mColor, .mPastColor, #mColorPickerInput, #mColorPickerWrapper").unbind();
      $.fn.mColorPicker.colorShow($(this).attr('id').replace('icp_', ''));
    });

    return this.each(function (index) {

      $.fn.mColorPicker.drawPickerTriggers($(this), index);
    });
  };

  $.fn.mColorPicker.currentColor = false;
  $.fn.mColorPicker.currentValue = false;
  $.fn.mColorPicker.color = false;
  $.fn.mColorPicker.attributeChangedEvent = 'DOMAttrModified';

  $.fn.mColorPicker.init = {
    replace: '[type=color]',
    enhancedSwatches: true,
    allowTransparency: false,
    showLogo: false
  };

  $.fn.mColorPicker.defaults = {
    imageFolder: 'http://gzaas.com/images/colorPicker/',
    swatches: [
               "#ffffff",
               "#CCFF00",
               "#AD234B",
               "#EF0401",
               "#6E4EC6",
               "#CD8AFA",
               "#FBB829",
               "#4c2b11",
               "#6CDFEA",
               "#211959",
               "#55FA42",
               "#000000"
             ]
  };

  $.fn.mColorPicker.drawPickerTriggers = function ($t, index) {

    if ($t[0].nodeName.toLowerCase() != 'input') return false;
    if ($t.data('mColorPicker') == 'true') return false;

    var id = $t.attr('id') || 'color_' + index,
        hidden = false;

    $t.attr('id', id);

    if ($t.attr('text') == 'hidden' || $t.attr('data-text') == 'hidden') hidden = true;

    var color = $t.val(),
        width = ($t.width() > 0)? $t.width(): parseInt($t.css('width'), 10),
        height = ($t.height())? $t.height(): parseInt($t.css('height'), 10),
        flt = $t.css('float'),
        image = (color == 'transparent')? "url('" + $o.imageFolder + "/grid.gif')": '',
        colorPicker = '';

    $('body').append('<span id="color_work_area"></span>');
    $('span#color_work_area').append($t.clone(true));
    colorPicker = $('span#color_work_area').html().replace(/type=[^a-z]*color[^a-z]*/gi, (hidden)? 'type="hidden"': 'type="text"');
    $('span#color_work_area').html('').remove();
    $t.after(
      (hidden)? '<span style="cursor:pointer;border:1px solid black;float:' + flt + ';width:' + width + 'px;height:' + height + 'px;" id="icp_' + id + '">&nbsp;</span>': ''
    ).after(colorPicker).remove();

    if (hidden) {

    	/*
      $('#icp_' + id).css({
        'background-color': color,
        'background-image': image,
        'display': 'inline-block'
      }).attr(
        'class', $('#' + id).attr('class')
      ).addClass(
        'mColorPickerTrigger'
      );
    } else {


      $('#' + id).css({
        'background-color': color,
        'background-image': image
      }).css({
        'color': $.fn.mColorPicker.textColor($('#' + id).css('background-color'))
      }).after(
        '<span style="cursor:pointer;" id="icp_' + id + '" class="mColorPickerTrigger"><img src="' + $o.imageFolder + 'color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>'
      ).addClass('mColorPickerInput');
      */
    }

    $('#icp_' + id).data('mColorPicker', 'true');

    $('#' + id).addClass('mColorPicker');

    return $('#' + id);
  };

  $.fn.mColorPicker.drawPicker = function () {

    $(document.createElement("div")).attr(
      "id","mColorPicker"
    ).css(
      'display','none'
    ).html(
      '<div class="metatag_submenu_title" id="colorPickerTitle"></div><div class="metatag_submenu_options"><span id="colorPickerUseIt"></span></div><div id="mColorPickerWrapper"><div id="mColorPickerImg" class="mColor"></div><div id="mColorPickerImgGray" class="mColor"></div><div id="mColorPickerSwatches"><div class="mClear"></div></div></div><span id="colorPickerKey"></span>'
    ).appendTo("body");

    for (n = 11; n > -1; n--) {

      $(document.createElement("div")).attr({
        'id': 'cell' + n,
        //'class': "mPastColor" + ((n > 0)? ' mNoLeftBorder': '')
        'class': "mPastColor"
      }).html(
        '&nbsp;'
      ).prependTo("#mColorPickerSwatches");
    }

    $('#mColorPicker').css({
      'color':'#fff',
      'z-index':999998,
      'width':'194px',
      'height':'58px',
      'font-size':'12px',
      'font-family':'times'
    });

    $('.mPastColor').css({
      'height':'32px',
      'width':'48px',
      'float':'left'
    });

    $('#colorPreview').css({
      'height':'50px'
    });

    $('.mNoLeftBorder').css({
      'border-left':0
    });

    $('.mClear').css({
      'clear':'both'
    });

    $('#mColorPickerWrapper').css({
      'position':'relative',
      'z-index':999999
    });

    $('#mColorPickerImg').css({
      'height':'128px',
      'width':'192px',
      'border':0,
      'cursor':'crosshair',
      'background-image':"url('" + $o.imageFolder + "colorpicker.png')"
    });

    $('#mColorPickerImgGray').css({
      'height':'8px',
      'width':'192px',
      'border':0,
      'cursor':'crosshair',
      'background-image':"url('" + $o.imageFolder + "graybar.jpg')"
    });

    $('#mColorPickerInput').css({
      'border':'solid 1px gray',
      'font-size':'10pt',
      'margin':'3px',
      'width':'80px'
    });

    $('#mColorPickerImgGrid').css({
      'border':0,
      'height':'20px',
      'width':'20px',
      'vertical-align':'text-bottom'
    });

    $('#mColorPickerSwatches').css({
      'border-right':'none'
    });


    $("#mColorPickerBg").click($.fn.mColorPicker.closePicker);

    var swatch = $.fn.mColorPicker.getCookie('swatches'),
        i = 0;

    if (typeof swatch == 'string') swatch = swatch.split('||');
    if (swatch == null || $.fn.mColorPicker.init.enhancedSwatches || swatch.length < 10) swatch = $o.swatches;

    $(".mPastColor").each(function() {

      $(this).css('background-color', swatch[i++].toLowerCase());
    });
  };

  $.fn.mColorPicker.closePicker = function () {
    $(".mColor, .mPastColor, #mColorPickerInput, #mColorPickerWrapper").unbind();
    $("#mColorPickerBg").hide();
    $("#mColorPicker").hide();
  };

  $.fn.mColorPicker.colorShow = function (id) {


	  flagShadowMenu = 0;
	  flagSharingMenu = 0;
	  $("#colorPickerTitle").html(setTranslationColorMenu(id));
	  $("#colorPickerKey").html(id);

	  $("#sharing_options").hide();
	  flagSharingMenu = 0;
		if (flagAttention==0){
			$("#attention").fadeOut(150);
			flagAttention = 1;
		}

    var $e = $("#icp_" + id);
        pos = $e.offset(),
        $i = $("#" + id);
        hex = $i.attr('data-hex') || $i.attr('hex'),
        pickerTop = pos.top + $e.outerHeight(),
        pickerLeft = pos.left,
        $d = $(document),
        $m = $("#mColorPicker");

        $m.hide();

		if (id=='color1') {
			if (flagColorMenu == 1){
			flagColorMenu = 0;
			return false;
			}
			else {
				flagColorMenu = 1;
				flagBackColorMenu = 0;
			}
		}

		if (id=='color2') {
			if (flagBackColorMenu == 1){
			flagBackColorMenu = 0;
			return false;
			}
			else {
				flagBackColorMenu = 1;
				flagColorMenu = 0;
			}
		}

    if ($i.attr('disabled')) return false;

                // KEEP COLOR PICKER IN VIEWPORT
                if (pickerTop + $m.height() > $d.height()) pickerTop = pos.top - $m.height();
                if (pickerLeft + $m.width() > $d.width()) pickerLeft = pos.left - $m.width() + $e.outerWidth();

	leftBase = (windowWidth * 0.15)+3;

    if (id=='color1'){
    	left = (leftBase + 269) + "px";
        $m.css({
            'bottom':"274px",
            'left':left,
            'position':'absolute'
          }).fadeIn(200);
    }

    else if (id=='color2'){
    	left = (leftBase + 308) + "px";
        $m.css({
            'bottom':"274px",
            'left':left,
            'position':'absolute'
          }).fadeIn(200);
    }

    else {
    	left = (leftBase + 515) + "px";
        $m.css({
            'bottom':"289px",
            'left':left,
            'position':'absolute'
          }).fadeIn(200);

    }


    $("#mColorPickerBg").css({
      'z-index':999990,
      'background':'black',
      'opacity': .01,
      'position':'absolute',
      'top':0,
      'left':0,
      'width': parseInt($d.width(), 10) + 'px',
      'height': parseInt($d.height(), 10) + 'px'
    }).show();

    var def = $i.val();

    $('#colorPreview span').text(def);
    $('#colorPreview').css('background', def);
    $('#color').val(def);

    if ($('#' + id).attr('data-text')) $.fn.mColorPicker.currentColor = $e.css('background-color');
    else $.fn.mColorPicker.currentColor = $i.css('background-color');

    if (hex == 'true') $.fn.mColorPicker.currentColor = $.fn.mColorPicker.RGBtoHex($.fn.mColorPicker.currentColor);

    $("#mColorPickerInput").val($.fn.mColorPicker.currentColor);

    $('.mColor, .mPastColor').bind('mousemove', function(e) {

        if (id=="color1"){
      	  $("#colorPickerUseIt").css('color',$.fn.mColorPicker.color);
      	  $("#colorPickerUseIt").css('background-color',$("body").css('background-color'));
        }
        else {
      		  $("#colorPickerUseIt").css('background-color',$.fn.mColorPicker.color);
      		  $("#colorPickerUseIt").css('color',$("#gzaas_screen").css('color'));
        }

      var offset = $(this).offset();


      $.fn.mColorPicker.color = $(this).css("background-color");

      $("#colorPickerUseIt").html('use it!');


      if ($(this).hasClass('mPastColor') && hex == 'true') $.fn.mColorPicker.color = $.fn.mColorPicker.RGBtoHex($.fn.mColorPicker.color);
      else if ($(this).hasClass('mPastColor') && hex != 'true') $.fn.mColorPicker.color = $.fn.mColorPicker.hexToRGB($.fn.mColorPicker.color);
      else if ($(this).attr('id') == 'mColorPickerTransparent') $.fn.mColorPicker.color = 'transparent';
      else if (!$(this).hasClass('mPastColor')) $.fn.mColorPicker.color = $.fn.mColorPicker.whichColor(e.pageX - offset.left, e.pageY - offset.top + (($(this).attr('id') == 'mColorPickerImgGray')? 128: 0), hex);



      //$.fn.mColorPicker.setInputColor(id, $.fn.mColorPicker.color);
    }).click(function() {


      $.fn.mColorPicker.colorPicked(id);
      $("#colorPickerUseIt").html('');

	  $("#colorPickerUseIt").css('background','none');
      $.fn.mColorPicker.currentColor = $.fn.mColorPicker.RGBtoHex($.fn.mColorPicker.currentColor);
      stringColor = $.fn.mColorPicker.currentColor.replace("#","");


      if (id=='color1'){
      	$("#gzaas_screen").css('color',$.fn.mColorPicker.currentColor);
      	$("#color_info").find('span[class="pre_info_option"]').css('background-color',$.fn.mColorPicker.currentColor);
      	$("#color_info").show();
      	console.log($.fn.mColorPicker.currentColor);
      	$("#color_span").css('background-color',$.fn.mColorPicker.currentColor);
      	$("#color").val(stringColor);
      	if (stringColor==$("#backColor").val()){
      		activateWarning(messageSameColor,1);
      	}
      }
      else if (id=='color2'){
    	$("body").css('background','none');
      	$("body").css('background-color',$.fn.mColorPicker.currentColor);
      	$("#backColor_info").find('span[class="pre_info_option"]').css('background-color',$.fn.mColorPicker.currentColor);
      	$("#backColor_info").show();
      	$("#backColor_span").css('background-color',$.fn.mColorPicker.currentColor);
      	$("#backColor_span").show();
      	$("#pattern_span").hide();
      	$(".back_no_selected").hide();
      	$("#pattern_no_selected").show();
      	$("#backColor").val(stringColor);
      	if ($("#pattern").val() != ''){
      		$("#pattern").val('');
      		$("#pattern_info").hide();
      	}
     	if (stringColor==$("#color").val()){
      		activateWarning(messageSameColor,1);
      	}
      }

      else {
    	  $("#shadow_color").val($.fn.mColorPicker.currentColor);
    	  _setTextShadow();
    	  $("#shadow_color_span").css('background-color',$.fn.mColorPicker.currentColor);
    	  $("#shadow_select_container").show();
    	  $.fn.mColorPicker.closePicker();
      }
    });

    $('#mColorPickerInput').bind('keyup', function (e) {

      try {

        $.fn.mColorPicker.color = $('#mColorPickerInput').val();
        $.fn.mColorPicker.setInputColor(id, $.fn.mColorPicker.color);

        if (e.which == 13) $.fn.mColorPicker.colorPicked(id);
      } catch (r) {}
    }).bind('blur', function () {

      $.fn.mColorPicker.setInputColor(id, $.fn.mColorPicker.currentColor);
    });

    $('#mColorPickerWrapper').bind('mouseleave', function () {

        $("#colorPickerUseIt").html('');
        $("#colorPickerUseIt").css('background','none');

      $.fn.mColorPicker.setInputColor(id, $.fn.mColorPicker.currentColor);
    });

    $(".metatag_submenu").hide();
	if (id!="color3") {$("#shadow_select_container").hide();}

	$("#style_info_supra").html('');

   	e.stopPropagation();
  };

  $.fn.mColorPicker.setInputColor = function (id, color) {

    var image = (color == 'transparent')? "url('" + $o.imageFolder + "grid.gif')": '',
        textColor = $.fn.mColorPicker.textColor(color);

    if ($('#' + id).attr('data-text') || $('#' + id).attr('text')) $("#icp_" + id).css({'background-color': color, 'background-image': image});
    $("#" + id).val(color).css({'background-color': color, 'background-image': image, 'color' : textColor}).trigger('change');
    $("#mColorPickerInput").val(color);

  };

  $.fn.mColorPicker.textColor = function (val) {

    if (typeof val == 'undefined' || val == 'transparent') return "black";
    val = $.fn.mColorPicker.RGBtoHex(val);
    return (parseInt(val.substr(1, 2), 16) + parseInt(val.substr(3, 2), 16) + parseInt(val.substr(5, 2), 16) < 400)? 'white': 'black';
  };

  $.fn.mColorPicker.setCookie = function (name, value, days) {

    var cookie_string = name + "=" + escape(value),
      expires = new Date();
      expires.setDate(expires.getDate() + days);
    cookie_string += "; expires=" + expires.toGMTString();

    document.cookie = cookie_string;
  };

  $.fn.mColorPicker.getCookie = function (name) {

    var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );

    if (results) return (unescape(results[2]));
    else return null;
  };

  $.fn.mColorPicker.colorPicked = function (id) {

    //$.fn.mColorPicker.closePicker();


    if ($.fn.mColorPicker.init.enhancedSwatches) $.fn.mColorPicker.addToSwatch();

    $("#" + id).trigger('colorpicked');
  };

  $.fn.mColorPicker.addToSwatch = function (color) {

    var swatch = []
        i = 0;

    if (typeof color == 'string') $.fn.mColorPicker.color = color.toLowerCase();

    $.fn.mColorPicker.currentValue = $.fn.mColorPicker.currentColor = $.fn.mColorPicker.color;

    if ($.fn.mColorPicker.color != 'transparent') swatch[0] = $.fn.mColorPicker.color.toLowerCase();

    /*
    $('.mPastColor').each(function() {

      $.fn.mColorPicker.color = $(this).css('background-color').toLowerCase();

      if ($.fn.mColorPicker.color != swatch[0] && $.fn.mColorPicker.RGBtoHex($.fn.mColorPicker.color) != swatch[0] && $.fn.mColorPicker.hexToRGB($.fn.mColorPicker.color) != swatch[0] && swatch.length < 10) swatch[swatch.length] = $.fn.mColorPicker.color;

      $(this).css('background-color', swatch[i++])
    });*/

    if ($.fn.mColorPicker.init.enhancedSwatches) $.fn.mColorPicker.setCookie('swatches', swatch.join('||'), 365);
  };

  $.fn.mColorPicker.whichColor = function (x, y, hex) {

    var colorR = colorG = colorB = 255;

    if (x < 32) {

      colorG = x * 8;
      colorB = 0;
    } else if (x < 64) {

      colorR = 256 - (x - 32 ) * 8;
      colorB = 0;
    } else if (x < 96) {

      colorR = 0;
      colorB = (x - 64) * 8;
    } else if (x < 128) {

      colorR = 0;
      colorG = 256 - (x - 96) * 8;
    } else if (x < 160) {

      colorR = (x - 128) * 8;
      colorG = 0;
    } else {

      colorG = 0;
      colorB = 256 - (x - 160) * 8;
    }

    if (y < 64) {

      colorR += (256 - colorR) * (64 - y) / 64;
      colorG += (256 - colorG) * (64 - y) / 64;
      colorB += (256 - colorB) * (64 - y) / 64;
    } else if (y <= 128) {

      colorR -= colorR * (y - 64) / 64;
      colorG -= colorG * (y - 64) / 64;
      colorB -= colorB * (y - 64) / 64;
    } else if (y > 128) {

      colorR = colorG = colorB = 256 - ( x / 192 * 256 );
    }

    colorR = Math.round(Math.min(colorR, 255));
    colorG = Math.round(Math.min(colorG, 255));
    colorB = Math.round(Math.min(colorB, 255));

    if (hex == 'true') {

      colorR = colorR.toString(16);
      colorG = colorG.toString(16);
      colorB = colorB.toString(16);

      if (colorR.length < 2) colorR = 0 + colorR;
      if (colorG.length < 2) colorG = 0 + colorG;
      if (colorB.length < 2) colorB = 0 + colorB;

      return "#" + colorR + colorG + colorB;
    }

    return "rgb(" + colorR + ', ' + colorG + ', ' + colorB + ')';
  };

  $.fn.mColorPicker.RGBtoHex = function (color) {

    color = color.toLowerCase();

    if (typeof color == 'undefined') return '';
    if (color.indexOf('#') > -1 && color.length > 6) return color;
    if (color.indexOf('rgb') < 0) return color;

    if (color.indexOf('#') > -1) {

      return '#' + color.substr(1, 1) + color.substr(1, 1) + color.substr(2, 1) + color.substr(2, 1) + color.substr(3, 1) + color.substr(3, 1);
    }

    var hexArray = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"],
        decToHex = "#",
        code1 = 0;

    color = color.replace(/[^0-9,]/g, '').split(",");

    for (var n = 0; n < color.length; n++) {

      code1 = Math.floor(color[n] / 16);
      decToHex += hexArray[code1] + hexArray[color[n] - code1 * 16];
    }

    return decToHex;
  };

  $.fn.mColorPicker.hexToRGB = function (color) {

    color = color.toLowerCase();

    if (typeof color == 'undefined') return '';
    if (color.indexOf('rgb') > -1) return color;
    if (color.indexOf('#') < 0) return color;

    var c = color.replace('#', '');

    if (c.length < 6) c = c.substr(0, 1) + c.substr(0, 1) + c.substr(1, 1) + c.substr(1, 1) + c.substr(2, 1) + c.substr(2, 1);

    return 'rgb(' + parseInt(c.substr(0, 2), 16) + ', ' + parseInt(c.substr(2, 2), 16) + ', ' + parseInt(c.substr(4, 2), 16) + ')';
  };

  $(document).ready(function () {

    if ($.fn.mColorPicker.init.replace == '[type=color]') {

      $('input').filter(function(index) {

        return this.getAttribute('type') == 'color';
      }).mColorPicker();

      $(document).bind('ajaxSuccess', function () {

        $('input').filter(function(index) {

          return this.getAttribute('type') == 'color';
        }).mColorPicker();
      });
    } else if ($.fn.mColorPicker.init.replace) {

      $('input' + $.fn.mColorPicker.init.replace).mColorPicker();

      $(document).bind('ajaxSuccess', function () {

        $('input' + $.fn.mColorPicker.init.replace).mColorPicker();
      });
    }
  });
})(jQuery);