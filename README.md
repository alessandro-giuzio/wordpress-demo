# WordPress Plugin Development Environment

A complete Docker-based WordPress development environment designed for learning WordPress plugin development.

## 🚀 Quick Start

1. **Clone this repository**
   ```bash
   git clone https://github.com/alessandro-giuzio/wordpress-demo.git
   cd wordpress-demo
   ```

2. **Start the development environment**
   ```bash
   docker compose up -d
   ```

3. **Access your WordPress site**
   - WordPress: http://localhost:8080
   - phpMyAdmin: http://localhost:8081 (for database management)

4. **Complete WordPress setup**
   - Follow the WordPress installation wizard
   - Create your admin user
   - Log in to the WordPress admin dashboard

## 📁 Project Structure

```
wordpress-demo/
├── docker-compose.yml          # Docker services configuration
├── .env                        # Environment variables
├── .env.example               # Example environment file
├── .gitignore                 # Git ignore rules
├── plugins/                   # Custom plugins directory
│   └── my-first-plugin/       # Example learning plugin
│       ├── my-first-plugin.php
│       ├── README.md
│       └── assets/
│           ├── style.css
│           └── script.js
└── themes/                    # Custom themes directory
```

## 🛠 Services

This environment includes:

- **WordPress 6.4**: Latest WordPress with Apache
- **MySQL 8.0**: Database server
- **phpMyAdmin**: Web-based database administration

## 🔧 Development Features

### Custom Plugin Development
- The `plugins/` directory is mounted to WordPress for immediate development
- Includes a comprehensive example plugin: "My First Plugin"
- Live reload - changes are reflected immediately

### Custom Theme Development
- The `themes/` directory is mounted for custom theme development
- Create your themes in the `themes/` folder

### Database Access
- Direct database access via phpMyAdmin at http://localhost:8081
- Credentials: root/rootpassword or wordpress/wordpress

## 📚 Learning Resources

### Included Example Plugin: "My First Plugin"

Located in `plugins/my-first-plugin/`, this plugin demonstrates:

- ✅ **Plugin Structure**: Proper organization and headers
- ✅ **WordPress Hooks**: Actions and filters
- ✅ **Asset Management**: CSS/JS enqueuing
- ✅ **Shortcodes**: Custom shortcode implementation
- ✅ **Admin Interface**: Settings pages
- ✅ **AJAX Functionality**: Frontend/backend communication
- ✅ **Database Options**: Settings storage
- ✅ **Security Best Practices**: Nonces and sanitization
- ✅ **Plugin Lifecycle**: Activation/deactivation/uninstall

### Getting Started with Plugin Development

1. **Activate the example plugin**
   - Go to Plugins in WordPress admin
   - Activate "My First Plugin"
   - Visit Settings > My First Plugin

2. **Test the shortcode**
   - Create a new post/page
   - Add `[hello_world]` or `[hello_world name="Your Name"]`
   - View the post to see the shortcode in action

3. **Explore the code**
   - Study `plugins/my-first-plugin/my-first-plugin.php`
   - Read the inline comments and documentation
   - Modify the code and see changes immediately

## 🎯 Plugin Development Workflow

1. **Create a new plugin**
   ```bash
   mkdir plugins/your-plugin-name
   touch plugins/your-plugin-name/your-plugin-name.php
   ```

2. **Add the plugin header**
   ```php
   <?php
   /**
    * Plugin Name: Your Plugin Name
    * Description: Your plugin description
    * Version: 1.0.0
    * Author: Your Name
    */
   
   // Prevent direct access
   if (!defined('ABSPATH')) {
       exit;
   }
   ```

3. **Develop and test**
   - Add your plugin code
   - Test in the WordPress admin
   - Use browser dev tools for debugging

4. **Use WordPress hooks**
   ```php
   add_action('init', 'your_function');
   add_filter('the_content', 'your_filter_function');
   ```

## 🔍 Debugging and Development Tools

### WordPress Debug Mode
Add these to your wp-config.php for debugging:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Useful WordPress Functions
- `error_log()`: Log debug messages
- `wp_die()`: Stop execution with message
- `var_dump()`: Inspect variables
- `wp_enqueue_script()`: Add JavaScript
- `wp_enqueue_style()`: Add CSS

### Browser Developer Tools
- Use Console for JavaScript debugging
- Network tab for AJAX requests
- Elements tab for CSS debugging

## 📖 WordPress Plugin Development Concepts

### Essential Hooks
- `init`: Initialize your plugin
- `wp_enqueue_scripts`: Load CSS/JS files
- `admin_menu`: Add admin menu items
- `save_post`: Run when posts are saved
- `wp_head`: Add content to HTML head

### Security Best Practices
- Always sanitize user input
- Use nonces for form security
- Validate and escape output
- Check user capabilities
- Prevent direct file access

### Plugin Structure Best Practices
- Use classes to organize code
- Separate concerns (admin, frontend, etc.)
- Follow WordPress coding standards
- Document your code
- Handle errors gracefully

## 🚦 Common Commands

```bash
# Start the environment
docker compose up -d

# Stop the environment
docker compose down

# View logs
docker compose logs wordpress

# Restart services
docker compose restart

# Update containers
docker compose pull && docker compose up -d
```

## 🛡 Security Notes

- This is a development environment only
- Default passwords are used - change them for production
- The `.env` file contains sensitive information
- Never commit `.env` files to version control

## 🤝 Contributing

Feel free to:
- Add more example plugins
- Improve documentation
- Share learning resources
- Report issues or suggestions

## 📄 License

This project is open source and available under the [MIT License](LICENSE).