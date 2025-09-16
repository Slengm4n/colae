<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/AuthHelper.php';

class AuthController
{
    /**
     * Exibe o formulário de login.
     */
    public function index()
    {
        require_once BASE_PATH . '/app/views/auth/login.php'; // Ou o caminho para o seu ficheiro de login
    }

    /**
     * Processa a tentativa de login do usuário.
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 1. Encontra o usuário pelo email
            $user = User::findByEmail($email);

            // 2. Verifica se o usuário existe e se a senha está correta
            if ($user && password_verify($password, $user['password_hash'])) {

                // 3. Login bem-sucedido: Inicia a sessão e guarda os dados do usuário
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // 4. AQUI ESTÁ A CORREÇÃO: Redireciona para o dashboard correto
                if ($user['role'] === 'admin') {
                    // Se for admin, vai para o dashboard do admin
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    // Se for um usuário comum, vai para o dashboard do usuário
                    header('Location: ' . BASE_URL . '/dashboard');
                }
                exit;
            } else {
                // 5. Falha no login: Redireciona de volta para a página de login com uma mensagem de erro
                header('Location: ' . BASE_URL . '/login?error=credentials');
                exit;
            }
        }
    }

    // ... Seus outros métodos (register, store, logout, etc.) continuam aqui ...

    public function register()
    {
        require_once BASE_PATH . '/app/views/auth/register.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            // Validação simples (pode ser melhorada)
            if ($password !== $password_confirmation) {
                // Idealmente, passe uma mensagem de erro para a view
                header('Location: ' . BASE_URL . '/register?error=password_mismatch');
                exit;
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if (User::create($name, $email, $birthdate, $password_hash)) {
                // Redireciona para o login após o registo bem-sucedido
                header('Location: ' . BASE_URL . '/login?status=registered');
                exit;
            } else {
                header('Location: ' . BASE_URL . '/register?error=generic');
                exit;
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
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

                Logger::getInstance()->info('Solicitação de redefinição de senha para usuário', ['user_id' => $user['id'], 'email' => $user['email']]);

                $this->sendPasswordResetEmail($email, $token);
            } else {
                Logger::getInstance()->warning('Tentativa de redefinição de senha para e-mail não cadastrado', ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
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
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = MAIL_PORT;
            $mail->CharSet = 'UTF-8';

            // Remetente e Destinatário
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email);

            // Conteúdo do E-mail
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacao de Senha - Colaê';
            $mail->Body    = "Olá!<br><br>Você solicitou a redefinição de sua senha. Clique no link abaixo para criar uma nova senha:<br><a href='{$reset_link}'>{$reset_link}</a><br><br>Este link expira em 1 hora.<br><br>Se você não solicitou isso, pode ignorar este e-mail.<br><br>Atenciosamente,<br>Equipe Colaê";
            $mail->AltBody = "Para redefinir sua senha, copie e cole este link no seu navegador: {$reset_link}";

            $mail->send();

            Logger::getInstance()->info('E-mail de redefinição de senha enviado', ['email' => $email]);
        } catch (Exception $e) {
            // Com a depuração ativa, o erro detalhado já aparecerá na tela.
            // Esta linha pode ser útil para logar o erro num ficheiro.
            Logger::getInstance()->error(
                'Falha ao enviar e-mail de redefinição de senha',
                ['email' => $email, 'error_message' => $mail->ErrorInfo]
            );
        }
    }

    private function isOver18($birthdate)
    {
        if (empty($birthdate)) {
            return false;
        }
        try {
            $nascimento = new DateTime($birthdate);
            $hoje = new DateTime();
            $idade = $hoje->diff($nascimento);
            return $idade->y >= 18;
        } catch (Exception $e) {
            return false;
        }
    }
}
