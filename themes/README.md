# Custom Themes Directory

This directory is for your custom WordPress themes. Themes placed here will be available in your WordPress installation under Appearance > Themes.

## Creating a New Theme

1. Create a new folder with your theme name
2. Add at least two files:
   - `style.css` (with theme header)
   - `index.php` (main template file)

### Basic Theme Structure

```
your-theme/
├── style.css          # Theme header and main styles
├── index.php          # Main template file
├── functions.php      # Theme functions (optional)
├── header.php         # Header template (optional)
├── footer.php         # Footer template (optional)
└── screenshot.png     # Theme preview image (optional)
```

### Example style.css header:

```css
/*
Theme Name: Your Theme Name
Description: Your theme description
Version: 1.0.0
Author: Your Name
*/
```

### Example index.php:

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article>
                    <h1><?php the_title(); ?></h1>
                    <div><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
```

## Learning Resources

- [WordPress Theme Developer Handbook](https://developer.wordpress.org/themes/)
- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Theme Development](https://codex.wordpress.org/Theme_Development)