<?php
$conn = new mysqli("localhost", "root", "", "dbms_project");

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$sql = "SELECT j.job_id, j.title, j.job_type, j.description, j.stipend_ctc, j.deadline, j.location, j.eligibility, c.name as company_name
        FROM Job_Internship j 
        JOIN Company c ON j.company_id = c.company_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>DTU Jobs</title>
    <style>
        body {
            background-color: #eef1f7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background-color: lightblue;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar .logo {
            font-size: 20px;
            font-weight: bold;
            color: #222;
        }

        .menu a {
            margin-left: 15px;
            text-decoration: none;
            color: #444;
        }

        .menu a:hover {
            color: blue;
        }

        h2 {
            text-align: center;
            margin: 25px 0 10px 0;
            color: #333;
        }

        .job-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 10px;
        }

        .job-box {
            background-color: white;
            border: 1px solid #ddd;
            width: 320px;
            padding: 15px;
            border-radius: 8px;
        }

        .job-box h3 {
            margin-top: 0;
            color: #444;
        }

        .job-box p {
            font-size: 14px;
            margin: 5px 0;
        }

        .btn-apply {
            background-color: #5b6dfa;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-apply:hover {
            background-color: #4054b2;
        }

        @media screen and (max-width: 600px) {
            .job-list {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="logo">Placement Portal</div>
        <div class="menu">
            <a href="index.php">Jobs</a>
            <a href="my_applications.php">My Applications</a>
            <a href="admin_panel.php">Admin</a>
        </div>
    </div>

    <h2>Available Positions</h2>

    <div class="job-list">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($job = $result->fetch_assoc()) {
                echo '<div class="job-box">';
                echo '<h3>' . $job['title'] . '</h3>';
                echo '<p><strong>Company:</strong> ' . $job['company_name'] . '</p>';
                echo '<p><strong>Type:</strong> ' . $job['job_type'] . '</p>';
                echo '<p><strong>Stipend/CTC:</strong> ' . $job['stipend_ctc'] . '</p>';
                echo '<p><strong>Location:</strong> ' . $job['location'] . '</p>';
                echo '<p><strong>Deadline:</strong> ' . $job['deadline'] . '</p>';
                echo '<p><strong>Eligibility:</strong> ' . $job['eligibility'] . '</p>';
                echo '<button class="btn-apply" onclick="location.href=\'apply.php?job_id=' . $job['job_id'] . '\'">Apply</button>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align:center; padding:20px;">No job openings found.</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
