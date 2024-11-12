

$(".dropdown-menu li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});




 $('.sel').each(function() {
  $(this).children('select').css('display', 'none');
  
  var $current = $(this);
  
  $(this).find('option').each(function(i) {
    if (i == 0) {
      $current.prepend($('<div>', {
        class: $current.attr('class').replace(/sel/g, 'sel__box')
      }));
      
      var placeholder = $(this).text();
      $current.prepend($('<span>', {
        class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
        text: placeholder,
        'data-placeholder': placeholder
      }));
      
      return;
    }
    
    $current.children('div').append($('<span>', {
      class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
      text: $(this).text()
    }));
  });
});

$('.sel').click(function() {
  $(this).toggleClass('active');
});

$('.sel__box__options').click(function() {
  var txt = $(this).text();
  var index = $(this).index();
  
  $(this).siblings('.sel__box__options').removeClass('selected');
  $(this).addClass('selected');
  
  var $currentSel = $(this).closest('.sel');
  $currentSel.children('.sel__placeholder').text(txt);
  $currentSel.children('select').prop('selectedIndex', index + 1);
});





$(document).ready(function() {
 $("#owl-demo").owlCarousel({
	margin: 20,
	nav: false,
	loop: false,
	autoplay:true,
	dots:true,
	rewind:true,
    autoplayTimeout:5000,
	autoplayHoverPause:true,
	 navText : ["<i class='flaticon-left-arrow'></i>","<i class='flaticon-right-arrow'></i>"],
	responsive: {
	  0: {
		items: 1
	  },
	  600: {
		items: 1
	  },
	  1000: {
		items: 1
	  }
	}
  })
})


$(document).ready(function() {
 $("#owl-demo1").owlCarousel({
	margin: 19,
	nav: true,
	loop: false,
	autoplay:true,
	dots:false,
	rewind:true,
    autoplayTimeout:4000,
	autoplayHoverPause:true,
	 navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive: {
	  0: {
		items: 2, margin: 5
	  },
	  600: {
		items: 3, margin: 5
	  },
	  1000: {
		items: 4
	  },
	  1600: {
		items: 5
	  }
	}
  })
})

$(document).ready(function() {
 $(".owl-demo2").owlCarousel({
	margin: 20,
	nav: true,
	loop: false,
	autoplay:true,
	dots:false,
	rewind:true,
    autoplayTimeout:4000,
	autoplayHoverPause:true,
	 navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive: {
	  0: {
		items:2, margin: 5
	  },
	  600: {
		items: 3, margin: 5
	  },
	  1000: {
		items: 4
	  },
	  1600: {
		items: 5
	  }
	}
  })
})
$(document).ready(function() {
 $("#owl-demo21").owlCarousel({
  margin: 20,
  nav: true,
  loop: false,
  autoplay:true,
  dots:false,
  rewind:true,
    autoplayTimeout:4000,
  autoplayHoverPause:true,
   navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
  responsive: {
    0: {
    items: 1
    },
    600: {
    items: 3
    },
    1000: {
    items: 4
    },
    1600: {
    items: 5
    }
  }
  })
})

$(document).ready(function() {
 $("#owl-demo3").owlCarousel({
	margin: 20,
	nav: true,
	loop: false,
	autoplay:true,
	dots:false,
	rewind:true,
    autoplayTimeout:4000,
	autoplayHoverPause:true,
	 navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
	responsive: {
	  0: {
		items: 1
	  },
	  600: {
		items: 1
	  },
	  1000: {
		items: 1
	  },
	  1600: {
		items: 1
	  }
	}
  })
})


$(document).ready(function () {
    var slider = $('#slider');
    var thumbnailSlider = $('#thumbnailSlider');
    var duration = 500;
    slider.owlCarousel({
     loop:false,
     nav:false,
     items:1
   }).on('changed.owl.carousel', function (e) {
     thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);
   });
   thumbnailSlider.owlCarousel({
     loop:false,
     center:false, 
     nav:true,
     margin:10,
	 navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
     responsive:{
      0:{
       items:3
     },
     600:{
       items:3
     },
     1000:{
       items:5
     }
   }
 }).on('click', '.owl-item', function () {
   slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);
 }).on('changed.owl.carousel', function (e) {
   slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
 });
});








$('.btn-number').click(function(e) {
  e.preventDefault();

  fieldName = $(this).attr('data-field');
  type = $(this).attr('data-type');
  var input = $("input[name='" + fieldName + "']");
  var currentVal = parseInt(input.val());
  if (!isNaN(currentVal)) {
    if (type == 'minus') {

      if (currentVal > input.attr('min')) {
        input.val(currentVal - 1).change();
      }
      if (parseInt(input.val()) == input.attr('min')) {
        $(this).attr('disabled', true);
      }

    } else if (type == 'plus') {

      if (currentVal < input.attr('max')) {
        input.val(currentVal + 1).change();
      }
      if (parseInt(input.val()) == input.attr('max')) {
        $(this).attr('disabled', true);
      }

    }
  } else {
    input.val(0);
  }
});


$('.input-number').change(function() {

  minValue = parseInt($(this).attr('min'));
  maxValue = parseInt($(this).attr('max'));
  valueCurrent = parseInt($(this).val());

  name = $(this).attr('name');
  if (valueCurrent >= minValue) {
    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
  } else {
    alert('Sorry, the minimum value was reached');
    $(this).val($(this).data('oldValue'));
  }
  if (valueCurrent <= maxValue) {
    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
  } else {
    alert('Sorry, the maximum value was reached');
    $(this).val($(this).data('oldValue'));
  }

});


$(document).on('click','.js-videoPoster',function(ev) {
  ev.preventDefault();
  var $poster = $(this);
  var $wrapper = $poster.closest('.js-videoWrapper');
  videoPlay($wrapper);
});
function videoPlay($wrapper) {
  var $iframe = $wrapper.find('.js-videoIframe');
  var src = $iframe.data('src');
  $wrapper.addClass('videoWrapperActive');
  $iframe.attr('src',src);
}
function videoStop($wrapper) {
  if (!$wrapper) {
    var $wrapper = $('.js-videoWrapper');
    var $iframe = $('.js-videoIframe');
  } else {
    var $iframe = $wrapper.find('.js-videoIframe');
  }
  $wrapper.removeClass('videoWrapperActive');
  $iframe.attr('src','');
}



function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


$.fn.responsiveTabs = function () {
    return this.each(function () {
        var el = $(this), tabs = el.find('dt'), content = el.find('dd'), placeholder = $('<div class="responsive-tabs-placeholder"></div>').insertAfter(el);
        tabs.on('click', function () {
            var tab = $(this);
            tabs.not(tab).removeClass('active');
            tab.addClass('active');
            placeholder.html(tab.next().html());
        });
        tabs.filter(':first').trigger('click');
    });
};
$('.responsive-tabs').responsiveTabs();


$('.accord-single').accord({
	openSingle: true,
});	




var rating = $('.rating-histogram');
var totalVotes = 0;
var secondaryVotes = 0;
var totalVotesInc = 0;
var averageScore = 0;
var array = [];
var highest = 0;

$('.rating-bar-container').each(function() {
  $(this).attr('valuemax', Number($(this).children('.bar-label').html()) * Number($(this).attr('valuenow')));
  totalVotes += Number($(this).attr('valuenow'));
  array.push(Number($(this).attr('valuenow')));
  highest = Math.max.apply(Math, array);
  totalVotesInc += Number($(this).children('.bar-label').html()) * Number($(this).attr('valuenow'))
  if ( $(this).attr('valuenow') == highest ) {
    $(this).children('.bar').width('100%');
  } else {
    secondaryVotes += Number($(this).attr('valuenow'));
  }
  $(this).children('.bar-number').html(Number($(this).attr('valuenow')).toLocaleString('ru'));
});
averageScore = (totalVotesInc/totalVotes).toFixed(1).toString().replace(".", ",");
rating.attr({
  'valuemax': totalVotes,
  'secvaluemax': secondaryVotes
});
$('.rating-bar-container').each(function() {
  if ( $(this).attr('valuenow') == highest ) {
    $(this).children('.bar').width('100%');
  } else {
    // console.log(1);
    console.log($(this).attr('valuenow'));
    $(this).children('.bar').width($(this).attr('valuenow') * 200 / rating.attr('valuemax') + '%');
  }
});

$('.reviews-num').html(' ' + Number(rating.attr('valuemax')).toLocaleString('ru'));
$('.score-container .score').html(averageScore);


jQuery(document).ready(function( $ ) {
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});
});

//$('.ex1').zoom();


