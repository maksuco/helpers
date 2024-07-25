<?php
if($config['email-align']=='text-left'){
  $config['email-logo-align'] = 'pl-2';
} elseif($config['email-align']=='text-right'){
  $config['email-logo-align'] = 'ml-auto pr-2';
} else {
  $config['email-logo-align'] = 'mx-auto px-1';
}
?>
//RESET STYLES
.email-body {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  width: 100%;
  min-width: 100%;
  height: 100%;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  mso-line-height-rule: exactly;
  @apply <?= $config['email-text'] ?> <?= $config['email-bg'] ?> !bg-none;
  
  center {
    width: 100%;
    @apply <?= $config['email-bg'] ?>;
  }
  
  img {
    display: block;
    object-fit: cover;
    width: 100%;
    height: auto;
    border: 0 none;
    line-height: 100%;
    outline: none;
    overflow: hidden;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }
  
  .email-img-v {
    height: 100%;
    max-height: 350px;
  }
  
  a img{
    border: 0 none;
  }
  
  table{
    font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
    border: 0 solid white !important;
    border-width: 0 !important;
  }
  
  table, td{
    position: relative;
    border-spacing: 0px;
    border-collapse: collapse;
    @apply <?= $config['email-bg'] ?>;
  }
  
  th,
  td,
  p {
    margin: 0;
  }
  
  //GRID
  .container {
    width: 100% !important;
    max-width: 660px !important;
    margin: 0 auto;
    @apply <?= $config['email-padding'] ?> <?= $config['email-bg'] ?>;
  }
  
  .email-logo {
    @apply <?= $config['email-align'] ?> <?= $config['email-padding'] ?>;
  }
  .email-logo-img {
    display: block;
    width: auto;
    height: auto;
    @apply <?= $config['email-logo-height'] ?> <?= $config['email-logo-align'] ?>;
  }
  
  .email-subject {
    display: block;
    width: 100%;
    @apply <?= $config['email-align'] ?> <?= $config['email-padding'] ?>;
  }
  
  .email-content {
    @apply <?= $config['email-align'] ?> <?= $config['email-text'] ?> <?= $config['email-content'] ?>;
  }
  
  .email-footer {
    @apply <?= $config['email-align'] ?>;
  }
  
  .email-box {
  }
  
  .email-p {
    @apply <?= $config['email-align'] ?>;
  }
  
  .footer {
    width: 100%;
    @apply <?= $config['email-align'] ?>;
  }
}
