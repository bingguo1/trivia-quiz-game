# PostgreSQL: Add NOT NULL AUTO_INCREMENT to Existing Column

PostgreSQL does not have `AUTO_INCREMENT`. The equivalent is a **sequence**.

## Steps (without modifying existing data)

### 1. Create a sequence in the same schema as the table

```sql
CREATE SEQUENCE myschema.your_table_your_column_seq;
```

> **Note:** The sequence must be in the **same schema** as the table, otherwise you'll get:
> `ERROR: sequence must be in same schema as table it is linked to`

### 2. Set the start value to avoid conflicts with existing data

```sql
SELECT setval('myschema.your_table_your_column_seq', (SELECT MAX(your_column) FROM myschema.your_table));
```

### 3. Set the column default to use the sequence

```sql
ALTER TABLE myschema.your_table
  ALTER COLUMN your_column SET DEFAULT nextval('myschema.your_table_your_column_seq');
```

### 4. Set NOT NULL

```sql
ALTER TABLE myschema.your_table
  ALTER COLUMN your_column SET NOT NULL;
```

### 5. Associate the sequence with the column (optional but recommended)

This ensures the sequence is dropped automatically if the column or table is dropped.

```sql
ALTER SEQUENCE myschema.your_table_your_column_seq
  OWNED BY myschema.your_table.your_column;
```

---

## Alternative: GENERATED ALWAYS AS IDENTITY (PostgreSQL 10+)

```sql
ALTER TABLE myschema.your_table
  ALTER COLUMN your_column SET NOT NULL,
  ALTER COLUMN your_column ADD GENERATED ALWAYS AS IDENTITY;
```

---

## Useful Query: Find a Table's Schema

```sql
SELECT table_schema, table_name
FROM information_schema.tables
WHERE table_name = 'your_table';
```

---

## Key Rules

- Existing rows are **never modified** — only future `INSERT`s that omit the column are affected.
- The sequence and the table **must be in the same schema** for `OWNED BY` to work.
- Replace `myschema`, `your_table`, and `your_column` with your actual names.
