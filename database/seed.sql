USE farm_visit_showcase;

INSERT INTO users (full_name, email, username, password_hash, role)
VALUES
('Site Admin', 'admin@example.com', 'admin', '$2y$10$wGHyyglN6E466zv8YBbqsu9dZYkTfLZNVVRFlE0YyqS/fWznuaCGi', 'admin')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO farm_hours (day_of_week, open_time, close_time, notes, is_closed) VALUES
(0, NULL, NULL, 'Closed', 1),
(1, '09:00:00', '17:00:00', 'Open to visits', 0),
(2, '09:00:00', '17:00:00', 'Open to visits', 0),
(3, '09:00:00', '17:00:00', 'Open to visits', 0),
(4, '09:00:00', '17:00:00', 'Open to visits', 0),
(5, '09:00:00', '18:00:00', 'Farmers market on-site', 0),
(6, '10:00:00', '16:00:00', 'Weekend visits', 0)
ON DUPLICATE KEY UPDATE day_of_week = day_of_week;
