<?php
// Direct database access to create an admin user
try {
    $db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if users table exists
    $checkTable = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if ($checkTable->fetch()) {
        echo "Users table exists.\n";
        
        // Check current users
        $users = $db->query("SELECT id, name, email FROM users");
        $userCount = 0;
        echo "\nExisting users:\n";
        while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
            echo "  - ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}\n";
            $userCount++;
        }
        
        if ($userCount == 0) {
            echo "\nNo users found. Creating admin user...\n";
            
            // Create admin user with bcrypt password hash for "password"
            $email = 'admin@admin.com';
            $name = 'Admin User';
            // This is bcrypt hash of "password"
            $password = '$2y$12$LQv3c1yqBWVHxkbVPk1PY.94QXoZB7RAQBxZjqzL1TfRBJW6VaZ9i';
            
            $stmt = $db->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, datetime('now'), datetime('now'))");
            $stmt->execute([$name, $email, $password]);
            
            echo "✓ Admin user created successfully!\n";
            echo "  Email: {$email}\n";
            echo "  Password: password\n";
        } else {
            echo "\nUsers already exist in database.\n";
        }
    } else {
        echo "ERROR: Users table does not exist. Database migrations need to be run.\n";
        
        // List all tables
        echo "\nAvailable tables:\n";
        $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
        while ($table = $tables->fetch()) {
            echo "  - {$table['name']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}
