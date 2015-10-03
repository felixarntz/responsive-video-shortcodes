<?php
/**
 * Class: respvid_widget
 * 
 * A widget that will display one or more media items (supported by WordPress oEmbed) in a group.
 * Aspect ratio for all items, the number of items per row and of course the URLs of the media to display can be specified.
 * If needed, RTL support can be turned on (media will be right-aligned).
 * 
 * @package ResponsiveVideoShortcodes
 * @version 1.2.5
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */
class Respvid_Widget extends WP_Widget
{
  public function __construct()
  {
    parent::__construct( 'respvid_widget', __( 'Responsive Video List Widget', 'responsive-video-shortcodes' ), array(
      'classname'   => 'widget_respvid',
      'description' => __( 'Use this widget to display a custom list of videos in a responsive way.', 'responsive-video-shortcodes' ),
    ) );
  }
    
  public function widget( $args, $instance )
  {
    extract( $args );
    
    $defaults = $this->get_defaults();
    extract( wp_parse_args( $instance, $defaults ) );

    $aspect_ratio = str_replace( ':', '-', $aspect_ratio );
    $urls = preg_split( '/\r\n|[\r\n]/', $urls );
    
    if( $num_per_row == 1 )
    {
      $align = 'center';
    }
    elseif( $rtl )
    {
      $align = 'right';
    }
    else
    {
      $align = 'left';
    }
    
    echo $before_widget;

    if( $title != '' )
    {
      echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
    }
       
    if( is_array( $urls ) && count( $urls ) > 0 )
    {
      foreach( $urls as $url )
      {
        $frontend_instance = Respvid_Frontend::instance();
        echo $frontend_instance->get_embed_video( $url, $align . ' resp-num-' . $num_per_row, $aspect_ratio );
      }
      echo '<div class="clear"></div>';
    }
    else
    {
      ?>
      <p><?php _e( 'There are no videos to display.', 'responsive-video-shortcodes' ) ?></p>
      <?php
    }

    echo $after_widget;
  }
    
  public function form( $instance )
  {
    $defaults = $this->get_defaults();
    extract( wp_parse_args( $instance, $defaults ) );
    ?>
      
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title' ); ?></label>
        <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'aspect-ratio' ); ?>"><?php _e( 'Aspect Ratio', 'responsive-video-shortcodes' ); ?></label>
      <select id="<?php echo $this->get_field_id( 'aspect_ratio' ); ?>" name="<?php echo $this->get_field_name( 'aspect_ratio' ); ?>" class="widefat">
        <?php
        $options = respvid_get_allowed_aspect_ratios();
        foreach( $options as $option )
        {
          echo '<option value="' . $option . '" ' . selected( $option, $aspect_ratio ) . '>' . $option . '</option>';
        }
        ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'num_per_row' ); ?>"><?php _e( 'Videos per row', 'responsive-video-shortcodes' ); ?></label>
      <input type="number" id="<?php echo $this->get_field_id( 'num_per_row' ); ?>" name="<?php echo $this->get_field_name( 'num_per_row' ); ?>" value="<?php echo esc_attr( $num_per_row ); ?>" min="1" max="6" step="1" class="widefat" />
    </p>
    <p class="description">
      <?php _e('Value must be between 1 and 6', 'responsive-video-shortcodes'); ?>
    </p>
    <p>
      <input type="checkbox" id="<?php echo $this->get_field_id( 'rtl' ); ?>" name="<?php echo $this->get_field_name( 'rtl' ); ?>" value="true" <?php checked( true, $rtl ); ?> />
      <label for="<?php echo $this->get_field_id( 'rtl' ); ?>"><?php _e( 'Right-to-Left Language?', 'responsive-video-shortcodes' ); ?></label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'urls' ); ?>"><?php _e( 'List of Video URLs', 'responsive-video-shortcodes' ); ?></label>
      <textarea id="<?php echo $this->get_field_id( 'urls' ); ?>" name="<?php echo $this->get_field_name( 'urls' ); ?>" rows="6" class="widefat"><?php echo esc_textarea( $urls ); ?></textarea>
    </p>
    <p class="description">
      <?php _e('One URL per line. No other separators than the linebreak.') ?>
    </p>

    <?php
  }
            
  public function update( $new_instance, $old_instance )
  {
    $options = respvid_get_allowed_aspect_ratios();
  
    $instance = $old_instance;

    $instance['title'] = strip_tags( $new_instance['title'] );
    if( in_array( $new_instance['aspect_ratio'], $options ) )
    {
      $instance['aspect_ratio'] = $new_instance['aspect_ratio'];
    }
    $new_instance['num_per_row'] = absint( $new_instance['num_per_row'] );
    if( $new_instance['num_per_row'] < 7 && $new_instance['num_per_row'] > 0 )
    {
      $instance['num_per_row'] = $new_instance['num_per_row'];
    }
    if( isset( $new_instance['rtl'] ) )
    {
      $instance['rtl'] = true;
    }
    else
    {
      $instance['rtl'] = false;
    }
    $instance['urls'] = strip_tags( $new_instance['urls'] );
            
    return $instance;
  }
  
  public function get_defaults()
  {
    $defaults = array(
      'title'     => '',
      'aspect_ratio'  => '16:9',
      'num_per_row' => 3,
      'rtl'     => false,
      'urls'      => '',
    );
    return $defaults;
  }
}
