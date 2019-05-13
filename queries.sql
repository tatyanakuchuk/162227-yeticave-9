INSERT INTO categories (name, symbol_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO bets (lot_id, user_id, dt_add, sum)
VALUES  (1, 1, NOW(), 11999),
        (2, 3, NOW(), 13999),
        (1, 2, NOW(), 14000);

INSERT INTO lots
SET category_id = 1,
    user_id = 1,
    dt_add = NOW(),
    dt_remove = '2019-05-15 12:00',
    title = '2014 Rossignol District Snowboard',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-1.jpg',
    sum_start = 6999,
    bet_step = 1000,
    user_id_winner = 2;
INSERT INTO lots
SET category_id = 1,
    user_id = 2,
    dt_add = NOW(),
    dt_remove = '2019-05-19 10:30',
    title = 'DC Ply Mens 2016/2017 Snowboard',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-2.jpg',
    sum_start = 8999,
    bet_step = 1000,
    user_id_winner = 1;
INSERT INTO lots
SET category_id = 2,
    user_id = 3,
    dt_add = NOW(),
    dt_remove = '2019-05-12 22:30',
    title = 'Крепления Union Contact Pro 2015 года размер L/XL',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-3.jpg',
    sum_start = 6000,
    bet_step = 1000,
    user_id_winner = 3;
INSERT INTO lots
SET category_id = 3,
    user_id = 2,
    dt_add = NOW(),
    dt_remove = '2019-05-10 18:20',
    title = 'Ботинки для сноуборда DC Mutiny Charocal',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-4.jpg',
    sum_start = 4999,
    bet_step = 1000,
    user_id_winner = 1;
INSERT INTO lots
SET category_id = 4,
    user_id = 1,
    dt_add = NOW(),
    dt_remove = '2019-05-07 17:00',
    title = 'Куртка для сноуборда DC Mutiny Charocal',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-5.jpg',
    sum_start = 6999,
    bet_step = 1000,
    user_id_winner = 2;
INSERT INTO lots
SET category_id = 6,
    user_id = 2,
    dt_add = NOW(),
    dt_remove = '2019-05-07 12:00',
    title = 'Маска Oakley Canopy',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
    img_path = '../img/lot-6.jpg',
    sum_start = 2500,
    bet_step = 1000,
    user_id_winner = 3;

INSERT INTO users
SET dt_add =    NOW(),
    name =      'Николай',
    email =     'nik2020@mail.ru',
    password =  'password1',
    avatar =    '',
    contact =   'Здесь будут какие-то контактные данные.';
INSERT INTO users
SET dt_add =    NOW(),
    name =      'Бобрик',
    email =     'bobrdobr@gmail.com',
    password =  'password2',
    avatar =    '',
    contact =   'Здесь тоже будут какие-то контактные данные.';
INSERT INTO users
SET dt_add =    NOW(),
    name =      'Валентина Николаевна',
    email =     'valentinabest@gmail.com',
    password =  'password3',
    avatar =    '',
    contact =   'И здесь будут какие-то контактные данные.';

-- 1) получить все категории
SELECT * FROM categories;

/*  2) получить самые новые, открытые лоты. Каждый лот должен включать название,
стартовую цену, ссылку на изображение, цену, название категории; */
SELECT l.id, title, img_path, sum_start, bet_step, c.name FROM lots l JOIN categories c ON l.category_id = c.id WHERE dt_remove > NOW() ORDER BY dt_add DESC;

-- 3) показать лот по его id. Получите также название категории, к которой принадлежит лот;
SELECT l.id, c.name, user_id, dt_add, dt_remove, title, description, img_path, sum_start, bet_step, user_id_winner FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = '';

-- 4) обновить название лота по его идентификатору
UPDATE lots SET title='Новое название' WHERE id = '';

-- 5) получить список самых свежих ставок для лота по его идентификатору
SELECT b.id, b.lot_id, b.dt_add, b.user_id, sum  FROM bets b JOIN lots l ON l.id = b.lot_id WHERE l.id = 1 ORDER BY b.dt_add DESC;