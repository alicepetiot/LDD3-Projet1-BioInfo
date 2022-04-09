<!doctype html>

<html lang="fr">
<head>


    <style>

        body 
        {
            font-family: 'Fira Sans', sans-serif;
            color: black;
            background-color: rgb(110,100,133); 
            font-size: 10px; 
        }

        .title {
            text-align: left;
            color: rgb(200,191,231);
        }

        .wrapper {
                display: grid;
                grid-template-columns: 
                [col1-start] 25%
                [col2-start] 10%  
                [col3-start] 10% 
                [col4-start] 14% 
                [col5-start] 13% 
                [col6-start] 14% 
                [col7-start] 13% 
                [col7-end];
                grid-template-rows: 
                [row1-start] 100px 
                [row2-start] 300px
                [row3-start] 250px 
                [row4-start] 250px 
                [row4-end];
                background-color: rgb(42,43,61);
                color: #444;
            }
    
        .box {
            background-color:#2f83ad;
            color: #fff;
            padding: 20px;
            font-size: 150%;

        }

        .keywords {
            grid-column: col1-start / col2-start;
            grid-row: row1-start / row4-end;
            overflow-x: scroll;
            background-color: rgb(37,38,54);
            color: rgb(195,195,195);
            margin-top: 10px;
            margin-right: 10px;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        .sequenceTitle {
            grid-column: col2-start / col4-start ;
            grid-row: row1-start / row2-start;
            /*overflow-y: scroll;*/
            background-color: rgb(49,51,72);
            text-align: justify;
            color: rgb(195,195,195);
            margin-top: 10px;
        }

        .sequence {
            grid-column: col2-start / col7-end ;
            grid-row: row2-start / row3-start;
            overflow-y: scroll;
            background-color: rgb(49,51,72);
            text-align: justify;
            color: rgb(195,195,195);
            margin-right: 10px;
            margin-bottom: 10px;
            
        }

        .seqMass {
            grid-column: col6-start / col7-end;
            grid-row: row1-start;
            background-color: rgb(22,23,33);
            margin-top: 10px;
            margin-right: 10px;
        }

        .seqLength {
            grid-column: col4-start / col6-start;
            grid-row: row1-start / row2-start ;
            background-color: rgb(37,38,54); 
            margin-top: 10px;
        }

        .nameProt {
            grid-column: col5-start / col7-end;
            grid-row: row3-start / row4-start;
            overflow-y: scroll;
	    /*display: flex;
            align-items: center;
            justify-content: center;*/
            background-color: rgb(49,51,72);
            color: rgb(195,195,195);
            margin-bottom: 10px;
            margin-right:10px;
        }

        .nameGene {
            grid-column: col5-start / col7-end;
            grid-row: row4-start / row4-end;
            /*display: flex;
            align-items: center;
	    justify-content: center;*/
            overflow-y: scroll;
            background-color: rgb(49,51,72);
            color: rgb(195,195,195);
            margin-right:10px;
            margin-bottom: 10px;
        }

        .comments {
            grid-column: col2-start / col5-start;
            grid-row: row3-start / row4-end;
            overflow-y: scroll;
            background-color: rgb(49,51,72);
            color: rgb(195,195,195);
            margin-right:10px;
            margin-bottom: 10px;
        }
        



        table,
        td {
            border: 0px solid rgb(195,195,195);
            padding: 0 15px;
        }

        thead,
        tfoot {
            background-color: #333;
            color: #fff;
        }

        .stylingHeader{
            background-color: rgb(37,38,54);
            color: #ffffff;
            text-align: left;
        }

        tr.spaceUnder>td{
            padding-bottom: 1em;
        }


        #cat {
        
        position: absolute;
        -webkit-animation: linear infinite;
        -webkit-animation-name: run;
        -webkit-animation-duration: 5s;
        }
        @-webkit-keyframes run {
        0% {
            left: 0;
        }
        50% {
            left: 100%;
        }
        100% {
            left: 0;    
        }
        }


        #dog {
        position: absolute;
        -webkit-animation: linear infinite;
        -webkit-animation-name: run;
        -webkit-animation-duration: 5s;
        }
        @-webkit-keyframes run {
        0% {
            left: 0;
        }
        50% {
            left: 100%;
        }
        100% {
            left: 0;    
        }
        }


    </style>
</head>


<body>
    <div class="title">
        <h1>
            Accession :  <?= $ac = $_REQUEST['accession']?>
        </h1>
    </div>

    <!-- <img src="cat.png" id="cat" width="150" height="150" style="display: block; margin-left: auto;">
    <img src="dog.jpg" id="dog" width="180" height="150" style="display: block; ">-->
   

    <?php 
        //On récupère déjà le numéro d'accession passé par le formulaire
        $ac = $_REQUEST['accession'];

        //On se connecte à Oracle
        $connexion = oci_connect('c##tmanea_a', 'tmanea_a', 'dbinfo');

        /* Les requêtes  */
        $reqOne =  " select seq, seqLength, seqMass, specie " 
                ." from entries"
                ." natural join proteins" 
                ." where accession = :acces";
    
        $reqTwo = " select prot_name, name_type, name_kind from entries "
                ." natural join prot_name_2_prot "
                ." natural join protein_names "
                ." where accession = :acces";

        $reqThree =  " select gene_name, name_type "
                    ." from gene_names "
                    ." natural join entry_2_gene_name "
                    ." where accession = :acces";

        $reqFour = " select txt_c, type_c from comments "
                ." where accession = :acces"; 

        $reqFive = " select kw_label from entries_2_keywords "
                ." natural join keywords "
                ." where accession = :acces";

        $reqSix = " select db_ref from dbref "
                ." where accession = :acces"
                ." and db_type = 'GO' ";

        /* Fin des requêtes */
            
    ?>

    <div class="wrapper">
        <div class="box keywords">
            <u><p style="font-size:15px; font-weight: bold;">Keywords</p></u>
            <ul>
            
            <?php
                $ordre = oci_parse($connexion, $reqFive);
                oci_bind_by_name($ordre, ":acces", $ac);
                oci_execute($ordre);
                while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                    echo '<li>'.$row[0].'</li>'  ;
                }
                oci_free_statement($ordre);
            ?>

            </ul> 
        </div>

        <div class="box sequence">
            <?php
                $ordre = oci_parse($connexion, $reqOne);
                oci_bind_by_name($ordre, ":acces", $ac);
                oci_execute($ordre);
                while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                    print $row[0]->load()."\n";
                    echo "<a href='https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=" . $row[3] . "'>see more...</a>";
                }
                oci_free_statement($ordre);
            ?>
        </div>

        <div class="box seqMass">
            <span style="font-size: 16px; text-decoration:bold;">Sequence Mass</span>
            <?php
                $ordre = oci_parse($connexion, $reqOne);
                oci_bind_by_name($ordre, ":acces", $ac);
                oci_execute($ordre);
                while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                    echo '<span style="font-size: 35px;">'.$row[2].'</span>';
                }
                oci_free_statement($ordre);
            ?>
        </div>

        <div class="box seqLength">
            <span style="font-size: 16px; text-decoration:bold;">Sequence Length</span>
            <?php            
                $ordre = oci_parse($connexion, $reqOne);
                oci_bind_by_name($ordre, ":acces", $ac);
                oci_execute($ordre);
                while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                    echo '<span style="font-size: 35px;">'.$row[1].'</span>';
                }
                oci_free_statement($ordre);      
            ?>
            
        </div>

        <div class="box nameGene">
            <u><p style="font-size:15px; font-weight: bold;">Gene</p></u>
        <table>

            <tbody>
                <tr class="stylingHeader">
                    <td><strong>gene name</strong></td>
                    <td><strong>type</strong></td>
                </tr>

                

                <?php                
                    $ordre = oci_parse($connexion, $reqThree);
                    oci_bind_by_name($ordre, ":acces", $ac);
                    oci_execute($ordre);
                    while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                        echo '<tr>';
                        echo '<td>' .$row[0]. '</td>';
                        echo '<td>' .$row[1]. '</td>';
                        echo '<tr>';
                    }
                    oci_free_statement($ordre);    
                ?>
            </tbody>
        </table>
     
        </div>

        <div class="box nameProt">
            <u><p style="font-size:15px; font-weight: bold;">Protein</p></u>
            <table>
                <tbody>
                    <tr class="stylingHeader">
                        <td><strong>name protein</strong></td>
                        <td><strong>name_type</strong></td>
                        <td><strong>sort type</strong></td>
                    </tr>

                    

                    <?php                
                        $ordre = oci_parse($connexion, $reqTwo);
                        oci_bind_by_name($ordre, ":acces", $ac);
                        oci_execute($ordre);
                        while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                            echo '<tr>';
                            echo '<td>' .$row[0]. '</td>';
                            echo '<td>' .$row[1]. '</td>';
                            echo '<td>' .$row[2]. '</td>';
                            echo '<tr>';
                        }
                        oci_free_statement($ordre);    
                    ?>
                </tbody>
            </table>    
        </div>

        <div class="box comments">
        <u><p style="font-size:15px; font-weight: bold;">Comments</p></u>

            <table>
                <tbody>
                    <tr class="stylingHeader">
                        <td><strong>commentaire</strong></td>
                        <td><strong>type_c</strong></td>
                    </tr>

                    

                    <?php                
                        $ordre = oci_parse($connexion, $reqFour);
                        oci_bind_by_name($ordre, ":acces", $ac);
                        oci_execute($ordre);
                        while (($row = oci_fetch_array($ordre, OCI_BOTH)) !=false) {
                            echo '<tr class="spaceUnder">';
                            echo '<td>' .$row[0]. '</td>';
                            echo '<td>' .$row[1]. '</td>';
                            echo '<tr>';
                        }
                        oci_free_statement($ordre);    
                    ?>
                </tbody>
            </table>    

            
        </div>

        <div class="box sequenceTitle">
            <u><p style="font-size:15px; font-weight: bold;">Sequence</p></u>
        </div>
    </div>
</body>
</html>

