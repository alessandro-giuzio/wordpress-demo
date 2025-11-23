<?php
get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    // This is the single testimonial template
    the_title('<h1>', '</h1>');
    // Show the testimonial content
    the_content();

    // Show custom fields (if you have them)
    $name = get_post_meta(get_the_ID(), '_name', true);
    $company = get_post_meta(get_the_ID(), '_company', true);
    $job = get_post_meta(get_the_ID(), '_job', true);

    if ($name) {
      echo '<div class="testimonial-meta">';
      echo '<p class="testimonial-name"><strong>Name:</strong> ' . esc_html($name) . '</p>';
    }
    if ($company) {
      echo '<p class="testimonial-company"><strong>Company:</strong> ' . esc_html($company) . '</p>';
    }
    if ($job) {
      echo '<p class="testimonial-job"><strong>Job:</strong> ' . esc_html($job) . '</p>';
    }
    echo '</div>';
  endwhile;
else :
  echo '<p>No testimonial found.</p>';
endif;
echo '</div>';

get_footer(name: 'testimonial');
