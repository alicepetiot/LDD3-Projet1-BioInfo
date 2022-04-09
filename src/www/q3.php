
<!doctype html>

<html lang="fr">
<head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

    <style>
        body 
        {
            background-color: rgb(49,51,72);
            font-family: 'Roboto', sans-serif;
            color: white;
            font-size: 20px;
        }

        .mainBlock
        {
            text-align: center;
            background-color: white;
            color: black;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            height: 500px;
            /*overflow-y: scroll;*/
            border-radius: 20px;
            display: table;
            margin-top: 8%;
            background-color: rgb(37,38,54);
            color: rgb(200,191,231);
        }

        a
        {
            color: rgb(191,191,191);
        }

        

      
    </style>

</head>


<body>

  <?php 
    //On récupère les contraintes utilisateur passées par le formulaire
    
    $is_gene_set = trim($_REQUEST['nameInGene']) != '';
    $is_prot_set = trim($_REQUEST['nameInProtein']) != '';
    $is_comm_set = trim($_REQUEST['nameInComment']) != '';

    $gene = "%" . $_REQUEST['nameInGene']    . "%";
    $prot = "%" . $_REQUEST['nameInProtein'] . "%";
    $comm = "%" . $_REQUEST['nameInComment'] . "%";

    //On se connecte à Oracle
    $connexion = oci_connect('c##tmanea_a', 'tmanea_a', 'dbinfo');

    /* Les requêtes  */
    $req =  " select distinct accession from entries";
    
    // Construction de la requête
    // partie Join
    if ($is_gene_set) {
      $req = $req ." natural join entry_2_gene_name"
                  ." join gene_names on entry_2_gene_name.gene_name_id=gene_names.gene_name_id";
    }

    if ($is_prot_set) {
      $req = $req ." natural join prot_name_2_prot"
                  ." join protein_names on prot_name_2_prot.prot_name_id=protein_names.prot_name_id";
    }

    if ($is_comm_set) {
      $req = $req ." natural join comments";
    }

    // Construction de la requête
    // partie Where
    if ($is_gene_set || $is_prot_set || $is_comm_set) {
      $req = $req . " where 1=1";
    }

    if ($is_gene_set) {
      $req = $req ." and gene_name like :gene";
    }

    if ($is_prot_set) {
      $req = $req ." and prot_name like :prot";
    }

    if ($is_comm_set) {
      $req = $req ." and txt_c like :comm";
    }

    //echo "<h1>".$req."</h1>";

    /* Fin des requêtes */
            
  ?>

  <!-- Le "main" de la page -->

  <div class="mainBlock">
    <br>  
    <h1 style="text-align: center;">Résultat</h1>
    <br>
    <?php 
      
      //echo "<p style=\"text-decoration: underline;\">Informations relatives au terme GO : </p>";

      $ordre = oci_parse($connexion, $req);

      if ($is_gene_set) {
        oci_bind_by_name($ordre, ":gene", $gene);
      }
  
      if ($is_prot_set) {
        oci_bind_by_name($ordre, ":prot", $prot);
      }
  
      if ($is_comm_set) {
        oci_bind_by_name($ordre, ":comm", $comm);
      }

      oci_execute($ordre);
      

      while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false)
      {
        echo "<a href='q2.php?accession=" . $row[0] . "'>" . $row[0] . "</a><br><br>";
      }

      //A executer quand on a finis vraiment toutes les requêtes
      oci_close($connexion);      
    
    ?>

     

  </div>


</body>
</html>

