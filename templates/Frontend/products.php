<?
get_header();
?>
<h2 style="text-align:center">Product List</h2>
<?
$all_products = new Wp_Query(array(
    'post_type' => 'product',
));
query_posts($all_products);
while( $all_products->have_posts()):
    $all_products->the_post();
    $post_id = get_post_field('ID'); 
    $product_info = get_post_meta( get_post_field('ID') , '_metabox_key', true );
    $url = wp_get_attachment_url( get_post_thumbnail_id(get_post_field('ID')) , 'thumbnail' );
    
?>

<div class="product" id="product">
    <div class="card">
      <img src="<?echo $url;?>" alt="ProductPic" style="width:200px;  margin-top:10px;">
      <h4><? the_title();?></h4>
      <p class="price"><? echo '<del> Rs'. $product_info['price'] .'.00</del> <span class="greentext"> Rs'. $product_info['sale_price'].'.00</span>'; ?></p>
      <p class="align">  <span class="check">&#10003;</span> <? echo 'Renew after '.$product_info['sub_per_interval'] ;?> </p>     
      <p class="align">  <span class="check">&#10003;</span> <? echo $product_info['sub_expiry'].' Plan';?> </p>  
      <p class="align">  <span class="check">&#10003;</span><? echo ' Free trial for '.$product_info['sub_free_trial'] ;?>  </p> 
      <p class="align">  <span class="check">&#10003;</span> <? echo 'SignUp fee '.$product_info['sub_entry_fee'] ;?>  </p>  
      <p><button> Purchase Subscription </button></p>  
    </div> 
</div>   
<?
endwhile;
get_footer();
?>