<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getenv('CLINIC_NAME'); ?></title>
    <link rel="shortcut icon" href="<?= getenv('CLIENT_LOGO') ?>" type="image/png">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
    
    <link rel="stylesheet" href="/DataTables/datatables.min.css" />

    <link rel="stylesheet" href="/animate.css/animate.min.css" />
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/paper.css" />

    
    <script defer src="/customjs.js"></script>
    <script defer src="/alpinejs/cdn.js"></script> 
    
    <script defer src="/DataTables/buttons.html5.min.js"> </script> 
    <script defer src="/DataTables/buttons.print.min.js"> </script>
    <script defer src="/DataTables/dataTables.buttons.min.js"> </script>
    <script defer src="/DataTables/jquery.dataTables.min.js"> </script>
    <script src="/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>

   <?= $this->renderSection('content') ?>

   <script src="/bootstrap/js/jquery.js"></script>
   <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="/DataTables/datatables.min.js"></script>
   <?= $this->renderSection('script') ?>
  
</body>
</html>