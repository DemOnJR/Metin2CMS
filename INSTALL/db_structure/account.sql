ALTER TABLE account.account ADD COLUMN `web_admin` int(1) NULL DEFAULT 0;
ALTER TABLE account.account ADD COLUMN `web_ip` varchar(12) NULL DEFAULT 0;
ALTER TABLE account.account ADD COLUMN `coins` varchar(32) NULL DEFAULT 0;