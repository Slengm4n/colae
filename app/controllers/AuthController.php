<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/AuthHelper.php';

class AuthController
{
    
    // Index para o formulário de login.
    public function index()
    {
        // Renderiza a pagina de login
        require_once BASE_PATH . '/app/views/auth/login.php'; 
    }

    // Processa a tentativa de login do usuário
    public function authenticate()
    {
        // Verifica se os dados do form foram enviados via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 1. Encontra o usuário pelo email pelo método do Model de User
            $user = User::findByEmail($email);

            // 2. Verifica se o usuário existe e se a senha está correta
            if ($user && password_verify($password, $user['password_hash'])) {

            // 3. Login bem-sucedido: Inicia a sessão e guarda os dados do usuário
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
            // OBS: Guarda o role para redireciona-lo para o caminho de dashboard correto (admin ou user)
                $_SESSION['user_role'] = $user['role'];

            //  Redireciona para o dashboard correto
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


    // Index para o formulário de login.
    public function register()
    {
       //Renderiza a pagina de cadastro 
        require_once BASE_PATH . '/app/views/auth/register.php';
    }

    //Função que prepara os dados para envia-lo ao Model para realizar a query
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            // Validação simples de senha, apenas se as duas se condizem
            if ($password !== $password_confirmation) {
                echo "As senhas precisam ser iguais.";
                header('Location: ' . BASE_URL . '/register?error=password_mismatch');
                exit;
            }

            //Faz a hash da senha para poder realizar a query
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            //Metodo de criação com as variaveis já preparadas passando para a função do Model User
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

    //Processa o logout
    public function logout()
    {
        session_start();
        session_destroy();
        //Renderiza a pagina de login novamento
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    //Processa a solicitação de redefinição de senha
    public function sendResetLink()
    {
        //Verfica se os dados passados pelo form são via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            // Usa o método do Model para fazer um query por email
            $user = User::findByEmail($email);

            
            if ($user) {
                //Cria o token aleatório de 32bytes
                $token = bin2hex(random_bytes(32));
                //Cria o formato de expiração
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                //Preapara para poder fazer a query no Model User
                User::savePasswordResetToken($email, $token, $expires_at);

                //Logger para relatar quem solicitou o a redefinição de senha
                Logger::getInstance()->info('Solicitação de redefinição de senha para usuário', ['user_id' => $user['id'], 'email' => $user['email']]);

                //Enviar para o método de redefinição de senha
                $this->sendPasswordResetEmail($email, $token);
            } else {
                //Logger para relatar que o email solicitado não é cadastrado no sistema
                Logger::getInstance()->warning('Tentativa de redefinição de senha para e-mail não cadastrado', ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
            }

            $message = "Se uma conta com este e-mail existir, um link de recuperação foi enviado.";
            $status = "success";
            //Renderiza a pagina fazendo um retorno
            require_once BASE_PATH . '/app/views/auth/forgot_password.php';
        }
    }


     // Mostra o formulário para redefinir a senha, validando o token.
    public function showResetPasswordForm()
    {
        //Pega o token válido passado pelo pelo sendResetLink
        $token = $_GET['token'] ?? '';
        //Acha o token válido
        $reset_data = User::findResetToken($token);

        //Verifica se o link/token já está expirado 
        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            $error = "Token inválido ou expirado. Por favor, solicite um novo link de recuperação.";
            //Renderiza uma pagina de erro
            require_once BASE_PATH . '/app/views/error.php';
            return;
        }
        //Caso seja feito com sucesso, renderiza a pagina de resetar a senha
        require_once BASE_PATH . '/app/views/auth/reset_password.php';
    }

    /**
     * Processa a redefinição da senha.
     */
    public function resetPassword()
    {
        //Verifica o token
        $token = $_POST['token'];
        //Pega senha
        $password = $_POST['password'];
        //Pega a confirmação de senha
        $password_confirm = $_POST['password_confirm'];

        //Usa o método para achar o Token no Model User
        $reset_data = User::findResetToken($token);

        //Verifica se o token ainda está válido
        if (!$reset_data || strtotime($reset_data['expires_at']) < time()) {
            $error = "Token inválido ou expirado.";
            require_once BASE_PATH . '/app/views/error.php';
            return;
        }

        //Verifica se as senhas se coincidem
        if (empty($password) || $password !== $password_confirm) {
            $error = "As senhas não coincidem ou estão em branco.";
            //Renderiza novamente a pagina
            require_once BASE_PATH . '/app/views/auth/reset-password.php';
            return;
        }
        
        //Faz a hash da nova senha para prepara-la para a query
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        //Passa a nova senha para o método de updatePassword do Model User
        User::updatePassword($reset_data['email'], $password_hash);
        //Deleta o Token usado após ter sido atualizado com sucesso
        User::deleteResetToken($token);

        //Renderiza a página de login com status de sucesso
        header('Location: ' . BASE_URL . '/login?status=password_updated');
        exit;
    }

    // Função auxiliar para enviar o e-mail via SMTP
    private function sendPasswordResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        $reset_link = "http://localhost" . BASE_URL . "/reset-password?token=" . $token;

        try {
            // --- CONFIGURAÇÃO SERVIDOR DO GMAIL ---
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
            //Caso haja algum erro de servidor e o email nao consiga ser enviado
            Logger::getInstance()->error(
                'Falha ao enviar e-mail de redefinição de senha',
                ['email' => $email, 'error_message' => $mail->ErrorInfo]
            );
        }
    }

    //Verificação de maioriadade para criação de conta
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
