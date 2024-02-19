<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Bill Of Quantity</title>
</head>
<body>
    <header>
        <h2 class="centered-text">Bill Of Quantity</h2>
        <h3 class="right-text">Admin</h3>
        <!-- <div class="logo-container"><img class="logo-image" src="sign-out.png" alt="Logo"></div> -->
    </header>
    <button id="addNewItemButton">Add a New Item</button>
    <input type="text" id="searchBox" placeholder="Search...">
    <button id="exportButton">Export to CSV</button>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <form id="surveyForm" action="submittoboq.php" method="post">
                <h1>New Item</h1>
                <!-- Survey fields go here -->
                <label for="tableNumber">Table Number:</label>
                <input type="text" id="tableNumber" name="tableNumber" required>

                <label for="itemNumber">Item Number:</label>
                <input type="text" id="itemNumber" name="itemNumber" required>

                <label for="itemDescription">Item Description:</label>
                <input type="text" id="itemDescription" name="itemDescription" required>

                <label for="quantity">Number of Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="period">Period (Months):</label>
                <input type="number" id="period" name="period" required>

                <label for="origin">Country of Origin:</label>
                <select name="origin" id="origin" required>
                    <option value="" disabled selected>Choose a Country</option>
                    <option value="saudi">Saudi Arabia</option>
                    <option value="uae">United Arab Emirates</option>
                    <option value="bahrain">Bahrain</option>
                    <option value="kuwait">Kuwait</option>
                    <option value="oman">Oman</option>
                    <option value="qatar">Qatar</option>
                </select>

                <label for="businessUnit">Business Unit:</label>
                <select name="businessUnit" id="businessUnit" required>
                    <option value="" disabled selected>Choose a Business Unit</option>
                    <option value="healthcare">Healthcare</option>
                    <option value="oandm">O&M</option>
                    <option value="marketing">Marketing</option>
                    <option value="finance">Finance</option>
                    <option value="sales">Sales</option>
                </select>

                <label for="unitType">Unit Type:</label>
                <input type="text" id="unitType" name="unitType" required>

                <label for="itemType">Item Type:</label>
                <input type="text" id="itemType" name="itemType" required>

                <button type="submit">Add</button>

            </form>
        </div>
    </div>

    <div id="cardContainer" class="card-container">
        <!-- Cards will be appended here -->
    </div>

    <script src="script.js"></script>
</body>
</html>