<DOCTYPE html>
<html>
  <head>
    <title>My Test Form</title>
  </head>

  <body>
    <form method="POST">
      <p>Please, choose the salary id to proceed result:</p>
      <p>
        <label for="salarieids">SalarieID:</label>
        <?php
          $query = "SELECT * FROM salarie";
          $result = mysql_query($query);
          if ($result) :
        ?>
        <select id="salarieids" name="salarieid">
          <?php
            while ($row = mysql_fetch_assoc($result)) {
              echo '<option value="', $row['salaried'], '">', $row['salaried'], '</option>'; //between <option></option> tags you can output something more human-friendly (like $row['name'], if table "salaried" have one) 
            }
          ?>
        </select>
        <?php endif ?>
      </p>
      <p>
        <input type="submit" value="Sumbit my choice"/>
      </p>
    </form>

    <?php if isset($_POST['salaried']) : ?>
      <?php
        $query = "SELECT * FROM salarie WHERE salarieid = " . $_POST['salarieid'];
        $result = mysql_query($query);
        if ($result) :
      ?>
        <table>
          <?php
            while ($row = mysql_fetch_assoc($result)) {
              echo '<tr>';
              echo '<td>', $row['salaried'], '</td><td>', $row['bla-bla-bla'], '</td>' ...; // and others
              echo '</tr>';
            }
          ?>
        </table>
      <?php endif?>
    <?php endif ?>
  </body>
</html>