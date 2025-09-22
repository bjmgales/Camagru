---------------------- USERS -----------------------
CREATE TABLE IF NOT EXISTS users (
    id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username                VARCHAR(22) NOT NULL UNIQUE,
    email                   VARCHAR(100) NOT NULL UNIQUE,
    password_hash           VARCHAR(255) NOT NULL,
    created_at              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    token_hash              VARCHAR(255),
    token_creation_time     TIMESTAMP,
    token_expires_at        TIMESTAMP,
    is_verified             TINYINT(1) NOT NULL DEFAULT 0
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

---------------------- IMAGES -----------------------
CREATE TABLE IF NOT EXISTS images (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    is_default      TINYINT(1) NOT NULL DEFAULT 0,
    user_id         INT UNSIGNED NOT NULL,
    file_path       VARCHAR(255),
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

---------------------- OVERLAYS -----------------------
CREATE TABLE IF NOT EXISTS overlays (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    is_default      TINYINT(1) NOT NULL DEFAULT 0,
    user_id         INT UNSIGNED,
    file_path       VARCHAR(255),
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CHECK (
        (is_default = 1 AND user_id IS NULL) OR
        (is_default = 0 AND user_id IS NOT NULL)
    )
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

---------------------- COMMENTS -----------------------
CREATE TABLE IF NOT EXISTS comments (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED,
    image_id        INT UNSIGNED NOT NULL,
    content         TEXT NOT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

---------------------- LIKES -----------------------
CREATE TABLE IF NOT EXISTS likes (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL,
    image_id        INT UNSIGNED NOT NULL,
    UNIQUE (image_id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- CHARSET==Emoji support, COLLATE==Case insenstivie (user = USer)


---------------------- JOBS -----------------------

CREATE EVENT cleanup_tokens
ON SCHEDULE EVERY 0.5 HOUR
DO
    DELETE FROM USERS WHERE token_expires_at < NOW()
---------------------- TEMPLATES -----------------------

INSERT INTO overlays (file_path, is_default) VALUES
('upload/overlays/defaults/elie.png', 1),
('upload/overlays/defaults/franck.png', 1),
('upload/overlays/defaults/manu.png', 1);

