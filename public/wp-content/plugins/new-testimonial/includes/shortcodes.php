<?php

/**
 * Handles shortcodes for the New_Testimonial plugin.
 */
class New_Testimonial_Shortcodes
{

  /**
   * Register shortcodes on construct.
   */
  public function __construct()
  {
    add_shortcode(
      'custom_image_upload_form',
      [$this, 'custom_image_upload_form_shortcode']
    );
  }

  /**
   * Shortcode callback for [custom_image_upload_form].
   *
   * @return string
   */
  public function custom_image_upload_form_shortcode()
  {
    ob_start();
    ?>
    <form method="post" enctype="multipart/form-data">
      <label for="custom_image">Upload an Image:</label>
      <input type="file" name="custom_image" id="custom_image" />
      <input type="submit" value="Upload Image" />
    </form>
    <?php
    return ob_get_clean();
  }
}
