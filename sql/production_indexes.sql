-- Gzaas production indexes
--
-- Take a backup first and run this during a low-traffic maintenance window.
-- MySQL ALTER TABLE statements auto-commit and may lock old table versions.
-- Check existing index names with: SHOW INDEX FROM table_name;

-- These checks must return no rows before adding the optional UNIQUE indexes
-- shown at the end of this file.
SELECT `urlKey`, COUNT(*) AS `duplicates`
FROM `messages`
GROUP BY `urlKey`
HAVING COUNT(*) > 1;

SELECT `apiKey`, COUNT(*) AS `duplicates`
FROM `apikeys`
GROUP BY `apiKey`
HAVING COUNT(*) > 1;

-- Lookup and relationship indexes. These do not change uniqueness rules.
ALTER TABLE `messages`
  ADD INDEX `idx_messages_url_key` (`urlKey`),
  ADD INDEX `idx_messages_visibility_id` (`visibility`, `id`),
  ADD INDEX `idx_messages_status_url_key` (`status`, `urlKey`);

ALTER TABLE `apikeys`
  ADD INDEX `idx_apikeys_api_key` (`apiKey`),
  ADD INDEX `idx_apikeys_deleted_api_key` (`deleted`, `apiKey`);

ALTER TABLE `apikey_message`
  ADD INDEX `idx_apikey_message_api_message` (`apiKey`, `idMessage`),
  ADD INDEX `idx_apikey_message_message` (`idMessage`);

ALTER TABLE `font_message`
  ADD INDEX `idx_font_message_message_font` (`idM`, `idF`),
  ADD INDEX `idx_font_message_font` (`idF`);

ALTER TABLE `color_message`
  ADD INDEX `idx_color_message_message` (`idM`);

ALTER TABLE `back_color_message`
  ADD INDEX `idx_back_color_message_message` (`idM`);

ALTER TABLE `pattern_message`
  ADD INDEX `idx_pattern_message_message_pattern` (`idM`, `idP`),
  ADD INDEX `idx_pattern_message_pattern` (`idP`);

ALTER TABLE `shadow_message`
  ADD INDEX `idx_shadow_message_message` (`idM`);

ALTER TABLE `style_message`
  ADD INDEX `idx_style_message_message_style` (`idM`, `idS`),
  ADD INDEX `idx_style_message_style` (`idS`);

ALTER TABLE `launchers`
  ADD INDEX `idx_launchers_message` (`idM`);

ALTER TABLE `message_visits`
  ADD INDEX `idx_message_visits_message_date` (`idM`, `date`),
  ADD INDEX `idx_message_visits_date` (`date`);

ALTER TABLE `fonts`
  ADD INDEX `idx_fonts_in_use_featured_font` (`inUse`, `featured`, `font`),
  ADD INDEX `idx_fonts_font` (`font`);

ALTER TABLE `patterns`
  ADD INDEX `idx_patterns_pattern` (`pattern`),
  ADD INDEX `idx_patterns_featured_pattern` (`featured`, `pattern`);

ALTER TABLE `styles`
  ADD INDEX `idx_styles_style` (`style`),
  ADD INDEX `idx_styles_public_featured_description` (`publicUse`, `featured`, `description`);

-- Optional integrity upgrade. Run these only after both duplicate checks above
-- return no rows. Drop the matching non-unique index first because the unique
-- index replaces it.
--
-- ALTER TABLE `messages`
--   DROP INDEX `idx_messages_url_key`,
--   ADD UNIQUE INDEX `uq_messages_url_key` (`urlKey`);
--
-- ALTER TABLE `apikeys`
--   DROP INDEX `idx_apikeys_api_key`,
--   ADD UNIQUE INDEX `uq_apikeys_api_key` (`apiKey`);
