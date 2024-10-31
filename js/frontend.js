function skt_wccart_addEvent(obj, evt, fn) {
  if (obj.addEventListener) {
      obj.addEventListener(evt, fn, false);
  }else if (obj.attachEvent) {
    obj.attachEvent("on" + evt, fn);
  }
}
document.addEventListener("mouseout", function(evt){
    var checktest = jQuery.cookie('test');
    if(checktest !=="Hmmm, cookie"){
      skt_wccart_addEvent(document, 'mouseout', function(evt) {
        if (evt.toElement == null && evt.relatedTarget == null ) {
          jQuery('.racartlightbox').css("display", "block");
        }
      });
    }
}, false);
jQuery('.racart_close').click(function () {
  jQuery.cookie('test', 'Hmmm, cookie', { expires: 1, path: '/' });
  jQuery('.racartlightbox').hide();
  var date = new Date();
  var check = date.setTime(date.getTime() + 48 * 60 * 60 * 1000);
  jQuery.cookie('exit-intent-closed', false, { expires: date });
  setTimeout(function(){
    jQuery('.racartlightbox').remove();   
  }, 100);
});
jQuery(document).keyup(function(e) {
if (e.which == 27) {
  jQuery.cookie('test', 'Hmmm, cookie', { expires: 1, path: '/' });
  jQuery('.racartlightbox').hide();
  var date = new Date();
  var check = date.setTime(date.getTime() + 48 * 60 * 60 * 1000);
  jQuery.cookie('exit-intent-closed', false, { expires: date });
  setTimeout(function(){
    jQuery('.racartlightbox').remove();   
  }, 100);
}
});