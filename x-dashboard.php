<html>
<head>
    <title>Dashboard - Machine Learning Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Dashboard</h4>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                    <div class="card-body">
                        <form action="clicked.php" method="post" class="mb-4">
                            <button type="submit" class="btn btn-success btn-lg">CLICK ME</button>
                        </form>

                        <div class="alert alert-info">
                            <strong>Your Score:</strong> <?php echo $userscore; ?>
                        </div>

                        <h5>Leaderboard</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($leaderboard as $row) {
                                    echo "<tr><td>" . htmlspecialchars($row['email']) . "</td><td>" . htmlspecialchars($row['score']) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
