<?php
// require the database connection
require 'classes/conn.php';
if (isset($_POST['search_clearance'])) {
    $keyword = $_POST['keyword'];
    ?>
    <table class="table table-hover text-center table-bordered table-responsive">
        <thead class="alert-info">
            <tr>
                <th> Actions</th>
                <th> Resident ID </th>
                <th> Surname </th>
                <th> First Name </th>
                <th> Middle Name </th>
                <th> Purpose </th>
                <th> House No. </th>
                <th> Street </th>
                <th> Village </th>
                <th> Municipality </th>
                <th> Status </th>
                <th> Age </th>
            </tr>
        </thead>

        <tbody>
            <?php
            $stmnt = $conn->prepare("SELECT * FROM `tbl_clearance` WHERE `lname` LIKE '%$keyword%' or  `mi` LIKE '%$keyword%' or  `fname` LIKE '%$keyword%' 
            or `age` LIKE '%$keyword%' or  `id_resident` LIKE '%$keyword%' or  `nationality` LIKE '%$keyword%' or  `houseno` LIKE '%$keyword%'
            or `street` LIKE '%$keyword%' or `brgy` LIKE '%$keyword%' or `municipal` LIKE '%$keyword%' or `date` LIKE '%$keyword%' or `purpose` LIKE '%$keyword%'");
            $stmnt->execute();

            while ($clearance_data = $stmnt->fetch()) {
                ?>
                <tr>
                    <td>
                        <form action="" method="post">
                            <a class="btn btn-success" target="blank"
                                style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                                href="brgyclearance_form.php?id_resident=<?= $clearance_data['id_resident']; ?>">Generate</a>
                            <button type="button" class="btn btn-info notify-btn"
                                style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                                data-service-type="clearance" data-resident-id="<?= $clearance_data['id_resident']; ?>"
                                data-certificate-id="<?= $clearance_data['id_clearance']; ?>"
                                <?= $clearance_data['notification_sent'] ? 'disabled' : '' ?>>
                                <?= $clearance_data['notification_sent'] ? 'Notified' : 'Notify' ?>
                            </button>
                            <input type="hidden" name="id_clearance" value="<?= $clearance_data['id_clearance']; ?>">
                            <button class="btn btn-danger" type="submit"
                                style="width: 90px; font-size: 17px; border-radius:30px;" name="delete_clearance"> Archive
                            </button>
                        </form>
                    </td>
                    <td> <?= $clearance_data['id_resident']; ?> </td>
                    <td> <?= $clearance_data['lname']; ?> </td>
                    <td> <?= $clearance_data['fname']; ?> </td>
                    <td> <?= $clearance_data['mi']; ?> </td>
                    <td> <?= $clearance_data['purpose']; ?> </td>
                    <td> <?= $clearance_data['houseno']; ?> </td>
                    <td> <?= $clearance_data['street']; ?> </td>
                    <td> <?= $clearance_data['brgy']; ?> </td>
                    <td> <?= $clearance_data['municipal']; ?> </td>
                    <td> <?= $clearance_data['status']; ?> </td>
                    <td> <?= $clearance_data['age']; ?> </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <?php
} else {
    ?>

    <table class="table table-hover text-center table-bordered table-responsive">
        <thead class="alert-info">
            <tr>
                <th> Actions</th>
                <th> Resident ID </th>
                <th> Surname </th>
                <th> First Name </th>
                <th> Middle Name </th>
                <th> Purpose </th>
                <th> House No. </th>
                <th> Street </th>
                <th> Village </th>
                <th> Municipality </th>
                <th> Status </th>
                <th> Age </th>
            </tr>
        </thead>

        <tbody>
            <?php if (is_array($view)) { ?>
                <?php foreach ($view as $clearance_data) { ?>
                    <tr>
                        <td>
                            <form action="" method="post">
                                <a class="btn btn-success" target="blank"
                                    style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                                    href="brgyclearance_form.php?id_resident=<?= $clearance_data['id_resident']; ?>">Generate</a>
                                <button type="button" class="btn btn-info notify-btn"
                                    style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                                    data-service-type="clearance" data-resident-id="<?= $clearance_data['id_resident']; ?>"
                                    data-certificate-id="<?= $clearance_data['id_clearance']; ?>"
                                    <?= $clearance_data['notification_sent'] ? 'disabled' : '' ?>>
                                    <?= $clearance_data['notification_sent'] ? 'Notified' : 'Notify' ?>
                                </button>
                                <input type="hidden" name="id_clearance" value="<?= $clearance_data['id_clearance']; ?>">
                                <button class="btn btn-danger" type="submit"
                                    style="width: 90px; font-size: 17px; border-radius:30px;" name="delete_clearance"> Archive
                                </button>
                            </form>
                        </td>
                        <td> <?= $clearance_data['id_resident']; ?> </td>
                        <td> <?= $clearance_data['lname']; ?> </td>
                        <td> <?= $clearance_data['fname']; ?> </td>
                        <td> <?= $clearance_data['mi']; ?> </td>
                        <td> <?= $clearance_data['purpose']; ?> </td>
                        <td> <?= $clearance_data['houseno']; ?> </td>
                        <td> <?= $clearance_data['street']; ?> </td>
                        <td> <?= $clearance_data['brgy']; ?> </td>
                        <td> <?= $clearance_data['municipal']; ?> </td>
                        <td> <?= $clearance_data['status']; ?> </td>
                        <td> <?= $clearance_data['age']; ?> </td>
                    </tr>
                    <?php
                }
                ?>
                <?php
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"
        integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w=="
        crossorigin="anonymous"></script>
    <!-- responsive tags for screen compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <!-- custom css -->
    <link href="customcss/regiformstyle.css" rel="stylesheet" type="text/css">
    <!-- bootstrap css -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

    <?php
}
$con = null;
?>