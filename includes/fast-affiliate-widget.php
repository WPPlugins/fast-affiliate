<?php

class fast_affiliate_widget2 extends WP_Widget {

    public function __construct() {
        $widget_options = array( 
          'classname' => 'fast_affiliate_widget2',
          'description' => 'Offers list',
        );
        parent::__construct( 'fast_affiliate_widget2', 'Fast Affiliate Widget Product and Price', $widget_options );
    }

    public function widget( $args, $instance ) {
        $post_id=get_the_ID();
        $products = get_post_meta($post_id, 'fast_affiliate_products_choice', true);


        if (is_array($products) && count($products)>0){
            $title = apply_filters( 'widget_title', $instance[ 'title' ] );

            // if (isset($instance['sticky'])) {
            //     echo "<div id='sticky-anchor'></div>";
            //     echo "<div id='fast_affiliate_widget2_product_sticky'>";
            // }
            // else {
            //     echo "<div id='sticky-anchor'></div>";
            //     echo "<div id='fast_affiliate_widget2_product'>";    
            // }
            echo "<div id='fast_affiliate_widget2_product'>";
            echo $args['before_widget'];
            echo $args['before_title'] . $title . $args['after_title']; 
            
            foreach($products as $product){
                $programs=get_option('fast_affiliate_programs');
                foreach($programs as $program) {
                    if ($product['program_id']==$program['program_id']) {
                        $program_name=$program['program_name'];
                        $program_logo_url=$program['program_logo_url'];
                        $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
                        $program_name = $program['program_name'];
                    }
                }

                if (strcmp($product['product_currency'],"EUR")==0){
                    $currency="€";
                } else {
                    $currency=$product['product_currency'];
                }

                if (array_key_exists('link_type', $product ) == false) {
                    $product['link_type'] = "Product Link";
                }

                if ($product['link_type']=="Product Link"){
                    ?>
                    <div class='fast_affiliate_widget2_product'>
                        <a class='fa_product_widget' data-link_id=<?php echo $product['link_id']?> href=<?php echo $product['affiliate_product_url']?> target='_blank' rel='nofollow' alt='product' > 
                            <div class='fast_affiliate_widget2_left_column'>
                                <p>
                                    <img src=<?php echo $product['product_url_image']?> >
                                </p>
                            </div>
                            <div class='fast_affiliate_widget2_middle_column'>
                                <?php $show_price = get_option('fast_affiliate_show_price'); ?>
                                <p><?php if ($show_price) { echo $product['product_price']." ".$currency; } ?></p>
                            </div>
                            <div class='fast_affiliate_widget2_right_column'>
                                <span class='fast_affiliate_button_offer'><?php echo (__('See Offer','fast-affiliate'))?></span>
                                <?php 
                                    if ($program_logo_url == "") {
                                        echo "<span id='program_name'>" . $program_name . "</span>";
                                    }
                                    else {
                                        echo "<img src='" . $program_logo_url . "'alt=shop logo>";
                                    }
                                ?>
                            </div>
                        </a>
                    </div>
                    <?php
                } else { // Quick link case
                    ?>
                    <div class='fast_affiliate_widget2_product'>
                        <a class='fa_product_widget' data-link_id=<?php echo $product['link_id']?> href=<?php echo $product['affiliate_product_url']?> target='_blank' rel='nofollow' alt='product' > 
                            <div class='fast_affiliate_widget2_double_left_column'>
                                <p>
                                    <?php echo $product['product_name']?>
                                </p>
                            </div>

                            <div class='fast_affiliate_widget2_right_column'>
                                <span class='fast_affiliate_button_offer'><?php echo (__('See Offer','fast-affiliate'))?></span>
                                <?php 
                                    if ($program_logo_url == "") {
                                        echo "<span id='program_name'>" . $program_name . "</span>";
                                    }
                                    else {
                                        echo "<img src='" . $program_logo_url . "'alt=shop logo>";
                                    }
                                ?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }

            echo $args['after_widget'];
            echo "</div>";
        }
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $sticky = isset( $instance['sticky'] ) ? $instance['sticky'] : ''; 
        ?>
        
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        <!-- 
        </br>
        <label for="<?php echo $this->get_field_id( 'sticky' ); ?>">Sticky:</label>
        <input id="<?php echo $this->get_field_id( 'sticky' );?>" type="checkbox" name="<?php echo $this->get_field_name( 'sticky' );?>" <?php checked(true, $sticky);?> /> 
        -->
        </p><?php 
    }
    
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        // if (!empty($new_instance['sticky'])) {
        //     $instance['sticky'] = 1;
        // }

        return $instance;
    }
}


function fast_affiliate_register_widget(){
    register_widget( 'fast_affiliate_widget2' );
}