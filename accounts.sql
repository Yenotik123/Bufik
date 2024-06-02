CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE Users (
    id INT PRIMARY KEY,
    username VARCHAR(255),
    password VARCHAR(255)
    -- other user fields
);

CREATE TABLE Purchases (
    id INT PRIMARY KEY,
    user_id INT,
    purchase_details VARCHAR(255),
    purchase_date TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);