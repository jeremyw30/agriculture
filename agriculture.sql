CREATE TABLE users(
   id_user INT,
   email VARCHAR(100) NOT NULL,
   roles VARCHAR(50) NOT NULL,
   surname VARCHAR(50) NOT NULL,
   zone VARCHAR(100) NOT NULL,
   balance DECIMAL(15,2) NOT NULL,
   created_at DATETIME NOT NULL,
   updated_at DATETIME,
   password VARCHAR(250) NOT NULL,
   PRIMARY KEY(id_user)
);

CREATE TABLE parcelles(
   id_parcelle INT,
   name VARCHAR(100) NOT NULL,
   surface_hectare DECIMAL(15,2) NOT NULL,
   type_sol VARCHAR(100) NOT NULL,
   inclinaison DECIMAL(15,2) NOT NULL,
   drainage VARCHAR(100) NOT NULL,
   base_price DECIMAL(15,2) NOT NULL,
   created_at DATE NOT NULL,
   quality VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_parcelle)
);

CREATE TABLE batiments(
   id_batiment INT,
   name VARCHAR(100) NOT NULL,
   type VARCHAR(100) NOT NULL,
   surface_m2 DECIMAL(15,2) NOT NULL,
   storage_capacity INT,
   base_price DECIMAL(15,2) NOT NULL,
   condition_status VARCHAR(50),
   created_at DATE,
   animal_capacity INT NOT NULL,
   PRIMARY KEY(id_batiment)
);

CREATE TABLE machines(
   id_machine INT,
   name VARCHAR(100) NOT NULL,
   brand VARCHAR(50),
   model VARCHAR(50),
   year_manufactured INT,
   power_hp INT,
   fuel_consumption DECIMAL(15,2),
   base_price DECIMAL(15,2) NOT NULL,
   condition_status VARCHAR(50) NOT NULL,
   created_at DATE,
   PRIMARY KEY(id_machine)
);

CREATE TABLE animaux(
   id_animaux INT,
   type VARCHAR(50) NOT NULL,
   base_weight_kg DECIMAL(15,2) NOT NULL,
   base_price DECIMAL(15,2) NOT NULL,
   average_productivity DECIMAL(15,2),
   health_profile VARCHAR(100),
   reproduction_cycle_days INT NOT NULL,
   created_at DATE,
   breed VARCHAR(50) NOT NULL,
   gender VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_animaux)
);

CREATE TABLE user_parcelles(
   id_user_parcelle INT,
   custom_name VARCHAR(100),
   current_crop VARCHAR(50),
   expected_harvest_at DATE,
   id_user INT NOT NULL,
   id_parcelle INT,
   PRIMARY KEY(id_user_parcelle),
   UNIQUE(current_crop),
   UNIQUE(expected_harvest_at),
   FOREIGN KEY(id_user) REFERENCES users(id_user),
   FOREIGN KEY(id_parcelle) REFERENCES parcelles(id_parcelle)
);

CREATE TABLE user_machines(
   id_user_machine INT,
   user_id INT NOT NULL,
   machine_id INT NOT NULL,
   custom_name VARCHAR(100),
   acquired_at DATE NOT NULL,
   fuel_level DECIMAL(15,2),
   last_maintenance_at DATE,
   is_active LOGICAL,
   id_machine INT NOT NULL,
   PRIMARY KEY(id_user_machine),
   UNIQUE(last_maintenance_at),
   UNIQUE(is_active),
   FOREIGN KEY(id_machine) REFERENCES machines(id_machine)
);

CREATE TABLE user_batiments(
   id_user_batiment INT,
   custom_name VARCHAR(100),
   current_occupancy INT,
   stored_quantity DECIMAL(15,2),
   is_active LOGICAL,
   id_user INT NOT NULL,
   id_batiment INT NOT NULL,
   PRIMARY KEY(id_user_batiment),
   FOREIGN KEY(id_user) REFERENCES users(id_user),
   FOREIGN KEY(id_batiment) REFERENCES batiments(id_batiment)
);

CREATE TABLE _parcelle_activities(
   id_parcelle INT,
   activity_type VARCHAR(50) NOT NULL,
   description VARCHAR(250) NOT NULL,
   cost DECIMAL(15,2),
   revenue DECIMAL(15,2),
   crop_type VARCHAR(50),
   quantity_planted DECIMAL(15,2),
   quantity_harvested DECIMAL(15,2),
   id_user_machine INT,
   id_user_parcelle INT NOT NULL,
   PRIMARY KEY(id_parcelle),
   FOREIGN KEY(id_user_machine) REFERENCES user_machines(id_user_machine),
   FOREIGN KEY(id_user_parcelle) REFERENCES user_parcelles(id_user_parcelle)
);

CREATE TABLE batiment_activities_(
   Id_batiment_activities_ COUNTER,
   activity_type VARCHAR(50) NOT NULL,
   description_ TEXT NOT NULL,
   cost DECIMAL(15,2) NOT NULL,
   animals_count INT NOT NULL,
   contractor_name VARCHAR(100) NOT NULL,
   materials_used TEXT NOT NULL,
   created_at DATE NOT NULL,
   id_user_batiment INT NOT NULL,
   PRIMARY KEY(Id_batiment_activities_),
   FOREIGN KEY(id_user_batiment) REFERENCES user_batiments(id_user_batiment)
);

CREATE TABLE machine_activities_(
   Id_machine_activities_ COUNTER,
   activity_tpe VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   cost DECIMAL(15,2) NOT NULL,
   hours_used DECIMAL(15,2) NOT NULL,
   mechanic_name VARCHAR(100) NOT NULL,
   parts_replaced VARCHAR(50) NOT NULL,
   next_maintenance_due DATE NOT NULL,
   created_at DATE NOT NULL,
   fuel_consumed DECIMAL(15,2) NOT NULL,
   id_user_machine INT NOT NULL,
   PRIMARY KEY(Id_machine_activities_),
   FOREIGN KEY(id_user_machine) REFERENCES user_machines(id_user_machine)
);

CREATE TABLE hotel_ventes(
   Id_hotel_ventes COUNTER,
   item_type VARCHAR(50) NOT NULL,
   item_id INT NOT NULL,
   asking_price DECIMAL(15,2) NOT NULL,
   final_price DECIMAL(15,2),
   title TEXT NOT NULL,
   is_sold LOGICAL,
   is_active LOGICAL,
   created_at DATE NOT NULL,
   sold_at DATE NOT NULL,
   id_user INT NOT NULL,
   id_user_1 INT NOT NULL,
   PRIMARY KEY(Id_hotel_ventes),
   UNIQUE(final_price),
   FOREIGN KEY(id_user) REFERENCES users(id_user),
   FOREIGN KEY(id_user_1) REFERENCES users(id_user)
);

CREATE TABLE user_animaux(
   id_user_animaux INT,
   user_id INT NOT NULL,
   current_location_type VARCHAR(100),
   is_active VARCHAR(50),
   animal_id INT NOT NULL,
   custom_name VARCHAR(100),
   id_user_batiment INT,
   id_user_parcelle INT,
   id_animaux INT,
   id_user INT NOT NULL,
   PRIMARY KEY(id_user_animaux),
   FOREIGN KEY(id_user_batiment) REFERENCES user_batiments(id_user_batiment),
   FOREIGN KEY(id_user_parcelle) REFERENCES user_parcelles(id_user_parcelle),
   FOREIGN KEY(id_animaux) REFERENCES animaux(id_animaux),
   FOREIGN KEY(id_user) REFERENCES users(id_user)
);

CREATE TABLE animal_activities(
   id_animal_activity INT,
   description VARCHAR(100) NOT NULL,
   cost DECIMAL(15,2) NOT NULL,
   revenue DECIMAL(15,2) NOT NULL,
   veterinarian_name VARCHAR(100) NOT NULL,
   created_at DATE NOT NULL,
   id_user_machine INT,
   id_user_batiment INT NOT NULL,
   id_user_parcelle INT NOT NULL,
   id_user_animaux INT NOT NULL,
   PRIMARY KEY(id_animal_activity),
   FOREIGN KEY(id_user_machine) REFERENCES user_machines(id_user_machine),
   FOREIGN KEY(id_user_batiment) REFERENCES user_batiments(id_user_batiment),
   FOREIGN KEY(id_user_parcelle) REFERENCES user_parcelles(id_user_parcelle),
   FOREIGN KEY(id_user_animaux) REFERENCES user_animaux(id_user_animaux)
);

CREATE TABLE transactions(
   Id_transactions COUNTER,
   transaction_type VARCHAR(50) NOT NULL,
   category VARCHAR(50) NOT NULL,
   amount DECIMAL(15,2) NOT NULL,
   description TEXT NOT NULL,
   invoice_number VARCHAR(50),
   created_at DATE NOT NULL,
   id_parcelle INT NOT NULL,
   Id_batiment_activities_ INT NOT NULL,
   Id_machine_activities_ INT NOT NULL,
   id_animal_activity INT NOT NULL,
   Id_hotel_ventes INT NOT NULL,
   id_user INT,
   PRIMARY KEY(Id_transactions),
   UNIQUE(invoice_number),
   FOREIGN KEY(id_parcelle) REFERENCES _parcelle_activities(id_parcelle),
   FOREIGN KEY(Id_batiment_activities_) REFERENCES batiment_activities_(Id_batiment_activities_),
   FOREIGN KEY(Id_machine_activities_) REFERENCES machine_activities_(Id_machine_activities_),
   FOREIGN KEY(id_animal_activity) REFERENCES animal_activities(id_animal_activity),
   FOREIGN KEY(Id_hotel_ventes) REFERENCES hotel_ventes(Id_hotel_ventes),
   FOREIGN KEY(id_user) REFERENCES users(id_user)
);
