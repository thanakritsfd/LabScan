<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="image/logo.jpg" type="image/x-icon">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>LabScan</title>
    <style>
        @font-face {
            font-family: 'Kanit';
            src: url('font/Kanit-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'LabScan';
            src: url('font/Lobster-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            background-color: #dee9ff;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Kanit', sans-serif;
        }

        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .form-container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* margin-top: 80px; */
        }

        .navbar {
            margin: 0;
            padding: 0;
        }

        .navbar .navbar-brand img {
            border-radius: 5px;
        }

        .navbar .navbar-brand-text {
            right: 0;
            font-size: 30px;
            color: black;
            font-family: 'LabScan';
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="image/logo.jpg" alt="Logo" width="50px" height="50px" class="d-inline-block align-text-top">
            </a>
            <div class="navbar-brand-text">
                LabScan
            </div>
        </div>
    </nav>
    <div class="form-container">
        <form id="myForm" action="print.php" method="post" target="outputFrame">
            <div class="mb-3">
                <label for="barcode" class="form-label">Scan Barcode</label>
                <input placeholder="Please Scan" style="background-color: #dee9ff; border-radius: 9px;" type="number" class="form-control" id="barcode" name="barcode">
            </div>
            <button type="submit" class="btn btn-primary" hidden>Submit</button>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Print Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <iframe name="outputFrame" src="" frameborder="0" id="outputFrame" width="420px;" height="250px"></iframe>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" onclick="printIframe()">Print</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("myForm").addEventListener("submit", function(event) {
            var barcodeInput = document.getElementById("barcode").value;

            if (barcodeInput === "" || barcodeInput == 0) {
                event.preventDefault();
                alert("Please enter a valid barcode number.");
                return false;
            }

            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            myModal.show();
            setTimeout(resetForm, 100);
        });

        function resetForm() {
            document.getElementById("myForm").reset();
        }

        function printIframe() {
            var iframe = document.getElementById('outputFrame');
            if (iframe) {
                iframe.contentWindow.focus(); // Focus on the iframe content
                iframe.contentWindow.print(); // Trigger print dialog
            } else {
                alert("No content available to print.");
            }
        }
    </script>
</body>

</html>