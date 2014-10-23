(function($){
	var initLayout = function() {
		var hash = window.location.hash.replace('#', '');
		var currentTab = $('ul.navigationTabs a')
							.bind('click', showTab)
							.filter('a[rel=' + hash + ']');
		if (currentTab.size() == 0) {
			currentTab = $('ul.navigationTabs a:first');
		}
		showTab.apply(currentTab.get(0));
		$('#colorpickerHolder').ColorPicker({flat: true});
		$('#colorpickerHolder2').ColorPicker({
			flat: true,
			color: '#00ff00',
			onSubmit: function(hsb, hex, rgb) {
				$('#colorSelector2 div').css('backgroundColor', '#' + hex);
			}
		});
		$('#colorpickerHolder2>div').css('position', 'absolute');
		var widt = false;
		$('#colorSelector2').bind('click', function() {
			$('#colorpickerHolder2').stop().animate({height: widt ? 0 : 173}, 500);
			widt = !widt;
		});
		$('#colorpickerField1, #colorpickerField2, #colorpickerField3,#colorpickerField4,#colorpickerField5,#colorpickerField6,#colorpickerField7,#colorpickerField8,#colorpickerField9,#colorpickerField10,#colorpickerField11,#colorpickerField12,#colorpickerField13,#colorpickerField14,#colorpickerField15,#colorpickerField16,#colorpickerField17,#colorpickerField18,#colorpickerField19,#colorpickerField20,#colorpickerField21,#colorpickerField22,#colorpickerField23,#colorpickerField24,#colorpickerField25,#colorpickerField26,#colorpickerField27,#colorpickerField28,#colorpickerField29,#colorpickerField30,#colorpickerField31,#colorpickerField32,#colorpickerField33,#colorpickerField34,#colorpickerField35,#colorpickerField36,#colorpickerField37,#colorpickerField38,#colorpickerField39,#colorpickerField40,#colorpickerField41,#colorpickerField42,#colorpickerField43,#colorpickerField44,#colorpickerField45,#colorpickerField46,#colorpickerField47,#colorpickerField48,#colorpickerField49,#colorpickerField50,#colorpickerField51,#colorpickerField52,#colorpickerField53,#colorpickerField54,#colorpickerField55,#colorpickerField56,#colorpickerField57,#colorpickerField58,#colorpickerField59,#colorpickerField60,#colorpickerField61,#colorpickerField62,#colorpickerField63,#colorpickerField64,#colorpickerField65,#colorpickerField66,#colorpickerField67,#colorpickerField68,#colorpickerField69,#colorpickerField70').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val("#"+hex);
				$(el).ColorPickerHide();
				$(el).css({"background-color":"#"+hex});
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		$('#colorSelector').ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#colorSelector div').css('backgroundColor', '#' + hex);
			}
		});
	};
	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
		$(this)
			.addClass('active')
			.blur();
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)
