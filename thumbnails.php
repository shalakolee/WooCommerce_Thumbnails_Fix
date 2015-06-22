<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
    
 <style>
 	.thumbnails {
		padding-top:0px;
		position:relative;
	}
	.thumbnails .img-nav-arrow {
		color:#8a8a8a;
		font-size:30px;
		cursor:pointer;
		display:none;
		top:45px;
		position:absolute;
		-webkit-transition: all 0.25s ease;
		-moz-transition: all 0.25s ease;
		-ms-transition: all 0.25s ease;
		-o-transition: all 0.25s ease;
		transition: all 0.25s ease;
	}
	.thumbnails .prodLeft {
		left:-10px;
	}
	.thumbnails .prodRight {
		right:-10px;
	}
	.thumbnails .prodLeft:hover {
		color:#ec2026;
		left:-12px;
	}
	.thumbnails .prodRight:hover {
		color:#ec2026;
		right:-12px;
	}
	.thumbnails ul li a {
		margin-right:14px;
	}
	.thumbnails ul li.last a {
		margin-right:0px !important;
	}
	.thumbnails a img {
		border:1px solid #b8b8b8;
		-webkit-transition: all 0.25s ease;
		-moz-transition: all 0.25s ease;
		-ms-transition: all 0.25s ease;
		-o-transition: all 0.25s ease;
		transition: all 0.25s ease;
	}
	.thumbnails a img:hover {
		border-color:#ec2127;
	}
	.thumbnails ul {
		margin:0px;
		padding:0px;
		list-style:none;
		letter-spacing:-4px;
		white-space:nowrap;
		position:absolute;
	}
	.thumbnails ul li {
		letter-spacing:0px;
		margin:0px;
		padding:0px;
		display:inline-block;
	}
	.galWrap {
		margin:0 auto;
		position:relative;
		overflow:hidden;
	}
</style>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>">
    	<a class="img-nav-arrow prodLeft" style="float:left;"><i class="fa fa-chevron-left"></i></a>
        <div class="galWrap">
            <ul>
            	<?php if( get_field('does_video_link') ){ ?>
                	<li><a data-rel="prettyPhoto[product-gallery]" rel="fancybox" href="<?php the_field('video_link'); ?>?rel=0&autoplay=1" class="videoBtn"></a></li>
                <?php }; ?>
                <?php
                
                    foreach ( $attachment_ids as $attachment_id ) {
            
                        $classes = array( 'zoom' );
            
                        if ( $loop == 0 || $loop % $columns == 0 )
                            $classes[] = 'first';
            
                        if ( ( $loop + 1 ) % $columns == 0 )
                            $classes[] = 'last';
            
                        $image_link = wp_get_attachment_url( $attachment_id );
            
                        if ( ! $image_link )
                            continue;
            
                        $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
                        $image_class = esc_attr( implode( ' ', $classes ) );
                        $image_title = esc_attr( get_the_title( $attachment_id ) );
            
                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a></li>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
            
                        $loop++;
                    }
                ?>
            </ul>
        </div>
    	<a class="img-nav-arrow prodRight"><i class="fa fa-chevron-right"></i></a>
    </div>
    <script>
		var picturesToShow = 3;
		
		var count = jQuery(".thumbnails .galWrap ul li").length;
		var marg = jQuery(".thumbnails .galWrap ul li a").css('margin-right').replace(/[^-\d\.]/g, '');
		var width = jQuery(".galWrap ul li").outerWidth(true);
		var height = jQuery(".galWrap ul li").outerHeight(true);
		var galW = (width * picturesToShow) - marg;
		var moveAmount = width;
		var pos = 0;
		
		jQuery(".thumbnails .galWrap ul li:last").addClass("last");
		jQuery(".thumbnails .galWrap").css({width: galW + "px", height: height + "px"});
		
		
		if( count > picturesToShow ){

			jQuery(".thumbnails .galWrap ul li:nth-child(3)").addClass("active");
			jQuery(".thumbnails .prodRight").show();
		};
	
		
		jQuery(".thumbnails .prodRight").click(function(){
			if( jQuery(".thumbnails .galWrap ul li.active").next().length ){
				jQuery(".thumbnails .galWrap ul li.active").removeClass("active").next().addClass("active");
				pos -= moveAmount;
				jQuery(".thumbnails .galWrap ul").stop().animate({left: pos + "px"});
				
				if( pos < 0 ){
					jQuery(".thumbnails .prodLeft").show();
				};
				
				if( jQuery(".thumbnails .galWrap ul li.active").next().length == 0 ){
					jQuery(".thumbnails .prodRight").hide();
				};
			} else {
				jQuery(".thumbnails .prodRight").hide();
			};
			
		});
		
		jQuery(".thumbnails .prodLeft").click(function(){
			if( jQuery(".thumbnails .galWrap ul li.active").prev().length ){
				jQuery(".thumbnails .galWrap ul li.active").removeClass("active").prev().addClass("active");
				pos += moveAmount;
				jQuery(".thumbnails .galWrap ul").stop().animate({left: pos + "px"});
				
				if( pos == 0 ){
					jQuery(".thumbnails .prodLeft").hide();
				};
				if( pos <= 0 ){
					jQuery(".thumbnails .prodRight").show();
				};
				
			} else {
			};
			
		});
    </script>
	<?php
}