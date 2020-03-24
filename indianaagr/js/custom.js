$("#showform").click(function(){
    $(".header .search form").fadeToggle();
    $(".header .search .form-control").focus();
});

//Append
if ($(window).width() < 768) {
    $(".header .textlink .mail").appendTo(".header .bottom");
}
//Light Gallery
$(document).ready(function(){
    $('.lightgallery').lightGallery();
});
//Accordion
$(".accordion .heading-panel").click(function(){
    $(this).next(".accordion .text-panel").slideToggle();
    $(".accordion .heading-panel").not(this).next(".accordion .text-panel").slideUp();
    $(this).toggleClass("active");
    $(".accordion .heading-panel").not(this).removeClass("active");
});
////Click to scroll div
$(document).ready( function() {	
  $('.click-scroll').click(function(e) {
    e.preventDefault();
    
    var id = $(this).attr('href');
   
    var target = $(id);
    
    var scrollTo = target.offset().top;
   
    var speed = 800;
    
    $('html,body').animate({
      scrollTop: scrollTo
    }, speed);
    
  }); 
});
//Click to active add & remove
$(".comclick-active a").click(function(){
    $(".comclick-active a").removeClass("active");
    $(this).addClass("active");
});


  if ($('.menu-bar').length) {
    $('.menu-bar').addClass('original').clone().insertAfter('.menu-bar').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();
    function stickIt() {
      var orgElementPos = $('.original').offset();
      orgElementTop = orgElementPos.top;               
      if ($(window).scrollTop() >= (orgElementTop)) {
        // scrolled past the original position; now only show the cloned, sticky element.
        
        // Cloned element should always have same left position and width as original element.     
        orgElement = $('.original');
        coordsOrgElement = orgElement.offset();
        leftOrgElement = coordsOrgElement.left;  
        widthOrgElement = orgElement.css('width');
        $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
        $('.original').css('visibility','hidden');
        } else {
        // not scrolled past the menu; only show the original menu.
        $('.cloned').hide();
        $('.original').css('visibility','visible');
      }
    }
    scrollIntervalID = setInterval(stickIt, 10);
  }     
