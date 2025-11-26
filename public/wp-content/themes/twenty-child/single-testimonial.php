<?php

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    // Get custom field values
    $name = get_post_meta(get_the_ID(), '_name', true);
    $company = get_post_meta(get_the_ID(), '_company', true);
    $job = get_post_meta(get_the_ID(), '_job', true);
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>
      <div class="testimonial-content">
        <?php the_content(); ?>
      </div>
      <div class="testimonial-meta">
        <?php if ($name) : ?>
          <p class="testimonial-name"><strong>Name:</strong> <?php echo esc_html($name); ?></p>
        <?php endif; ?>
        <?php if ($company) : ?>
          <p class="testimonial-company"><strong>Company:</strong> <?php echo esc_html($company); ?></p>
        <?php endif; ?>
        <?php if ($job) : ?>
          <p class="testimonial-job"><strong>Job:</strong> <?php echo esc_html($job); ?></p>
        <?php endif; ?>
      </div>
    </article>
<?php
  endwhile;
endif;

get_footer();
