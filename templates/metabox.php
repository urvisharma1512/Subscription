<?php settings_errors(); ?>
<div class="metabox">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tabs-left sideways">
        <li class="active">
    	    <a href="#general_product_data" data-toggle="tab">General</a>
        </li>
        <li>
    	    <a href="#inventory_product_data" data-toggle="tab">Inventory</a>
        </li>
        <li>
        	<a href="#subscription_product_data" data-toggle="tab">Subscription Setting</a>
        </li>
        <li>
        	<a href="#product_attributes" data-toggle="tab">Attributes</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="content">
      <div class="tab-pane active" id="general_product_data">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" class="widefat" value="<?php echo esc_attr( $price ); ?>"><br><br>
            <label for="sale_price">Sale Price:</label>
            <input type="text" id="sale_price" name="sale_price" class="widefat" value="<?php echo esc_attr( $sale_price ); ?>"><br><br>
      </div>
      <div class="tab-pane" id="inventory_product_data">
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" class="widefat" value="<?php echo esc_attr( $sku ); ?>"><br><br>
            <label for="stock_status">In_Stock:</label>
            <input type="text" id="stock_status" name="stock_status" class="widefat" value="<?php echo esc_attr( $stock_status ); ?>"><br><br>
      </div>
      <div class="tab-pane" id="subscription_product_data">
          <label for="sub_per_interval">Subscription per Interval:</label>
          <input type="text" id="sub_per_interval" name="sub_per_interval" class="widefat" value="<?php echo esc_attr( $sub_per_interval ); ?>"><br><br>
          <label for="sub_expiry">Subscription Expiry:</label>
          <input type="text" id="sub_expiry" name="sub_expiry" class="widefat" value="<?php echo esc_attr( $sub_expiry ); ?>"><br><br>
          <label for="sub_entry_fee">Entry Fee:</label>
          <input type="text" id="sub_entry_fee" name="sub_entry_fee" class="widefat" value="<?php echo esc_attr( $sub_entry_fee ); ?>"><br><br>
          <label for="sub_free_trial">Free Trials:</label>
          <input type="text" id="sub_free_trial" name="sub_free_trial" class="widefat" value="<?php echo esc_attr( $sub_free_trial ); ?>"><br><br>
      </div>
      <div class="tab-pane" id="product_attributes">Settings Tab.</div>
    </div>
</div>

