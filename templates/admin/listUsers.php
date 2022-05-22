<?php
include "templates/include/header.php";
include "templates/admin/include/header.php";
?>

    <h1>Пользователи</h1>

    <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php } ?>


    <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
    <?php } ?>

          <table>
            <tr>
              <th>Логин</th>
              <th>Активен</th>
            </tr>

    <?php foreach ($results['results'] as $user) { ?>
            <tr onclick="location='admin.php?action=editUser&amp;userId=<?php echo $user->id?>'">
              <td>
                  <?php echo $user->login?>
              </td>
              <td><?php echo $user->active ? 'Активен' : 'Заблокирован' ?></td>
            </tr>

    <?php } ?>

          </table>

          <p>Всего пользователей: <?php echo $results['totalRows']?></p>

          <p><a href="admin.php?action=newUser">Добавить нового пользователя</a></p>

<?php include "templates/include/footer.php" ?>