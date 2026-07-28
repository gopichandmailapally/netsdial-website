-- ═══════════════════════════════════════════════════════════════
--  NetsDial – Auto-fill areas for ALL districts that have NONE
--  Gives every district 3 areas so the menu always shows services
-- ═══════════════════════════════════════════════════════════════

-- Step 1: Insert "<District> City" for all empty districts
INSERT IGNORE INTO areas (district_id, name, slug, is_active)
SELECT d.id,
  CONCAT(d.name, ' City') AS name,
  CONCAT(d.slug, '-main') AS slug,
  1
FROM districts d
LEFT JOIN areas a ON a.district_id = d.id AND a.is_active = 1
WHERE d.is_active = 1
GROUP BY d.id
HAVING COUNT(a.id) = 0;

-- Step 2: Insert "<District> Urban" for all those same empty districts
INSERT IGNORE INTO areas (district_id, name, slug, is_active)
SELECT d.id,
  CONCAT(d.name, ' Urban') AS name,
  CONCAT(d.slug, '-urban-area') AS slug,
  1
FROM districts d
LEFT JOIN areas a ON a.district_id = d.id AND a.is_active = 1
WHERE d.is_active = 1
GROUP BY d.id
HAVING COUNT(a.id) <= 1;

-- Step 3: Insert "<District> Town" for all those same empty districts
INSERT IGNORE INTO areas (district_id, name, slug, is_active)
SELECT d.id,
  CONCAT(d.name, ' Town') AS name,
  CONCAT(d.slug, '-town') AS slug,
  1
FROM districts d
LEFT JOIN areas a ON a.district_id = d.id AND a.is_active = 1
WHERE d.is_active = 1
GROUP BY d.id
HAVING COUNT(a.id) <= 2;

-- Verify: no district should have 0 areas now
SELECT 'Districts still with 0 areas:' AS check_label,
  COUNT(*) AS count
FROM (
  SELECT d.id
  FROM districts d
  LEFT JOIN areas a ON a.district_id = d.id AND a.is_active = 1
  WHERE d.is_active = 1
  GROUP BY d.id
  HAVING COUNT(a.id) = 0
) x;

-- Final totals
SELECT COUNT(*) AS total_districts FROM districts WHERE is_active=1;
SELECT COUNT(*) AS total_areas FROM areas WHERE is_active=1;
SELECT COUNT(*) * 19 AS estimated_service_pages FROM areas WHERE is_active=1;
