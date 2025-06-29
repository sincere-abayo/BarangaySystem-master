<?php
require('classes/Authentication.php');
require('classes/Blotter.php');
$auth = new Authentication();
$blotter_obj = new Blotter();
$auth->validate_admin();
$userdetails = $auth->get_userdata();

// DB Connection
$connection = $blotter_obj->openConn();
$sql = "SELECT * FROM tbl_blotter";
$params = [];
$filter_summary = "Showing all records";

// To retain selected values in form
$filter_type_val = $_POST['filter_type'] ?? '';
$selected_month = $_POST['month'] ?? '';
$selected_year_month = $_POST['year_month'] ?? '';
$selected_year_annual = $_POST['year_annual'] ?? '';
$start_date_val = $_POST['start_date'] ?? '';
$end_date_val = $_POST['end_date'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['filter_type'])) {
    $filter_type = $_POST['filter_type'];

    switch ($filter_type) {
        case 'monthly':
            if (!empty($_POST['month'])) {
                $month = $_POST['month'];
                $year = !empty($_POST['year_month']) ? $_POST['year_month'] : date('Y');
                $sql .= " WHERE YEAR(timeapplied) = ? AND MONTH(timeapplied) = ?";
                $params = [$year, $month];
                $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                $filter_summary = "Showing records for " . $monthName . ", " . $year;
            }
            break;
        case 'annually':
            if (!empty($_POST['year_annual'])) {
                $year = $_POST['year_annual'];
                $sql .= " WHERE YEAR(timeapplied) = ?";
                $params = [$year];
                $filter_summary = "Showing records for year " . $year;
            }
            break;
        case 'date_range':
            if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $sql .= " WHERE DATE(timeapplied) BETWEEN ? AND ?";
                $params = [$start_date, $end_date];
                $filter_summary = "Showing records from " . $start_date . " to " . $end_date;
            }
            break;
    }
}
$sql .= " ORDER BY timeapplied DESC";
$stmt = $connection->prepare($sql);
$stmt->execute($params);
$blotters = $stmt->fetchAll();
?>
<?php include('dashboard_sidebar_start.php'); ?>
<div class="container-fluid">
    <h1 class="mb-4 text-center">Blotter Report</h1>
    <hr>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Report</h6>
        </div>
        <div class="card-body">
            <form method="POST" class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label for="filter_type">Filter By:</label>
                    <select class="form-control" id="filter_type" name="filter_type">
                        <option value="" <?= $filter_type_val == '' ? 'selected' : '' ?>>Select...</option>
                        <option value="monthly" <?= $filter_type_val == 'monthly' ? 'selected' : '' ?>>Monthly</option>
                        <option value="annually" <?= $filter_type_val == 'annually' ? 'selected' : '' ?>>Annually</option>
                        <option value="date_range" <?= $filter_type_val == 'date_range' ? 'selected' : '' ?>>Date Range
                        </option>
                    </select>
                </div>

                <!-- Filters Container -->
                <div class="col-md-7 d-flex align-items-end">
                    <!-- Monthly Filter -->
                    <div id="monthly_filter" class="form-row" style="display: none; width: 100%;">
                        <div class="form-group col-md-6">
                            <label for="month">Month:</label>
                            <select class="form-control" name="month">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= $selected_month == $m ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $m, 1, date('Y'))) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="year_month">Year:</label>
                            <input type="number" class="form-control" name="year_month"
                                value="<?= $selected_year_month ?: date('Y') ?>">
                        </div>
                    </div>

                    <!-- Annually Filter -->
                    <div id="annually_filter" class="form-group" style="display: none;">
                        <label for="year_annual">Year:</label>
                        <input type="number" class="form-control" name="year_annual"
                            value="<?= $selected_year_annual ?: date('Y') ?>">
                    </div>

                    <!-- Date Range Filter -->
                    <div id="date_range_filter" class="form-row" style="display: none; width: 100%;">
                        <div class="form-group col-md-6">
                            <label for="start_date">From:</label>
                            <input type="date" class="form-control" name="start_date" value="<?= $start_date_val ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">To:</label>
                            <input type="date" class="form-control" name="end_date" value="<?= $end_date_val ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-success btn-block">Apply Filter</button>
                    <a href="admn_blotter_report.php" class="btn btn-secondary btn-block mt-2">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h5 class="mb-3"><em><?= htmlspecialchars($filter_summary) ?></em></h5>
            <button id="exportPDF" class="btn btn-primary mb-3">Export to PDF</button>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="blotterTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>House No</th>
                            <th>Street</th>
                            <th>Cell</th>
                            <th>Municipal</th>
                            <th>Contact</th>
                            <th>Narrative</th>
                            <th>Date/Time Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rownum = 1;
                        foreach ($blotters as $row): ?>
                            <tr>
                                <td><?= $rownum++ ?></td>
                                <td><?= htmlspecialchars($row['lname']) ?></td>
                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['mi']) ?></td>
                                <td><?= htmlspecialchars($row['houseno']) ?></td>
                                <td><?= htmlspecialchars($row['street']) ?></td>
                                <td><?= htmlspecialchars($row['brgy']) ?></td>
                                <td><?= htmlspecialchars($row['municipal']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['narrative']) ?></td>
                                <td><?= htmlspecialchars($row['timeapplied']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('dashboard_sidebar_end.php'); ?>
<!-- jsPDF and autotable CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
<script>
    // Logic to show/hide filters
    document.addEventListener('DOMContentLoaded', function () {
        const filterType = document.getElementById('filter_type');
        const monthlyFilter = document.getElementById('monthly_filter');
        const annuallyFilter = document.getElementById('annually_filter');
        const dateRangeFilter = document.getElementById('date_range_filter');

        function toggleFilters() {
            monthlyFilter.style.display = 'none';
            annuallyFilter.style.display = 'none';
            dateRangeFilter.style.display = 'none';

            switch (filterType.value) {
                case 'monthly':
                    monthlyFilter.style.display = 'flex';
                    break;
                case 'annually':
                    annuallyFilter.style.display = 'block';
                    break;
                case 'date_range':
                    dateRangeFilter.style.display = 'flex';
                    break;
            }
        }

        filterType.addEventListener('change', toggleFilters);
        toggleFilters(); // Run on page load to show correct filter if already selected
    });

    // PDF Export
    document.getElementById('exportPDF').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'landscape' });
        const filterSummary = "<?= htmlspecialchars($filter_summary, ENT_QUOTES) ?>";

        // Improved heading
        doc.setFontSize(22);
        doc.setFont('helvetica', 'bold');
        doc.text('Nyarutarama Blotter Report', doc.internal.pageSize.getWidth() / 2, 18, { align: 'center' });

        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text(filterSummary, doc.internal.pageSize.getWidth() / 2, 26, { align: 'center' });

        // Table
        doc.autoTable({
            html: '#blotterTable',
            startY: 32,
            headStyles: { fillColor: [41, 128, 185] },
            styles: { fontSize: 8 },
            margin: { left: 14, right: 14 },
            didDrawPage: function (data) {
                // Footer with line, page number, and message
                const pageHeight = doc.internal.pageSize.height;
                const pageWidth = doc.internal.pageSize.width;
                doc.setDrawColor(180);
                doc.setLineWidth(0.2);
                doc.line(data.settings.margin.left, pageHeight - 16, pageWidth - data.settings.margin.right, pageHeight - 16);
                doc.setFontSize(10);
                doc.setTextColor(100);
                doc.text('Generated by Nyarutarama Management System', data.settings.margin.left, pageHeight - 10);
                const pageNum = 'Page ' + doc.internal.getNumberOfPages();
                doc.text(pageNum, pageWidth - data.settings.margin.right, pageHeight - 10, { align: 'right' });
            }
        });
        doc.save('blotter_report.pdf');
    });
</script>