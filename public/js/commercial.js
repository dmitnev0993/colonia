(function ($) {
	var tmr;
	var uploaded = false;
	$(document).ready(function() {
		var blockcomplete='';
		var formcomplete='';
		var windowWidth = Math.min($(window).width() - 40, 700);
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
				if($(this).hasClass('li')){
					var thisnum=Number($(this).attr('id').substring(2))+1;
					if(thisnum>lastblock){
						return false;
					}
				}
				blockcomplete='yes';
				$('.mandatory .element').each(function() {
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
				if ($('#sc19').length && !($('#sc19').val() > 0)) {
					$('#sc19').addClass("redborder").parent().addClass('redcolor');
					blockcomplete='no';
				}
				if ($('.sc17ulink').length && !$('.sc17ulink').hasClass('hidden') && !uploaded) {
					$('.sc17ulink button').css({color:'red'});
					blockcomplete='no';
				}
				$('.mandatory .subelement').each(function(){
					if($(this).hasClass('prered')){
						blockcomplete='no';
						var id = $(this).attr('id');
						$(this).addClass('redborder').change(function(){
							if($('#'+id).val()!=''){
								$('#'+id).removeClass('redborder prered');
							}else{
								$('#'+id).addClass('prered');
							}
						});
					}
				});
				var idnum=$('.h2').attr('id');
				idnum=idnum.substring(5);
				if (idnum=='4'){return false;}
				if ($('#s011').length && !$('#s011').val() || $('#s012').length && !$('#s012').val() || $('#s013').length && !$('#s013').val()) {
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
				$.get('/query-commercial', spRequest, function(msg){
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
	function checkmail(value)
	{
	 return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(value);
	}
	function getSearchData(){
		$.post("/search-suburb", {suburb: $('#finder').val()}, function(data){
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
	function search_click(id){
	  var searched_data = jsondata.data[id];
	  $('#s011').val(searched_data.postcode);
		$('.s011').removeClass('hidden');
	  $('#s013').val(searched_data.suburb);
		$('.s013').removeClass('hidden');
		$('#s012').val(searched_data.state);
		$('.s012').removeClass('hidden');
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
			claimsstring+='<input type="file" class="element" name="file" id="file" onchange="file_send()" />';
			if ($('#s14').val()!=''){
				claimsstring+='<div class="uploaded"><a target="_blank" href="'+$('#s14').val()+'">View uploaded claims details</a></div>';
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
			claimsstring+='<div class="claimsstring"><select class="element short" id="s13'+i+'1" name="s13'+i+'1">'+options1+'</select><select class="element" id="s13'+i+'2" name="s13'+i+'2"><option value="Please select">Please select</option>'+options2+'</select><span class="usd">$</span><input class="element" id="s13'+i+'3" name="s13'+i+'3" /></div>';
			rowstotal=i;
		}
		$('#claimsdetails').html(claimsstring);
		for(var i=1;i<=claimsnumber;i++){
			$('#s13'+i+'1').val(claimsjson['s13'+i+'1']);
			$('#s13'+i+'2').val(claimsjson['s13'+i+'2']);
			$('#s13'+i+'3').val(claimsjson['s13'+i+'3']);
		}
	}
	function file_send() {
    $('.uploaded').remove();
    var file_data = $('#file').prop('files')[0];
    if (file_data.size > 10000000) {
      $('#file').val('');
      $('#dialog6').dialog('open');
      return false;
    }
		var splitarray = $('#file').val().split('.');
		var ext = splitarray[splitarray.length-1];
		if(!((ext=='doc')||(ext=='docx')||(ext=='txt')||(ext=='rtf')||(ext=='pdf')||(ext=='jpg')||(ext=='jpeg')||(ext=='bmp'))){
			$('#dialog3').dialog('open');
			$('#file').val('');
			return false;
		}
		$('#mask').show();
		sendForm("my_form", "/sites/all/modules/custom/strata/fileupload.php", callback);
		return false;
	}
	function file_send_history() {
    $('.uploaded').remove();
    var file_data = $('#sc17ulinkFile').prop('files')[0];
    if (file_data.size > 10000000) {
    	$('.sc17ulink button').html('Upload document');
	    $('.sc17ulink button').after('<span class="uploaded" style="color:red;">Max file size 10Mb</span>');
      $('#sc17ulink').val('').addClass('empty');
      $('#sc17ulinkFile').val('');
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
	        $('.sc17ulink button').html('Upload another document').after('<span class="uploaded"><a target="_blank" href="' + response + '">Uploaded file</a></span>');
	        $('#sc17ulink').val(response).removeClass('empty');
	        $('.sc17ulink button').css({color:'inherit'});
	        uploaded = true;
	      } else {
    			$('.sc17ulink button').html('Upload document');
	      	$('.sc17ulink button').after('<span class="uploaded" style="color:red;">An error occured</span>');
	        $('#sc17ulink').val('');
	        $('#sc17ulinkFile').val('').addClass('empty');
	        uploaded = false;
	      }
      },
      error: function(error){
      	console.log(error);
    		$('body').css({cursor: 'default'});
      }
     });
	}
	function sendForm(form, url, callfunc) {
		if (!document.createElement) return;
		if (typeof(form)=="string") form=document.getElementById(form);
		var frame=createIFrame();
		var act = form.getAttribute('action');
		frame.onSendComplete = function() {callfunc(form,act,getIFrameXML(frame));};
		form.setAttribute('target', frame.id);
		form.setAttribute('action', url);
		form.submit();
	}

	function createIFrame() {
		var id = 'f' + Math.floor(Math.random() * 99999);
		var div = document.createElement('div');
		div.innerHTML = "<iframe style=\"display:none\" src=\"about:blank\" id=\""+id+"\" name=\""+id+"\" onload=\"sendComplete('"+id+"')\"></iframe>";
		document.body.appendChild(div);
		return document.getElementById(id);
	}

	function sendComplete(id) {
		var iframe=document.getElementById(id);
		if (iframe.onSendComplete &&
		typeof(iframe.onSendComplete) == 'function')	iframe.onSendComplete();
	}

	function getIFrameXML(iframe) {
		var doc=iframe.contentDocument;
		if (!doc && iframe.contentWindow) doc=iframe.contentWindow.document;
		if (!doc) doc=window.frames[iframe.id].document;
		if (!doc) return null;
		if (doc.location=="about:blank") return null;
		if (doc.XMLDocument) doc=doc.XMLDocument;
		$('#mask').hide();
		return doc;
	}

	function callback(form,act,doc) {
		form.setAttribute('action', act);
		form.removeAttribute('target');
		if (doc.body.innerHTML=='size'){
			$('#dialog4').dialog('open');;
			$('#file').val('');
		}else if (doc.body.innerHTML!='error'){
			$('#s14').val(doc.body.innerHTML);
		}else{
			$('#dialog5').dialog('open');;
			$('#file').val('');
		}
	}

	function ajaxAfterLoad () {
		if ($('#sc17ulink').length && $('#sc17ulink').val()) uploaded = true;
		$('#sc17').on('input', function(){
			if ($(this).val() > 1000 && $(this).val() <= 1985) {
				$('.sc17ulink').removeClass("hidden");
			} else {
				$('.sc17ulink').addClass("hidden");
			}
		});
		console.log(4);
		$('#sc17ulinkFile').on('change', function () {
			file_send_history();
		});
		$('.sc17ulink button').on('click', function () {
			$('#sc17ulinkFile').click();
		});
		if ($('#adddd').length) {
			$('#adddd').click(function () {
				var quant=Number($('.ddquant').val())+1;
				$('.ddquant').val(quant);
				var str='<tr class="tr'+quant+'">';
				str+=		'<td>'+quant+'</td>';
				str+=		'<td><input type="text" class="subelement" id="dd'+quant+'2" value="" /></td>';
				str+=		'<td><input type="text" class="subelement" id="dd'+quant+'3" value="" /></td>';
				str+=		'<td><span>$</span><input type="text" class="subelement" id="dd'+quant+'4" value="" /></td>';
				str+=		'</tr>';
				quant=quant-1;
				$('.dd .tr'+quant).after(str);
				ddchange();
				return false;
			});
			ddchange();
			$('#sc40_yes').click(function(){
				$('#claimsdetails').show(300).addClass('mandatory');
			});
			$('#sc40_no').click(function(){
				$('#claimsdetails').hide(300).removeClass('mandatory redcolor');
				$('#sc41').removeClass('redborder');
				$('#claimsdetails .subelement').removeClass('prered redborder');
			});
		}
		if ($('#sc1').length) {
			sc1();
			sc8();
			$('#sc1').blur(function(){
				sc1();
			});
			$('#sc8').blur(function(){
				sc8()
			});
		}
		if ($('#sc31').length) {
			if($('#sc31').val()=='yes'){
				$('.sc32').removeClass('hidden').addClass('mandatory');
			}
			$('#sc31_yes').click(function(){
				$('.sc32').removeClass('hidden').addClass('mandatory');
			});
			$('#sc31_no').click(function(){
				$('.sc32').addClass('hidden').removeClass('mandatory redcolor');
				$('#sc32').removeClass('redborder');
			});
			if($('#sc53').val()=='yes'){
				$('.sc54').removeClass('hidden').addClass('mandatory');
			}
			$('#sc53_yes').click(function(){
				$('.sc54').removeClass('hidden').addClass('mandatory');
			});
			$('#sc53_no').click(function(){
				$('.sc54').addClass('hidden').removeClass('mandatory redcolor');
				$('#sc54').removeClass('redborder');
			});
			if($('#sc55').val()=='yes'){
				$('.sc56').removeClass('hidden').addClass('mandatory');
			}
			$('#sc55_yes').click(function(){
				$('.sc56').removeClass('hidden').addClass('mandatory');
			});
			$('#sc55_no').click(function(){
				$('.sc56').addClass('hidden').removeClass('mandatory redcolor');
				$('#sc56').removeClass('redborder');
			});
			if($('#sc49').val()=='yes'){
				$('.sc50').removeClass('hidden').addClass('mandatory');
			}
			$('#sc49_yes').click(function(){
				$('.sc50').removeClass('hidden').addClass('mandatory');
			});
			$('#sc49_no').click(function(){
				$('.sc50').addClass('hidden').removeClass('mandatory redcolor');
				$('#sc50').removeClass('redborder');
			});
			if($('#sc42').val()=='yes'){
				$('.sc43').removeClass('hidden').addClass('mandatory');
			}
			$('#sc42_yes').click(function(){
				$('.sc43').removeClass('hidden').addClass('mandatory');
			});
			$('#sc42_no').click(function(){
				$('.sc43').addClass('hidden').removeClass('mandatory redcolor');
				$('#sc43').removeClass('redborder');
			});
			sc37();
			$('#sc37').click(function(){
				sc37();
			});
			sc2829();
			$('#sc28,#sc29').click(function(){
				sc2829();
			});
			$('#addddoc').click(function(){
				var quant=Number($('.ddocquant').val())+1;
				$('.ddocquant').val(quant);
				var str='<tr class="tr'+quant+'">';
				str+=		'<td>'+quant+'</td>';
				str+=		'<td><input type="text" class="subelement" id="ddoc'+quant+'2" value="" /></td>';
				str+=		'</tr>';
				quant=quant-1;
				$('.ddoc .tr'+quant).after(str);
				ddocchange();
				return false;
			});
			ddocchange();
			var claimsstring;
			$('#sc20_yes').click(function(){
				claimsstring='';
				if ($('#sc2').val()!=''){
					claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Replace file with claims details</label>';
				}else{
					claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Load file with claims details</label>';
				}
				claimsstring+='<input type="file" class="element" name="file" id="file" onchange="file_send()" />';
				if ($('#sc2').val()!=''){
					claimsstring+='<span class="uploaded"><a target="_blank" href="'+$('#sc2').val()+'">View uploaded claims details</a></span>';
				}
				claimsstring+='</form>';
				$('#heritageupload').html(claimsstring);
			});
			$('#sc20_no').click(function(){
				$('#heritageupload').html('');
			});
			if($('#sc20').val()=='yes'){
				claimsstring='';
				if ($('#sc2').val()!=''){
					claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Replace file with claims details</label>';
				}else{
					claimsstring+='<form id="my_form" method="post" action="" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><label class="top">Load file with claims details</label>';
				}
				claimsstring+='<input type="file" class="element" name="file" id="file" onchange="file_send()" />';
				if ($('#sc2').val()!=''){
					claimsstring+='<div class="uploaded"><a target="_blank" href="'+$('#sc2').val()+'">View uploaded claims details</a></div>';
				}
				claimsstring+='</form>';
				$('#heritageupload').html(claimsstring);
			}
			$('#sc45').blur(function(){
				if((Number($(this).val()<=0))||(Number($(this).val()>100))){
					$(this).val('');
				}
			});
		}
		if ($('#block4').length) {
			$('#submit, .nav, #lefthand').remove();
		}
		$('.calendar').datepicker({
		  dateFormat : "dd M yy",
		  maxDate: "+3m",
		  minDate: "-3m",
		  nextText: "",
		  prevText: "",
		  numberOfMonths: 1
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
        tmr = setTimeout(function () {getSearchData();}, 2000);// задержка 2 секунды, чтобы при наборе текта не запрашивать при каждом нажатии ajax ответ
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
		$('#s011,#s013,#s012').click(function(){
			$('#finder').focus();
		});
		$('#s05').blur(function(){
			if(($(this).val()!='')&&(!checkmail($(this).val()))){
	    	$('#dialog1').dialog('open');;
			$(this).val('').addClass('redborder');
    	}
    });
		$('#mask').hide();

		if($('.h2').attr('id')=='block0'){$('#prev').addClass('hidden');$('#next').removeClass('hidden');}
		else if($('.h2').attr('id')=='block3'){$('#next').addClass('hidden');$('#prev').removeClass('hidden');}
		else{$('#next').removeClass('hidden');$('#prev').removeClass('hidden');}
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
    $('#postcode').on('click', function (e) {
    	var $target = $(e.target);
    	if ($target.hasClass('searchLine')) {
    		search_click($target.data('id'));
    	}
    });
	}
	function ddchange() {
		$('.dd input').change(function(){
			var str='';
			var complete=true;
			$('.dd input').each(function(){
				if($(this).val()==''){
					complete=false;
					$(this).addClass('prered');
				}else{
					$(this).removeClass('prered');
				}
				str+=$(this).val()+'(:)';
			});
			str=str.substring(0, str.length - 3);
			$('#sc41').val(str);
			if(complete){
				$('#sc41').removeClass('empty redborder');
				$('.sc41').removeClass('redcolor');
			}else{
				$('#sc41').addClass('empty');
			}
		});
	}

	function sc1(){
		if($('#sc1').val()==''){
			$('#st8').html('15% of Building Sum Insured');
			$('#st9').html('1% of Building Sum Insured');
		}else{
			$('#st8').html('$ '+Number($('#sc1').val())/100*15);
			$('#st9').html('$ '+Number($('#sc1').val())/100);
		}
	}

	function sc8(){
		if($('#sc8').val()==''){
			$('#st10').html('15% of Catastrophe Sum Insured');
			$('#st11').html('5% of Catastrophe Sum Insured');
			$('#st12').html('5% of Catastrophe Sum Insured');
		}else{
			$('#st10').html('$ '+Number($('#sc8').val())/100*15);
			$('#st11').html('$ '+Number($('#sc8').val())/100*5);
			$('#st12').html('$ '+Number($('#sc8').val())/100*5);
		}
	}

	function sc37(){
		if ($('#sc37').prop('checked')) {
			$('.sc38').removeClass('hidden').addClass('mandatory');
		} else {
			$('.sc38').addClass('hidden').removeClass('mandatory redcolor');
			$('#sc38').removeClass('redborder');
		}
	}
	function sc2829(){
		if(($('#sc28').val()=='yes')||($('#sc29').val()=='yes')){
			$('#stateocc').removeClass('hidden');
		}else{
			$('#stateocc').addClass('hidden');
		}
	}
	function ddocchange(){
		$('.ddoc input').change(function(){
			var str='';
			var complete=true;
			$('.ddoc input').each(function(){
				if($(this).val()==''){
					complete=false;
					$(this).addClass('prered');
				}else{
					$(this).removeClass('prered');
				}
				str+=$(this).val()+'(:)';
			});
			str=str.substring(0, str.length - 3);
			$('#sc3').val(str);
			if(complete){
				$('#sc3').removeClass('empty redborder');
				$('.sc3').removeClass('redcolor');
			}else{
				$('#sc3').addClass('empty');
			}
		});
	}
	function file_send() {
		var splitarray = $('#file').val().split('.');
		var ext = splitarray[splitarray.length-1];
		if(!((ext=='doc')||(ext=='docx')||(ext=='txt')||(ext=='rtf')||(ext=='pdf')||(ext=='jpg')||(ext=='jpeg')||(ext=='bmp'))){
			alert('Only .doc, .docx, .txt, .rtf, .pdf, .jpg, .jpeg and.bmp extensions allowed');
			return false;
		}
		$('#mask').show();
		sendForm("my_form", "/fileupload.php", callback);
		return false;
	}
	function sendForm(form, url, callfunc) {
		if (!document.createElement) return;
		if (typeof(form)=="string") form=document.getElementById(form);
		var frame=createIFrame();
		var act = form.getAttribute('action');
		frame.onSendComplete = function() {callfunc(form,act,getIFrameXML(frame));};
		form.setAttribute('target', frame.id);
		form.setAttribute('action', url);
		form.submit();
	}

	function createIFrame() {
		var id = 'f' + Math.floor(Math.random() * 99999);
		var div = document.createElement('div');
		div.innerHTML = "<iframe style=\"display:none\" src=\"about:blank\" id=\""+id+"\" name=\""+id+"\" onload=\"sendComplete('"+id+"')\"></iframe>";
		document.body.appendChild(div);
		return document.getElementById(id);
	}

	function sendComplete(id) {
		var iframe=document.getElementById(id);
		if (iframe.onSendComplete &&
		typeof(iframe.onSendComplete) == 'function')	iframe.onSendComplete();
	}

	function getIFrameXML(iframe) {
		var doc=iframe.contentDocument;
		if (!doc && iframe.contentWindow) doc=iframe.contentWindow.document;
		if (!doc) doc=window.frames[iframe.id].document;
		if (!doc) return null;
		if (doc.location=="about:blank") return null;
		if (doc.XMLDocument) doc=doc.XMLDocument;
		$('#mask').hide();
		return doc;
	}

	function callback(form,act,doc) {
		form.setAttribute('action', act);
		form.removeAttribute('target');
		if (doc.body.innerHTML=='size'){
			alert("File size should not exeed 2MB");
		}else if (doc.body.innerHTML!='error'){
			$('#sc2').val(doc.body.innerHTML);
		}else{
			alert("Download error");
		}
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
		$('.mandatory .element').removeClass("redborder");
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
