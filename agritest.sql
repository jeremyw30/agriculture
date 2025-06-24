-- Schéma complet de la base de données pour le système d'exploitation agricole




CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    balance DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
);

CREATE TABLE animals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL, -- vache, porc, mouton, poule, etc.
    race VARCHAR(50),
    age_months INT,
    weight_kg DECIMAL(6,2),
    gender ENUM('male', 'female') NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    health_status ENUM('healthy', 'sick', 'critical') DEFAULT 'healthy',
    productivity_rate DECIMAL(5,2) DEFAULT 100.00, -- pourcentage de productivité
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE parcelles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    surface_hectares DECIMAL(8,2) NOT NULL,
    type_sol ENUM('argile', 'sable', 'limon', 'calcaire', 'terre_noire') NOT NULL,
    location VARCHAR(100),
    fertility_level ENUM('faible', 'moyenne', 'bonne', 'excellente') DEFAULT 'moyenne',
    base_price DECIMAL(12,2) NOT NULL,
    max_animals_capacity INT DEFAULT 0, -- capacité de pâturage
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE batiments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type ENUM('grange', 'etable', 'hangar', 'silo', 'poulailler', 'porcherie') NOT NULL,
    surface_m2 DECIMAL(8,2) NOT NULL,
    animal_capacity INT DEFAULT 0, -- capacité d'animaux
    storage_capacity INT DEFAULT 0, -- capacité de stockage en tonnes
    base_price DECIMAL(12,2) NOT NULL,
    condition_status ENUM('excellent', 'good', 'fair', 'poor') DEFAULT 'good',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE machines (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type ENUM('tracteur', 'moissonneuse', 'semoir', 'charrue', 'pulverisateur', 'remorque') NOT NULL,
    brand VARCHAR(50),
    model VARCHAR(50),
    year_manufactured INT,
    power_hp INT, -- puissance en chevaux
    fuel_consumption DECIMAL(5,2), -- consommation par heure
    base_price DECIMAL(12,2) NOT NULL,
    condition_status ENUM('excellent', 'good', 'fair', 'poor') DEFAULT 'good',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- HOTEL DES VENTES
-- ===========================

CREATE TABLE hotel_ventes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_type ENUM('animal', 'machine', 'parcelle', 'batiment') NOT NULL,
    item_id INT NOT NULL,
    seller_id INT,
    buyer_id INT NULL,
    asking_price DECIMAL(12,2) NOT NULL,
    final_price DECIMAL(12,2) NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    is_sold BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sold_at TIMESTAMP NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_item_type_id (item_type, item_id),
    INDEX idx_seller (seller_id),
    INDEX idx_active_sales (is_active, is_sold)
);

-- ===========================
-- TABLES DE POSSESSION
-- ===========================

CREATE TABLE user_animals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    animal_id INT NOT NULL,
    custom_name VARCHAR(100),
    acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    acquisition_price DECIMAL(10,2) NOT NULL,
    current_location_type ENUM('parcelle', 'batiment', 'marche') DEFAULT 'parcelle',
    current_parcelle_id INT NULL,
    current_batiment_id INT NULL,
    is_active BOOLEAN DEFAULT TRUE, -- false si vendu ou mort
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (current_parcelle_id) REFERENCES user_parcelles(id) ON DELETE SET NULL,
    FOREIGN KEY (current_batiment_id) REFERENCES user_batiments(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_animal (user_id, animal_id),
    INDEX idx_user_active (user_id, is_active)
    
);

CREATE TABLE user_parcelles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    parcelle_id INT NOT NULL,
    custom_name VARCHAR(100),
    acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    acquisition_price DECIMAL(12,2) NOT NULL,
    current_crop VARCHAR(50) NULL,
    crop_planted_at TIMESTAMP NULL,
    expected_harvest_at TIMESTAMP NULL,
    current_animals_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parcelle_id) REFERENCES parcelles(id),
    UNIQUE KEY unique_user_parcelle (user_id, parcelle_id),
    INDEX idx_user_active (user_id, is_active)
);

CREATE TABLE user_batiments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    batiment_id INT NOT NULL,
    custom_name VARCHAR(100),
    acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    acquisition_price DECIMAL(12,2) NOT NULL,
    current_occupancy INT DEFAULT 0,
    stored_quantity DECIMAL(10,2) DEFAULT 0, -- quantité stockée
    last_maintenance_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (batiment_id) REFERENCES batiments(id),
    UNIQUE KEY unique_user_batiment (user_id, batiment_id),
    INDEX idx_user_active (user_id, is_active)
);

CREATE TABLE user_machines (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    machine_id INT NOT NULL,
    custom_name VARCHAR(100),
    acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    acquisition_price DECIMAL(12,2) NOT NULL,
    total_hours_used DECIMAL(8,2) DEFAULT 0,
    fuel_level DECIMAL(5,2) DEFAULT 100.00, -- niveau de carburant en %
    last_maintenance_at TIMESTAMP NULL,
    next_maintenance_hours DECIMAL(8,2) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (machine_id) REFERENCES machines(id),
    UNIQUE KEY unique_user_machine (user_id, machine_id),
    INDEX idx_user_active (user_id, is_active)
);

-- ===========================
-- TABLES D'ACTIVITÉS
-- ===========================

CREATE TABLE animal_activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_animal_id INT NOT NULL,
    activity_type ENUM('soins', 'deplacement', 'reproduction', 'vente', 'alimentation', 'vaccination', 'tonte') NOT NULL,
    description TEXT,
    cost DECIMAL(8,2) DEFAULT 0,
    revenue DECIMAL(8,2) DEFAULT 0, -- pour les ventes, productions
    quantity DECIMAL(8,2) NULL, -- quantité de lait, œufs, laine, etc.
    target_parcelle_id INT NULL,
    target_batiment_id INT NULL,
    machine_used_id INT NULL,
    veterinarian_name VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_animal_id) REFERENCES user_animals(id) ON DELETE CASCADE,
    FOREIGN KEY (target_parcelle_id) REFERENCES user_parcelles(id) ON DELETE SET NULL,
    FOREIGN KEY (target_batiment_id) REFERENCES user_batiments(id) ON DELETE SET NULL,
    FOREIGN KEY (machine_used_id) REFERENCES user_machines(id) ON DELETE SET NULL,
    INDEX idx_user_animal (user_animal_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);

CREATE TABLE parcelle_activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_parcelle_id INT NOT NULL,
    activity_type ENUM('semis', 'recolte', 'traitement', 'labour', 'paturage', 'irrigation', 'fertilisation') NOT NULL,
    description TEXT,
    cost DECIMAL(8,2) DEFAULT 0,
    revenue DECIMAL(8,2) DEFAULT 0, -- pour les récoltes
    crop_type VARCHAR(50) NULL,
    quantity_planted DECIMAL(8,2) NULL, -- en kg ou unités
    quantity_harvested DECIMAL(8,2) NULL,
    machine_used_id INT NULL,
    weather_conditions VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_parcelle_id) REFERENCES user_parcelles(id) ON DELETE CASCADE,
    FOREIGN KEY (machine_used_id) REFERENCES user_machines(id) ON DELETE SET NULL,
    INDEX idx_user_parcelle (user_parcelle_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);

CREATE TABLE machine_activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_machine_id INT NOT NULL,
    activity_type ENUM('maintenance', 'reparation', 'utilisation', 'ravitaillement') NOT NULL,
    description TEXT,
    cost DECIMAL(8,2) DEFAULT 0,
    hours_used DECIMAL(5,2) NULL,
    fuel_consumed DECIMAL(6,2) NULL, -- litres de carburant
    mechanic_name VARCHAR(100) NULL,
    parts_replaced TEXT NULL, -- pièces remplacées
    next_maintenance_due TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_machine_id) REFERENCES user_machines(id) ON DELETE CASCADE,
    INDEX idx_user_machine (user_machine_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);

CREATE TABLE batiment_activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_batiment_id INT NOT NULL,
    activity_type ENUM('renovation', 'nettoyage', 'stockage', 'hebergement', 'reparation', 'desinfection') NOT NULL,
    description TEXT,
    cost DECIMAL(8,2) DEFAULT 0,
    animals_count INT NULL,
    storage_quantity DECIMAL(10,2) NULL, -- quantité stockée/retirée
    contractor_name VARCHAR(100) NULL,
    materials_used TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_batiment_id) REFERENCES user_batiments(id) ON DELETE CASCADE,
    INDEX idx_user_batiment (user_batiment_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);

-- ===========================
-- TRANSACTIONS FINANCIÈRES
-- ===========================

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    transaction_type ENUM('achat', 'vente', 'depense', 'revenu', 'maintenance', 'production') NOT NULL,
    category ENUM('animaux', 'parcelles', 'batiments', 'machines', 'semences', 'carburant', 'veterinaire', 'autres') NOT NULL,
    amount DECIMAL(12,2) NOT NULL, -- positif pour revenus, négatif pour dépenses
    description TEXT NOT NULL,
    reference_table VARCHAR(50) NULL,
    reference_id INT NULL,
    invoice_number VARCHAR(50) NULL,
    payment_method ENUM('cash', 'bank_transfer', 'check', 'credit') DEFAULT 'cash',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_type (user_id, transaction_type),
    INDEX idx_user_date (user_id, created_at),
    INDEX idx_category (category)
);

-- ===========================
-- ÉVÉNEMENTS ET ALERTES
-- ===========================

CREATE TABLE user_alerts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    alert_type ENUM('maintenance', 'sante_animal', 'recolte', 'stock_bas', 'meteo', 'finance') NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    is_read BOOLEAN DEFAULT FALSE,
    is_resolved BOOLEAN DEFAULT FALSE,
    reference_table VARCHAR(50) NULL,
    reference_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_unread (user_id, is_read),
    INDEX idx_user_priority (user_id, priority)
);

-- ===========================
-- CONFIGURATION ET PARAMÈTRES
-- ===========================

CREATE TABLE game_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===========================
-- TRIGGERS POUR MISE À JOUR AUTOMATIQUE
-- ===========================

DELIMITER //

-- Trigger pour mettre à jour le solde utilisateur lors des transactions
CREATE TRIGGER update_user_balance_after_transaction
    AFTER INSERT ON transactions
    FOR EACH ROW
BEGIN
    UPDATE users
    SET balance = balance + NEW.amount,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = NEW.user_id;
END//

-- Trigger pour créer une transaction lors d'un achat
CREATE TRIGGER create_transaction_on_purchase
    AFTER UPDATE ON hotel_ventes
    FOR EACH ROW
BEGIN
    IF NEW.is_sold = TRUE AND OLD.is_sold = FALSE THEN
        INSERT INTO transactions (user_id, transaction_type, category, amount, description, reference_table, reference_id)
        VALUES (NEW.buyer_id, 'achat',
                CASE NEW.item_type
                    WHEN 'animal' THEN 'animaux'
                    WHEN 'parcelle' THEN 'parcelles'
                    WHEN 'batiment' THEN 'batiments'
                    WHEN 'machine' THEN 'machines'
                END,
                -NEW.final_price,
                CONCAT('Achat ', NEW.item_type, ' - ', NEW.title),
                'hotel_ventes', NEW.id);
       
        INSERT INTO transactions (user_id, transaction_type, category, amount, description, reference_table, reference_id)
        VALUES (NEW.seller_id, 'vente',
                CASE NEW.item_type
                    WHEN 'animal' THEN 'animaux'
                    WHEN 'parcelle' THEN 'parcelles'
                    WHEN 'batiment' THEN 'batiments'
                    WHEN 'machine' THEN 'machines'
                END,
                NEW.final_price,
                CONCAT('Vente ', NEW.item_type, ' - ', NEW.title),
                'hotel_ventes', NEW.id);
    END IF;
END//

DELIMITER ;

-- ===========================
-- DONNÉES INITIALES
-- ===========================

INSERT INTO game_settings (setting_key, setting_value, description) VALUES
('starting_balance', '10000.00', 'Solde de départ pour nouveaux utilisateurs'),
('maintenance_alert_threshold', '30', 'Jours avant maintenance pour déclencher alerte'),
('max_animals_per_parcelle', '50', 'Nombre maximum d animaux par hectare'),
('fuel_price_per_liter', '1.45', 'Prix du carburant par litre'),
('veterinarian_base_cost', '50.00', 'Coût de base visite vétérinaire');