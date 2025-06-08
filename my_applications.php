<?php
$conn = new mysqli("localhost", "root", "", "dbms_project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";
$applications = [];
$student = null;

if (isset($_POST['search_student'])) {
    $student_id = $_POST['student_id'];

    $res = $conn->query("SELECT * FROM Student WHERE student_id = $student_id");

    if ($res && $res->num_rows > 0) {
        $student = $res->fetch_assoc();

        $app_sql = "SELECT a.application_id, a.status, a.date_applied, j.title, j.job_type, j.stipend_ctc, j.location,
                    c.name as company_name, i.interview_date, i.mode, i.result
                    FROM Application a
                    JOIN Job_Internship j ON j.job_id = a.job_id
                    JOIN Company c ON j.company_id = c.company_id
                    LEFT JOIN Interview i ON i.application_id = a.application_id
                    WHERE a.student_id = $student_id";

        $app_res = $conn->query($app_sql);
        if ($app_res->num_rows > 0) {
            while ($row = $app_res->fetch_assoc()) {
                $applications[] = $row;
            }
        }
    } else {
        $msg = "No student found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Applications</title>
    <style>
        body {
            background: #f0f0f0;
            font-family: sans-serif;
            padding: 20px;
        }

        .topbar {
            background: #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }

        .topbar h2 {
            margin: 0;
        }

        .search-box {
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            margin-bottom: 25px;
        }

        input[type="number"] {
            padding: 8px;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        button {
            background: blue;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }

        .student-info, .apps-box {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #bbb;
        }

        .app-item {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        .status {
            padding: 5px 10px;
            background: lightgray;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .error-msg {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="topbar">
    <h2>My Applications - DTU</h2>
</div>

<div class="search-box">
    <form method="post">
        <label>Enter Student ID:</label><br>
        <input type="number" name="student_id" required placeholder="e.g., 1"><br>
        <button type="submit" name="search_student">Search</button>
    </form>
</div>

<?php if ($msg != ""): ?>
    <p class="error-msg"><?php echo $msg; ?></p>
<?php endif; ?>

<?php if ($student): ?>
    <div class="student-info">
        <h3>Student Details</h3>
        <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        <p><strong>Branch:</strong> <?php echo $student['branch']; ?></p>
        <p><strong>CGPA:</strong> <?php echo $student['cgpa']; ?></p>
    </div>


    <div class="apps-box">
        <h3>Applications</h3>

        <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $app): ?>
                <div class="app-item">
                    <p><strong>Job:</strong> <?php echo $app['title']; ?> (<?php echo $app['job_type']; ?>)</p>
                    <p><strong>Company:</strong> <?php echo $app['company_name']; ?></p>
                    <p><strong>Location:</strong> <?php echo $app['location']; ?></p>
                    <p><strong>Stipend/CTC:</strong> <?php echo $app['stipend_ctc']; ?></p>
                    <p><strong>Applied On:</strong> <?php echo $app['date_applied']; ?></p>
                    <p><span class="status"><?php echo $app['status']; ?></span></p>
                    <?php if ($app['interview_date']): ?>
                        <p><strong>Interview:</strong> <?php echo $app['interview_date']; ?> (<?php echo $app['mode']; ?>)</p>
                        <p><strong>Result:</strong> <?php echo $app['result']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

       
        <?php else: ?>
            <p>No applications found for this student.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
