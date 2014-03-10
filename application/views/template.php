<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="<?=  base_url(); ?>css/template.css">
</head>
<body>
  <div id="header">
  <?php $this->load->view('header');?>
  </div>
  
  <div id="main">
  <?php $this->load->view($main);?>
  </div>
  
</body>
</html>
