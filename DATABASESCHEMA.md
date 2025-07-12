-- ✅ 1. users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    phone_number VARCHAR(20),
    address TEXT,
    role BOOLEAN DEFAULT 0, -- 0 = client, 1 = admin
    google_user_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ✅ 2. device_types
CREATE TABLE device_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ✅ 3. device_brands
CREATE TABLE device_brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ✅ 4. device_models
CREATE TABLE device_models (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_type_id INT,
    device_brand_id INT,
    model_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (device_type_id) REFERENCES device_types(id),
    FOREIGN KEY (device_brand_id) REFERENCES device_brands(id)
);

-- ✅ 5. issue_categories
CREATE TABLE issue_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ✅ 6. issue_items
CREATE TABLE issue_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (issue_category_id, name),
    FOREIGN KEY (issue_category_id) REFERENCES issue_categories(id)
);

-- ✅ 7. service_packages
CREATE TABLE service_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_category_id INT,
    name VARCHAR(100) NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    description TEXT,
    estimated_duration VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_category_id) REFERENCES issue_categories(id)
);

-- ✅ 8. service_methods
CREATE TABLE service_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(100)
);

-- ✅ 9. status
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ✅ 10. order_steps
CREATE TABLE order_steps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    step_name ENUM('received', 'diagnosing', 'repairing', 'completed', 'delivered')
);

-- ✅ 11. orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_code VARCHAR(100) UNIQUE,
    device_type_id INT,
    device_model_id INT,
    serial_number VARCHAR(100),
    issue_category_id INT,
    detailed_problem TEXT,
    service_package_id INT,
    service_method_id INT,
    repair_urgency ENUM('low', 'medium', 'high'),
    total_cost DECIMAL(10,2),
    payment_status ENUM('paid', 'unpaid') DEFAULT 'unpaid',
    status_id INT,
    current_step_id INT,
    repair_image_before TEXT,
    repair_image_after TEXT,
    order_date DATE,
    complete_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (device_type_id) REFERENCES device_types(id),
    FOREIGN KEY (device_model_id) REFERENCES device_models(id),
    FOREIGN KEY (issue_category_id) REFERENCES issue_categories(id),
    FOREIGN KEY (service_package_id) REFERENCES service_packages(id),
    FOREIGN KEY (service_method_id) REFERENCES service_methods(id),
    FOREIGN KEY (status_id) REFERENCES status(id),
    FOREIGN KEY (current_step_id) REFERENCES order_steps(id)
);

-- ✅ 12. order_step_histories
CREATE TABLE order_step_histories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    step_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (step_id) REFERENCES order_steps(id)
);

-- ✅ 13. payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_code VARCHAR(100) UNIQUE,
    order_id INT,
    amount_paid DECIMAL(10,2),
    status ENUM('completed', 'not yet'),
    payment_method ENUM('cash', 'bank_transfer'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- ✅ 14. part_categories
CREATE TABLE part_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    supplier VARCHAR(255),
    location VARCHAR(255)
);

-- ✅ 15. parts
CREATE TABLE parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    part_category_id INT,
    stock_quantity INT,
    stock_status ENUM('in_stock', 'out_of_stock'),
    stock_price DECIMAL(10,2),
    unit_cost DECIMAL(10,2),
    selling_price DECIMAL(10,2),
    FOREIGN KEY (part_category_id) REFERENCES part_categories(id)
);

-- ✅ 16. order_parts
CREATE TABLE order_parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    part_id INT,
    quantity_used INT,
    unit_cost DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (part_id) REFERENCES parts(id)
);

-- ✅ 17. notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type VARCHAR(50),
    title VARCHAR(255),
    message TEXT,
    link_to VARCHAR(255),
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
