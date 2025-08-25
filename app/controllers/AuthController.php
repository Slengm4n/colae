<?php
require_once BASE_PATH . '/vendor/autoload.php';
// Certifique-se de que os caminhos para os arquivos estão corretos
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/core/AuthHelper.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    /**
     * Mostra a página de login.
     */
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

                // Se for admin, redireciona para o dashboard, senão para a home
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    // Futuramente, pode ser um painel do usuário
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

    public function sendResetLink()
    {
        $email = $_POST['email'];
        $user = User::findByEmail($email);

        if ($user) {
            // Gera um token seguro
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Salva o token no banco de dados
            User::savePasswordResetToken($email, $token, $expires_at);

            // Envia o e-mail com o link de redefinição
            $this->sendPasswordResetEmail($email, $token);
        }

        // Mostra uma mensagem de sucesso para o usuário, mesmo que o e-mail não exista
        // Isso evita que alguém descubra quais e-mails estão cadastrados
        $message = "Se uma conta com este e-mail existir, um link de recuperação foi enviado.";
        $status = "success";
        require_once BASE_PATH . '/app/views/auth/forgot_password.php';
    }

    public function showResetPasswordForm()
    {
        $token = $_GET['token'] ?? '';
        $reset_data = User::findResetToken($token);

        // Verifica se o token é válido e não expirou
        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            die("Token inválido ou expirado. Por favor, solicite um novo link de recuperação.");
        }

        require_once BASE_PATH . '/app/views/auth/reset-password.php';
    }

    public function resetPassword()
    {
        $token = $_POST['token'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $reset_data = User::findResetToken($token);

        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            die("Token inválido ou expirado.");
        }

        if ($password !== $password_confirm) {
            $error = "As senhas não coincidem.";
            require_once BASE_PATH . '/app/views/auth/reset-password.php';
            return;
        }

        // Atualiza a senha do usuário
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        User::updatePassword($reset_data['email'], $password_hash);

        // Deleta o token para que não possa ser usado novamente
        User::deleteResetToken($token);

        // Redireciona para o login com uma mensagem de sucesso
        header('Location: ' . BASE_URL . '/login?status=password_updated');
        exit;
    }

    private function sendPasswordResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        $reset_link = "http://localhost" . BASE_URL . "/reset-password?token=" . $token;

        try {
            // Configurações do servidor de e-mail (SMTP)
            // IMPORTANTE: Use um serviço de e-mail real como Gmail, SendGrid, etc.
            // O exemplo abaixo usa as configurações do Mailtrap.io para teste.
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'jpcslengman@gmail.com'; // Seu usuário
            $mail->Password = 'akrd habr qbdl oqvc'; // Sua senha
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 456;
            $mail->CharSet = 'UTF-8';

            // Remetente e Destinatário
            $mail->setFrom('no-reply@colae.com', 'Colaê Sistema');
            $mail->addAddress($email);

            // Conteúdo do E-mail
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacao de Senha - Colaê';
            $mail->Body    = "Olá!<br><br>Você solicitou a redefinição de sua senha. Clique no link abaixo para criar uma nova senha:<br><a href='{$reset_link}'>{$reset_link}</a><br><br>Se você não solicitou isso, pode ignorar este e-mail.<br><br>Atenciosamente,<br>Equipe Colaê";
            $mail->AltBody = "Para redefinir sua senha, copie e cole este link no seu navegador: {$reset_link}";

            $mail->send();
        } catch (Exception $e) {
            // Em um ambiente de produção, você deveria logar este erro
            // echo "A mensagem não pôde ser enviada. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
