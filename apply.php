<?php
$conn = new mysqli("localhost", "root", "", "dbms_project");

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

$id = $_GET['job_id'];
$msg = "";
$student = null;

$job_sql = "SELECT j.title, j.job_type, c.name as company_name FROM Job_Internship j 
            JOIN Company c ON j.company_id = c.company_id 
            WHERE j.job_id = $id";
$job_res = $conn->query($job_sql);
$job = $job_res->fetch_assoc();

if (isset($_POST['search_student'])) {
    $sid = $_POST['student_id'];
    $s_res = $conn->query("SELECT * FROM Student WHERE student_id = $sid");

    if ($s_res->num_rows > 0) {
        $student = $s_res->fetch_assoc();

        $applied = $conn->query("SELECT * FROM Application WHERE student_id = $sid AND job_id = $id");
        if ($applied->num_rows > 0) {
            $msg = "Already applied.";
        }
    } else {
        $msg = "No such student ID.";
    }
}

if (isset($_POST['apply_now'])) {
    $sid = $_POST['student_id'];
    $ins = "INSERT INTO Application (student_id, job_id, date_applied, status)
            VALUES ($sid, $id, CURDATE(), 'Applied')";
    if ($conn->query($ins)) {
        $msg = "Applied successfully!";
    } else {
        $msg = "Error while applying.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply Page</title>
    <style>
        body {
            background: #f3f3f3;
            font-family: sans-serif;
            padding: 30px;
        }

        .box {
            background: white;
            padding: 20px;
            width: 500px;
            margin: auto;
            border: 1px solid #ccc;
        }

        input {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
        }

        button {
            background: #337ab7;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .msg {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .info {
            background: #eef;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2><?php echo $job['title']; ?></h2>
        <p><strong>Company:</strong> <?php echo $job['company_name']; ?></p>

        <?php if ($msg): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>

        <?php if (!$student): ?>
            <form method="POST">
                <label>Enter Student ID:</label>
                <input type="number" name="student_id" required>
                <button type="submit" name="search_student">Find</button>
            </form>
        <?php else: ?>
            <div class="info">
                <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
                <p><strong>Branch:</strong> <?php echo $student['branch']; ?></p>
            </div>

            <?php if ($msg != "Already applied."): ?>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                    <button type="submit" name="apply_now">Apply Now</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <br>
        <a href="index.php">← Back to Jobs</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
