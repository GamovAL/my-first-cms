<?php
include "templates/include/header.php";
include "templates/admin/include/header.php";
?>
<h1><?php echo $results['pageTitle']?></h1>
    <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <?php if (! is_null($results['user']->id)): ?>
            <input type="hidden" name="id" value="<?php echo $results['user']->id ?>">
        <?php endif; ?>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>

            <li>
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" placeholder="Логин" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['user']->login )?>" />
            </li>

            <li>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" placeholder="Пароль" required maxlength="1000" value="<?php echo htmlspecialchars( $results['user']->password )?>">
            </li>


            <ul>
                <label for="active">Активный</label>
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" <?php echo $results['user']->active ? " checked" : ""?> >
            </ul>


        </ul>

        <div class="buttons">
            <input type="submit" name="saveChanges" value="Сохранить" />
            <input type="submit" formnovalidate name="cancel" value="Отмена" />
        </div>

    </form>

<?php if ($results['user']->id) { ?>
    <p><a href="admin.php?action=deleteUser&amp;userId=<?php echo $results['user']->id ?>" onclick="return confirm('Удалить данного пользователя?')">
            Удалить пользователя
        </a>
    </p>
<?php } ?>
<?php include "templates/include/footer.php"; ?>