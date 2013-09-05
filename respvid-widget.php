<?php

class respvid_widget extends WP_Widget
{
    function respvid_widget()
    {
        $widget_ops = array( 'classname' => 'widget_respvid_widget', 'description' => __( 'Use this widget to display a custom list of videos in a responsive way.', 'respvid' ) );
        $this->WP_Widget( 'widget_respvid_widget', __( 'Responsive Video List Widget', 'respvid' ), $widget_ops );
        $this->alt_option_name = 'widget_respvid_widget';
    }
    
    function form($instance)
    {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'aspect-ratio' => '16:9', 'num-per-row' => 1, 'rtl' => 0, 'list' => '' ) );
        $title = esc_attr( $instance['title'] );
        $aspect_ratio = esc_attr( $instance['aspect-ratio'] );
        $num_per_row = esc_attr( $instance['num-per-row'] );
        $rtl = esc_attr( $instance['rtl'] );
        $list = esc_textarea( $instance['list'] );
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('aspect-ratio'); ?>"><?php _e('Aspect Ratio', 'respvid'); ?></label>
        	<select class="widefat" id="<?php echo $this->get_field_id('aspect-ratio'); ?>" name="<?php echo $this->get_field_name('aspect-ratio'); ?>">
        		<?php
        		$options = array( '4:3', '16:9', '21:9' );
        		foreach( $options as $option )
        		{
        			echo '<option value="' . $option . '" id="' . $option . '" ' . selected( $option, $aspect_ratio ) . '>' . $option . '</option>';
        		}
        		?>
        	</select>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('num-per-row'); ?>"><?php _e('Videos per row', 'respvid'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('num-per-row'); ?>" name="<?php echo $this->get_field_name('num-per-row'); ?>" type="text" value="<?php echo $num_per_row; ?>" />
        	<br />
        	<em><?php _e('Value must be between 1 and 6', 'respvid'); ?></em>
        </p>
        <p>
        	<input id="<?php echo $this->get_field_id('rtl'); ?>" name="<?php echo $this->get_field_name('rtl'); ?>" type="checkbox" value="1" <?php checked( '1', $rtl ); ?>/>
        	<label for="<?php echo $this->get_field_id('rtl'); ?>"><?php _e('Right-to-Left Language?', 'respvid'); ?></label>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('list'); ?>"><?php _e('List of Video URLs', 'respvid'); ?></label>
        	<textarea class="widefat" style="height:100px;" id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>"><?php echo $list; ?></textarea>
        	<br />
        	<em><?php _e('One URL per line. No other separators than the linebreak.')?></em>
        </p>
    
        <?php
    }
    
    function validate_num_per_row( $value )
    {
    	if( $value > 6 )
    	{
    		return 6;
    	}
    	else if( $value < 1 )
    	{
    		return 1;
    	}
    	else
    	{
    		return $value;
    	}
    }
            
    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['aspect-ratio'] = strip_tags( $new_instance['aspect-ratio'] );
        $instance['num-per-row'] = $this->validate_num_per_row( intval( strip_tags( $new_instance['num-per-row'] ) ) );
        $instance['rtl'] = strip_tags( $new_instance['rtl'] );
        $instance['list'] = strip_tags( $new_instance['list'] );
                
        return $instance;
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
        extract( $instance );
        $title = $instance['title'];
        $aspect_ratio = str_replace( ':', '-', $instance['aspect-ratio'] );
        $num_per_row = $instance['num-per-row'];
        $rtl = $instance['rtl'];
        $urls = preg_split( '/\r\n|[\r\n]/', $instance['list'] );
        
        if( $num_per_row == 1 )
        {
        	$align = 'center';
        }
        else if( $rtl )
        {
        	$align = 'right';
        }
        else
        {
        	$align = 'left';
        }
        
        echo $before_widget;
        if ( $title != '' )
        {
            echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
        }
        else
        {
            echo '<span class="paddingtop"></span>';
        }
           
        if ( count( $urls ) > 0 && !empty( $urls[0] ) )
        {
        	foreach( $urls as $url )
        	{
        		echo resp_before_video( $align . ' resp-num-' . $num_per_row, $aspect_ratio );
        		echo resp_embed_video( $url );
        		echo resp_after_video();
        	}
        	echo '<div class="clear"></div>';
        }
        else
        {
            ?>
            <p><?php _e('There are no videos to display.', 'respvid') ?></p>
            <?php
        }
        echo $after_widget;
    }
}