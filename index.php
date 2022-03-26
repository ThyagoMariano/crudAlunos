<!-- import -->
<?php
require_once 'consult.php';
$alunos = new Alunos("crud_students", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./src/style.css" />
  <title>Formulario</title>
</head>

<body>
  <main>
    <?php
    // Verifica
    if (isset($_POST['name'])) {
      if (isset($_GET['idstudents_up']) && !empty($_GET['idstudents_up'])) {
        $idstudents_up = addslashes($_GET['idstudents_up']);
        $name = addslashes($_POST['name']);
        $dt_birth = addslashes($_POST['dt_birth']);
        $registration = addslashes($_POST['registration']);

        if (!empty($name) && !empty($dt_birth && !empty($registration))) {
          $alunos->attDados($idstudents_up, $name, $dt_birth, $registration);
          header("location: index.php");
        } else {
          echo "preencha todoss campos";
        }
      } else {
        $name = addslashes($_POST['name']);
        $dt_birth = addslashes($_POST['dt_birth']);
        $registration = addslashes($_POST['registration']);

        if (!empty($name) && !empty($dt_birth && !empty($registration))) {
          if (!$alunos->register($name, $dt_birth, $registration)) {

            echo "já existe aluno com esse numero de matricula";
          }
        } else {
          echo "preencha todos campos";
        }
      }
    }



    ?>

    <?php
    if (isset($_GET['idstudents_up'])) {
      $id_up = addslashes($_GET['idstudents_up']);
      $res = $alunos->edit($id_up);
    }
    ?>


    <div class="box">
      <h1><?php if (isset($res)) {
            echo "Atualizar";
          } else {
            echo "Cadastrar";
          }
          ?> aluno</h1>
      <form method="POST" class="registerStudents">
        <label for="name">
          <input id="name" name="name" type="text" maxlength="100" value="<?php if (isset($res)) {
                                                                            echo $res['name'];
                                                                          } ?>" />
        </label>

        <label for="dt_birth">
          <input id="dt_birth" name="dt_birth" type="date" value="<?php if (isset($res)) {
                                                                    echo $res['dt_birth'];
                                                                  } ?>" />
        </label>
        <label for=" registration">
          <input id="registration" name="registration" type="number" max="9999" value="<?php if (isset($res)) {
                                                                                          echo $res['registration'];
                                                                                        } ?>" />
        </label>

        <div class="btn">
          <input id="enviar" name="enviar" type="submit" value="<?php if (isset($res)) {
                                                                  echo "Atualizar";
                                                                } else {
                                                                  echo "Cadastrar";
                                                                }
                                                                ?>" />
        </div>
      </form>


    </div>
    <table>
      <tr>
        <th>id</th>
        <th>nome</th>
        <th>data nascimento</th>
        <th>num. matricula</th>
      </tr>
      <?php
      $dados = $alunos->consult();
      if (count($dados) > 0) {
        for ($i = 0; $i < count($dados); $i++) {
          echo "<tr>";
          foreach ($dados[$i] as $key => $value) {
            echo "<td>" . $value . "</td>";
          }
      ?>
          <td>
            <a href="index.php?idstudents_up=
            <?php
            echo $dados[$i]['idstudents'];
            ?>" class="btn2">Editar
            </a>

            <a href="index.php?idstudents=
            <?php
            echo $dados[$i]['idstudents'];
            ?>" class="btn2">Excluir
            </a>
          </td>
      <?php
          echo "</tr>";
        }
      } else {
        echo "<tr>";
        echo "<td>";
        echo "Não há cadastro disponivel";
        echo "</td>";
        echo "</tr>";
      }

      ?>

    </table>
  </main>



</body>

</html>

<?php if (isset($_GET['idstudents'])) {
  $idstudents = addslashes($_GET['idstudents']);
  $alunos->delete($idstudents);
  header("location: index.php");
}
?>