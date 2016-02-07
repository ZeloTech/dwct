/*-----------------------------------------------------------------------------------*/
/*	Get My Location
/*-----------------------------------------------------------------------------------*/
var js=document.scripts;
var jsPath;
for(var i=js.length;i>0;i--){
  if(js[i-1].src.indexOf("custom.js")>-1){
    jsPath=js[i-1].src.substring(0,js[i-1].src.lastIndexOf("/")+1);
  }
}
jQuery(document).ready(function($){

/*-----------------------------------------------------------------------------------*/
/*	jQuery Superfish Menu
/*-----------------------------------------------------------------------------------*/

    function init_nav(){
        jQuery('ul.nav').superfish({ 
	        delay:       1000,                             // one second delay on mouse out 
	        animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
	        speed:       'fast'                           // faster animation speed 
    	});
    }
    init_nav();

/*-----------------------------------------------------------------------------------*/
/*	Responsive Menu
/*-----------------------------------------------------------------------------------*/
	$(window).resize(function(){
		if($("#primary-nav").width() >768){
			$("#responsive-menu").hide();
		} 

	});
	
	$(".btn-nav-right").click(function(){
			$("#responsive-menu").slideToggle(300);
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Featured Slider
/*-----------------------------------------------------------------------------------*/	    

      $('#slides').slidesjs({
        width: 960,
        height: 290,
        play: {
	    	auto: true
	    }         
      });

/*-----------------------------------------------------------------------------------*/
/*	Coupon Click
/*-----------------------------------------------------------------------------------*/      
	$(".coupon-code").each(function(index, element) {

		$(this).click(function(){
			if($(this).html()=="Print Coupon"&&$(this).html()=="Click to Redeem"){
				if($(this).attr("aff-url"))window.open($(this).attr("aff-url"));
			}
		});		
		
		var clip = new ZeroClipboard( $(this), {
			moviePath: jsPath+"/ZeroClipboard.swf"
		});
		
		clip.on( 'load', function(client) {
		  // alert( "movie is loaded" );
		});
		
		clip.on( 'complete', function(client, args) {
		  //this.style.display = "none"; // "this" is the element that was clicked
		  //alert("Copied text to clipboard: " + args.text );
		  if($(this).attr("aff-url"))
		  	window.open($(this).attr("aff-url"));
			var data={id:$(this).attr("cid"),action:"click"}
			$.post( jsPath+'../ajax-action.php', data, function(response){})
		  	$(this).next().remove();
		});
		clip.on( 'mouseover', function(client) {
			$(this).after("<div class='pop-info'> "+$(this).attr("pop-info")+"</div>")
		});
		clip.on( 'mouseout', function(client) {
			$(this).next().remove();
		});
		
	});	
	
/*-----------------------------------------------------------------------------------*/
/*	Coupon Ratings
/*-----------------------------------------------------------------------------------*/
	
	/* Thumbs Up */    
	$(".thumbs-up").each(function(index, element) {
      var obj=$(this);
	  if($.cookie("like_me_"+obj.attr("mid"))=="up")
	  	obj.css("background","url('"+jsPath+"../../images/thumbs-up-ticked.png') no-repeat 0 8px rgba(0, 0, 0, 0)");;
     // $(this).unbind();
	 if(!obj.data("events")&&$(this).attr("mid"))
      $(this).bind("click",'',function(){  
        var data={
           action:'like',
           id: $(this).attr("mid")
        };
        $.post( jsPath+'../ajax-action.php', data, function(response){
		  if(response){
			  $.cookie("like_me_"+obj.attr("mid"),"up",{ expires: 1, path: '/' });
			  obj.html(response);
			  obj.next().unbind();
			  obj.css("background","url('"+jsPath+"../../images/thumbs-up-ticked.png') no-repeat 0 8px rgba(0, 0, 0, 0)");
			  obj.unbind();
		  }
        })
      })
    });
    
    /* Thumbs Down */
    $(".thumbs-down").each(function(index, element) {
      var obj=$(this);
	  if($.cookie("like_me_"+obj.attr("mid"))=="down")
	  	obj.css("background","url('"+jsPath+"../../images/thumbs-down-ticked.png') no-repeat 0 8px rgba(0, 0, 0, 0)");;
	  
     // $(this).unbind();
	 if(!obj.data("events")&&$(this).attr("mid"))
      $(this).bind("click",'',function(){  
        var data={
           action:'unlike',
           id: $(this).attr("mid")
        };
        $.post( jsPath+'../ajax-action.php', data, function(response){
		  if(response){
			  $.cookie("like_me_"+obj.attr("mid"),"down",{ expires: 1, path: '/' });
			  obj.html(response);
			  obj.prev().unbind();
			  obj.css("background","url('"+jsPath+"../../images/thumbs-down-ticked.png') no-repeat 0 8px rgba(0, 0, 0, 0)");
			  obj.unbind();
		  }
        })
      })
    });/* end like it */


/*-----------------------------------------------------------------------------------*/
/*	Share, Report and Comments
/*-----------------------------------------------------------------------------------*/
	
	/* Share */
	$(".share").toggle(
		function(){
			$(this).next().slideDown(100);
			if($(this).next().siblings(".drop-section").css("display")=="block")
			$(this).siblings(".report").click();
		},
		function(){
			$(this).next().slideUp(100);
		}
	);

	/* Report Issue */	
	$(".report").toggle(
		function(){
			$(this).next().slideDown(100);
			if($(this).next().siblings(".drop-section").css("display")=="block")
			$(this).siblings(".share").click();
		},
		function(){
			$(this).next().slideUp(100);
		}
	);
	
	$(".report-button").click(function(){
		var obj=$(this);
        var data={
           action:'report',
           id: $(this).attr("mid"),
		   ras:$(this).prev().val()
        };
        $.post( jsPath+'../ajax-action.php', data, function(response){
			  var rebox=obj.parent().html(response);
			  obj.unbind();
			  setTimeout(function(){rebox.prev().click();},1500);
			 
        })
	});
	
	/* Make Comment */
	$(".make-comment").each(function(index, element) {
		var obj=$(this);
		obj.toggle(
			function(){
				$(".comments-mini:eq("+index+")").show();
			},
			function(){
				$(".comments-mini:eq("+index+")").hide();
			}
		);
		$(".close-comment:eq("+index+")").click(function(){
			 obj.click();
		});
    })
	
	$(".fancybox").fancybox({type: 'iframe',height:490,autoSize:false});        

/* $("#overdue").nextAll().find(".entry-thumb-wrapper .entry-thumb").before('<img src="'+jsPath+'../../images/mask.png" style="position:absolute" >'); */	

/*-----------------------------------------------------------------------------------*/
/*	Responsive ZeroClipboard
/*-----------------------------------------------------------------------------------*/
	function responsive(){
		 if($("body").width()<=960){
		 	$("#global-zeroclipboard-html-bridge").css("display","none");
			$(".mobile-button").show();
		 }else{
		 	$("#global-zeroclipboard-html-bridge").css("display","block");
			$(".mobile-button").hide();
		 }
	}
	responsive();
	$(window).resize(function() {
		responsive();
	});

	
})

/*-----------------------------------------------------------------------------------*/
/*	Refresh Comments
/*-----------------------------------------------------------------------------------*/
function reflash_comments(id,url){
	var data={action:"comment_mini_list",id:id} 
	setTimeout(function(){
	jQuery.post( url, data, function(response){
		jQuery(".comments-mini-"+id+"").html(response);
	})
	},1000)
}