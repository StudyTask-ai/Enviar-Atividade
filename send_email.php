<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $to = 'luansilva8521@outlook.com.br'; // Seu e-mail
    $subject = 'Nova Atividade Enviada';
    $message = "Nome: $name\n";
    
    // Criação do cabeçalho do e-mail
    $headers = "From: no-reply@seusite.com\r\n";
    $headers .= "Reply-To: no-reply@seusite.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";
    
    // Montando o corpo do e-mail
    $body = "--boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n";
    $body .= "--boundary\r\n";
    
    // Anexando o arquivo
    if (is_uploaded_file($_FILES['activityImage']['tmp_name'])) {
        $fileName = $_FILES['activityImage']['name'];
        $fileContent = file_get_contents($_FILES['activityImage']['tmp_name']);
        $fileContent = chunk_split(base64_encode($fileContent));
        
        $body .= "Content-Type: application/octet-stream; name=\"$fileName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
        $body .= $fileContent . "\r\n";
        $body .= "--boundary--";
        
        // Enviar e-mail
        if (mail($to, $subject, $body, $headers)) {
            echo "Atividade enviada com sucesso!";
        } else {
            echo "Erro ao enviar a atividade.";
        }
    } else {
        echo "Nenhum arquivo foi enviado.";
    }
} else {
    echo "Método inválido.";
}
?>