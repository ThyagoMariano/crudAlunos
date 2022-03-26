<?php

class Alunos
{
  private $pdo;
  public function __construct($dbname, $host, $user, $pass)
  {
    try {
      $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $pass);
    } catch (PDOException $e) {
      echo "Erro serv" . $e->getMessage();
      exit();
    } catch (Exception $e) {
      echo "erro generico" . $e->getMessage();
      exit();
    }
  }
  // Buscar
  public function consult()
  {
    $res = array();
    $cmd = $this->pdo->query("SELECT * FROM students ORDER BY name");
    $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }



  // cadastrar
  public function register($name, $dt_birth, $registration)
  {
    $cmd =  $this->pdo->prepare("SELECT idstudents FROM students WHERE registration = :r");
    $cmd->bindValue(":r", $registration);
    $cmd->execute();
    if ($cmd->rowCount() > 0) {
      return false;
    } else {
      $cmd = $this->pdo->prepare("INSERT INTO students(name,dt_birth,registration) VALUES (:n, :d,:r)");
      $cmd->bindValue(":n", $name);
      $cmd->bindValue(":d", $dt_birth);
      $cmd->bindValue(":r", $registration);
      $cmd->execute();
      return true;
    }
  }

  // deletar
  public function delete($idstudents)
  {
    $cmd =  $this->pdo->prepare("DELETE FROM students WHERE idstudents = :id");
    $cmd->bindValue(":id", $idstudents);
    $cmd->execute();
  }

  // editar
  public function edit($idstudents)
  {
    $res = array();
    $cmd =  $this->pdo->prepare("SELECT * FROM students WHERE idstudents = :id");
    $cmd->bindValue(":id", $idstudents);
    $cmd->execute();
    $res = $cmd->fetch(PDO::FETCH_ASSOC);
    return $res;
  }
  // atualizar
  public function attDados($idstudents, $name, $dt_birth, $registration)
  {
    $cmd = $this->pdo->prepare("UPDATE students SET name = :n, dt_birth = :d, registration = :r WHERE idstudents = :id");
    $cmd->bindValue(":n", $name);
    $cmd->bindValue(":d", $dt_birth);
    $cmd->bindValue(":r", $registration);
    $cmd->bindValue(":id", $idstudents);
    $cmd->execute();
  }
}
