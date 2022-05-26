<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getenv('CLINIC_NAME'); ?></title>
    <link rel="shortcut icon" href="/assets/icons/zana-icon.png" type="image/png">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" href="/style.css" />
    <script defer src="/alpinejs/cdn.js"></script>

</head>
<body>

   <?= $this->renderSection('content') ?>

   <script src="/bootstrap/js/jquery.js"></script>
   <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="/DataTables/datatables.min.js"></script>
   <?= $this->renderSection('script') ?>
  
</body>
</html>