<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= isset($pageTitle)? $pageTitle : '' ?> - <?= getenv('CLINIC_NAME'); ?></title>
    <link rel="shortcut icon" href="<?= getenv('CLIENT_LOGO') ?>" type="image/png">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
    
    <link rel="stylesheet" href="/DataTables/DataTables-1.11.3/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="/DataTables/Buttons-2.0.1/css/buttons.bootstrap5.min.css" />

    <link rel="stylesheet" href="/animate.css/animate.min.css" />
    <?= $this->renderSection('module-css') ?>
    <!-- <link rel="stylesheet" href="/dropzone@5/dropzone.min.css" type="text/css" /> -->
    <link rel="stylesheet" href="/paper.css" />
    <link rel="stylesheet" href="/style.css" />

    
    <script defer src="/alpinejs/cdn.js"></script> 
    <script defer src="/customjs.js"></script>
    
    <script defer src="/DataTables/buttons.html5.min.js"> </script> 
    <script defer src="/DataTables/buttons.print.min.js"> </script>
    <script defer src="/DataTables/dataTables.buttons.min.js"> </script>
    <script defer src="/DataTables/jquery.dataTables.min.js"> </script>
    <script src="/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- <script defer src="/dropzone@5/dropzone.min.js"></script> -->
    <!-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> -->


</head>
<body>

   <?= $this->renderSection('content') ?>

   <script src="/bootstrap/js/jquery.js"></script>
   <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="/DataTables/datatables.min.js"></script>
   <?= $this->renderSection('script') ?>
  
</body>
</html>