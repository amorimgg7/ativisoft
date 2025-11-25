

-- 1. Tabelas que existem em assistent_master mas NÃO existem em ass_08057969

SELECT CONCAT(
    'CREATE TABLE ass_08057969.', table_name,
    ' LIKE assistent_master.', table_name, ';'
) AS sql_needed
FROM information_schema.tables t
WHERE t.table_schema = 'assistent_master'
  AND NOT EXISTS (
        SELECT 1 FROM information_schema.tables
        WHERE table_schema = 'ass_08057969'
          AND table_name = t.table_name
    );


-- 2. Colunas que existem no assistent_master e NÃO existem no ass_08057969


SELECT CONCAT(
    'ALTER TABLE ass_08057969.', c.table_name,
    ' ADD COLUMN ', c.column_name, ' ', c.column_type,
    IF(c.is_nullable = 'NO', ' NOT NULL', ''),
    IF(c.column_default IS NOT NULL, CONCAT(' DEFAULT ''', c.column_default, ''''), ''),
    IF(c.extra <> '', CONCAT(' ', c.extra), ''),
    ';'
) AS sql_needed
FROM information_schema.columns c
WHERE c.table_schema = 'assistent_master'
  AND NOT EXISTS (
      SELECT 1 FROM information_schema.columns
      WHERE table_schema = 'ass_08057969'
        AND table_name = c.table_name
        AND column_name = c.column_name
  );


-- 3. Colunas que já existem nas duas, mas são diferentes (tipo, default, null, extra)

SELECT CONCAT(
    'ALTER TABLE ass_08057969.', c1.table_name,
    ' MODIFY ', c1.column_name, ' ', c1.column_type,
    IF(c1.is_nullable = 'NO', ' NOT NULL', ''),
    IF(c1.column_default IS NOT NULL, CONCAT(' DEFAULT ''', c1.column_default, ''''), ''),
    IF(c1.extra <> '', CONCAT(' ', c1.extra), ''),
    ';'
) AS sql_needed
FROM information_schema.columns c1
JOIN information_schema.columns c2
  ON c1.table_name = c2.table_name
 AND c1.column_name = c2.column_name
WHERE c1.table_schema = 'assistent_master'
  AND c2.table_schema = 'ass_08057969'
  AND (
        c1.column_type <> c2.column_type OR
        c1.is_nullable <> c2.is_nullable OR
        IFNULL(c1.column_default,'') <> IFNULL(c2.column_default,'') OR
        c1.extra <> c2.extra
      );