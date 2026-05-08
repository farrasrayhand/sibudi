CREATE TABLE guestbooks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    visit_date DATE NOT NULL,
    message TEXT NOT NULL,
    photo VARCHAR(255) NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

