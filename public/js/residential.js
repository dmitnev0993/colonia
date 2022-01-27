(function ($) {
	var tmr;
	var uploaded = false;
	$(document).ready(function() {
		var blockcomplete='';
		var formcomplete='';
		var windowWidth = Math.min($(window).width() - 40, 700);
		$('body').on('click', '#s0_yes', function () {
			$('#s0_no').click();
			$('#dialog6').dialog('open');
		});
		$('.dialog').dialog({
			autoOpen: false,
			width: windowWidth,
			height: 280,
			modal: true,
			buttons: {
				"OK": function() {
					$(this).dialog("close");
				}
			},
			title: 'Please note'
		});
		common();
		ajaxElements();
		ajaxAfterLoad();
		$("#getquote").click(function() {
			$('#textdiv').fadeOut(200);
			$('#quotediv').fadeIn(200);
			return false;
		});
		$('li a.ajax').each(function() {
			$(this).addClass("empty");
		});
		$('#finder').on('focus', function () {
			if ($(this).val() == 'Incorrect postcode') $(this).val('');
		});
		$(".ajax").click(function() {
			var lastblock=Number($('.lastblock').val());
			if ($('#s0_yes').prop('checked')) {
				$('#dialog6').dialog('open');
				return false;
			}
			if($(this).hasClass('li')){
				var thisnum=Number($(this).attr('id').substring(2))+1;
				if(thisnum>lastblock){
					return false;
				}
			}
			$('.mandatory .element').removeClass("redborder").parent().removeClass('redcolor');
			blockcomplete='yes';
			$('.mandatory > .element, .mandatory > label > .element').each(function() {
				if($(this).hasClass('empty')){
					$(this).addClass("redborder").parent().addClass('redcolor');
					blockcomplete='no';
				}
			});
			$('.claimsstring .element').each(function(){
				if($(this).val()=='' || $(this).val()=='Please select') {
					$(this).addClass('redborder').parent().addClass('redcolor');
					blockcomplete='no';
				}
			});
			if ($('#s217').length && !($('#s217').val() > 0)) {
				$('#s217').addClass("redborder").parent().addClass('redcolor');
				blockcomplete='no';
			}
			if ($('.s28ulink').length && !$('.s28ulink').hasClass('hidden') && !uploaded) {
				$('.s28ulink button').css({color:'red'});
				blockcomplete='no';
			}
			var idnum=$('.h2').attr('id');
			idnum=idnum.substring(5);
			if (idnum=='10'){
				return false;
			}
			if (idnum=='4'){return false;}
			if ($('#s011').length && !$('#s011').val() || $('#s012').length && !$('#s012').val() || $('#s013').length && !$('#s013').val() || $('#s21').length && !$('#s21').val() || $('#s22').length && !$('#s22').val() || $('#s22state').length && !$('#s22state').val()) {
				$('#finder').addClass("redborder").val('Incorrect postcode').parent().addClass('redcolor');
				blockcomplete='no';
			}
			if(blockcomplete=='yes'){
				$('#center a#li'+idnum).removeClass("redcolor");
				formcomplete[idnum]='yes';
			}else{
				$('#dialog2').dialog('open');;
				return false;
			}
			var spRequest={id:$(this).attr("id"),block:$('.h2').attr('id')};
			$('.element').each(function() {
				if ($(this).attr('type') == 'checkbox') {
					spRequest[$(this).attr("name")] = $(this).prop('checked') ? 'yes' : 'no';
				} else {
					spRequest[$(this).attr("name")] = $(this).val();
				}
			});
			$('#mask').show();
			$.post('/query-residential', spRequest,function(msg){
				$("#dynamic").html(msg);
				common();
				ajaxElements();
				ajaxAfterLoad();
			});
			return false;
		});
	});
	function displayDialog(id){
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		if(id=='postcode'){
			$('#mask').fadeTo(1,0.1);
		}else{
			$('#mask').fadeTo(700,0.6);
			var winH = $(window).height()+2*$(window).scrollTop();
			var winW = $(window).width();
			$('#boxes').html($(id).html());
			$('#boxes').css('top',  winH/2-$('#boxes').height()/2);
			$('#boxes').css('left', winW/2-$('#boxes').width()/2);
			$('#boxes').fadeIn(700);
			$('#boxes .button').click(function(){
				$('#mask, #boxes').fadeOut(700);
			});
		}
	}
	function checkmail (value) {
	 return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(value);
	}
	function getSearchData () {
		$.post("/search-suburb", {suburb:$('#finder').val()}, function(data){
			jsondata = JSON.parse(data);
			var lo = "";
			if(jsondata.data.length > 0){
					for(var i=0;i<jsondata.data.length;i++){
						lo += '<div class="searchLine" data-id="' + i + '" id="search_' + i + '">' + jsondata.data[i].postcode + ', ' + jsondata.data[i].suburb + '</div>';
					}
					$('#postcode').html(lo).show();
					$('#mask').fadeOut(1);
			 }else{
				$('#postcode').html('').hide();
				$('#mask').fadeOut(1);
			 }
			 $('#finder').addClass('waitno').removeClass('waityes').focus();
		});
	}
	function search_click (id) {
	  var searched_data=jsondata.data[id];
	  if ($('#s011').length && $('#s012').length && $('#s013').length) {
	    $('#s011').val(searched_data.postcode);
			$('.s011').removeClass('hidden');
	    $('#s013').val(searched_data.suburb);
			$('.s013').removeClass('hidden');
			$('#s012').val(searched_data.state);
			$('.s012').removeClass('hidden');
	  } else if ($('#s21').length && $('#s22').length && $('#s22state').length) {
	    $('#s21').val(searched_data.postcode);
			$('.s21').removeClass('hidden');
	    $('#s22').val(searched_data.suburb);
			$('.s22').removeClass('hidden');
			$('#s22state').val(searched_data.state);
			$('.s22state').removeClass('hidden');
	  }
		$('#postcode').html('').hide();
		$('#mask').fadeOut(1);
		$('.finder').removeClass('mandatory redcolor');
		$('#d-finder label.top .mandatory').remove();
		$('#finder').val('').removeClass('redborder element').addClass('subelement');
	}

	function claimsquest(){
		var claimsjson = new Array;
		if($('#s13_total').html()!=''){
			var claimsjson=JSON.parse($('#s13_total').html());
		}
		var claimsnumber=Number($("#s11").val());
		var claimsstring="";
		if(Number($('#s11').val())>0){
			if ($('#s14').val()!=''){
				claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Replace file with claims details</label>';
			}else{
				claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Load file with claims details</label>';
			}
			claimsstring+='<input type="file" class="element" name="file" id="file" />';
			if ($('#s14').val()!=''){
				claimsstring+='<span class="uploaded"><a target="_blank" href="'+$('#s14').val()+'">View uploaded claims details</a></span>';
			}
			claimsstring+='</form>';
		}
		var date = new Date();
		var year = date.getFullYear();
		var options1 = '';
		for(var i=year;i>=year-5;i--){
			options1+='<option value="'+i+'">'+i+'</option>';
		}
		var options2 = '<option value="Water Damage">Water Damage</option><option value="Fusion Damage">Fusion Damage</option><option value="Fire Damage">Fire Damage</option><option value="Accidental Damage">Accidental Damage</option><option value="Malicious Damage">Malicious Damage</option><option value="Storm Damage">Storm Damage</option><option value="Birst Pipe Damage">Birst Pipe Damage</option><option value="Impact Damage">Impact Damage</option><option value="Glass Damage">Glass Damage</option><option value="Building and Common Contents">Building and Common Contents</option><option value="Legal liability">Legal liability</option><option value="Ofice bearers liability">Ofice bearers liability</option><option value="Voluntary workers">Voluntary workers</option><option value="Fidelity guaranty">Fidelity guaranty</option><option value="Machinary breakdown">Machinary breakdown</option>';
		var rowstotal=0;
		for(var i=1;i<=claimsnumber;i++){
			claimsstring+='<div class="claimsstring"><select class="element short" id="s13'+i+'1" name="s13'+i+'1">'+options1+'</select><select class="element" id="s13'+i+'2" name="s13'+i+'2"><option value="Please select">Please select</option>'+options2+'</select><span class="usd">$</span><input class="element claimsum" id="s13'+i+'3" name="s13'+i+'3" /></div>';
			rowstotal=i;
		}
		claimsstring = $(claimsstring);
		$('#claimsdetails').empty().append(claimsstring);
		claimhandle();
		for(var i=1;i<=claimsnumber;i++){
			if('s13'+i+'1' in claimsjson) $('#s13'+i+'1').val(claimsjson['s13'+i+'1']);
			if('s13'+i+'2' in claimsjson) $('#s13'+i+'2').val(claimsjson['s13'+i+'2']);
			if('s13'+i+'3' in claimsjson) $('#s13'+i+'3').val(claimsjson['s13'+i+'3']);
		}
	}
	function claimhandle(){
		var cj='';
		$('#s12').click(function(){
			if(Number($("#s11").val())>0){
				$('#s1313').focus();
			}else{
				$("#s11").focus();
			}
		});
		$('#file').on('change', function () {
			file_send();
		});
		$('.claimsstring .element').on('change', function() {
			if($(this).val()!='' && $(this).val()!='Please select') $(this).removeClass('redborder').parent().removeClass('redcolor');
			var sum=0;
			$('.claimsum').each(function(){
				sum+=Number($(this).val());
			});
			$('#s12').val(sum);
			cj = '{';
			for(var i=1;i<=Number($("#s11").val());i++){
				cj += '"s13' + i + '1":"' + $('#s13'+i+'1').val() + '","s13' + i + '2":"' + $('#s13'+i+'2').val() + '","s13' + i + '3":"' + $('#s13'+i+'3').val() + '",';
			}
			cj = cj.slice(0, -1);
			cj += '}';
			$('#s13_total').html(cj);
		});
	}
	function file_send() {
    $('.uploaded').remove();
    var file_data = $('#file').prop('files')[0];
    if (file_data.size > 10000000) {
      $('#file').val('');
      $('#file').after($('<span class="uploaded" style="color:red;">Max file size 10Mb</span>'));
      $('#s14').val('').addClass('empty');
      $('#file').val('');
      return;
    }
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
      url: '/fileupload',
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function(response){
      	if (response != 'error') {
	        $('#s14').val(response).removeClass('empty');
	        $('#file').after($('<span class="uploaded"><a target="_blank" href="'+ response +'">View uploaded claims details</a></span>'));
	      } else {
      		$('#file').after($('<span class="uploaded" style="color:red;">An error occured</span>'));
	      	$('#s14').val('').addClass('empty');
      		$('#file').val('');
	      }
      }
     });
	}
	function file_send_history() {
    $('.uploaded').remove();
    var file_data = $('#s28ulinkFile').prop('files')[0];
    if (file_data.size > 10000000) {
    	$('.s28ulink button').html('Upload document');
	    $('.s28ulink button').after('<span class="uploaded" style="color:red;">Max file size 10Mb</span>');
      $('#s28ulink').val('').addClass('empty');
      $('#s28ulinkFile').val('');
	    uploaded = false;
      return;
    }
    var form_data = new FormData();
    form_data.append('file_history', file_data);
    $('body').css({cursor: 'wait'});
    $.ajax({
      url: '/sites/all/modules/custom/strata/fileupload.php',
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function(response){
    		$('body').css({cursor: 'default'});
      	if (response && response != 'error') {
	        $('.s28ulink button').html('Upload another document').after('<span class="uploaded"><a target="_blank" href="' + response + '">Uploaded file</a></span>');
	        $('#s28ulink').val(response).removeClass('empty');
	        $('.s28ulink button').css({color:'inherit'});
	        uploaded = true;
	      } else {
    			$('.s28ulink button').html('Upload document');
	      	$('.s28ulink button').after('<span class="uploaded" style="color:red;">An error occured</span>');
	        $('#s28ulink').val('').addClass('empty');
	        $('#s28ulinkFile').val('');
	        uploaded = false;
	      }
      },
      error: function(error){
      	console.log(error);
    		$('body').css({cursor: 'default'});
      }
     });
	}
	function ajaxAfterLoad () {
		if ($('#s28ulink').length && $('#s28ulink').val()) uploaded = true;
		$('.calendar').datepicker({
		  dateFormat : "dd M yy",
		  maxDate: "+3m",
		  minDate: "-3m",
		  nextText: "",
		  prevText: "",
		  numberOfMonths:1
		});
		$('#finder').blur(function(){
			$(this).val('');
		});
		$('#finder').keyup(function(){
			if($(this).val().length >=3){
				$('#finder').unbind('blur');
				$('#mask').fadeIn(300);
        $('#finder').addClass('waityes').removeClass('waitno');
        if(tmr)clearTimeout(tmr);
        tmr=setTimeout(function () {getSearchData();}, 2000);// задержка 2 секунды, чтобы при наборе текта не запрашивать при каждом нажатии ajax ответ
			}else{
	      $('#finder').addClass('waitno').removeClass('waityes');
			}
		});
		$('#s01').change(function(){
			var dateWithoutYear = $('#s01').val().slice(0,-4);
			var dateYear = $('#s01').val().slice(-4);
			var newDate = dateWithoutYear + (Number(dateYear) + 1).toString();
			$('#s02').val(newDate);
		});
		$('#s219').change(function(){
			var element = $('#s2191');
			if ($(this).val() != 'Please Select' && $(this).val() != '0%') {
				$('.s2191').removeClass("hidden").addClass("mandatory");
			} else {
				$('.s2191').addClass("hidden").removeClass("mandatory");
				element.val('').addClass('empty').removeClass('redborder');
			}
		});
		$('#s28').on('input', function(){
			if ($(this).val() > 1000 && $(this).val() <= 1985) {
				$('.s28ulink').removeClass("hidden");
			} else {
				$('.s28ulink').addClass("hidden");
			}
		});
		$('#s28ulinkFile').on('change', function () {
			file_send_history();
		});
		$('.s28ulink button').on('click', function () {
			$('#s28ulinkFile').click();
		});
		$('#s011,#s013,#s012,#s21,#s22,#s22state').click(function(){
			$('#finder').focus();
		});
		$('#s05').blur(function(){
			if(($(this).val()!='')&&(!checkmail($(this).val()))){
	    	$('#dialog1').dialog('open');;
				$(this).val('').addClass('redborder');
    	}
    });
    $('#postcode').on('click', function (e) {
    	var $target = $(e.target);
    	if ($target.hasClass('searchLine')) {
    		search_click($target.data('id'));
    	}
    });

		if($('.h2').attr('id')=='block1'){
			if(Number($('#s11').val())>=0){claimsquest();}
			$('#s11').change(function(){
				if(Number($('#s11').val())>=0){claimsquest();}
			});
		};
		if($('.h2').attr('id')=='block3'){
			$('.element').change(function(){
				var block3='yes';
				$('.mandatory .element').each(function(){
					if(($(this)=='')||($(this)=='Please Select')){
						block3='no';
					}
				});
				if(block3=='yes'){
					$('#submit').removeClass('hidden');
				}else{
					$('#submit').addClass('hidden');
				}
			});
		}
		if ($('#block4').length) {
			$('#submit, .nav, #lefthand').remove();
		}
		if ($('#block10').length) {
			$('#submit, .nav, #lefthand').remove();
		}
		if($('.lastblock').val()=='4'){
			$('#submit').removeClass('hidden');
		}else{
			$('#submit').addClass('hidden');
		}
		$('#li'+(Number($('.lastblock').val())-1)).removeClass('grey');
		$('#s220').change(function(){
			if($(this).val()=='Above 30%'){
				$('#div_s221').removeClass('hidden').addClass('mandatory');
				$('#div_s221 label').html($('#div_s221 label').html()+'<span class="mandatory">*</span>');
			}else{
				$('#div_s221').removeClass('mandatory').addClass('hidden');
			}
		});
		if($('.volunteer')){
			$('#volunteer_yes').on('click', function(){
				$('.weekly').removeClass('hidden');
			});
			$('#volunteer_no').on('click', function(){
				$('.weekly').addClass('hidden');
			});
		}
		$('#mask').hide();
		if($('.h2').attr('id')=='block0'){$('#prev').addClass('hidden');$('#next').removeClass('hidden');}
		else if($('.h2').attr('id')=='block3'){$('#next').addClass('hidden');$('#prev').removeClass('hidden');}
		else{$('#next').removeClass('hidden');$('#prev').removeClass('hidden');}
		$('#finder').blur(function(){
			$(this).val('');
		});
	}
	function ajaxElements () {
		$('.selectOrOther').on('change', function () {
			var name = $(this).data('id');
			if ($(this).val() == 'Other') {
				$('#' + name + 'other').removeClass("hidden").val('');
				$('#' + name).addClass('empty').val('');
			} else {
				$('#' + name + 'other').addClass("hidden").val('');
				$('#' + name).removeClass('redborder empty').val($(this).val());
				$('.' + name).removeClass('redcolor');
			}
		});
		$('.selectOrOtherCustom').on('change', function () {
			var name = $(this).attr('name');
			var other = this.options[this.selectedIndex].dataset.other;
			if (other) {
				$('#' + name + 'other').removeClass("hidden")
				.find('input')
				.addClass('empty')
				.val('');
				$('#' + name).addClass('empty mandatory').val('');
			} else {
				$('#' + name + 'other')
				.addClass("hidden")
				.removeClass('redcolor')
				.find('input')
				.removeClass('redborder empty');
				$('#' + name).removeClass('redborder empty mandatory').val($(this).val());
				$('.' + name).removeClass('redcolor');
			}
		});
		$('input.other').on('input', function () {
			var name = $(this).data('id');
			if ($(this).val() != '') {
				$('#' + name).removeClass('redborder empty').val($(this).val());
				$('.' + name).removeClass('redcolor');
			} else {
				$('#' + name).addClass('empty').val($(this).val());
			}
		});
		$('.radioYn').on('click', function () {
			var name = $(this).data('id');
			$('#' + name).val($(this).val()).removeClass('redborder empty');
			$('.' + name).removeClass('redcolor');
		});
		$('.radioYnPpd').on('click', function () {
			var name = $(this).data('name');
			var element = $('#' + name);
			$(this).parents('.elementContainer').removeClass('redcolor');
			element.removeClass('redborder empty');
			if ($(this).val() == 'yes') {
				$('.' + name + ' div').removeClass("hidden").addClass("mandatory");
				if (element.val() == 'No') {
					element.val('');
				}
			} else {
				$('.' + name + ' div').addClass("hidden").removeClass("mandatory");
				element.val('No');
			}
		});
	}
	function common(){
		$('.mandatory .element').removeClass("redborder").parent().removeClass("redcolor");
		$('.element').click(function() {
			$('.active').removeClass('active');
			$(this).addClass('active');
		});
		$('.mandatory label.top').each(function(){
			$(this).html($(this).html()+'<span class="mandatory">*</span>');
		});
		$('.currency label.top').each(function(){
			$(this).html($(this).html()+'<span class="currency">$</span>');
		});
		$('.percent label.top').each(function(){
			$(this).html($(this).html()+'<span class="percent">%</span>');
		});
		$('.element').each(function(){
			if(($(this).val()=='')||($(this).val()=='Please Select')){
				$(this).addClass('empty');
			}
		});
		$('.element').change(function(){
			if(!$(this).hasClass('ppd')){
				if(($(this).val()=='')||($(this).val()=='Please Select')){
					$(this).addClass('empty');
				}else{
					$(this).removeClass('empty redborder').parent().removeClass('redcolor');
					$('.'+$(this).attr('id')).removeClass('redcolor');
				}
			}
		});
		$('.radio_n').click(function(){
			if(!$('#'+$(this).attr('id').substring(0,$(this).attr('id').length-3)).hasClass('ppd')){
				$('.'+$(this).attr('id').substring(0,$(this).attr('id').length-3)).removeClass('redcolor');
				$('#'+$(this).attr('id').substring(0,$(this).attr('id').length-3)).removeClass('redborder empty').parents('.redcolor').removeClass('redcolor');
			}
		});
		$('.radio_y').click(function(){
			if(!$('#'+$(this).attr('id').substring(0,$(this).attr('id').length-4)).hasClass('ppd')){
				$('.'+$(this).attr('id').substring(0,$(this).attr('id').length-4)).removeClass('redcolor');
				$('#'+$(this).attr('id').substring(0,$(this).attr('id').length-4)).removeClass('redborder empty').parents('.redcolor').removeClass('redcolor');
			}
		});
		$('.digit').keypress(function(e){
	      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
	        return false;
	      }
	    });
		$('.help').each(function(){
				$(this).find('.helpimage').attr('src','/sites/all/themes/online/images/help-images/'+$(this).attr('id').substring(2)+'.jpg');
		});
		$('.help').hover(
			function(e){
				$('.helpimage').stop().hide(100);
				$(this).find('.helpimage').show(1000);
			},
			function(){
				$(this).find('.helpimage').hide(300);
			}
		);
	}
})(jQuery);
