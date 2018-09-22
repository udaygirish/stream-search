<?php
    $search_term = isset($_GET['q']) ? $_GET['q'] : 'nothing';

    $mysql_server = "localhost";
    $mysql_username = "root";
    $mysql_password = "root";
    $database_name = "storilabs";
    $table_name = "cloud_table";

    $conn = new mysqli($mysql_server, $mysql_username, $mysql_password, $database_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "select * from $table_name where object_name like '%$search_term%'";
    $query_result = $conn->query($sql);
    $results = array();
    while($row = $query_result->fetch_assoc())
    {
        $results[] = $row;
    }

    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Stream search</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div style="margin-top: 10vh">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">Stream search</h1>
            <!-- <h5 class="animated fadeIn mb-3">Enter the search term and click search</h5> -->
            <div class="flex-center col-md-8">
                <form class="md-form input-group">
                    <input type="text" value="<?= isset($_GET['q']) ? $_GET['q'] : ''; ?>" name="q" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button class="btn btn-primary waves-effect m-0" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <?php if (count($results) > 0) { ?>
                <p class="h5">Results (<?= count($results) ?>)</p><br/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            <?php foreach($results as $row) { ?>
                                <a class="list-group-item list-group-item-action" id="list-home-list-<?=  $row["object_id"] ?>" data-toggle="list" href="#list-home-<?=  $row["object_id"] ?>" role="tab" aria-controls="home"><?=  $row["object_name"] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="nav-tabContent">
                            <?php foreach($results as $row) { ?>
                            <div class="tab-pane fade show" id="list-home-<?=  $row["object_id"] ?>" role="tabpanel" aria-labelledby="list-home-list-<?=  $row["object_id"] ?>">
                                    <iframe height="500vh" width="100%" src="<?= $row["stream_url"] ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } else { ?><div class="flex-center"><p class="h5">No results <img width="20px" height="20px" src="img/no.png"/></p></div><?php } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
</body>

</html>