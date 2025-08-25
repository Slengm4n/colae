<?php
// Inclui o autoload do Composer.
require_once BASE_PATH . '/vendor/autoload.php';

require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/core/AuthHelper.php';

// Usa as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class AuthController
{
    public function index()
    {
        require_once BASE_PATH . '/app/views/auth/login.php';
    }

    /**
     * Mostra a página de registro de novo usuário.
     */
    public function register()
    {
        require_once BASE_PATH . '/app/views/auth/register.php';
    }

    /**
     * Processa a tentativa de login.
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                AuthHelper::start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    header('Location: ' . BASE_URL . '/dashboard');
                }
                exit;
            } else {
                $error = "Email ou senha inválidos.";
                require_once BASE_PATH . '/app/views/auth/login.php';
            }
        }
    }

    /**
     * Salva o novo usuário vindo do formulário de registro.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $birthdate = $_POST['birthdate'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($password) || empty($birthdate)) {
                $error = "Todos os campos são obrigatórios.";
                require_once BASE_PATH . '/app/views/auth/register.php';
                return;
            }

            if (User::findByEmail($email)) {
                 $error = "Este e-mail já está cadastrado.";
                 require_once BASE_PATH . '/app/views/auth/register.php';
                 return;
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if (User::create($name, $email, $birthdate, $password_hash)) {
                header('Location: ' . BASE_URL . '/login?status=success');
                exit;
            } else {
                $error = "Ocorreu um erro ao criar sua conta.";
                require_once BASE_PATH . '/app/views/auth/register.php';
            }
        }
    }
    
    /**
     * Efetua o logout do usuário.
     */
    public function logout()
    {
        AuthHelper::start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function showForgotPasswordForm()
    {
        require_once BASE_PATH . '/app/views/auth/forgot_password.php';
    }

    /**
     * Processa a solicitação de redefinição de senha.
     */
    public function sendResetLink()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $user = User::findByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                User::savePasswordResetToken($email, $token, $expires_at);
                $this->sendPasswordResetEmail($email, $token);
            }

            $message = "Se uma conta com este e-mail existir, um link de recuperação foi enviado.";
            $status = "success";
            require_once BASE_PATH . '/app/views/auth/forgot_password.php';
        }
    }

    /**
     * Mostra o formulário para redefinir a senha, validando o token.
     */
    public function showResetPasswordForm()
    {
        $token = $_GET['token'] ?? '';
        $reset_data = User::findResetToken($token);

        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            $error = "Token inválido ou expirado. Por favor, solicite um novo link de recuperação.";
            require_once BASE_PATH . '/app/views/error.php';
            return;
        }

        require_once BASE_PATH . '/app/views/auth/reset_password.php';
    }

    /**
     * Processa a redefinição da senha.
     */
    public function resetPassword()
    {
        $token = $_POST['token'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $reset_data = User::findResetToken($token);

        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            $error = "Token inválido ou expirado.";
            require_once BASE_PATH . '/app/views/error.php';
            return;
        }

        if (empty($password) || $password !== $password_confirm) {
            $error = "As senhas não coincidem ou estão em branco.";
            require_once BASE_PATH . '/app/views/auth/reset-password.php';
            return;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        User::updatePassword($reset_data['email'], $password_hash);
        User::deleteResetToken($token);

        header('Location: ' . BASE_URL . '/login?status=password_updated');
        exit;
    }

    /**
     * Função auxiliar para enviar o e-mail.
     */
    private function sendPasswordResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        $reset_link = "http://localhost" . BASE_URL . "/reset-password?token=" . $token;

        try {
            // >>>>> DEPURAÇÃO REMOVIDA <<<<<
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

            // --- CONFIGURAÇÃO CORRIGIDA DO GMAIL ---
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jpcslengman@gmail.com'; // Seu e-mail do Gmail
            $mail->Password = 'akrd habr qbdl oqvc';   // Sua senha de app de 16 letras
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usar SMTPS (SSL)
            $mail->Port = 465;                         // Porta correta para SMTPS
            $mail->CharSet = 'UTF-8';

            // Remetente e Destinatário
            $mail->setFrom('jpcslengman@gmail.com', 'Colaê Sistema');
            $mail->addAddress($email);

            // Conteúdo do E-mail
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacao de Senha - Colaê';
            $mail->Body    = "Olá!<br><br>Você solicitou a redefinição de sua senha. Clique no link abaixo para criar uma nova senha:<br><a href='{$reset_link}'>{$reset_link}</a><br><br>Este link expira em 1 hora.<br><br>Se você não solicitou isso, pode ignorar este e-mail.<br><br>Atenciosamente,<br>Equipe Colaê";
            $mail->AltBody = "Para redefinir sua senha, copie e cole este link no seu navegador: {$reset_link}";

            $mail->send();
        } catch (Exception $e) {
            // Com a depuração ativa, o erro detalhado já aparecerá na tela.
            // Esta linha pode ser útil para logar o erro num ficheiro.
            error_log("A mensagem não pôde ser enviada. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
