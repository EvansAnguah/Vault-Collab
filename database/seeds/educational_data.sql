-- ============================================================
-- Educational Data Seeder
-- Populates the cheat sheets and learning resources
-- ============================================================

USE `vault_collab`;

-- Clear existing data (optional, but good for testing)
TRUNCATE TABLE `cheat_sheets`;
TRUNCATE TABLE `learning_resources`;

-- ------------------------------------------------------------
-- CHEAT SHEETS
-- ------------------------------------------------------------
INSERT INTO `cheat_sheets` (`language`, `title`, `description`, `code`, `category`, `difficulty`) VALUES
('PHP', 'PDO Database Connection', 'Connect to a MySQL database using PDO, the standard modern PHP extension.', 
'$dsn = "mysql:host=localhost;dbname=testdb;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, "user", "pass", $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}', 'Database', 'intermediate'),

('PHP', 'Prepared Statements', 'How to safely execute a query preventing SQL injection.', 
'$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(["email" => $userEmail]);
$user = $stmt->fetch();', 'Database', 'intermediate'),

('PHP', 'Array Iteration', 'Looping over associative arrays.', 
'$student = ["name" => "John", "index" => "RMU123", "dept" => "IT"];
foreach ($student as $key => $value) {
    echo ucfirst($key) . ": " . $value . "\\n";
}', 'Basics', 'beginner'),

('JavaScript', 'Fetch API', 'Making asynchronous HTTP requests in modern JS.', 
'fetch("https://api.example.com/data")
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error("Error:", error));', 'Network', 'intermediate'),

('JavaScript', 'DOM Selection', 'Selecting elements from the HTML Document.', 
'// Select single element
const btn = document.querySelector(".btn-primary");

// Select multiple
const inputs = document.querySelectorAll("input[type=text]");', 'DOM', 'beginner'),

('MySQL', 'INNER JOIN', 'Fetch matching records from two tables.', 
'SELECT users.first_name, departments.name 
FROM users 
INNER JOIN departments ON users.department_id = departments.id;', 'Queries', 'intermediate'),

('CSS', 'Flexbox Core', 'Center an item perfectly in modern CSS.', 
'.center-container {
    display: flex;
    justify-content: center; /* Horizontal Center */
    align-items: center;     /* Vertical Center */
    height: 100vh;
}', 'Layout', 'beginner');

-- ------------------------------------------------------------
-- LEARNING RESOURCES
-- ------------------------------------------------------------
-- Inserting general resources for (department_id = NULL)
INSERT INTO `learning_resources` (`title`, `description`, `youtube_url`, `thumbnail_url`, `department_id`, `category`) VALUES
('Git & GitHub Crash Course for Beginners', 'Learn the basics of version control, essential for collaborating on your project vault.', 'https://www.youtube.com/watch?v=RGOj5yH7evk', 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&q=80&w=600', NULL, 'Version Control'),

('PHP MVC Framework - Build it from scratch', 'Understand how the underlying Model-View-Controller architecture works in PHP applications.', 'https://www.youtube.com/watch?v=kYv9lG7M1-A', 'https://images.unsplash.com/photo-1599507593499-a3f7d1d08731?auto=format&fit=crop&q=80&w=600', NULL, 'Backend Development'),

('CSS Flexbox Tutorial', 'Master CSS layouts quickly with Flexbox. Essential for creating responsive UI.', 'https://www.youtube.com/watch?v=fYq5JZgSks0', 'https://images.unsplash.com/photo-1507721999472-8ed4421c4af2?auto=format&fit=crop&q=80&w=600', NULL, 'Frontend Design'),

('MySQL Database Design basics', 'Learn how to properly design relations, primary keys, and foreign keys for your RMU project.', 'https://www.youtube.com/watch?v=ztHopE5Wnpc', 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&q=80&w=600', NULL, 'Database Setup');

