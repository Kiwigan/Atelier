use atelier;


CREATE TABLE perfumes (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    product_price DECIMAL(10, 2) NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    product_details TEXT,
    product_rating TINYINT CHECK (product_rating >= 1 AND product_rating <= 5),
    gender VARCHAR(10) NOT NULL
);