# MySQL Remote Connection Troubleshooting

## 1. Check Port and Bind Address

```bash
# Check which port MySQL is listening on
sudo ss -tlnp | grep mysql

# Check bind address
sudo grep -i bind-address /etc/mysql/mysql.conf.d/mysqld.cnf
```

By default, `bind-address = 127.0.0.1` blocks external connections.

### Fix: Allow external connections

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:
```
bind-address = 0.0.0.0
```

Then restart MySQL:
```bash
sudo systemctl restart mysql
```

---

## 2. Error: Host is not allowed to connect

```
Host '192.168.x.x' is not allowed to connect to this MySQL server
```

The MySQL user only exists for `localhost`. Create a remote entry:

```sql
-- Connect as root
sudo mysql

-- Create user for remote access
CREATE USER 'sqluser'@'%' IDENTIFIED BY 'yourpassword';
GRANT ALL PRIVILEGES ON *.* TO 'sqluser'@'%';
FLUSH PRIVILEGES;
```

> Use a specific IP instead of `'%'` for better security:
> `CREATE USER 'sqluser'@'192.168.1.10' ...`

---

## 3. Error: IDENTIFIED BY syntax error (MySQL 8.0+)

```
ERROR 1064 (42000): ... right syntax to use near 'IDENTIFIED BY ...'
```

MySQL 8.0 removed `IDENTIFIED BY` from `GRANT`. Use separate `CREATE USER` and `GRANT` statements (see above).

---

## 4. Error: Public Key Retrieval is not allowed

This is a MySQL 8.0 caching_sha2_password authentication issue.

**Option A** — Add to JDBC connection URL (client-side fix):
```
allowPublicKeyRetrieval=true&useSSL=false
```

**Option B** — Switch user to legacy auth plugin (recommended for compatibility):
```sql
ALTER USER 'sqluser'@'%' IDENTIFIED WITH mysql_native_password BY 'yourpassword';
FLUSH PRIVILEGES;
```

---

## 5. Check Firewall

```bash
sudo ufw status
sudo ufw allow 3306/tcp
```

---

## Quick Reference

| Problem | Cause | Fix |
|---|---|---|
| Connection refused | `bind-address = 127.0.0.1` | Set to `0.0.0.0`, restart MySQL |
| Host not allowed | User only exists for `localhost` | `CREATE USER 'user'@'%'` + `GRANT` |
| Syntax error on GRANT | MySQL 8.0 removed `IDENTIFIED BY` in GRANT | Use separate `CREATE USER` then `GRANT` |
| Public key retrieval error | caching_sha2_password plugin | Use `mysql_native_password` or add `allowPublicKeyRetrieval=true` |
| Port blocked | Firewall blocking 3306 | `sudo ufw allow 3306/tcp` |
