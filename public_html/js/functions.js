/******************************************

			JS STRUCTURE

******************************************
1. GLOBAL CONSTANTS
2. GZAAS COMMON FUNCTIONS

3.1. HOME
3.2. SEE GZAAS
3.3. PREVIEW
******************************************/


/*************************/
/** 1. GLOBAL CONSTANTS **/
/*************************/

var topBottomHeight = 180;
var topLeftRight = 210;
const gzaasWidthPercentage = '89%';
const gzaasLeftMarginPercentage = '5%';

const previewMenuLeftMargin = 0.15;

const menu = $("#menuUsed").val();

// Times and animations
const timeToGzaasFadeIn = 150;
const timeToAdaptToResolutionOnSeeGzaas = 400;
const timeToAdaptToResolutionOnPreviewGzaas = 400;
const timeToShowMessageOnSeeGzaas = 1000;
const timeToShowMessageOnPreviewGzaas = 600;

const menuSidebarFadeTime = 350;
const menuSidebarShowDelayTime = 4300;

var oldWindowWidth;
var menuOpacity=1;

var maxSize = 40;
var maxNewLines = 10;


/*******************************/
/** 2. GZAAS COMMON FUNCTIONS **/
/*******************************/

function _renderGzaasMessage(timeToAdaptToResolution,timeToShowMessage) {

	setNewGzaasMessageSizeOnOverflowed();
	setTimeout('adaptSizesAndSpacesToWindowResolution()',timeToAdaptToResolution);
	if (typeof screenshot != "undefined" && screenshot) {
		if (screenshot=="video") {
			setTimeout('showGzaasMessage()',500);
		} else {
			showGzaasMessageWithoutAnimation();
		}
	} else {
		setTimeout('showGzaasMessage()',timeToShowMessage);
	}
}

// Adapt message to screen
function setNewGzaasMessageSizeOnOverflowed() {

	// VERTICAL OVERFLOW CONTROL
	oldWindowWidth = $(window).width();
	divHeight = $("#gzaas_screen").height();
	windowHeight = $(window).height();
	freeSpaceHeight = windowHeight - topBottomHeight;

	if (divHeight>freeSpaceHeight){
		oldFontSize = (parseInt(oldFontSize) * freeSpaceHeight) / divHeight;
		oldLetterSpacing = (parseInt(oldLetterSpacing) * freeSpaceHeight) / divHeight;
		oldLineHeight = (parseInt(oldLineHeight) * freeSpaceHeight) / divHeight;

		modifyFontSizeLetterSpacingAndLineHeight(oldFontSize,oldLetterSpacing,oldLineHeight);
	}

	// HORIZONTAL OVERFLOW CONTROL
	divWidth = $("#gzaas_screen").width();
	windowWidth = $(window).width();
	freeSpaceWidth = windowWidth - (windowWidth/5);

	if (divWidth>freeSpaceWidth){
		oldFontSize = (parseInt(oldFontSize) * freeSpaceWidth) / divWidth;
		oldLetterSpacing = (parseInt(oldLetterSpacing) * freeSpaceWidth) / divWidth;
		oldLineHeight = (parseInt(oldLineHeight) * freeSpaceWidth) / divWidth;

		modifyFontSizeLetterSpacingAndLineHeight(oldFontSize,oldLetterSpacing,oldLineHeight);
	}

	$("#gzaas_screen").css('width',gzaasWidthPercentage);
	$("#gzaas_screen").css('left',gzaasLeftMarginPercentage);

}

function modifyFontSizeLetterSpacingAndLineHeight(newFontSize,newLetterSpacing,newLineHeight) {

	$("#gzaas_screen").css('font-size',newFontSize+'px');
	$("#gzaas_screen").css('letter-spacing','-'+newLetterSpacing+'px');
	$("#gzaas_screen").css('lineHeight',newLineHeight+'px');
}

function adaptSizesAndSpacesToWindowResolution() {

	oldWidth = oldWindowWidth;
	windowWidth = $(window).width();
	windowHeight = $(window).height();

	newFontSize = (windowWidth/oldWidth)*oldFontSize;
	newLetterSpacing = (windowWidth/oldWidth)*oldLetterSpacing;
	newLineHeight = (windowWidth/oldWidth)*oldLineHeight;

	modifyFontSizeLetterSpacingAndLineHeight(newFontSize,newLetterSpacing,newLineHeight);

	divHeight = $("#gzaas_screen").height();
	marginTop = (windowHeight/2)-(divHeight/2);
	$("#gzaas_screen").css('top',marginTop+'px');

	// If preview page, menu open, let's move it with the buttons
	if ($("body").hasClass('preview')) {

		$("#sub_50").css('left',$("#mo_6").offset().left);
		$("#sub_1").css('left',$("#mo_1").offset().left);
		$("#sub_4").css('left',$("#mo_4").offset().left);
		$("#shadow_select_container").css('left',$("#to_shadow").offset().left);
		if (typeof $("#mColorPicker").attr('data-trigger') != "undefined") {
			$("#mColorPicker").css('left',$("#icp_"+$("#mColorPicker").attr('data-trigger')).offset().left);
		}
	}

}

// Render message
function showGzaasMessage(){
	$("#gzaas_screen").show().addClass('animate');
}

function showGzaasMessageWithoutAnimation(){
	$("#gzaas_screen").show();
}

// Window resize event
function _setEventNewResolutionWhenWindowResize() {

	$(window).resize(function() {
		adaptSizesAndSpacesToWindowResolution();
	});
}


/**************/
/** 3.1 HOME **/
/**************/

function initializeHome() {
	$('#gs_form').focus();
	$("#gs_form").keydown(function(e) {
		if (e.which == '13') {
			$('#preview_button').click();
			e.preventDefault();
		}
	});
}


/*******************/
/** 3.2 SEE GZAAS **/
/*******************/

function initializeSeeGzaas()
{
	_renderGzaasMessage(timeToAdaptToResolutionOnSeeGzaas,timeToShowMessageOnSeeGzaas);
	_showMenuAndSidebarWithDelay(menuSidebarShowDelayTime,menuSidebarFadeTime);
	initializeSeeGzaasEvents();
}

function initializeSeeGzaasEvents()
{
	_setEventNewResolutionWhenWindowResize();
	_setEventKeyMapping();
	_setEventClickOnNewGzaas();
	_setEventClickOnCloseNewGzaasContainer();
	_setEventKeyDownOnNewGzaasForm();
}

// See gzaas functions
function _showMenuAndSidebarWithDelay(time,fade) {
	time = 0; // tmp
	setTimeout(function(){
		_showMenuAndSidebar(fade);
	},time);
}

function _showMenuAndSidebar(menuSidebarShowFadeTime) {
		$("#header").slideDown(menuSidebarShowFadeTime);
		$("#footer").slideDown(menuSidebarShowFadeTime);
		$("#right_sidebar").fadeIn(menuSidebarShowFadeTime);
		$("#screen_layer").hide();
}

function _hideMenuAndSidebar(menuSidebarHideFadeTime) {
		$("#header").slideUp(menuSidebarHideFadeTime);
		$("#footer").slideUp(menuSidebarHideFadeTime);
		$("#right_sidebar").fadeOut(menuSidebarHideFadeTime);
}


// See gzaas events
function _setEventKeyMapping()
{
	$(document).keydown(function(e){
		switch (e.keyCode) {
		case 37:
			break;
		case 38:
		$("#gzaas_screen").click();break;
		case 39:
		$("#random_explore").click();break;
		case 40:
		$("#go_home_gzaas").click();break;
		}
	});
}

function _setEventClickOnNewGzaas() {

	$("#to-new-gzaas").click(function(){
		$(".center_dialog").hide();
		$("#create_gzaas_container").fadeIn(150);
		$('#gs_form_create_gzaas').focus();
	});

	$("#to-share").click(function(){
		showSharePopup(urlKey);
	});
}

function _setEventClickOnCloseNewGzaasContainer() {

	$(".center_dialog .title .close").click(function(){
		$(".center_dialog").hide();
	});
}

function _setEventKeyDownOnNewGzaasForm() {

	$("#gs_form_create_gzaas").keydown(function(e) {
		if (e.which == '13') {
			$('#create_button').click();
				e.preventDefault();
		}
	});
}


/*****************/
/** 3.3 PREVIEW **/
/*****************/

// Initialize Preview Js functions and events
function initializePreview()
{
	_renderGzaasMessage(timeToAdaptToResolutionOnPreviewGzaas,timeToShowMessageOnPreviewGzaas);
	_setFocusOnForm();
	_setTextShadow();
	_initRangeShadows();
	initializePreviewEvents();
}

function initializePreviewEvents() {

	_setEventNoIdea1();
	_setEventNewResolutionWhenWindowResize();

	// Shadow events
	_setEventClearShadow();
	_setEventClickOnShadowMenuOption();
	_setEventSetNewShadow();
	_setEventClickOnNewShadow();
	_setEventPreventShadowContainerClosingWhenItsColorPickerClicked();

	// Menu options events
	_setEventClickOnMenuOption();
	_setEventClickOnColorPickerMenuOption();
	_setEventHideAllMenuOptionsWhenDocumentClicked();
	_setEventClickOnMenuHashtag();
	_setEventHoverOnMenuHashtag();
	_setEventSeeAllHashtags();

	// Form events
	_setEventFormCharCount();
	_setEventClickOnExpandForm();
	_setEventKeydownOnForm();
	_setEventKeyUpOnForm();


	// Finish and create gzaas
	_setEventFinishAndCreateGzaas();
	_setEventNewGzaas();

	// Animations
	_setEventAnimateHoverOnExternalLink();
}

// Event methods

// Shadow events
function _setEventClearShadow()
{
	$(".shadow_clear").click(function(e){
		clear_shadow(e, $(this));
	});
}

function _setEventClickOnShadowMenuOption()
{
	$("#to_shadow").click(function(e){
		if (flagShadowMenu==0){
			var offset = $(this).offset();
			$("#shadow_select_container").css('left',offset.left);
			$("#shadow_select_container").fadeIn(150);
			flagShadowMenu = 1;
		}
		else {
			$("#shadow_select_container").hide();
			flagShadowMenu = 0;
		}
		flagColorMenu = 0;
		flagBackColorMenu = 0;
		$(".metatag_submenu, #mColorPickerBg, #mColorPicker").hide();
		$(".mColor, .mPastColor, #mColorPickerInput, #mColorPickerWrapper").unbind();
		e.stopPropagation();
	});
}

function _setEventSetNewShadow()
{
	$("#set_new_shadow").click(function(){
		setFinalTextShadow();
		_setEventClearShadow();
	});
}

function _setEventClickOnNewShadow()
{
	$("#go_to_new_shadow").click(function(){
		$("#go_to_new_shadow").hide();
		$("#shad_1").show();
	});
}


function _setEventPreventShadowContainerClosingWhenItsColorPickerClicked()
{
	$("#shadow_select_container").click(function(e) {
		if (flagColorHover == 0) {
			e.stopPropagation();
		}
		$.fn.mColorPicker.closePicker();
	});
}


// Menu options events
function _setEventClickOnMenuOption()
{
	$(".metatag_option,.styles").click(function(e){
		if ($(this).parent().find('ul[class="metatag_submenu"]').css('display') == 'none'){
			$("#shadow_select_container, .metatag_submenu, #mColorPickerBg, #mColorPicker").hide();
			$(".mColor, .mPastColor, #mColorPickerInput, #mColorPickerWrapper").unbind();
			flagShadowMenu = 0;
			flagColorMenu = 0;
			flagBackColorMenu = 0;
			var offset = $(this).offset();
			$(this).parent().find('ul[class="metatag_submenu"]').css('left',offset.left);
			$(this).parent().find('ul[class="metatag_submenu"]').fadeIn(150);
			e.stopPropagation();
		}
	});
}

function _setEventClickOnColorPickerMenuOption()
{
	$("#mColorPicker").click(function(e){
		colorPickerKey = $("#colorPickerKey").html();
		if (colorPickerKey=="color3"){
			e.stopPropagation();
		}
	});
}

function _setEventNoIdea1()
{
	$("#icp_color3").hover(function(){
		flagColorHover = 1;
		}, function(){
		flagColorHover = 0;
	});
}

function _setEventHideAllMenuOptionsWhenDocumentClicked()
{
	$(document).click(function(){
		flagShadowMenu = 0;
		flagColorMenu = 0;
		flagBackColorMenu = 0;
		$("#shadow_select_container").hide();
		$(".metatag_submenu").hide();
		$(".metatag_option_selected").addClass('metatag_option');
		$(".metatag_option_selected").removeClass('metatag_option_selected');
		$(".styles_selected").addClass('styles');
		$(".styles_selected").removeClass('styles_selected');
		$(".mColor, .mPastColor, #mColorPickerInput, #mColorPickerWrapper").unbind();
		$("#mColorPickerBg").hide();
		$("#mColorPicker").hide();

	});
}

function _setEventClickOnMenuHashtag()
{
	$(".hashtag_menu").click(function(e){
		var tVal = $('#gs_form_preview').val();
		hashtag = $(this).data('hashkey');
		metatag = $(this).data('metakey');
		urlPattern = $(this).data('urlpattern');

		switch (metatag) {
		case 1:
			$("#font").val(hashtag);
			$('#refresh_button').click();
			break;
		case 4:
			setNewPattern(hashtag,urlPattern);
			break;
		default:
			$("#font").val('');
			$("#color").val('');
			$("#backColor").val('');
			$("#pattern").val('');
			$("#style").val(hashtag);
			$('#refresh_button').click();
			break;
		}

	});
}

function setNewPattern(hashtag,urlPattern) {

	// Menu buttons update
	$("#backColor_span").hide();
	$("#backcolor_no_selected").show();
	$("#pattern_span").show();
	$("#pattern_no_selected").hide();

	$("#backColor").val('');
	$("#pattern").val(hashtag);
	$("body").css('background-image','url('+urlPattern+')');
	$("#pattern_span").css('background-image','url('+urlPattern+')').css('background-size','20px');
}

function closeAllOptionsPopover() {
	$("#mask,#all_options_container").hide();
}

function _setEventHoverOnMenuHashtag()
{
	$(".hashtag_menu").hover(function(e){
		$(this).find('span[class="add_hashtag"]').show();
	},
	function(e){
		$(this).find('span[class="add_hashtag"]').hide();
	});
}

function _checkValidTextMessage(textmessage)
{
	if ($.trim(textmessage) == '') {
		return false;
	} else {
		return true;
	}
}

function _checkValidStyleFeatures(data)
{
	if ((data.font=='') && (data.color=='') && (data.backColor=='') && (data.pattern=='') && (data.style=='') && (data.shadows=='')) {
		return false;
	} else {
		return true;
	}
}

function _checkValidColorStyles(data)
{
	if ((data.color==data.backColor) && (data.color!='')) {
		return false;
	} else {
		return true;
	}
}

function _setEventFinishAndCreateGzaas()
{
	$("#gzaas_it_preview").click(function() {
		var message = $("#gs_form_preview").val();

		if (!_checkValidTextMessage(message)) {
			_activateWarning(messageGzaasBlank,1);
			$("#gs_form_preview").focus();
		} else {
			var data = {};
			data.font = $("#font").val();
			data.color = $("#color").val();
			data.backColor = $("#backColor").val();
			data.pattern = $("#pattern").val();
			data.shadows = $("#shadows").val();
			data.style = $("#style").val();
			data.visibility = $("#visibility").val();
			data.message = message;

			if (!_checkValidStyleFeatures(data)) {
				_activateWarning(messageNoStyle,1);
			} else if (!_checkValidColorStyles(data)) {
				_activateWarning(messageSameColor,1);
			} else {
				// Valid message, style and color features
				flagNewGs = 1;
				$(this).hide();
				$("#in_new_gs_preview").show();
				$("#metatags_container,footer .vr, #preview_form_container").hide();

				var urlNewGzaas = urlBase+'/gzaas/newgs/';
				$.post(urlNewGzaas,data, response_ajax_new_gs, "json");
			}
		}
		return false;
	});
}

function _setEventNewGzaas()
{
	$("#repeat_new_gs_preview").click(function(){
		window.location = urlBase+'/preview/preview?style=random&gs_form=gzaas!';
	});
}

function _setEventSeeAllHashtags()
{
	$(".metatag_see_all").click(function(){
		$("#mask").show();
		key = $(this).parent().find('span[class="meta_key_span"]').html();
		if (key==1){
			if (flagGalleryFonts == 0) {
				flagGalleryFonts = 1;
				flagGalleryPatterns = 0;
				flagGalleryStyles = 0;
				$("#all_options_container").html('');
				$("#all_options_container").load(urlBase+'/getallfonts/');
			}
		}
		else if (key==4){
			if (flagGalleryPatterns == 0) {
				flagGalleryPatterns = 1;
				flagGalleryFonts = 0;
				flagGalleryStyles = 0;
				$("#all_options_container").html('');
				$("#all_options_container").load(urlBase+'/getallpatterns/');
			}
		}
		else if (key==50){
			if (flagGalleryStyles == 0) {
				flagGalleryStyles = 1;
				flagGalleryFonts = 0;
				flagGalleryPatterns = 0;
				$("#all_options_container").html('');
				$("#all_options_container").load(urlBase+'/getallstyles/');
			}
		}
		$("#all_options_container").show();
	});
}

function _setEventClickOnExpandForm()
{
	$("#expand_form").click(function(){
		if (flagFormExpanded==0){
			$("#gs_form_preview").css('bottom','114px');
			$("#gs_form_preview").css('height','141px');
			$(".counter").show();
			$("#expand_form").css("background","url('http://gzaas.com/images/arrow_down_form.png') no-repeat scroll 5px 5px #ddd");
			$("#expand_form").css('top','-127px');
			flagFormExpanded=1;
		}
		else {
			$("#gs_form_preview").css('bottom','-3px');
			$("#gs_form_preview").css('height','19px');
			$(".counter").hide();
			$("#expand_form").css("background","url('http://gzaas.com/images/arrow_up_form.png') no-repeat scroll 5px 5px #ddd");
			$("#expand_form").css('top','-11px');
			flagFormExpanded=0;
		}
		$("#gs_form_preview").focus();
	});
}

function _setEventKeydownOnForm()
{
	$("#gs_form_preview").keydown(function(e) {
		if ((e.which == '13') && (flagFormExpanded == 0)) {
			$('#refresh_button').click();
				e.preventDefault();
		}
		text = $(this).val();
		numNewLines = text.split('\n').length-1;
		if (numNewLines>=maxNewLines) {
			flagNoMoreLines = 1;
		} else {
			flagNoMoreLines = 0;
		}
		if ((e.which == '13') && (flagNoMoreLines == 1)) {
			e.preventDefault();
		}
		$("#refresh_button").fadeIn(150);
	});
}

function _setEventKeyUpOnForm()
{
	$("#gs_form_preview").keyup(function(e) {
		text = $(this).val();
		if (text.length > maxSize) {
			limitedText = text.substr(0,maxSize);
			$(this).val(limitedText);
		}
	});
}

function _setEventFormCharCount()
{
	$("#gs_form_preview").charCount({
		allowed: maxSize,
		warning: maxSize-10,
		counterText: ''
	});
}

function _setEventAnimateHoverOnExternalLink()
{
	var imageBaseUrl = $("#imageBaseUrl").val();
	$(".link_external").hover(function(){
		$(this).css('background','url('+imageBaseUrl+'link_external_hover.png) no-repeat right center');
	},function(){
		$(this).css('background','url('+imageBaseUrl+'link_external.png) no-repeat right center');
	});
}

function _setFocusOnForm()
{
	$("#gs_form_preview").focus();
}

function _activateWarning(message,style)
{
	$("#warnings_preview").html(message);
	if (style==0){
		$("#warnings_preview").css('background','#00ff00');
	} else {
		$("#warnings_preview").css('background','#FFFF00');
	}
	$("#warnings_preview").fadeIn(500, function(){
		setTimeout(function(){
			$("#warnings_preview").fadeOut(500);
		},2000);
	});
	return false;
}


function response_ajax_new_gs(data){

	// Interface
	$("#gzaas_screen").hide();
	$("#in_new_gs_preview").hide();
	$("#repeat_new_gs_preview").show();

	// Valid data
	if (data.valid==true) {
		$("#to_preview").attr('href',data.urlGs);
		showSharePopup(data.urlKey);
	} else {
		$("#preview_error_message").html(data.errorMessage);
		$("#new_gs_container_error").fadeIn(2000);
	}

}

var sharePopupShown = false;

function showSharePopup(urlKey) {

	if (!sharePopupShown) {

		urlKey = "NqQU";

		$("#new_gs_subtitle").html(messageTitlePopup);
		$("#new_gs_save").attr('href',urlAmazonS3 + urlKey + '.jpg');
		$("#new_gs_facebook").attr('href','http://www.facebook.com/sharer.php?u=' + urlBase + urlKey + '&t=' + urlBase + urlKey);
		$("#new_gs_twitter").attr('href','http://twitter.com/home?status=' + urlBase + urlKey + ' /via @gzaas');
		$("#new_gs_pinterest").attr('href','http://www.pinterest.com/pin/create/button/?url=' + urlBase + urlKey + '&media=' + urlAmazonS3 + urlKey + ".jpg&description=via http://gzaas.com");
		$("#url_result").val(urlBase + urlKey);

		sharePopupShown = true;
	}

	$(".center_dialog").hide();
	$("#url_result").show();
	// Interface
	$("#new_gs_container_preview").fadeIn(500);

}

function setTranslationColorMenu(colorMenu){
	if(colorMenu=="color1"){
		return fontcolor;
	} else if(colorMenu=="color2") {
		return backgroundcolor;
	} else {
		return shadowcolor;
	}
}

function _initRangeShadows()
{
	$("#hor_shad").rangeinput({
		change:function(event, value){
		_setTextShadow();
		}
	});

	$("#ver_shad").rangeinput({
		change:function(event, value){
		_setTextShadow();
		}
	});

	$("#blur_shad").rangeinput({
		change:function(event, value){
		_setTextShadow();
		}
	});
}

function getActualTextShadow() {
	return $("#hor_shad").val()+'px '+$("#ver_shad").val()+'px '+$("#blur_shad").val()+'px '+$("#shadow_color").val();
}

function _setTextShadow() {
	textShadow = '';
	actualShadow = getActualTextShadow();
	if (arrayShadows.length>0){
		for (x in arrayShadows) {
			if (x==0){
				textShadow = arrayShadows[0];
			}
			else {
				textShadow = textShadow + ', ' + arrayShadows[x];
			}
		}

		textShadow = textShadow +', '+ actualShadow;
	}
	else {
		textShadow = actualShadow;
	}
	if (textShadow == "0px 0px 0px #fff") {
		$("#gzaas_screen").css('text-shadow','');
	}
	else {
		$("#gzaas_screen").css('text-shadow',textShadow);
	}
}


function setFinalTextShadow() {
	$("#shad_1").css('display','none');
	textShadow = $("#hor_shad").val()+'px '+$("#ver_shad").val()+'px '+$("#blur_shad").val()+'px '+$("#shadow_color").val();
	arrayShadows.push(textShadow);
	stringShadows = arrayShadows.join(',');
	$("#shadows").val(stringShadows);
	position = arrayShadows.length;
	listShadowOption = '<ul class="shadow_list_option"><li class="shad_list_title">Shadow '+position+'</li><li>'+$("#hor_shad").val()+'px</li><li>'+$("#ver_shad").val()+'px</li>'+
	'<li>'+$("#blur_shad").val()+'px</li><li class="shad_list_opt_col" style="background:'+$("#shadow_color").val()+'"></li>'+
	'<li class="shadow_clear">X</li><span class="position" style="display:none">'+position+'</span></ul>';
	$("#shadow_list").append(listShadowOption);
	$("#shadow_list").show();
	$("#hor_shad").val('0');
	$("#ver_shad").val('0');
	$("#blur_shad").val('0');
	$("#go_to_new_shadow").css('display','block');

}

function clear_shadow(e, thisSelector) {
	// Eliminamos sombra del array de sombras
	position = thisSelector.parent().find('span[class="position"]').html();
	arrayShadows.splice(position-1,1);
	stringShadows = arrayShadows.join(',');
	$("#shadows").val(stringShadows);

	// Si no hay sombras, mostramos m�dulo crear sombra y ocultamos lista
	if (arrayShadows.length == 0) {
		$("#shadow_list").hide();
		$("#go_to_new_shadow").hide();
		$("#shad_1").show();
	}

	// Reordenamos lista posiciones para posiciones siguientes
	followingShadows = thisSelector.parent().parent().find('ul[class="shadow_list_option"]');
	followingShadows.each(function(){
		followPos = $(this).find('span[class="position"]').html();
		if (followPos > position) {
			$(this).find('span[class="position"]').html(followPos-1)
		}
	});

	// Eliminamos sombra html
	thisSelector.parent().hide(0).remove();

	// Renderizamos la nueva configuración de sombras
	_setTextShadow();

	// Prevenimos la eliminación de sombras en cascada
	e.PreventDefault();

}

function hideNavigationBar() {
	if (/mobile/i.test(navigator.userAgent) && !location.hash) {
		setTimeout(function() { window.scrollTo(0,1); },1000);
	}
}

function getPage() {
	if (typeof page!="undefined" && page=="preview") {
		return "preview";
	}
	if (typeof page!="undefined" && page=="seegzaas") {
		return "seegzaas";
	}
	if (typeof page!="undefined" && page=="home") {
		return "home";
	}
}

// DOCUMENT READY
$(document).ready(function(){

	oldWindowWidth = $(window).width();
	hideNavigationBar();

	if (getPage()=="preview") {
		initializePreview();
	}

	if (getPage()=="seegzaas") {
		initializeSeeGzaas();
	}

	if (getPage()=="home") {
		initializeHome();
	}

	/**
	if (typeof testanimations != "undefined") {
		$("#gzaas_screen").show();
		var chars = $("#gzaas_screen").text().split('');
		var newMessage = "";
		chars.forEach(function(value) {
			newMessage += "<i>" + value + "</i>";
		});
		$("#gzaas_screen").html(newMessage);
		var delay = 0;
		$("#gzaas_screen i").each(function() {
			delay += 150;
			var selector = $(this);
			setTimeout(function() {
				selector.addClass('swing').addClass('animated');
			},delay);
		});
	}
	**/

});





