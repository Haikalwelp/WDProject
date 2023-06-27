<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$database = "megah";
$create_db_query = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($create_db_query) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($database);

// Create the table
$create_table_query = "
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255),
    product_code VARCHAR(255),
    type VARCHAR(255),
    category VARCHAR(255),
    gst VARCHAR(255),
    uom VARCHAR(255),
    cost DECIMAL(10, 2),
    selling DECIMAL(10, 2),
    balance INT
)";
if ($conn->query($create_table_query) === TRUE) {
    echo "Table created successfully!<br>";
} else {
    echo "Error creating table: " . $conn->error;
}
// Insert the data
$data = [
    ["ARISTON PENCIL CASE FBC100 RED BLACK BLUE", "9557109025065", "Product", "Pencil Case", null, "PCS", 3.00, 6.00, 4],
    ["ARISTON PENCIL CASE FBC22 RED BLACK BLUE", "9557109025058", "Product", "Pencil Case", null, "PCS", 3.00, 4.00, 6],
    ["ASTAR PENCIL BOX NO.A90", "9555078915752", "Product", "Pencil Case", null, "PCS", 1.00, 2.00, 7],
    ["KIJO PENCIL CASE", "9555299217543", "Product", "Pencil Case", null, "PCS", 2.00, 1.00, 2],
    ["ARISTON PENCIL BOX L", "9557109032629", "Product", "Pencil Box", null, "PCS", 3.00, 4.00, 13],
    ["FANCY ERASER 48PCS", "9557109012256", "Product", "Eraser", null, "BOX", 5.00, 7.50, 1],
    ["PENMARK 12 COLOUR PENCILS SHORT", "9557218033173", "Product", "Colour pencil", null, "BOX", 1.90, 2.00, 22],
    ["SCHOOL OFFICE 12 PENCIL COLOUR LONG", "6422844004312", "Product", "Colour pencil", null, "BOX", 3.50, 4.00, 47],
    ["ELITE 12 WATER COLOUR PLASTIC TUBE SMALL", "9557109003216", "Product", "Water Colour", null, "PCS", 2.00, 3.00, 29],
    ["ELITE 24 WATER COLOUR PEN", "9557109009102", "Product", "Marker Pen", null, "CASE", 6.00, 7.00, 45],
    ["ELITE 12 WATER COLOUR PEN", "9557109003056", "Product", "Marker Pen", null, "UNIT", 2.50, 3.00, 0],
    ["ELITE 2B PENCILS 122-2BN", "9557109009072", "Product", "Pencil", null, "BOX", 2.00, 3.00, 6],
    ["ELITE 2B EXAM GRADE PENCILS", "9557109009324", "Product", "Pencil", null, "UNIT", 3.00, 4.00, 26],
    ["ELITE 125 GLUE", "9557109006057", "Product", "Glue", null, "PCS", 0.80, 1.00, 33],
    ["MIVO PEN HOLDER", "9557218080863", "Product", "Storage organization", null, "PCS", 3.00, 4.00, 9],
    ["MIVO ROTATABLE PEN HOLDER", "9557218192276", "Product", "Storage organization", null, "PCS", 6.00, 8.00, 9],
    ["KIJO PEN STANDS PS8932", null, "Product", "Storage organization", null, "PCS", 5.00, 6.90, 118],
    ["UNO CARD", "1452883000001", "Product", "Card Game", null, "UNIT", 5.00, 7.50, 36],
    ["ARISTON ANIMAL CLUB ERASER ARFE-605", "9557109031776", "Product", "Eraser", null, "UNIT", 1.50, 2.50, 3],
    ["ARISTON FRESH FRUIT ERASER ARFE-607", "9557109031790", "Product", "Eraser", null, "UNIT", 1.50, 2.50, 13],
    ["ARISTON ANIMALS CLUB ERASERS ARFE-601", "9557109031783", "Product", "Eraser", null, "UNIT", 1.50, 2.50, 2],
    ["FLAMINGO BLACK 2B PENCILS/BOX PB212", "9556936021141", "Product", "Pencil", null, "BOX", 3.00, 3.70, 34],
    ["FLAMINGO 2B EXAM PENCIL PBF 216", "9556936021172", "Product", "Pencil", null, "BOX", 3.50, 4.90, 15],
    ["B.O.H.O MAGNETIC WHITEBOARD ERASER", "9557218040416", "Product", "Eraser", null, "PCS", 1.50, 2.20, 61],
    ["ASTAR BLACKBOARD DUSTER A900", "9555078907047", "Product", "Eraser", null, "PCS", 1.20, 1.50, 11],
    ["STABILO 6 TRIANGULAR JUMBO PENCILS", "9556091134199", "Product", "Pencil", null, "BOX", 7.90, 9.30, 7],
    ["ELITE EXAM GRADE 2B PENCIL SET E128-2B/STB", "9557109020886", "Product", "Pencil", null, "PCS", 2.20, 2.90, 4],
    ["ELITE GREEN 2B PENCIL SET E122-2BN/STB", "9557109009133", "Product", "Pencil", null, "PCS", 2.20, 2.90, 4],
    ["PE FOAM DOUBLE SIDED TS-35 FOAM BLACK 24MMX10Y", "9557419902409", "Product", "Tape", null, "PCS", 5.00, 7.90, 0],
    ["3M PE FOAM 1600TG", null, "Product", "Tape", null, "PCS", 15.00, 16.50, 2],
    ["DENMARK D/S ACRYLIC FOAM TAPE 10MMX1.5M", "957218201053", "Product", "Tape", null, "PCS", 5.00, 5.90, 12],
    ["HARD PVC TAPE MULTICOLOR 9MM", "9550059011509", "Product", "Tape", null, "PCS", 2.00, 2.50, 25],
    ["PE FOAM D/S HEAVY DUTY 18MMX9Y", "9557419901809", "Product", "Tape", null, "PCS", 5.00, 5.90, 2],
    ["ARMSTRONG D/S ACRYLIC FOAM TAPE 12MMX9Y", "9555325901408", "Product", "Tape", null, "PCS", 15.00, 18.00, 1],
    ["PE FOAM D/S TAPE HEAVY DUTY 12MMX9Y", "9557419901209", "Product", "Tape", null, "PCS", 4.00, 4.90, 3],
    ["LION FILE 100GSM WHITE ENVELOPE", "9555017404828", "Product", "Envelope", null, "PCS", 0.25, 0.70, 116],
    ["MAHJOR PAPER IN ROLL 3I\"X43\"", "2204270001", "Product", "Paper", null, "PCS", 0.40, 1.00, 82],
    ["DIAMOND AIR FRESHNERS - ENGLISH LAVENDER", "555944000018", "Product", "Perfume", null, "UNIT", 7.50, 10.00, 4],
    ["DIAMOND AIR FRESHNERS - VANILLA BOUQUET", "9555944000001", "Product", "Perfume", null, "UNIT", 7.50, 10.00, 4]
];

$insert_query = "INSERT INTO products (product_name, product_code, type, category, gst, uom, cost, selling, balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("ssssssddi", $productName, $productCode, $type, $category, $gst, $uom, $cost, $selling, $balance);

foreach ($data as $row) {
    $productName = $row[0];
    $productCode = $row[1];
    $type = $row[2];
    $category = $row[3];
    $gst = $row[4];
    $uom = $row[5];
    $cost = $row[6];
    $selling = $row[7];
    $balance = $row[8];
    $stmt->execute();
}

echo "Data inserted successfully!<br>";

// Close the statement and connection
$stmt->close();
$conn->close();
?>