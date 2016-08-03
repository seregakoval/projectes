$(function(){
    $('#leftmenu li a.leaf').on('click',function(){
        var leaf = $(this);
        if(leaf.parent('li').children('ul').length){
            
            leaf.parent('li').children('ul').slideToggle('fast', function(){
                leaf.toggleClass('active');
            });
            
        }
        return false;
    });
  $('#header .logo').append("<a id='am320'><i class='fa fa-bars'></i></a>");
    
  $('#m320 a.close').on('click',function(){
    $('#m320').hide();
    return false;
  });
  
  $('#am320').on('click',function(){
    $('#m320').show();
    return false;
  });
  
  
  
    
  $('#topline').append("<a id='shul'><i class='fa fa-bars'></i></a>");
  
  $('#shul').on('click', function(){
      $('ul#self').toggleClass('active');
    });
  
  if($('#leftbar').length)
  {
    if( $('.secondmenu').length ){
      $('.secondmenu').prepend("<a id='shulm'><i class='fa fa-bars'></i></a>");
    }
    else{
      $('#secondmenu h2').prepend("<a id='shulm' class='l46'><i class='fa fa-bars'></i></a>");
    }
  }
  
  $('#shulm').on('click', function(){
      if($(this).hasClass('l46')){$('#leftbar').css({'margin-top':'46px'});};
      $('#leftbar').toggleClass('active');
    });
  
	/* help */
	$('#content .helptabble .helpmore').on('click',function(){
		$(this).next('.helptext').slideToggle('fast');
		$(this).toggleClass('active');
		return false;
	});
	
	/* mainpage */
	
	$('.progressbar span').each(function() {
        var rel = $(this).attr('rel');
		$(this).animate({'width':rel+'%'},'slow');
    });
	/*
	$('#carvis a.offer, #cararr').on('click',function(){
		return false;
	});
	*/
	$('#carvis .offer').hover(
		function(){
			var rel = $(this).attr('rel');
			$('#carvis .offer').each(function() {
                $(this).removeClass('active');
            });
			
			$('#offers .offer').each(function() {
                $(this).removeClass('active');
            });
			
			$(this).addClass('active');
			$('#offers .offer[rel='+rel+']').addClass('active');
			
		},
		function(){
			
		}
	);
	/*
	$('#offers #carusel #cararr a#cardown').on('click',function(){
		
		console.log($('#carvis a[rel='+$('#carvis .offer').length+']').position().top);
		if($('#carvis a[rel='+$('#carvis .offer').length+']').position().top>270+$('#carvis').position().top){
			$('#visbl').css('margin-top','-118px');
			var rel = $('#carvis a.active').attr('rel');
			$('#carvis a.offer').each(function() {
				$(this).removeClass('active');
			});
			$('#offers .offer').each(function() {
                $(this).removeClass('active');
            });
			rel++;
			$('#carvis a.offer[rel='+rel+']').addClass('active');
			$('#offers .offer[rel='+rel+']').addClass('active');
		};
		
		return false;
	});
	
	$('#offers #carusel #cararr a#carup').on('click',function(){
		
		if($('#carvis a[rel=1]').position().top<$('#carvis').position().top-20){
			console.log(parseInt($('#visbl').css('margin-top'),10)+118+'px');
			$('#visbl').css('margin-top',parseInt($('#visbl').css('margin-top'),10)+118+'px');
			var rel = $('#carvis a.active').attr('rel');
			$('#carvis a.offer').each(function() {
				$(this).removeClass('active');
			});
			$('#offers .offer').each(function() {
                $(this).removeClass('active');
            });
			rel--;
			$('#carvis a.offer[rel='+rel+']').addClass('active');
			$('#offers .offer[rel='+rel+']').addClass('active');
		};

		return false;
	});
	*/
	if($("#carlite").length){
		$("#carlite").jCarouselLite({
			btnNext: "#carnavalright",
			btnPrev: "#carnavalleft",
			visible:4
		});
	}
	if($(".photoslider div").length){
		$(".photoslider div").jCarouselLite({
			btnNext: "#photonext",
			btnPrev: "#photoprev",
			visible:3
		});
	}
	
	
	if($("#carusel").length){
		$("#carusel").jCarouselLite({
			btnNext: "#cardown",
			btnPrev: "#carup",
			vertical: true,
			circular: false,
			visible:3
		});
	}
	
	
	$('#catsbutton').on('click',function(){
		$('#cats').slideToggle('fast');
		return false;
	});
	
	$('#cats ul li a').on('click',function(){
		var cat = $(this).html();
		$('#catsbutton').val(cat).html(cat+'<i class="fa fa-angle-down"></i>');
		$('#cats').hide();
		return false;
	});
	
	$('.rightmenu li a').hover(
		function(){
			rel = $(this).attr('rel');
			$('.whitebox[rel='+rel+']').show().hover(
				function(){
					$(this).show();
					rel = $(this).attr('rel');
					$('.rightmenu li a[rel='+rel+']').addClass('active');
				},
				function(){
					$(this).hide();
					rel = $(this).attr('rel');
					$('.rightmenu li a[rel='+rel+']').removeClass('active');
				}
			);
			$(this).addClass('active');
		},
		function(){
			$(this).removeClass('active');
			$('.whitebox[rel='+rel+']').hide();
		}
	);
	
	$('#goods').on('click',function(){
		$(this).toggleClass('active');
		$('#allcat').toggle();
		return false;	
	});
	$('#allcat').hover(function(){},function(){
		$('#goods').removeClass('active');
		$(this).hide();
	});
	
	
	$('.showfull').on('click',function(){
		var rel = $(this).attr('rel');
		var anch = $(this).html();
		$(this).html(rel);
		$(this).attr('rel',anch);
		
		$(this).parent('p').prev('.fulltext').slideToggle('fast');
		
		return false;
	});
	
	$('a.toup').on('click',function(){
		var temp = Math.ceil($(this).parent('div,td').children('.numonly').val());
		temp++;
		$(this).parent('div,td').children('.numonly').val(temp);
		return false;
	});
	
	$('a.todown').on('click',function(){
		var temp = Math.ceil($(this).parent('div,td').children('.numonly').val());
		temp--;
		if (temp<1) temp=1;
		$(this).parent('div,td').children('.numonly').val(temp);
		return false;
	});
	
	$(".numonly").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
	$('.selectcount a.todown').on('click',function(){
		$(this).parent('.selectcount').children('.counttocart').slideToggle('fast');
		return false;
	});
	
	$('.fullcard .extra .linetocart ul.counttocart li').on('click',function(){
		$(this).parent('ul').parent('.selectcount').children('input').val(Math.ceil($(this).html()));
		$(this).parent('ul').hide();
		console.log(Math.ceil($('.fullcard .extra .linetocart ul.counttocart li').html()));
	});
	
	$('.cardinfotitles li a').on('click',function(){
		rel = $(this).attr('rel');
		$(this).parent('li').parent('ul').children('li').each(function(index, element) {
            $(this).removeClass('active');
			$(this).children('a').removeClass('active');
        });
		$(this).addClass('active');
		$(this).parent('li').addClass('active');
		$(this).parent('li').parent('ul').parent('.cardinfo').children('.tabtext').each(function(index, element) {
            $(this).removeClass('active');
        });
		$(this).parent('li').parent('ul').parent('.cardinfo').children('.tabtext[rel='+rel+']').addClass('active');
		
		return false;
	});
	
	$('.ppup .close, #shadow').on('click', function(){
		$('.ppup').each(function(index, element) {
            $(this).hide();
			$('#shadow').hide();
        });
		return false;
	});
	
	$('#getupload').on('click',function(){
		$('#pupload').show();
		$('#shadow').show();
		return false;
	});
	
	$('#getgift').on('click',function(){
		$('#pgift').show();
		$('#shadow').show();
		return false;
	});
	
	$('#getnews').on('click',function(){
		$('#pnew').show();
		$('#shadow').show();
		return false;
	});
	
	if($('.userstat select').length){
		$('.userstat select').styler();
	}
	
	if($('.infodata select').length){
		$('.infodata select').styler();
	}
	if($('#lc #rlc .org select').length){
		$('#lc #rlc .org select').styler();
	}
	if($('.ppup .newsform select').length){
		$('.ppup .newsform select').styler();
	}
	
	if($('.filtrbody .line select').length){
		$('.filtrbody .line select').styler();
	}
	
	
	$('.togglefiltr a').on('click',function(){
		var tmp = $(this).attr('rel');
		$(this).attr('rel',$(this).html());
		$(this).html(tmp);
		$('.filtrbody').slideToggle('fast');
		
		return false;
	});
	
	
	$('a.check').on('click',function(){
		$(this).prev('input').trigger('click');
		return false;
	});
	
	if($('.infodata input[type=checkbox]').length){
		$('.infodata input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_minimal'
		});
	}
	
	if($('.filtrbody input[type=checkbox]').length){
		$('.filtrbody input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_minimal_small'
		});
	}
	
});