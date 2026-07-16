<?php
require_once 'config.php';

$result = $conn->query("SELECT id, name, age, status FROM people ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People Status App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">

        <h1>People Status Manager</h1>

        <form id="personForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="1" max="120" required>

            <button type="submit">Submit</button>
        </form>

        <p id="message"></p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="peopleTableBody">

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr id="row-<?php echo $row['id']; ?>">

                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </td>

                        <td><?php echo $row['age']; ?></td>

                        <td class="status">
                            <?php echo $row['status']; ?>
                        </td>

                        <td>
                            <button
                                type="button"
                                class="toggle-btn"
                                data-id="<?php echo $row['id']; ?>">
                                Toggle
                            </button>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>
        </table>

    </div>

    <script src="script.js"></script>

</body>
</html>