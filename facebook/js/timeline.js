/*!
 * Expander - v1.4.11 - 2014-07-16
 * http://plugins.learningjquery.com/expander/
 * Copyright (c) 2014 Karl Swedberg
 * Licensed MIT (http://www.opensource.org/licenses/mit-license.php)
 */

(function(e){e.expander={version:"1.4.11",defaults:{slicePoint:100,sliceOn:null,preserveWords:!0,showWordCount:!1,wordCountText:" ({{count}} words)",widow:4,expandText:"read more",expandPrefix:"&hellip; ",expandAfterSummary:!1,summaryClass:"summary",detailClass:"details",moreClass:"read-more",lessClass:"read-less",moreLinkClass:"more-link",lessLinkClass:"less-link",collapseTimer:0,expandEffect:"slideDown",expandSpeed:250,collapseEffect:"slideUp",collapseSpeed:200,userCollapse:!0,userCollapseText:"read less",userCollapsePrefix:" ",onSlice:null,beforeExpand:null,afterExpand:null,onCollapse:null,afterCollapse:null}},e.fn.expander=function(a){function l(e,a){var l="span",s=e.summary,n=h.exec(s),t=n?n[2].toLowerCase():"";return a?(l="div",n&&"a"!==t&&!e.expandAfterSummary?s=s.replace(h,e.moreLabel+"$1"):s+=e.moreLabel,s='<div class="'+e.summaryClass+'">'+s+"</div>"):s+=e.moreLabel,[s," <",l+' class="'+e.detailClass+'"',">",e.details,"</"+l+">"].join("")}function s(e,a){var l='<span class="'+e.moreClass+'">'+e.expandPrefix;return e.wordCountText=e.showWordCount?e.wordCountText.replace(/\{\{count\}\}/,a.replace(f,"").replace(/\&(?:amp|nbsp);/g,"").replace(/(?:^\s+|\s+$)/,"").match(/\w+/g).length):"",l+='<a href="#" class="'+e.moreLinkClass+'">'+e.expandText+e.wordCountText+"</a></span>"}function n(a,l){return a.lastIndexOf("<")>a.lastIndexOf(">")&&(a=a.slice(0,a.lastIndexOf("<"))),l&&(a=a.replace(p,"")),e.trim(a)}function t(e,a){a.stop(!0,!0)[e.collapseEffect](e.collapseSpeed,function(){var l=a.prev("span."+e.moreClass).show();l.length||a.parent().children("div."+e.summaryClass).show().find("span."+e.moreClass).show(),e.afterCollapse&&e.afterCollapse.call(a)})}function r(a,l,s){a.collapseTimer&&(o=setTimeout(function(){t(a,l),e.isFunction(a.onCollapse)&&a.onCollapse.call(s,!1)},a.collapseTimer))}var i="init";"string"==typeof a&&(i=a,a={});var o,d=e.extend({},e.expander.defaults,a),c=/^<(?:area|br|col|embed|hr|img|input|link|meta|param).*>$/i,p=d.wordEnd||/(&(?:[^;]+;)?|[a-zA-Z\u00C0-\u0100]+)$/,f=/<\/?(\w+)[^>]*>/g,u=/<(\w+)[^>]*>/g,m=/<\/(\w+)>/g,h=/(<\/([^>]+)>)\s*$/,x=/^(<[^>]+>)+.?/,C=/\s\s+/g,v=function(a){return e.trim(a||"").replace(C," ")},g={init:function(){this.each(function(){var a,i,p,h,C,g,w,S,b,y,E,T,k,P,L=[],I=[],O="",$={},j=this,A=e(this),D=e([]),W=e.extend({},d,A.data("expander")||e.meta&&A.data()||{}),z=!!A.find("."+W.detailClass).length,F=!!A.find("*").filter(function(){var a=e(this).css("display");return/^block|table|list/.test(a)}).length,U=F?"div":"span",Q=U+"."+W.detailClass,Z=W.moreClass+"",q=W.lessClass+"",B=W.expandSpeed||0,G=v(A.html()),H=G.slice(0,W.slicePoint);if(W.moreSelector="span."+Z.split(" ").join("."),W.lessSelector="span."+q.split(" ").join("."),!e.data(this,"expanderInit")){for(e.data(this,"expanderInit",!0),e.data(this,"expander",W),e.each(["onSlice","beforeExpand","afterExpand","onCollapse","afterCollapse"],function(a,l){$[l]=e.isFunction(W[l])}),H=n(H),C=H.replace(f,"").length;W.slicePoint>C;)h=G.charAt(H.length),"<"===h&&(h=G.slice(H.length).match(x)[0]),H+=h,C++;if(W.sliceOn){var J=H.indexOf(W.sliceOn);-1!==J&&W.slicePoint>J&&(W.slicePoint=J,H=G.slice(0,W.slicePoint))}for(H=n(H,W.preserveWords),g=H.match(u)||[],w=H.match(m)||[],p=[],e.each(g,function(e,a){c.test(a)||p.push(a)}),g=p,i=w.length,a=0;i>a;a++)w[a]=w[a].replace(m,"$1");if(e.each(g,function(a,l){var s=l.replace(u,"$1"),n=e.inArray(s,w);-1===n?(L.push(l),I.push("</"+s+">")):w.splice(n,1)}),I.reverse(),z)b=A.find(Q).remove().html(),H=A.html(),G=H+b,S="";else{if(b=G.slice(H.length),y=e.trim(b.replace(f,"")),""===y||y.split(/\s+/).length<W.widow)return;S=I.pop()||"",H+=I.join(""),b=L.join("")+b}W.moreLabel=A.find(W.moreSelector).length?"":s(W,b),F?b=G:"&"===H.charAt(H.length-1)&&(O=/^[#\w\d\\]+;/.exec(b),O&&(b=b.slice(O[0].length),H+=O[0])),H+=S,W.summary=H,W.details=b,W.lastCloseTag=S,$.onSlice&&(p=W.onSlice.call(j,W),W=p&&p.details?p:W),E=l(W,F),A.html(E),k=A.find(Q),P=A.find(W.moreSelector),"slideUp"===W.collapseEffect&&"slideDown"!==W.expandEffect||A.is(":hidden")?k.css({display:"none"}):k[W.collapseEffect](0),D=A.find("div."+W.summaryClass),T=function(e){e.preventDefault(),P.hide(),D.hide(),$.beforeExpand&&W.beforeExpand.call(j),k.stop(!1,!0)[W.expandEffect](B,function(){k.css({zoom:""}),$.afterExpand&&W.afterExpand.call(j),r(W,k,j)})},P.find("a").unbind("click.expander").bind("click.expander",T),W.userCollapse&&!A.find(W.lessSelector).length&&A.find(Q).append('<span class="'+W.lessClass+'">'+W.userCollapsePrefix+'<a href="#" class="'+W.lessLinkClass+'">'+W.userCollapseText+"</a></span>"),A.find(W.lessSelector+" a").unbind("click.expander").bind("click.expander",function(a){a.preventDefault(),clearTimeout(o);var l=e(this).closest(Q);t(W,l),$.onCollapse&&W.onCollapse.call(j,!0)})}})},destroy:function(){this.each(function(){var a,l,s=e(this);s.data("expanderInit")&&(a=e.extend({},s.data("expander")||{},d),l=s.find("."+a.detailClass).contents(),s.removeData("expanderInit"),s.removeData("expander"),s.find(a.moreSelector).remove(),s.find("."+a.summaryClass).remove(),s.find("."+a.detailClass).after(l).remove(),s.find(a.lessSelector).remove())})}};return g[i]&&g[i].call(this),this},e.fn.expander.defaults=e.expander.defaults})(jQuery);

$=jQuery.noConflict();
jQuery(document).ready(function($){

		$('.timeline .timeline-image img').load(function(){
			if($(this).width() == 1){
	        	$(this).hide();
			}else{
				$(this).addClass('width100');
			}
		});

		if ($(window).width() > 240) {
	        $('.timeline-image img').addClass('not-loaded');
	        $('.timeline-image img.not-loaded').lazyload({
	            threshold : 400,
	            //effect: 'fadeIn',
	            data_attribute: 'src',
	            load: function() {
	                // Disable trigger on this image
	                $(this).removeClass("not-loaded");
	            }
	        });
	        $('.timeline-image img.not-loaded').trigger('scroll');
	    }


	$('.timelineicon-comment').click(function(e){
        $(this).closest('.timeline-post').find('.timeline-comments').toggle('fast');
        $(this).closest('.timeline-post').find('.timeline-cicon').toggleClass('timelineicon-comment').toggleClass('timelineicon-arrow-up');
        var titlec = $(this).closest('.timeline-post').find('.timeline-commenttitle').attr('title');
        var findccomment = $(this).closest('.timeline-post').find('.timeline-comments');
	    if ($('.timelineicon-arrow-up')) {
            if ((findccomment).length) {
	        $('.timelineicon-arrow-up').attr('title', ' X ');
	            scrollToTimelineAnchor(findccomment);
			e.preventDefault();
			}else{
				e.preventDefault();
			}
	    }
	    if ($('.timelineicon-comment')) {
	        $('.timelineicon-comment').attr('title', titlec);
	    }
	});

    function scrollToTimelineAnchor(anchor){
      var aTag = $(anchor);
        $('html, body').animate( {scrollTop: aTag.offset().top - 100}, {duration: 500} );
     }

    $('div.timeline-content, div.timeline-description').expander({
      slicePoint: 300,
      widow: 4,
      preserveWords: true,
      expandEffect: 'fadeIn',
      expandText: ' <span class="timelineicon-sign-in timeline-morelessicon"></span>',
      expandPrefix: ' ... ',
      collapseEffect: 'fadeOut',
      userCollapseText: '<br><span class="timelineicon-sign-out timeline-morelessicon"></span>',
      userCollapsePrefix: '',
      onCollapse: function() {
        $('html, body').animate( {scrollTop: $(this).offset().top}, {duration: 500} );
      }
	});

	document.addEventListener('play', function(e){
	    var videos = document.getElementsByTagName('video , iframe');
	    for(var i = 0, len = videos.length; i < len;i++){
	        if(videos[i] != e.target){
	            videos[i].pause();
	        }
	    }
	}, true);

});

    // Load YouTube Frame API
    (function(){ //Closure, to not leak to the scope
      var s = document.createElement('script');
      s.src = '//www.youtube.com/player_api'; /* Load Player API*/
      var before = document.getElementsByTagName('script')[0];
      before.parentNode.insertBefore(s, before);
    })();

    function onYouTubeIframeAPIReady() {
        var $ = jQuery;
		var players = [];
        $('iframe').filter(function(){return this.src.indexOf('https://www.youtube.com/') == 0}).each( function (k, v) {
            if (!this.id) { this.id='embeddedvideoiframe' + k }
            players.push(new YT.Player(this.id, {
                events: {
                    'onStateChange': function(event) {
                        if (event.data == YT.PlayerState.PLAYING) {
                            $.each(players, function(k, v) {
                                if (this.getIframe().id != event.target.getIframe().id) {
                                    this.stopVideo();
                                }
                            });
                        }
                    }
                }
            }))
        });
    }


