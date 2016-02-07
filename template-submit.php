<?php
/*
Template Name: Submit
*/
require_once dirname( __FILE__ ) . '/includes/form-process.php';
//$wpdb->hide_errors();
nocache_headers();
?>

<?php get_header();?>
<script type="text/javascript">
jQuery(document).ready(function($){
	<?php if($is_allow_newstore=="on"):?>
	$("#form-store").append('<option value="new" class="level-0">Add New Store</option>');
	<?php endif;?>
	$(".coupon-new-store").hide(); 
	$("#form-store").change(function(){
		if($(this).val()=="new")
			$(".coupon-new-store").show(400);
		else
			$(".coupon-new-store").hide(400);
	})
	
	switch($("#form-type").find("option:selected").text()){
		case "Printable Coupon":
		  $(".print-upload").show();
		  $(".form-code").hide();
		  $("#form-type").data("print",1);
		  break;
		case "Coupon Code":
		  $(".form-code").show();
		  $(".print-upload").hide();
		  $("#form-type").data("code",1);
		  break;
		default:
		  $(".print-upload").hide();
		  $(".form-code").hide();
	}
	$("#form-type").change(function(){
		var obj=$(this).find("option:selected").text();
		
		switch(obj){
		case "Printable Coupon":
		  $(".print-upload").show(400);
		  $(".form-code").hide(400);
		  $("#form-type").data("code",0);
		  $("#form-type").data("print",1);
		  break;
		case "Coupon Code":
		  $(".form-code").show(400);
		  $(".print-upload").hide(400);
		  $("#form-type").data("code",1);
		  $("#form-type").data("print",0);
		  break;
		default:
		  $(".print-upload").hide(400);
		  $(".form-code").hide(400);
		  $("#form-type").data("print",0);
		  $("#form-type").data("code",0);
		}
		
	})
	$( "#expiration" ).datepicker({ dateFormat: "yy-mm-dd" });
	$( "#unclear" ).click(function(){
		d = new Date();
		$(this).prev().attr("src", "<?php echo get_template_directory_uri().'/includes/check-code.php'; ?>?"+d.getTime());
	});

	/*
	$("input").keydown(function(){
		$(this).css("border-color","#669906");
		$(this).next("p").remove();
	})
	$("input").change(function(){
		$(this).css("border-color","#669906");
	})	
	$("select").change(function(){
		$(this).css("border-color","#669906");
		$(this).next("p").remove();
	})
	$("textarea").change(function(){
		$(this).css("border-color","#669906");
		$(this).next("p").remove();
	})
	*/
		
})

	var state = new Array(11);
	function IsDate(str) {  
		var reg = /^(\d{4})-(\d{2})-(\d{2})$/;  
		var arr = reg.exec(str);  
		if (reg.test(str)&&RegExp.$2<=12&&RegExp.$3<=31){  
			return true;
		}else{
			return false;  
		}
	} 	
	function checkform(){
		//var state=false;
		if(jQuery("#post-title").val().length==0&&state[0]!=1){
			state[0]=1;
			jQuery("#post-title").css("border-color","#F90");
			
		}else if(jQuery("#post-title").val().length!=0){
			state[0]=0;
		}

		if(jQuery("#form-store").find("option:selected").val()=='-1'&&state[1]!=1){
			jQuery("#form-store").css("border-color","#F90");
			state[1]=1;
		}else if(jQuery("#form-store").find("option:selected").val()!='-1'&&state[1]==1){
			state[1]=0;
			jQuery("#form-store").next().remove();
		}
		
		
		if(jQuery("#form-cat").find("option:selected").val()=='-1'&&state[2]!=1){
			jQuery("#form-cat").css("border-color","#F90");
			state[2]=1;
		}else if(jQuery("#form-cat").find("option:selected").val()!='-1'&&state[2]==1){
			state[2]=0;
			jQuery("#form-cat").next().remove();
		}
		
		if(jQuery("#form-type").data("code")==1){
			state[4]=0;
		}
		if(jQuery("#form-type").data("code")==1&&jQuery("#form-code").val().length==0&&state[3]!=1){
			jQuery("#form-code").css("border-color","#F90");
			state[3]=1;
		}else if(jQuery("#form-type").data("code")==1&&jQuery("#form-code").val().length!=0&&state[3]==1){
			state[3]=0;
			jQuery("#form-code").next().remove();
		}
		if(jQuery("#form-type").data("print")==1){
			state[3]=0;
		}
		if(jQuery("#form-type").data("print")==1&&jQuery("#print-upload").val().length==0&&state[4]!=1){
			state[3]=0;
			jQuery("#print-upload").css("border-color","#F90");
			state[4]=1;
		}else if(jQuery("#form-type").data("print")==1&&jQuery("#print-upload").val().length!=0&&state[4]==1){
			state[3]=0;
			state[4]=0;
			jQuery("#print-upload").next().remove();
		}
		
		if(jQuery("#destination").val().length==0&&state[5]!=1){
			jQuery("#destination").css("border-color","#F90");
			state[5]=1;
		}else if(jQuery("#destination").val().length!=0&&state[5]==1){
			state[5]=0;
			jQuery("#destination").next().remove();
		}
		if(IsDate(jQuery("#expiration").val())==false&&state[6]!=1){
			jQuery("#expiration").css("border-color","#F90");
			state[6]=1;
		}else if(IsDate(jQuery("#expiration").val())&&state[6]==1){
			state[6]=0;
			jQuery("#expiration").next().remove();
		}
		if(jQuery("#verification")&&jQuery("#verification").val().length==0&&state[7]!=1){
			jQuery("#verification").css("border-color","#F90");
			state[7]=1;
		}else if(jQuery("#verification").val().length!=0&&state[7]==1){
			state[7]=0;
			jQuery("#unclear").next().remove();
		}
		
		if(jQuery("#form-store").find("option:selected").val()=='new'){
			if(jQuery("#store-name").val().length==0&&state[8]!=1){
				jQuery("#store-name").css("border-color","#F90");
				state[8]=1;
			}else if(jQuery("#store-name").val().length!=0&&state[8]==1){
				state[8]=0;
				jQuery("#store-name").next().remove();
			}
			if(jQuery("#store-url").val().length==0&&state[9]!=1){
				jQuery("#store-url").css("border-color","#F90");
				state[9]=1;
			}else if(jQuery("#store-url").val().length!=0&&state[9]!=1){
				state[9]=0;
				jQuery("#store-url").next().remove();
			}
		}
				
		for(var i=0,len=state.length;i<len;i++){
			if(state[i]==1){
				//alert(i);
				return false;
			}
		}
	}
</script>
<div id="content" class="page-content">
	
      
        <?php if(isset($post_sented) && $post_sented == true) { ?>

		<h1 class="page-title"><?php the_title(); ?></h1>
			
        <div id="submit-content">  
	        <div class="thanks">
	            <p><?php _e('Thanks, your coupon was submitted successfully.', 'junkie') ?></p>
	        </div><!-- .thanks -->
        </div>

	    <?php } else {?>
	    
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    
				<div id="post-<?php the_ID(); ?>">
			    
					<h1 class="page-title"><?php the_title(); ?> </h1>
			
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'junkie').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link( __('Edit', 'junkie'), ' <div class="edit-post">( ', ' )</div>' ); ?>
						
					</div><!-- .entry-content -->
					
				</div><!-- #post-<?php the_ID(); ?> -->
				
			<?php endwhile; endif; ?>
            
	        <div id="submit-content">
                <div id="formbox">
                <?php
                    if ($err != "") {
                        echo "<p class='msg'>".$err."</p>";
                    }
                    if ($_GET['success'] == "success") {
                        echo "<p>Thanks, your coupon was submitted successfully.</p>";
                    }
                    else {
                ?>
                
                <?php if (is_user_logged_in()||$is_open_submit=='Everyone') { ?>
                        <form action="" method="post" enctype="multipart/form-data" onsubmit="return checkform()">
                            <input type="hidden" name="action" value="post" />
                            <?php wp_nonce_field( 'new-post' ); ?>
                                <p><label for="post-title">  <?php _e('Coupon Title', 'junkie'); ?> </label><input type="text" id="post-title" name="post-title" value="<?php echo $post_title;?>" size="60" tabindex="1"/>
                                </p>
                                <p><label for="store">  <?php _e('Coupon Store', 'junkie'); ?> </label>
								<?php wp_dropdown_categories('name=form-store&taxonomy=coupon_store&orderby=name&order=ASC&hide_empty=0&hierarchical=1&show_option_none=Select Store'); ?>
                                </p>
                                <p class="coupon-new-store"><label for="store-name"><?php _e('New Store Name', 'junkie'); ?></label><input type="text" name="store-name" id="store-name" value="<?php echo $store_name; ?>" >
                                </p>
                                <p class="coupon-new-store"><label for="store-url"><?php _e('New Store URL', 'junkie'); ?></label><input type="text" name="store-url" id="store-url" value="<?php echo $store_url; ?>" >
                                </p>
                                <p class="coupon-new-store"><label for="store-url"><?php _e('New Store Image', 'junkie'); ?></label><input name="store-img" type="file" id="store-img" value="http://<?php echo $store_url; ?>" >                          
                                </p>
                                <p><label for="category">  <?php _e('Coupon Category', 'junkie'); ?> </label>
								<?php wp_dropdown_categories('name=form-cat&taxonomy=coupon_cat&orderby=name&order=ASC&hide_empty=0&hierarchical=1&show_option_none=Select Category'); ?>
                                </p>
                                <p><label for="form-type"><?php _e('Coupon Type', 'junkie'); ?> </label> 
								<?php
                                    $coupon_type_list=get_terms( 'coupon_type', 'orderby=count&hide_empty=0' );
                                ?>
                                <select id="form-type" name="form-type" >
                                <?php
                                    foreach ( $coupon_type_list as $term ) {
                                        echo "<option value='".$term->name."' >" . $term->name . "</option>";
                                    }              
                                ?>
                                </select>
                                </p>
                                <p class="form-code"><label for="form-code"><?php _e('Coupon Code', 'junkie'); ?></label><input type="text" name="form-code" id="form-code" value="<?php echo $form_code; ?>" >
                                </p>
                                <p class="print-upload"><label for="print-upload"><?php _e('Printed Coupon', 'junkie'); ?></label><input name="print-upload" id="print-upload"  type="file" >
                                </p>
                                <p><label for="destination"><?php _e('Destination URL', 'junkie'); ?></label><input type="text" name="destination" id="destination" value="<?php echo $destination; ?>" placeHolder="http://www.mysite.com/?affid=123" >
                                </p>
                                <p><label for="expiration"><?php _e('Expiration Date', 'junkie'); ?></label><input type="text" name="expiration" id="expiration" value="<?php echo $expiration; ?>" >
                                </p>
                                <?php if($is_newtags=="on"): ?>
                                <p><label for="tags"><?php _e('Coupon Tags', 'junkie'); ?></label><input type="text" name="tags" id="tags" value="<?php echo $tags; ?>" placeHolder="Seperated by commas." >
                                </p>
                                <?php endif; ?> 
                                <?php if($is_verification=="on"): ?>
                                <p><label for='verification'><?php _e('Verification Code', 'junkie'); ?></label><input type="text" name="verification" id="verification" value="" > <img src="<?php echo get_template_directory_uri().'/includes/check-code.php'; ?>" alt="Verification Code"> <span id="unclear"><?php _e('Refresh', 'junkie'); ?></span></p>
                                <?php endif; ?>                              
                                <p class="submit-textarea"><label for="post-content"><?php _e('Full Description', 'junkie'); ?> </label><textarea name="post-content" id="post-content" class="clearfix" cols=60 rows=10 tabindex="2"><?php echo $post_content; ?></textarea>
                                <input id="submit" type="submit" value="Submit" class="button" />
                                <span id="submit-flag"></span>
                                </p>                                                                    
                        </form>
                        
                        <?php } else { ?>
							<p><?php _e('You need to', 'junkie'); ?> <a href="<?php echo get_site_url()."/wp-admin"?>"><?php _e('log in', 'junkie'); ?></a> <?php _e('to use the submission form.', 'junkie'); ?></p>
                        <?php } ?>
                    <?php } ?>
                </div><!-- #formbox -->

            </div><!-- #submit-content -->

    	<?php }?>
    	

</div>

<?php get_sidebar(); ?>    	
<?php get_footer(); ?>