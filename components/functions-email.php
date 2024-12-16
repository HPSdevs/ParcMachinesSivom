<?php


function sendDemandeintervention()
{
  // from page-addintervention.php
  require_once("./controllers/ctrl-utilisateur.php");
  $config = parse_ini_file("./configx-hps/config-email.ini");
  if ($config['sendmail']) {
    // Email a envoyer a tous les chefs meca
    $listto = CallGetUserChefMeca();
    foreach ($listto as $to) {
      //base
      $subject = $config['titdeminter'];
      $message = $config['txtdeminter'];
      $headers = array(
        'From' => $config['appemail'],
        'Reply-To' => $config['appemail'],
        'X-Mailer' => 'PHP/' . phpversion()
      );
      mail($to['courriel'], $subject, $message, $headers);
    }
  }
}

function sendFinIntervention($iddestinataire)
{
  // from page-voirintervention.php
  require_once("./controllers/ctrl-utilisateur.php");
  $config = parse_ini_file("./configx-hps/config-email.ini");
  if ($config['sendmail']) {
    // Email a envoyer au demandeur initial de la demande d'intervention
    $to = CallGetUserEmail($iddestinataire);
    //base
    $subject = $config['titfininter'];
    $message = $config['txtfininter'];
    $headers = array(
      'From' => $config['appemail'],
      'Reply-To' => $config['appemail'],
      'X-Mailer' => 'PHP/' . phpversion()
    );
    mail($to, $subject, $message, $headers);
  }
}
