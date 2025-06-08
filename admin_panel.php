<!DOCTYPE html>
<html>
<head>
    <title>DTU Admin Panel</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f1f1f1;
            padding: 20px;
        }

        .navbar {
            background: #ffffff;
            padding: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
            display: inline-block;
        }

        .nav-links {
            float: right;
        }

        .nav-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #333;
        }

        .header {
            background: #ddd;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .container h3 {
            margin-top: 0;
        }

        .notice {
            background: #ffffcc;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #cccc99;
        }

        @media screen and (max-width: 600px) {
            .nav-links {
                float: none;
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>DTU Placement Portal</h2>
        <div class="nav-links">
            <a href="index.php">Student Panel</a>
            <a href="admin_panel.php">Admin Panel</a>
        </div>
    </div>

    <div class="header">
        <h1>Admin Panel</h1>
        <p>Job Posting & Management</p>
    </div>

    <div class="container">
        <h3>Coming Soon</h3>
        <p>This page is for administrators to post job & internship listings.</p>

        <div class="notice">
            <strong>Note:</strong> This panel is currently under development. In future versions, it will allow company HRs or admins to add, update, and remove listings from the database.
        </div>
    </div>

</body>
</html>
