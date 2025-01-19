import Database from 'better-sqlite3';

    const db = new Database('plugin.db');

    // Créer les tables si elles n'existent pas
    db.exec(`
      CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT,
        email TEXT,
        password TEXT
      );
      
      CREATE TABLE IF NOT EXISTS preferences (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        language TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
      );
      
      CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        plugin_name TEXT,
        plugin_version TEXT
      );
    `);

    const parametresButton = document.getElementById('parametres');

    parametresButton.addEventListener('click', () => {
      // Ouvrir les paramètres
      console.log('Ouvrir les paramètres');
    });
