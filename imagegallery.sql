-- imagegallery_seed.sql
-- Seed data for WanderLens / ImageGallery (XAMPP import)
-- Passwords are bcrypt hashes compatible with PHP password_verify().

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS imagegallery;
USE imagegallery;

DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS starred_users;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname    VARCHAR(50) NOT NULL,
  lname    VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  email    VARCHAR(100) NOT NULL UNIQUE,
  phone    VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- bcrypt hash for password: 12345
-- Generated with: php -r "echo password_hash('12345', PASSWORD_DEFAULT), PHP_EOL;"
SET @PASS_HASH := '$2y$10$X7tiRIA7GsgC7UlDvl4tVer7NwsRHEUakm8hXEZ1gMj8aZQZ36ahe';

INSERT INTO users (fname, lname, username, email, phone, password) VALUES
('Alice',   'Wanderer',   'alice',   'alice@example.com',   '1111111111', @PASS_HASH),
('Bob',     'Traveler',   'bob',     'bob@example.com',     '2222222222', @PASS_HASH),
('Charlie', 'Nomad',      'charlie', 'charlie@example.com', '3333333333', @PASS_HASH),
('Diana',   'Explorer',   'diana',   'diana@example.com',   '4444444444', @PASS_HASH),
('Evan',    'Rider',      'evan',    'evan@example.com',    '5555555555', @PASS_HASH),
('Fiona',   'Roamer',     'fiona',   'fiona@example.com',   '6666666666', @PASS_HASH),
('George',  'Seeker',     'george',  'george@example.com',  '7777777777', @PASS_HASH),
('Hannah',  'Hiker',      'hannah',  'hannah@example.com',  '8888888888', @PASS_HASH),
('Ivan',    'Backpacker', 'ivan',    'ivan@example.com',    '9999999999', @PASS_HASH),
('Julia',   'Globetrot',  'julia',   'julia@example.com',   '1010101010', @PASS_HASH),
('Kevin',   'Rover',      'kevin',   'kevin@example.com',   '1212121212', @PASS_HASH),
('Laura',   'Drifter',    'laura',   'laura@example.com',   '1313131313', @PASS_HASH),
('Max',     'Jumper',     'max',     'max@example.com',     '1414141414', @PASS_HASH),
('Nina',    'Wings',      'nina',    'nina@example.com',    '1515151515', @PASS_HASH),
('Oscar',   'Climber',    'oscar',   'oscar@example.com',   '1616161616', @PASS_HASH);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id   INT NOT NULL,
  image     VARCHAR(255) NOT NULL,
  caption   TEXT NOT NULL,
  location  VARCHAR(255) NOT NULL,
  visibility ENUM('public','private') NOT NULL DEFAULT 'public',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7 posts per user (105 total)
-- Exactly 1 private post per user (the first one for each user)
INSERT INTO posts (user_id, image, caption, location, visibility) VALUES
(1, 'user1_post1.jpg', 'Hidden sunrise over Paris',               'Paris, France',          'private'),
(1, 'user1_post2.jpg', 'Night lights at Times Square',            'New York, USA',          'public'),
(1, 'user1_post3.jpg', 'Big Ben by the Thames',                   'London, UK',             'public'),
(1, 'user1_post4.jpg', 'Crossing Shibuya at rush hour',           'Tokyo, Japan',           'public'),
(1, 'user1_post5.jpg', 'Opera House from the ferry',              'Sydney, Australia',      'public'),
(1, 'user1_post6.jpg', 'Foggy morning at the Golden Gate',        'San Francisco, USA',     'public'),
(1, 'user1_post7.jpg', 'Backwater cruise memories',               'Kappad, India',         'public'),

(2, 'user2_post1.jpg', 'Private hike near the canyon rim',        'Grand Canyon, USA',      'private'),
(2, 'user2_post2.jpg', 'Rio from the top of Sugarloaf',           'Rio de Janeiro, Brazil', 'public'),
(2, 'user2_post3.jpg', 'Colosseum in golden hour',                'Rome, Italy',            'public'),
(2, 'user2_post4.jpg', 'Blue domes in Oia',                       'Santorini, Greece',      'public'),
(2, 'user2_post5.jpg', 'Temple sunset in Ubud',                   'Bali, Indonesia',        'public'),
(2, 'user2_post6.jpg', 'Overwater villa dreams',                  'Maldives',               'public'),
(2, 'user2_post7.jpg', 'Old town charm in Prague',                'Prague, Czech Republic', 'public'),

(3, 'user3_post1.jpg', 'Secret slopes in the Alps',               'Swiss Alps, Switzerland','private'),
(3, 'user3_post2.jpg', 'City lights under the tower',             'Tokyo, Japan',           'public'),
(3, 'user3_post3.jpg', 'Evening walk along the Seine',            'Paris, France',          'public'),
(3, 'user3_post4.jpg', 'Skyline from Brooklyn Bridge',            'New York, USA',          'public'),
(3, 'user3_post5.jpg', 'Surf break in Bondi',                     'Sydney, Australia',      'public'),
(3, 'user3_post6.jpg', 'Old streets and coffee in Rome',          'Rome, Italy',            'public'),
(3, 'user3_post7.jpg', 'Cable car views of Rio',                  'Rio de Janeiro, Brazil', 'public'),

(4, 'user4_post1.jpg', 'Quiet trail near Machu Picchu',           'Machu Picchu, Peru',     'private'),
(4, 'user4_post2.jpg', 'Sunrise at Angkor Wat',                   'Siem Reap, Cambodia',    'public'),
(4, 'user4_post3.jpg', 'Street food crawl in Bangkok',            'Bangkok, Thailand',      'public'),
(4, 'user4_post4.jpg', 'Red Square evening walk',                 'Moscow, Russia',         'public'),
(4, 'user4_post5.jpg', 'Harbour cruise in Sydney',                'Sydney, Australia',      'public'),
(4, 'user4_post6.jpg', 'Morning run along Copacabana',            'Rio de Janeiro, Brazil', 'public'),
(4, 'user4_post7.jpg', 'Busy crossing in Shibuya',                'Tokyo, Japan',           'public'),

(5, 'user5_post1.jpg', 'Private dunes in the desert',             'Dubai, UAE',             'private'),
(5, 'user5_post2.jpg', 'Sunset over Santorini cliffs',            'Santorini, Greece',      'public'),
(5, 'user5_post3.jpg', 'Romantic night in Paris',                 'Paris, France',          'public'),
(5, 'user5_post4.jpg', 'Boat through Halong Bay',                 'Halong Bay, Vietnam',    'public'),
(5, 'user5_post5.jpg', 'Hiking trail above Interlaken',           'Swiss Alps, Switzerland','public'),
(5, 'user5_post6.jpg', 'Old tram ride in Lisbon',                 'Lisbon, Portugal',       'public'),
(5, 'user5_post7.jpg', 'Snowy streets in Prague',                 'Prague, Czech Republic', 'public'),

(6, 'user6_post1.jpg', 'Sunrise at a quiet backwater',            'kappad, India',         'private'),
(6, 'user6_post2.jpg', 'View from the Great Wall',                'Great Wall of China',    'public'),
(6, 'user6_post3.jpg', 'Times Square at midnight',                'New York, USA',          'public'),
(6, 'user6_post4.jpg', 'Boat ride on the Thames',                 'London, UK',             'public'),
(6, 'user6_post5.jpg', 'Markets in Marrakesh',                    'Marrakesh, Morocco',     'public'),
(6, 'user6_post6.jpg', 'Northern lights chase',                   'Reykjavik, Iceland',     'public'),
(6, 'user6_post7.jpg', 'Beach walk in Bali',                      'Bali, Indonesia',        'public'),

(7, 'user7_post1.jpg', 'Hidden beach near Sydney',                'Sydney, Australia',      'private'),
(7, 'user7_post2.jpg', 'Trek near the canyon edge',               'Grand Canyon, USA',      'public'),
(7, 'user7_post3.jpg', 'Cable car at Sugarloaf',                  'Rio de Janeiro, Brazil', 'public'),
(7, 'user7_post4.jpg', 'Night markets in Bangkok',                'Bangkok, Thailand',      'public'),
(7, 'user7_post5.jpg', 'White houses in Santorini',               'Santorini, Greece',      'public'),
(7, 'user7_post6.jpg', 'Rainy streets of London',                 'London, UK',             'public'),
(7, 'user7_post7.jpg', 'Floating breakfast in Maldives',          'Maldives',               'public'),

(8, 'user8_post1.jpg', 'Quiet temple hike',                       'Kyoto, Japan',           'private'),
(8, 'user8_post2.jpg', 'Views from Eiffel tower deck',            'Paris, France',          'public'),
(8, 'user8_post3.jpg', 'Late night ramen',                        'Tokyo, Japan',           'public'),
(8, 'user8_post4.jpg', 'Boat in the canals of Venice',            'Venice, Italy',          'public'),
(8, 'user8_post5.jpg', 'Ridge trail above the Alps',              'Swiss Alps, Switzerland','public'),
(8, 'user8_post6.jpg', 'Old town rooftops',                       'Prague, Czech Republic', 'public'),
(8, 'user8_post7.jpg', 'Sunset on kappad beach',                 'kappad, India',         'public'),

(9, 'user9_post1.jpg', 'Private dune buggy ride',                 'Dubai, UAE',             'private'),
(9, 'user9_post2.jpg', 'Opera house lights at night',             'Sydney, Australia',      'public'),
(9, 'user9_post3.jpg', 'Surfing warm waves',                      'Bali, Indonesia',        'public'),
(9, 'user9_post4.jpg', 'Hiking to a Machu Picchu viewpoint',      'Machu Picchu, Peru',     'public'),
(9, 'user9_post5.jpg', 'Desert camp near Doha',                   'Doha, Qatar',            'public'),
(9, 'user9_post6.jpg', 'Boat along the Danube',                   'Budapest, Hungary',      'public'),
(9, 'user9_post7.jpg', 'Icy lagoon in Iceland',                   'Reykjavik, Iceland',     'public'),

(10, 'user10_post1.jpg', 'Private trek in the canyon shadows',    'Grand Canyon, USA',      'private'),
(10, 'user10_post2.jpg', 'Sunrise balloons in Cappadocia',        'Cappadocia, Turkey',     'public'),
(10, 'user10_post3.jpg', 'Coffee by the Colosseum',               'Rome, Italy',            'public'),
(10, 'user10_post4.jpg', 'Evening boat through Santorini',        'Santorini, Greece',      'public'),
(10, 'user10_post5.jpg', 'Neon streets of Tokyo',                 'Tokyo, Japan',           'public'),
(10, 'user10_post6.jpg', 'Watching surfers in Sydney',            'Sydney, Australia',      'public'),
(10, 'user10_post7.jpg', 'Old town walk in Lisbon',               'Lisbon, Portugal',       'public'),

(11, 'user11_post1.jpg', 'Private cabin in the Alps',             'Swiss Alps, Switzerland','private'),
(11, 'user11_post2.jpg', 'Foggy morning on the Great Wall',       'Great Wall of China',    'public'),
(11, 'user11_post3.jpg', 'Sunset at Copacabana',                  'Rio de Janeiro, Brazil', 'public'),
(11, 'user11_post4.jpg', 'Rooftops in Prague',                    'Prague, Czech Republic', 'public'),
(11, 'user11_post5.jpg', 'City lights in New York',               'New York, USA',          'public'),
(11, 'user11_post6.jpg', 'Backwater ride in kappad',             'kappad, India',         'public'),
(11, 'user11_post7.jpg', 'Bridge views in Budapest',              'Budapest, Hungary',      'public'),

(12, 'user12_post1.jpg', 'Private walk near Machu Picchu',        'Machu Picchu, Peru',     'private'),
(12, 'user12_post2.jpg', 'Evening stroll in Paris',               'Paris, France',          'public'),
(12, 'user12_post3.jpg', 'Cherry blossoms in Tokyo',              'Tokyo, Japan',           'public'),
(12, 'user12_post4.jpg', 'Sunrise at the Colosseum',              'Rome, Italy',            'public'),
(12, 'user12_post5.jpg', 'Island hop in the Maldives',            'Maldives',               'public'),
(12, 'user12_post6.jpg', 'Golden hour in Santorini',              'Santorini, Greece',      'public'),
(12, 'user12_post7.jpg', 'Beach run in Bali',                     'Bali, Indonesia',        'public'),

(13, 'user13_post1.jpg', 'Private night in Times Square',         'New York, USA',          'private'),
(13, 'user13_post2.jpg', 'Sunset ride over Rio',                  'Rio de Janeiro, Brazil', 'public'),
(13, 'user13_post3.jpg', 'Breakfast with Eiffel views',           'Paris, France',          'public'),
(13, 'user13_post4.jpg', 'Empty beach near kappad',              'kappad, India',         'public'),
(13, 'user13_post5.jpg', 'Hiking trail in Swiss Alps',            'Swiss Alps, Switzerland','public'),
(13, 'user13_post6.jpg', 'Temple visit in Bangkok',               'Bangkok, Thailand',      'public'),
(13, 'user13_post7.jpg', 'Evening in Lisbon',                     'Lisbon, Portugal',       'public'),

(14, 'user14_post1.jpg', 'Private desert sunset camp',            'Dubai, UAE',             'private'),
(14, 'user14_post2.jpg', 'Overlooking Grand Canyon',              'Grand Canyon, USA',      'public'),
(14, 'user14_post3.jpg', 'Old streets and trams',                 'Lisbon, Portugal',       'public'),
(14, 'user14_post4.jpg', 'Snowy day in Prague',                   'Prague, Czech Republic', 'public'),
(14, 'user14_post5.jpg', 'Boat ride in Venice',                   'Venice, Italy',          'public'),
(14, 'user14_post6.jpg', 'Beach day in Bali',                     'Bali, Indonesia',        'public'),
(14, 'user14_post7.jpg', 'Backwaters near kappad',               'kappad, India',         'public'),

(15, 'user15_post1.jpg', 'Private trek in the Alps',              'Swiss Alps, Switzerland','private'),
(15, 'user15_post2.jpg', 'City walk in New York',                 'New York, USA',          'public'),
(15, 'user15_post3.jpg', 'Evening cruise in Sydney',              'Sydney, Australia',      'public'),
(15, 'user15_post4.jpg', 'Sunrise in Machu Picchu',               'Machu Picchu, Peru',     'public'),
(15, 'user15_post5.jpg', 'Boat on the Seine in Paris',            'Paris, France',          'public'),
(15, 'user15_post6.jpg', 'Beach sunsets in Maldives',             'Maldives',               'public'),
(15, 'user15_post7.jpg', 'Hill ride above Rio',                   'Rio de Janeiro, Brazil', 'public');

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  comment TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- One comment per post from a different user:
-- commenter = (owner_user_id % 15) + 1
INSERT INTO comments (post_id, user_id, comment) VALUES
(1, 2, 'Looks amazing!'),
(2, 2, 'Great shot!'),
(3, 2, 'Love this place.'),
(4, 2, 'Bucket list!'),
(5, 2, 'So cool.'),
(6, 2, 'Amazing view.'),
(7, 2, 'Peaceful vibes.'),

(8, 3, 'Wow!'),
(9, 3, 'Beautiful!'),
(10, 3, 'Nice!'),
(11, 3, 'Perfect.'),
(12, 3, 'Awesome.'),
(13, 3, 'Dreamy.'),
(14, 3, 'Lovely city.'),

(15, 4, 'Breathtaking.'),
(16, 4, 'Nice lights.'),
(17, 4, 'Paris vibes.'),
(18, 4, 'Great skyline.'),
(19, 4, 'Looks fun!'),
(20, 4, 'So good.'),
(21, 4, 'Awesome view.'),

(22, 5, 'Incredible.'),
(23, 5, 'Amazing sunrise.'),
(24, 5, 'Food heaven.'),
(25, 5, 'So grand.'),
(26, 5, 'Relaxing.'),
(27, 5, 'Nice run spot.'),
(28, 5, 'So busy!'),

(29, 6, 'Desert is cool.'),
(30, 6, 'So pretty.'),
(31, 6, 'Romantic.'),
(32, 6, 'Dream trip.'),
(33, 6, 'Great hike.'),
(34, 6, 'Nice streets.'),
(35, 6, 'Beautiful snow.'),

(36, 7, 'Calm morning.'),
(37, 7, 'Must visit.'),
(38, 7, 'NYC energy!'),
(39, 7, 'Nice ride.'),
(40, 7, 'Colorful!'),
(41, 7, 'Wow lights.'),
(42, 7, 'Beach day!'),

(43, 8, 'Hidden gems!'),
(44, 8, 'Epic.'),
(45, 8, 'Amazing.'),
(46, 8, 'Fun nights.'),
(47, 8, 'Iconic.'),
(48, 8, 'Lovely.'),
(49, 8, 'Paradise.'),

(50, 9, 'So calm.'),
(51, 9, 'Great view.'),
(52, 9, 'Yum!'),
(53, 9, 'Romantic.'),
(54, 9, 'Tough hike.'),
(55, 9, 'Nice rooftops.'),
(56, 9, 'Great sunset.'),

(57, 10, 'Sounds fun.'),
(58, 10, 'Nice lights.'),
(59, 10, 'Awesome waves.'),
(60, 10, 'Steep trail.'),
(61, 10, 'Cool camp.'),
(62, 10, 'Beautiful.'),
(63, 10, 'Stunning.'),

(64, 11, 'Dramatic!'),
(65, 11, 'Magical.'),
(66, 11, 'Love Rome.'),
(67, 11, 'Great trip.'),
(68, 11, 'Neon vibes.'),
(69, 11, 'So cool.'),
(70, 11, 'Lovely place.'),

(71, 12, 'Cozy!'),
(72, 12, 'Amazing fog.'),
(73, 12, 'Perfect sunset.'),
(74, 12, 'Nice view.'),
(75, 12, 'Great city.'),
(76, 12, 'Peaceful.'),
(77, 12, 'Nice bridge.'),

(78, 13, 'Great walk.'),
(79, 13, 'So nice.'),
(80, 13, 'Beautiful.'),
(81, 13, 'Stunning.'),
(82, 13, 'Dreamy.'),
(83, 13, 'Amazing.'),
(84, 13, 'Relaxing.'),

(85, 14, 'Crazy nights.'),
(86, 14, 'Beautiful.'),
(87, 14, 'Perfect.'),
(88, 14, 'So calm.'),
(89, 14, 'Great trail.'),
(90, 14, 'Nice temple.'),
(91, 14, 'Lovely.'),

(92, 15, 'Nice vibes.'),
(93, 15, 'Huge!'),
(94, 15, 'Charming.'),
(95, 15, 'Magical.'),
(96, 15, 'Pretty.'),
(97, 15, 'Relaxing.'),
(98, 15, 'Serene.'),

(99, 1, 'Intense!'),
(100, 1, 'Nice walk.'),
(101, 1, 'Relaxing.'),
(102, 1, 'Epic.'),
(103, 1, 'Romantic.'),
(104, 1, 'Unreal.'),
(105, 1, 'Amazing.');

CREATE TABLE starred_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  starred_user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (starred_user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_star (user_id, starred_user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO starred_users (user_id, starred_user_id) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10);

SET FOREIGN_KEY_CHECKS = 1;

