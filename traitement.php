<?php
// Inclure l'autoloader de Composer si vous l'avez utilisé
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupérer et nettoyer les données
    $emailExpediteur = filter_var(trim($_POST['email_expediteur']), FILTER_SANITIZE_EMAIL);
    $messageUtilisateur = htmlspecialchars(trim($_POST['message_texte']));

    // 2. Valider l'adresse email
    if (!filter_var($emailExpediteur, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email fournie n'est pas valide.";
        exit();
    }

    // 3. Définir votre adresse email de destinataire
    $votreEmail = "seboufarid43@gmail.com.com"; // <-- REMPLACEZ PAR VOTRE ADRESSE EMAIL RÉELLE

    // Initialiser PHPMailer
    $mail = new PHPMailer(true); // Passer 'true' active les exceptions pour un meilleur débogage

    try {
        // Configuration du serveur SMTP (Exemple avec Gmail SMTP)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ou smtp.outlook.com, smtp.mailgun.org, etc.
        $mail->SMTPAuth = true;
        $mail->Username = 'seboufarid43@gmail.com'; // Votre adresse email complète
        $mail->Password = 'farid2007'; // Votre mot de passe d'application (pour Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou ENCRYPTION_SMTPS pour le port 465
        $mail->Port = 587; // Port SMTP (587 pour STARTTLS, 465 pour SMTPS)

        // Destinataires
        $mail->setFrom('no-reply@votredomaine.com', 'Votre Site Web'); // Adresse d'envoi (doit être valide pour SMTP)
        $mail->addAddress($votreEmail); // Adresse du destinataire (votre email)
        $mail->addReplyTo($emailExpediteur, 'Expéditeur du formulaire'); // Pour répondre à l'utilisateur

        // Contenu de l'email
        $mail->isHTML(false); // Envoyer en texte brut
        $mail->Subject = "Nouveau message du formulaire de contact";
        $mail->Body    = "De : " . $emailExpediteur . "\n\nMessage :\n" . $messageUtilisateur;

        $mail->send();
        echo "Message envoyé avec succès !";
    } catch (Exception $e) {
        // Afficher l'erreur détaillée de PHPMailer
        echo "Erreur lors de l'envoi du message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode non autorisée.";
}
exit();
?>