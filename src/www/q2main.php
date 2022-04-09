<!doctype html>

<html lang="fr">
<head>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet"> 

    <style>
        body 
        {
            background-color: rgb(49,51,72);
            font-family: 'Amiri', serif;
            color: white;
        }

        .mainBlock
        {
            text-align: center;
        }

        input[type=text] 
        {
            padding: 10px;
            margin:10px 0;
            border: 0;
            box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
            border-radius:10px;
        }

        input[type="submit"]
        {
            padding: 10px;
            margin:10px 0;
            border: 0;
            box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
            border-radius:10px;
        }

        .accessionList
        {
            margin-left: auto;
            margin-right: auto;
            width: 20%;
            background-color: rgb(37,38,54);
            height: 200px;
            overflow-y: scroll;
            text-align: center;
        }

    </style>

</head>


<body>

  <!-- Le "main" de lhelicopiaa page -->

  <h1 style="text-align: center;">Formulaire</h1>
  <hr/>

  <div class="mainBlock">
    <form method="post" action="q2.php">
    <b><u>Accession a trouver :</u></b>
    <input type="text" name="accession" placeholder="NumAccess..">
    </input> <br>
    <input type="submit" name="submit" 
    value="envoyer">
    <p><u> Listes des numéros d'accessions disponibles dans notre base de données </u></p>
    </input>
    </form>
  </div>

   <div class="accessionList">

  <?php

    //On se connecte à Oracle

    $connexion = oci_connect('c##tmanea_a', 'tmanea_a', 'dbinfo');


    $reqOne =  " select accession from entries";
  
    $ordre = oci_parse($connexion, $reqOne);

    oci_execute($ordre);
    while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false)
    {
        echo '' . $row[0] . ' <br> ' ;   
    }
    oci_free_statement($ordre);

    //A executer quand on a finis vraiment toutes les requêtes
    oci_close($connexion);
  
  ?>

    </div>
  
</body>

</html>

