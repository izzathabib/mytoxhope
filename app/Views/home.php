<!-- Import view from folder layouts and file app.php -->
<?= $this->extend('layouts/app.php'); ?>
<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyToxHope</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            margin: 10px;
            width: 22%;
            min-width: 200px;
        }

        .fa-home {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h4 class="text-left">
            <i class="fas fa-home"></i>
            <b>Malaysian Toxicological Data (Household Products) - MyToxHope</b>
        </h4>
        <div class="card-container">
            <div class="card">
                <img src="images/demo/flat/1.png" class="card-img-top"
                    alt="Toxicological / Poisoning Case Notification">
                <div class="card-body">
                    <h5 class="card-title">Toxicological / Poisoning Case Notification</h5>
                    <p class="card-text">Submission of online toxicological case notification that leads to automated
                        clinical information retrieval.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/demo/flat/2.png" class="card-img-top" alt="Identification of Poisoning Substances">
                <div class="card-body">
                    <h5 class="card-title">Identification of Poisoning Substances</h5>
                    <p class="card-text">Need to identify a specific agent involved in a poisoning incident? Health
                        professionals can utilise this function to aid identification of active substance prior to
                        submission of the notification form.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/demo/flat/3.png" class="card-img-top"
                    alt="Treatment and Clinical Information Retrieval">
                <div class="card-body">
                    <h5 class="card-title">Treatment and Clinical Information Retrieval</h5>
                    <p class="card-text">Health professionals need to log-in/register to submit the online notification
                        form of poisoning cases that are being managed before they are able to access clinical
                        information on the toxicity of the substance associated with the case.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/demo/flat/6.png" class="card-img-top" alt="Statistical Report Access for Stakeholders">
                <div class="card-body">
                    <h5 class="card-title">Statistical Report Access for Stakeholders</h5>
                    <p class="card-text">Relevant authorities/policy makers and licensed user can access real-time
                        analytical report of the toxicological cases notified via the system.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?= $this->endsection(); ?>