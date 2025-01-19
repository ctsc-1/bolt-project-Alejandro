<?php
    /*
    Plugin Name: Alejandro Plugin
    Description: Plugin de gestion des préférences utilisateurs
    Version: 1.0
    Author: Votre Nom
    */

    // Activation du plugin
    register_activation_hook(__FILE__, 'alejandro_create_tables');

    function alejandro_create_tables() {
      global $wpdb;
      
      $charset_collate = $wpdb->get_charset_collate();
      
      $sql = "CREATE TABLE {$wpdb->prefix}alejandro_users (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        username varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        password varchar(255) NOT NULL,
        PRIMARY KEY (id)
      ) $charset_collate;
      
      CREATE TABLE {$wpdb->prefix}alejandro_preferences (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id mediumint(9) NOT NULL,
        language varchar(50) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES {$wpdb->prefix}alejandro_users(id)
      ) $charset_collate;
      
      CREATE TABLE {$wpdb->prefix}alejandro_settings (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        plugin_name varchar(255) NOT NULL,
        plugin_version varchar(50) NOT NULL,
        PRIMARY KEY (id)
      ) $charset_collate;";
      
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }

    // Ajout du menu d'administration
    add_action('admin_menu', 'alejandro_add_admin_menu');

    function alejandro_add_admin_menu() {
      add_menu_page(
        'Alejandro Plugin',
        'Alejandro',
        'manage_options',
        'alejandro-plugin',
        'alejandro_admin_page',
        'dashicons-admin-users',
        6
      );
    }

    function alejandro_admin_page() {
      ?>
      <div class="wrap">
        <h1>Bienvenue sur Alejandro Plugin</h1>
        <div class="avatar">
          <img src="<?php echo plugins_url('avatar.png', __FILE__); ?>" alt="Avatar d'Alejandro" style="border-radius: 50%; width: 100px;">
        </div>
        <a href="<?php echo admin_url('admin.php?page=alejandro-settings'); ?>" class="button button-primary">Paramètres</a>
      </div>
      <?php
    }

    // Ajout de la page des paramètres
    add_action('admin_menu', 'alejandro_add_settings_page');

    function alejandro_add_settings_page() {
      add_submenu_page(
        'alejandro-plugin',
        'Paramètres',
        'Paramètres',
        'manage_options',
        'alejandro-settings',
        'alejandro_settings_page'
      );
    }

    function alejandro_settings_page() {
      ?>
      <div class="wrap">
        <h1>Paramètres du Plugin</h1>
        <form method="post" action="options.php">
          <?php
          settings_fields('alejandro_settings_group');
          do_settings_sections('alejandro-plugin');
          submit_button();
          ?>
        </form>
      </div>
      <?php
    }

    // Enregistrement des paramètres
    add_action('admin_init', 'alejandro_register_settings');

    function alejandro_register_settings() {
      register_setting('alejandro_settings_group', 'alejandro_plugin_name');
      register_setting('alejandro_settings_group', 'alejandro_plugin_version');
      
      add_settings_section(
        'alejandro_main_section',
        'Configuration Principale',
        null,
        'alejandro-plugin'
      );
      
      add_settings_field(
        'alejandro_plugin_name',
        'Nom du Plugin',
        'alejandro_plugin_name_callback',
        'alejandro-plugin',
        'alejandro_main_section'
      );
      
      add_settings_field(
        'alejandro_plugin_version',
        'Version du Plugin',
        'alejandro_plugin_version_callback',
        'alejandro-plugin',
        'alejandro_main_section'
      );
    }

    function alejandro_plugin_name_callback() {
      $setting = get_option('alejandro_plugin_name');
      echo '<input type="text" name="alejandro_plugin_name" value="' . esc_attr($setting) . '">';
    }

    function alejandro_plugin_version_callback() {
      $setting = get_option('alejandro_plugin_version');
      echo '<input type="text" name="alejandro_plugin_version" value="' . esc_attr($setting) . '">';
    }
    ?>
