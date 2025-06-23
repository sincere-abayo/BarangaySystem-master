<?php include('dashboard_sidebar_start_staff.php'); ?>
<?php
require('classes/Authentication.php');
require('classes/Certificate.php');
$auth = new Authentication();
$certificate = new Certificate();
$userdetails = $auth->get_userdata();
$indigencies = $certificate->view_certofindigency();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Indigency Report</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <style>
        .filter-row {
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Indigency Report</h2>
        <div class="row filter-row">
            <div class="col-md-3 mb-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search indigency certificates...">
            </div>
            <div class="col-md-3 mb-2">
                <input type="number" id="filterYear" class="form-control" placeholder="Year (e.g. 2024)">
            </div>
            <div class="col-md-3 mb-2">
                <select id="filterMonth" class="form-control">
                    <option value="">All Months</option>
                    <?php for ($m = 1; $m <= 12; $m++)
                        echo '<option value="' . sprintf('%02d', $m) . '">' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>'; ?>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" id="filterStart" class="form-control" placeholder="Start Date">
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" id="filterEnd" class="form-control" placeholder="End Date">
            </div>
            <div class="col-md-2 mb-2">
                <button class="btn btn-secondary w-100" onclick="clearFilters()">Clear Filters</button>
            </div>
        </div>
        <div class="mb-3">
            <strong>Total Indigency Certificates:</strong> <span
                id="totalIndigencies"><?= is_array($indigencies) ? count($indigencies) : 0 ?></span>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="indigencyTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Cert. No.</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Purpose</th>
                        <th>Issue Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($indigencies))
                        foreach ($indigencies as $ind) { ?>
                            <tr>
                                <td><?= str_pad($ind['id_indigency'], 6, '0', STR_PAD_LEFT) ?></td>
                                <td><?= htmlspecialchars($ind['fname'] . ' ' . $ind['mi'] . ' ' . $ind['lname']) ?></td>
                                <td><?= htmlspecialchars($ind['age'] ?? '') ?></td>
                                <td><?= htmlspecialchars($ind['houseno'] . ', ' . $ind['street'] . ', ' . $ind['brgy'] . ', ' . $ind['municipal']) ?>
                                </td>
                                <td><?= htmlspecialchars($ind['purpose']) ?></td>
                                <td><?= htmlspecialchars($ind['date']) ?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" onclick="exportPDF()">Export to PDF</button>
    </div>
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterYear = document.getElementById('filterYear');
        const filterMonth = document.getElementById('filterMonth');
        const filterStart = document.getElementById('filterStart');
        const filterEnd = document.getElementById('filterEnd');
        const table = document.getElementById('indigencyTable');
        const totalIndigencies = document.getElementById('totalIndigencies');
        function filterTable() {
            let count = 0;
            const search = searchInput.value.toLowerCase();
            const year = filterYear.value;
            const month = filterMonth.value;
            const start = filterStart.value;
            const end = filterEnd.value;
            Array.from(table.tBodies[0].rows).forEach(row => {
                let show = true;
                const text = row.textContent.toLowerCase();
                if (search && !text.includes(search)) show = false;
                const date = row.cells[5].textContent;
                if (year && (!date || !date.startsWith(year))) show = false;
                if (month && (!date || date.substr(5, 2) !== month)) show = false;
                if (start && (!date || date < start)) show = false;
                if (end && (!date || date > end)) show = false;
                row.style.display = show ? '' : 'none';
                if (show) count++;
            });
            totalIndigencies.textContent = count;
        }
        [searchInput, filterYear, filterMonth, filterStart, filterEnd].forEach(el => el.addEventListener('input', filterTable));
        function clearFilters() {
            searchInput.value = '';
            filterYear.value = '';
            filterMonth.value = '';
            filterStart.value = '';
            filterEnd.value = '';
            filterTable();
        }
        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l');
            doc.text('Indigency Report', 14, 16);
            doc.autoTable({
                html: '#indigencyTable',
                startY: 22,
                headStyles: { fillColor: [41, 128, 185] },
                styles: { fontSize: 9 }
            });
            doc.save('indigency_report.pdf');
        }
        window.onload = filterTable;
    </script>
</body>

</html>
<?php include('dashboard_sidebar_end.php'); ?>