<?php
// require the database connection
require 'classes/conn.php';
if (isset($_POST['search_certofindigency'])) {
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> village </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
        </tr>
    </thead>

    <tbody>
        <?php

            $stmnt = $conn->prepare("SELECT * FROM `tbl_indigency` WHERE `lname` LIKE '%$keyword%' or  `mi` LIKE '%$keyword%' or  `fname` LIKE '%$keyword%' 
                or  `id_resident` LIKE '%$keyword%' or  `nationality` LIKE '%$keyword%' or  `houseno` LIKE '%$keyword%'
            or `street` LIKE '%$keyword%' or `brgy` LIKE '%$keyword%' or `municipal` LIKE '%$keyword%' or `date` LIKE '%$keyword%' or `purpose` LIKE '%$keyword%'");
            $stmnt->execute();

            while ($certificate_data = $stmnt->fetch()) {
                ?>
        <tr>
            <td>
                <form action="" method="post">
                    <a class="btn btn-success" target="blank"
                        style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                        href="indigency_form.php?id_resident=<?= $certificate_data['id_resident']; ?>">Generate</a>
                    <button type="button" class="btn btn-info notify-btn"
                        style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                        data-service-type="certificate_indigency"
                        data-resident-id="<?= $certificate_data['id_resident']; ?>"
                        data-certificate-id="<?= $certificate_data['id_indigency']; ?>"
                        <?= $certificate_data['notification_sent'] ? 'disabled' : '' ?>>
                        <?= $certificate_data['notification_sent'] ? 'Notified' : 'Notify' ?>
                    </button>
                    <input type="hidden" name="id_indigency" value="<?= $certificate_data['id_indigency']; ?>">
                    <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;"
                        type="submit" name="delete_certofindigency"> Archive </button>
                </form>
            </td>
            <td> <?= $certificate_data['id_resident']; ?> </td>
            <td> <?= $certificate_data['lname']; ?> </td>
            <td> <?= $certificate_data['fname']; ?> </td>
            <td> <?= $certificate_data['mi']; ?> </td>
            <td> <?= $certificate_data['nationality']; ?> </td>
            <td> <?= $certificate_data['houseno']; ?> </td>
            <td> <?= $certificate_data['street']; ?> </td>
            <td> <?= $certificate_data['brgy']; ?> </td>
            <td> <?= $certificate_data['municipal']; ?> </td>
            <td> <?= $certificate_data['purpose']; ?> </td>
            <td> <?= $certificate_data['date']; ?> </td>
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> village </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
        </tr>
    </thead>

    <tbody>
        <?php if (is_array($view)) { ?>
        <?php foreach ($view as $certificate_data) { ?>
        <tr>
            <td>
                <form action="" method="post">
                    <a class="btn btn-success" target="blank"
                        style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                        href="indigency_form.php?id_resident=<?= $certificate_data['id_resident']; ?>">Generate</a>
                    <button type="button" class="btn btn-info notify-btn"
                        style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"
                        data-service-type="certificate_indigency"
                        data-resident-id="<?= $certificate_data['id_resident']; ?>"
                        data-certificate-id="<?= $certificate_data['id_indigency']; ?>"
                        <?= $certificate_data['notification_sent'] ? 'disabled' : '' ?>>
                        <?= $certificate_data['notification_sent'] ? 'Notified' : 'Notify' ?>
                    </button>
                    <input type="hidden" name="id_indigency" value="<?= $certificate_data['id_indigency']; ?>">
                    <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;"
                        type="submit" name="delete_certofindigency"> Archive </button>
                </form>
            </td>
            <td> <?= $certificate_data['id_resident']; ?> </td>
            <td> <?= $certificate_data['lname']; ?> </td>
            <td> <?= $certificate_data['fname']; ?> </td>
            <td> <?= $certificate_data['mi']; ?> </td>
            <td> <?= $certificate_data['nationality']; ?> </td>
            <td> <?= $certificate_data['houseno']; ?> </td>
            <td> <?= $certificate_data['street']; ?> </td>
            <td> <?= $certificate_data['brgy']; ?> </td>
            <td> <?= $certificate_data['municipal']; ?> </td>
            <td> <?= $certificate_data['purpose']; ?> </td>
            <td> <?= $certificate_data['date']; ?> </td>
        </tr>
        <?php
                }
                ?>
        <?php
            }
            ?>
    </tbody>

</table>

<?php
}
$con = null;
?>