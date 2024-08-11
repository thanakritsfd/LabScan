<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="image/logo.jpg" type="image/x-icon">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <title>LabPrint</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        @font-face {
            font-family: 'BarcodeFont';
            src: url('font/barcode.ttf') format('truetype');
        }

        @font-face {
            font-family: 'THSarabunPSK';
            src: url('font/THSarabun_1.ttf') format('truetype');
        }

        body {
            font-family: 'THSarabunPSK', sans-serif;
            font-size: 12px;
            transform: scale(1.8);
            transform-origin: 0 0;
            overflow: hidden!important;
        }

        .barcode {
            font-family: 'BarcodeFont';
            font-size: 12px;
            letter-spacing: 2px;
            margin-top: 15px;
            text-align: center;
        }

        .vertical-270 {
            transform: rotate(270deg);
            transform-origin: center center;
            position: absolute;
            transform: translate(-50%, -50%) rotate(270deg);
            white-space: nowrap;
            display: table-cell;
            vertical-align: middle;
        }

        .bottom p {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        table {
            width: 2.3in;
            height: 1.2in;
        }

        /* 
        td,
        tr {
            border: 1px solid #000;
        } */
        #content {
            visibility: hidden;
        }

        .spinner-container {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            height: 100vh;
            /* Full viewport height */
            position: fixed;
            /* Fixed to stay in place */
            width: 100vw;
            /* Full viewport width */
            top: 0;
            left: 0;
            z-index: 1050;
            /* Ensure it is above other content */
        }

        #spinner {
            width: 10rem;
            height: 10rem;
        }
    </style>
</head>

<body>
    <div class="spinner-container">
        <div id="spinner" class="spinner-border" role="status"></div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $barcode = $_POST['barcode'];
        $patientorderuids = substr($barcode, 0, 10);
    }
    ?>
    <table style="float: left;" id="content">
        <tbody>
            <tr>
                <td width="auto">
                    <div class="center barcode"><?php echo htmlspecialchars("*" . $barcode . "*"); ?></div>
                </td>
                <td rowspan="2" style="font-weight: bold;">
                    <p class="vertical-270" id="HN"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="bottom" style="font-weight: bold;">
                        <p id="Name"></p>
                        <p id="DOB"></p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>

<script>
    document.getElementById('spinner').style.display = 'block';
    var patientOrderUids = <?php echo json_encode($patientorderuids); ?>;
    $.ajax({
        url: 'http://192.168.5.246:8081/LabScan',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            "patientorderuids": patientOrderUids
        }),
        async: true,
        success: function(getData) {
            var Name = document.getElementById("Name");
            var HN = document.getElementById("HN");
            var DOB = document.getElementById("DOB");

            var isoDate = getData.data.dateofbirth;
            var date = new Date(isoDate);
            var day = String(date.getUTCDate()).padStart(2, '0');
            var month = String(date.getUTCMonth() + 1).padStart(2, '0');
            var year = date.getUTCFullYear();
            var formattedDate = `${day}/${month}/${year}`;

            var title = (getData.data.title !== undefined && getData.data.title !== null && getData.data.title !== "") ? getData.data.title : "";
            var firstname = (getData.data.firstname !== undefined && getData.data.firstname !== null && getData.data.firstname !== "") ? getData.data.firstname : "";
            var middlename = (getData.data.middlename !== undefined && getData.data.middlename !== null && getData.data.middlename !== "") ? getData.data.middlename : "";
            var lastname = (getData.data.lastname !== undefined && getData.data.lastname !== null && getData.data.lastname !== "") ? getData.data.lastname : "";

            HN.innerHTML = "HN : " + getData.data.HN;
            Name.innerHTML = "Pt : " + title + " " + firstname + " " + middlename + " " + lastname;
            DOB.innerHTML = "DOB : " + formattedDate;

            document.getElementById('spinner').style.display = 'none';
            document.getElementById('content').style.visibility = 'visible';
            // print();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
        }
    });
</script>