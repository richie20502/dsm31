-- Table UserTypes
CREATE TABLE UserTypes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

-- Table Users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    Last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    Address VARCHAR(255),
    user_type_id INT,
    FOREIGN KEY (user_type_id) REFERENCES user_types(id)
);

-- Table ProductCategories
CREATE TABLE product_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

-- Table Suppliers
CREATE TABLE suppliers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255)
);

-- Table Products
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    category_id INT,
    supplier_id INT,
    FOREIGN KEY (category_id) REFERENCES product_categories(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- Table Sales
CREATE TABLE sales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATETIME NOT NULL,
    user_id INT,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table SalesDetails
CREATE TABLE sales_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sale_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Table Inventory
CREATE TABLE inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    quantity INT NOT NULL,
    last_updated DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);


INSERT INTO gestion.suppliers (name, contact, phone, email, address)
VALUES
('Proveedor Uno', 'Juan Pérez', '555-0101', 'juan.perez@proveedoruno.com', 'Calle Falsa 123'),
('Proveedor Dos', 'Laura Gómez', '555-0102', 'laura.gomez@proveedordos.com', 'Avenida Siempre Viva 456'),
('Proveedor Tres', 'Carlos Ruiz', '555-0103', 'carlos.ruiz@proveedortres.com', 'Camino Largo 789'),
('Proveedor Cuatro', 'Ana Torres', '555-0104', 'ana.torres@proveedorcuatro.com', 'Plaza Central 101'),
('Proveedor Cinco', 'Luis Molina', '555-0105', 'luis.molina@proveedorcinco.com', 'Sector 5 202'),
('Proveedor Seis', 'Sofía Castro', '555-0106', 'sofia.castro@proveedorseis.com', 'Ruta Norte 303'),
('Proveedor Siete', 'Marco Antonio', '555-0107', 'marco.antonio@proveedorsiete.com', 'Bulevar del Este 404'),
('Proveedor Ocho', 'Patricia Solano', '555-0108', 'patricia.solano@proveedorocho.com', 'Ronda Sur 505'),
('Proveedor Nueve', 'Jorge Vargas', '555-0109', 'jorge.vargas@proveedornueve.com', 'Diagonal 10 606'),
('Proveedor Diez', 'Mónica Linares', '555-0110', 'monica.linares@proveedordiez.com', 'Pasaje del Río 707');



INSERT INTO gestion.products (name, description, price, stock, category_id, supplier_id)
VALUES
('Producto001', 'Descripción de Producto 001', 10.5, 20, 1, 1),
('Producto002', 'Descripción de Producto 002', 20.0, 15, 2, 2),
('Producto003', 'Descripción de Producto 003', 15.5, 10, 3, 3),
('Producto004', 'Descripción de Producto 004', 22.5, 5, 4, 4),
('Producto005', 'Descripción de Producto 005', 18.7, 25, 1, 5),
('Producto006', 'Descripción de Producto 006', 19.3, 30, 2, 6),
('Producto007', 'Descripción de Producto 007', 21.0, 35, 3, 7),
('Producto008', 'Descripción de Producto 008', 17.8, 40, 4, 8),
('Producto009', 'Descripción de Producto 009', 16.2, 45, 1, 9),
('Producto010', 'Descripción de Producto 010', 20.1, 50, 2, 10),
('Producto011', 'Descripción de Producto 011', 23.4, 22, 3, 1),
('Producto012', 'Descripción de Producto 012', 24.5, 18, 4, 2),
('Producto013', 'Descripción de Producto 013', 25.6, 14, 1, 3),
('Producto014', 'Descripción de Producto 014', 26.7, 10, 2, 4),
('Producto015', 'Descripción de Producto 015', 27.8, 6, 3, 5),
('Producto016', 'Descripción de Producto 016', 28.9, 8, 4, 6),
('Producto017', 'Descripción de Producto 017', 30.0, 12, 1, 7),
('Producto018', 'Descripción de Producto 018', 35.1, 16, 2, 8),
('Producto019', 'Descripción de Producto 019', 40.2, 20, 3, 9),
('Producto020', 'Descripción de Producto 020', 45.3, 24, 4, 10),
('Producto021', 'Descripción de Producto 021', 50.4, 28, 1, 1),
('Producto022', 'Descripción de Producto 022', 55.5, 32, 2, 2),
('Producto023', 'Descripción de Producto 023', 60.6, 36, 3, 3),
('Producto024', 'Descripción de Producto 024', 65.7, 40, 4, 4),
('Producto025', 'Descripción de Producto 025', 70.8, 44, 1, 5),
('Producto026', 'Descripción de Producto 026', 75.9, 48, 2, 6),
('Producto027', 'Descripción de Producto 027', 80.0, 52, 3, 7),
('Producto028', 'Descripción de Producto 028', 85.1, 56, 4, 8),
('Producto029', 'Descripción de Producto 029', 90.2, 60, 1, 9),
('Producto030', 'Descripción de Producto 030', 95.3, 64, 2, 10),
('Producto031', 'Descripción de Producto 031', 100.4, 68, 3, 1),
('Producto032', 'Descripción de Producto 032', 105.5, 72, 4, 2),
('Producto033', 'Descripción de Producto 033', 110.6, 76, 1, 3),
('Producto034', 'Descripción de Producto 034', 115.7, 80, 2, 4),
('Producto035', 'Descripción de Producto 035', 120.8, 84, 3, 5),
('Producto036', 'Descripción de Producto 036', 125.9, 88, 4, 6),
('Producto037', 'Descripción de Producto 037', 130.0, 92, 1, 7),
('Producto038', 'Descripción de Producto 038', 135.1, 96, 2, 8),
('Producto039', 'Descripción de Producto 039', 140.2, 100, 3, 9),
('Producto040', 'Descripción de Producto 040', 145.3, 104, 4, 10),
('Producto041', 'Descripción de Producto 041', 150.4, 108, 1, 1),
('Producto042', 'Descripción de Producto 042', 155.5, 112, 2, 2),
('Producto043', 'Descripción de Producto 043', 160.6, 116, 3, 3),
('Producto044', 'Descripción de Producto 044', 165.7, 120, 4, 4),
('Producto045', 'Descripción de Producto 045', 170.8, 124, 1, 5),
('Producto046', 'Descripción de Producto 046', 175.9, 128, 2, 6),
('Producto047', 'Descripción de Producto 047', 180.0, 132, 3, 7),
('Producto048', 'Descripción de Producto 048', 185.1, 136, 4, 8),
('Producto049', 'Descripción de Producto 049', 190.2, 140, 1, 9),
('Producto050', 'Descripción de Producto 050', 195.3, 144, 2, 10);
