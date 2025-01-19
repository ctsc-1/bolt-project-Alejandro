<?php
    /*
    Plugin Name: Alejandro Plugin
    Description: Plugin de gestion des préférences utilisateurs
    Version: 1.0
    Author: Votre Nom
    */

    // [Code existant...]

    // Ajout du shortcode
    add_shortcode('alejandro_plugin', 'alejandro_frontend_display');

    function alejandro_frontend_display() {
      ob_start();
      ?>
      <div class="alejandro-plugin-front">
        <header class="alejandro-header">
          <h1>Bienvenue</h1>
          <p>Gérez vos préférences et paramètres</p>
        </header>
        
        <div class="alejandro-avatar">
          <img src="<?php echo plugins_url('avatar.png', __FILE__); ?>" alt="Avatar d'Alejandro">
        </div>
        
        <?php if (is_user_logged_in()): ?>
          <div class="alejandro-actions">
            <a href="<?php echo admin_url('admin.php?page=alejandro-settings'); ?>" class="alejandro-button">
              Mes Paramètres
            </a>
          </div>
        <?php else: ?>
          <div class="alejandro-login-notice">
            <p>Veuillez vous connecter pour accéder à vos paramètres.</p>
            <a href="<?php echo wp_login_url(); ?>" class="alejandro-button">
              Connexion
            </a>
          </div>
        <?php endif; ?>
      </div>
      <?php
      return ob_get_clean();
    }

    // Ajout des styles front-end
    add_action('wp_enqueue_scripts', 'alejandro_enqueue_frontend_styles');

    function alejandro_enqueue_frontend_styles() {
      wp_enqueue_style(
        'alejandro-frontend-style',
        plugins_url('css/frontend-style.css', __FILE__)
      );
    }
    ?>
