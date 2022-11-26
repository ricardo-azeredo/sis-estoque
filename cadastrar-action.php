<?php
    session_start();
    ob_start();
    require 'config.php';

    $name = filter_input(INPUT_POST, 'nome'); 
    $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL); 
    $password = filter_input(INPUT_POST,'senha'); 
    $password_confirm = filter_input(INPUT_POST,'confirmar'); 


    if($name && $email && $password && $password_confirm){
        
        $sql = $pdo->prepare("select * from usuario where email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        // //Verifico se tem um mesmo email já cadastrado.
        if($sql->rowCount() === 0){
        //     //Verificar se a senha e a confirmação de senha são iguais.
            if($password === $password_confirm){
                
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = $pdo->prepare( "INSERT INTO usuarios (nome,email,senha) VALUES (:name, :email, :password)" );
                $sql->bindValue(':name', $name); 
                $sql->bindValue(':email', $email); 
                $sql->bindValue(':password', $password_hash);                 
                $sql->execute();

                
                $_SESSION['msg'] = "Usuário Cadastrado com Sucesso!";
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['msg'] = "Erro: As Senhas não Batem!";
                header('Location: cadastrar.php ');
                exit;
            }
        } else {
            $_SESSION['msg'] = "Erro: E-mail já cadastrado!";
            header('Location: cadastrar.php ');
            exit;
        }
    } else {
        $_SESSION['msg'] = "Erro: Necessário preencher todos os campos!";
        header('Location: cadastrar.php ');
        exit;
    }

   