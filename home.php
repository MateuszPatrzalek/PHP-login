<?php echo '<div class="alert alert-success">Logowanie przebiegło pomyślnie!</div>' ?>

<div class="container login-container">
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md-6 login-form">
            <h3>Witaj na koncie: <b><?php echo $login;?></b></h3>
            <form>
            <div class="form-group">
                <a href = 'login.php?akcja=wyloguj' class="btn btn-lg btn-warning btn-block">Wyloguj się</a>
            </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
</div>
