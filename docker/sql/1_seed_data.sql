-- Vloženie kategórií (categories)
INSERT INTO `categories` (`id`, `name`) VALUES
                                            (1, 'Programovanie a vývoj'),
                                            (2, 'Výtvarné umenie a ilustrácia'),
                                            (3, 'Ručné práce a remeslá'),
                                            (4, 'Fotografia a video'),
                                            (5, 'Grafický dizajn a UI/UX'),
                                            (6, 'Modelárstvo a 3D tlač'),
                                            (7, 'Hudba a zvuková tvorba');

-- Vloženie štítkov (tags) priradených ku kategóriám
INSERT INTO `tags` (`category_id`, `name`) VALUES
-- 1. Programovanie a vývoj
(1, 'PHP'),
(1, 'JavaScript'),
(1, 'Python'),
(1, 'C# / .NET'),
(1, 'C++'),
(1, 'React'),
(1, 'Docker'),
(1, 'PostgreSQL'),
(1, 'Web Development'),
(1, 'Mobilné aplikácie'),

-- 2. Výtvarné umenie a ilustrácia
(2, 'Akvarel'),
(2, 'Olejomaľba'),
(2, 'Kresba ceruzkou'),
(2, 'Digitálna maľba'),
(2, 'Skicáre'),
(2, 'Kaligrafia'),
(2, 'Akryl'),

-- 3. Ručné práce a remeslá
(3, 'Pletenie'),
(3, 'Háčkovanie'),
(3, 'Šitie'),
(3, 'Tvorba z dreva'),
(3, 'Kožená galantéria'),
(3, 'Keramika'),
(3, 'Výroba šperkov'),

-- 4. Fotografia a video
(4, 'Portrétna fotografia'),
(4, 'Krajinárska fotografia'),
(4, 'Analógová fotografia'),
(4, 'Street foto'),
(4, 'Makro'),
(4, 'Strih videa'),
(4, 'Color grading'),

-- 5. Grafický dizajn a UI/UX
(5, 'UI/UX Dizajn'),
(5, 'Vektorová grafika'),
(5, 'Tvorba loga'),
(5, 'Branding'),
(5, 'Typografia'),
(5, 'Figma'),

-- 6. Modelárstvo a 3D tlač
(6, '3D Modelovanie'),
(6, 'Blender'),
(6, 'FDM tlač'),
(6, 'SLA tlač (resín)'),
(6, 'Miniatúry a figúrky'),
(6, 'RC modely'),

-- 7. Hudba a zvuková tvorba
(7, 'Klavír'),
(7, 'Gitara'),
(7, 'Zvukový inžiniering'),
(7, 'FL Studio / Ableton'),
(7, 'Filmová hudba'),
(7, 'Podcasty');

-- Vloženie predvolenej témy (themes)
-- id = 1 je referencovaná ako predvolená téma pri registrácii nového používateľa (users.theme_id)
INSERT INTO `themes` (`id`, `name`, `layout`, `color_primary`, `color_background`, `color_text`, `font`, `preview_image_path`) VALUES
    (1, 'Folio – predvolená', 'grid', '2563ebff', 'f8fafcff', '0f172aff', 'Inter', '');


-- Admin user seed
INSERT INTO `users` (
    `username`, `email`, `password_hash`, `role`,
    `display_name`, `bio`, `avatar_path`, `is_banned`, `theme_id`
) VALUES (
             'admin',
             'admin@example.com',
             '$2y$12$Z5.iHyYjCgo.hvsnNQsmT.oEb7r5m7Xi3TjfAkJ.tvdNbt0gF5M9y',  -- hash pre "admin"
             'admin',
             'Administrátor',
             'Hlavný administrátor systems',
             '',
             0,
             1
         );

-- Test user seed
INSERT INTO `users` (`username`, `email`, `password_hash`, `role`,
                     `display_name`, `bio`, `avatar_path`, `is_banned`, `theme_id`
) VALUES (
             'testuser',
             'test@example.com',
             '$2y$12$XFi8FBy8.SjzrmIv2zCqHu2D0bvvHIgSWhWiGwY6tM0J.MF2yd13G',  -- hash pre "testuser"
             'user',
             'Test User',
             'Testovací používateľ pre vývoj',
             '',
             0,
             1
         );