<?php
session_start();

if (!isset($_SESSION['initiate'])) //zabezpieczenie przed przechwyceniem sesji
{
    session_regenerate_id();
    $new_session_id = session_id();
    session_write_close();
    session_id($new_session_id);
    session_start();
    $_SESSION['initiate'] = 1;
}
?>

<html lang = "pl">
<head>
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<br>

    <?php
    if(isset($_GET['akcja']) && isset($_GET['akcja']) == "wyloguj") //wylogowanie
    {
        $_SESSION['logged'] = 0;
        session_destroy();
        $result = '<div class="alert alert-warning">Zostałeś pomyślnie wylogowany!</div>';
    }

    if(!empty($_SESSION['logged']) && $_SESSION['logged'] == 1 && time() - $_SESSION['time'] > 600) //czas trwania sesji = 10 min
    {
        $_SESSION['logged'] = 0;
        session_destroy();
        $result = '<div class="alert alert-warning">Twoja sesja wygasła!</div>';
    }

    if(!empty($_SESSION['logged']) && $_SESSION['logged'] == 1 && $_SESSION['pc_info'] != $_SERVER['HTTP_USER_AGENT']) //wylogowanie użytownika w przypadku zmiany przeglądarki lub jej wyłaczenia
    {
        $_SESSION['logged'] = 0;
        session_destroy();
        $result = '<div class="alert alert-warning">Prosimy o ponowne zalogowanie się!</div>';
    }

    if ((isset($_POST['username']) && isset($_POST['password'])) || $_SESSION['logged'] == 1)
    {
        if ((!empty($_POST['username']) && !empty($_POST['password'])) || $_SESSION['logged'] == 1)
        {
            $login = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            if (($login == 'test' && $password == '1234') || $_SESSION['logged'] == 1)
            {

                include ("home.php");
                $_SESSION['logged'] = 1;
                $_SESSION['time'] = time();
                $_SESSION['pc_info'] = $_SERVER['HTTP_USER_AGENT'];
            }
            else
            {
                $result = '<div class="alert alert-danger">Błędny login lub hasło!</div>';
            }
        }
        else
        {
            $result = '<div class="alert alert-danger">Podaj login lub hasło!</div>';
        }
    }
    ?>

<?php
if($_SESSION['logged'] == 0)
{
    ?>

    <div class="container login-container">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-6 login-form">
                <h3>Logowanie</h3>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username = test"/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password = 1234"/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>
                    </div>
                    <div class="form-group">
                        <?php echo $result; ?>
                    </div>
                </form>
            </div>
            <div class="col-md"></div>
        </div>
    </div>

    <?php
}
?>

</body>
</html>


