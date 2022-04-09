-- 1 ère requête 
SELECT accession,prot_name
FROM ENTRIES NATURAL JOIN PROTEIN_NAMES NATURAL JOIN COMMENTS
WHERE name_kind='recommendedName'
AND txt_c LIKE '%cardiac%';

-- 2 ème requête


SELECT e.accession, p.prot_name, p.name_kind
    FROM Protein_names p, Entries e, Keywords k, Prot_name_2_prot p2, Proteins p1, Entries_2_keywords k2
    WHERE  e.accession = p1.accession
    AND  p1.accession = p2.accession
    AND  p2.prot_name_id = p.prot_name_id
    AND  e.accession = k2.accession
    AND  k2.kw_id = k.kw_id
    AND  p.name_kind = 'recommendedName'
    AND k.kw_label like '%Long QT syndrome%';



-- 3 ème requête
SELECT accession 
FROM ENTRIES NATURAL JOIN PROTEINS
WHERE seqLength = 
    (SELECT MAX(seqLength) 
    FROM PROTEINS);

-- 4 ème requête
SELECT e.accession, COUNT(DISTINCT gene_name)
FROM Entries e, Gene_names g1,
entry_2_gene_name g2 
WHERE e.accession = g2.accession
AND g2.gene_name_id = g1.gene_name_id 
GROUP BY e.accession
HAVING COUNT (DISTINCT gene_name) > 2;

-- 5 ème requête 
SELECT ENTRIES.accession, prot_name, name_kind 
FROM PROTEIN_NAMES NATURAL JOIN ENTRIES 
WHERE prot_name LIKE '%channel%';

-- 6 ème requête 
SELECT ENTRIES.accession
FROM ENTRIES NATURAL JOIN KEYWORDS
WHERE kw_label LIKE '%Long QT syndrome%'
AND kw_label LIKE '%Short QT syndrome%';

SELECT e.accession  
FROM ENTRIES e, KEYWORDS k1, ENTRIES_2_KEYWORDS k2
WHERE e.accession=k2.accession
AND k2.kw_id = k1.kw_id 
AND k1.kw_label LIKE '%Long QT syndrome%'
AND k1.kw_label LIKE '%Short QT syndrome%';

-- 7 ème requête

SELECT DISTINCT db.db_ref 
FROM dbref db, entries e1, entries e2,
entries_2_keywords e2k1, entries_2_keywords e2k2, keywords k 
WHERE db.accession = e1.accession
AND e1.accession = e2k1.accession
AND e2.accession = e2k2.accession
AND e1.accession != e2.accession
AND e2k1.kw_id = k.kw_id
AND e2k2.kw_id = k.kw_id 
AND k.kw_label LIKE '%Long QT syndrome%'