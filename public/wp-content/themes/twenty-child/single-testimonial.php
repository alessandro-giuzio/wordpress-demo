<?php
get_header('testimonial');

if (have_posts()) :
  while (have_posts()) : the_post();
    // This is the single testimonial template
    the_title('<h1>', '</h1>');
    // Show the testimonial content
    the_content();

    // Show custom fields (if you have them)
    $name = get_post_meta(get_the_ID(), '_name', true);
    $company = get_post_meta(get_the_ID(), '_company', true);

    if ($name) {
      echo '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
    }
    if ($company) {
      echo '<p><strong>Company:</strong> ' . esc_html($company) . '</p>';
    }
  endwhile;
else :
  echo '<p>No testimonial found.</p>';
endif;

get_footer();
