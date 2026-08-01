<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
requireAdmin();
$current = basename(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI & Directory Listings – NetsDial Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .listing-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:20px;margin-top:24px }
    .listing-card { background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s }
    .listing-card:hover { transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.12) }
    .listing-card-header { padding:16px 20px;display:flex;gap:14px;align-items:center;border-bottom:1px solid #f3f4f6 }
    .listing-icon { width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0 }
    .listing-card-body { padding:16px 20px }
    .listing-card-body p { font-size:.88rem;color:#6b7280;line-height:1.6;margin-bottom:14px }
    .listing-btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:.85rem;font-weight:600;text-decoration:none;transition:.2s }
    .listing-btn-primary { background:var(--primary,#FF6B00);color:#fff }
    .listing-btn-primary:hover { background:#e55d00 }
    .listing-btn-outline { background:#fff;color:#374151;border:1.5px solid #d1d5db;margin-left:6px }
    .listing-btn-outline:hover { border-color:#374151 }
    .status-badge { font-size:.72rem;padding:3px 10px;border-radius:20px;font-weight:600;margin-left:auto }
    .status-free { background:#d1fae5;color:#065f46 }
    .status-paid { background:#fef3c7;color:#92400e }
    .status-critical { background:#fee2e2;color:#991b1b }
    .section-header { display:flex;align-items:center;gap:12px;margin:32px 0 8px;border-left:4px solid var(--primary,#FF6B00);padding-left:14px }
    .tip-box { background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:20px 24px;margin-bottom:24px }
    .tip-box h4 { color:#1d4ed8;margin-bottom:8px }
    .step-list { counter-reset:steps;list-style:none;padding:0;margin:0 }
    .step-list li { counter-increment:steps;display:flex;gap:14px;align-items:flex-start;padding:12px 0;border-bottom:1px solid #f3f4f6 }
    .step-list li:last-child { border:none }
    .step-list li::before { content:counter(steps);background:var(--primary,#FF6B00);color:#fff;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;flex-shrink:0;margin-top:1px }
    .copy-box { background:#1e293b;color:#e2e8f0;border-radius:10px;padding:16px;font-family:monospace;font-size:.85rem;line-height:1.7;margin-top:12px;white-space:pre-wrap;word-break:break-all;position:relative }
    .copy-btn { position:absolute;top:10px;right:10px;background:#334155;color:#e2e8f0;border:none;border-radius:6px;padding:4px 10px;font-size:.78rem;cursor:pointer }
    .copy-btn:hover { background:#475569 }
  </style>
</head>
<body>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<div class="admin-content">
  <div class="page-header">
    <h1><i class="fas fa-robot"></i> AI Platform & Directory Listings</h1>
    <p>Submit NetsDial to every search engine, AI platform, and business directory to appear in Google, ChatGPT, Gemini, Perplexity, Grok, Claude, DeepSeek, and more.</p>
  </div>

  <!-- Priority Alert -->
  <div class="tip-box" style="background:#fff7ed;border-color:#fed7aa">
    <h4 style="color:#c2410c"><i class="fas fa-fire"></i> Priority Action – Do These First!</h4>
    <p style="font-size:.9rem;color:#6b7280;margin:0">These 5 actions have the highest impact on appearing in AI platforms and search engines. Complete them before anything else.</p>
  </div>

  <!-- CRITICAL LISTINGS -->
  <div class="section-header">
    <i class="fas fa-exclamation-triangle" style="color:#dc2626"></i>
    <h2 style="margin:0;font-size:1.2rem">CRITICAL – Search Engines & AI (Do First)</h2>
  </div>
  <div class="listing-grid">

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#4285f422"><img src="https://www.google.com/favicon.ico" width="24" alt="Google"></div>
        <div>
          <div style="font-weight:700">Google Business Profile</div>
          <div style="font-size:.8rem;color:#6b7280">Powers Google Search, Maps & Gemini AI</div>
        </div>
        <span class="status-badge status-free">FREE</span>
      </div>
      <div class="listing-card-body">
        <p>This is the <strong>most important listing</strong>. When you create a Google Business Profile, your business appears in Google Maps, Google Search local pack, AND feeds Google Gemini AI answers. Add all photos, services, working hours, and get reviews.</p>
        <a href="https://business.google.com/create" target="_blank" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> Create / Claim Listing</a>
        <a href="https://support.google.com/business" target="_blank" class="listing-btn listing-btn-outline">Guide</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#00897b22"><img src="https://www.google.com/favicon.ico" width="24" alt="Google Search Console"></div>
        <div>
          <div style="font-weight:700">Google Search Console</div>
          <div style="font-size:.8rem;color:#6b7280">Submit sitemap – force Google to index all pages</div>
        </div>
        <span class="status-badge status-critical">DO NOW</span>
      </div>
      <div class="listing-card-body">
        <p>Submit your sitemap to Google Search Console so Google indexes ALL your 36,000+ service pages. Also use URL Inspection to check individual pages. Your site verification code can be added from <a href="/admin/settings.php">Admin Settings → SEO</a>.</p>
        <div class="copy-box">https://netsdial.com/sitemap.php<button class="copy-btn" onclick="navigator.clipboard.writeText('https://netsdial.com/sitemap.php')">Copy</button></div>
        <br>
        <a href="https://search.google.com/search-console" target="_blank" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> Open Search Console</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#0078d422"><img src="https://www.bing.com/favicon.ico" width="24" alt="Bing"></div>
        <div>
          <div style="font-weight:700">Bing Webmaster + Places</div>
          <div style="font-size:.8rem;color:#6b7280">Powers Bing Search & Microsoft Copilot AI</div>
        </div>
        <span class="status-badge status-free">FREE</span>
      </div>
      <div class="listing-card-body">
        <p>Bing powers <strong>Microsoft Copilot AI</strong> and ChatGPT's web browsing. Submit your sitemap to Bing Webmaster Tools AND create a Bing Places listing for local search.</p>
        <a href="https://www.bing.com/webmasters" target="_blank" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> Bing Webmaster</a>
        <a href="https://www.bingplaces.com" target="_blank" class="listing-btn listing-btn-outline">Bing Places</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#7c3aed22"><i class="fas fa-robot" style="color:#7c3aed"></i></div>
        <div>
          <div style="font-weight:700">ChatGPT / OpenAI Operator</div>
          <div style="font-size:.8rem;color:#6b7280">Powers ChatGPT search and browsing answers</div>
        </div>
        <span class="status-badge status-free">FREE</span>
      </div>
      <div class="listing-card-body">
        <p>ChatGPT uses Bing search results AND your website's <code>llms.txt</code> file (already created at <strong>netsdial.com/llms.txt</strong>) to answer questions. Also submit your URL to OpenAI's crawler allowlist. Your <code>robots.txt</code> already allows GPTBot.</p>
        <a href="https://openai.com/form/operator-feedback" target="_blank" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> OpenAI Submit</a>
        <a href="https://netsdial.com/llms.txt" target="_blank" class="listing-btn listing-btn-outline">View llms.txt</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#1a73e822"><i class="fab fa-google" style="color:#1a73e8;font-size:1.4rem"></i></div>
        <div>
          <div style="font-weight:700">Google Knowledge Panel</div>
          <div style="font-size:.8rem;color:#6b7280">Appear in Google's entity knowledge cards</div>
        </div>
        <span class="status-badge status-free">FREE</span>
      </div>
      <div class="listing-card-body">
        <p>A Google Knowledge Panel is what appears on the right side of Google Search results for well-known entities. It's powered by Google Business Profile + consistent NAP (Name, Address, Phone) across the web. Add netsdial.com to as many directories as possible with the <strong>exact same business name, address, and phone</strong>.</p>
        <a href="https://support.google.com/knowledgepanel/answer/9787176" target="_blank" class="listing-btn listing-btn-primary">Learn More</a>
      </div>
    </div>

  </div>

  <!-- AI PLATFORMS -->
  <div class="section-header" style="margin-top:40px">
    <i class="fas fa-microchip" style="color:#7c3aed"></i>
    <h2 style="margin:0;font-size:1.2rem">AI Platforms (Appear in AI Answers)</h2>
  </div>
  <div class="listing-grid">

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#10a37f22"><i class="fas fa-comment-dots" style="color:#10a37f;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">Perplexity AI</div>
          <div style="font-size:.8rem;color:#6b7280">Direct web indexer – crawls your site</div>
        </div>
        <span class="status-badge status-free">AUTO</span>
      </div>
      <div class="listing-card-body">
        <p>Perplexity AI (perplexity.ai) runs its own web crawler (<strong>PerplexityBot</strong>) which is already allowed in your <code>robots.txt</code>. You can also submit your URL directly to Perplexity to get indexed faster. Ask Perplexity about "NetsDial" to check if it's indexed.</p>
        <a href="https://www.perplexity.ai" target="_blank" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> Check on Perplexity</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#cc785c22"><i class="fas fa-brain" style="color:#cc785c;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">Claude AI (Anthropic)</div>
          <div style="font-size:.8rem;color:#6b7280">Uses web search – ClaudeBot allowed</div>
        </div>
        <span class="status-badge status-free">AUTO</span>
      </div>
      <div class="listing-card-body">
        <p>Claude AI uses the Anthropic web crawler (<strong>ClaudeBot</strong>) which is already allowed in your <code>robots.txt</code>. Your <code>llms.txt</code> file also helps Claude understand your business. Claude's answers will include your site when users ask about nets in Hyderabad.</p>
        <a href="https://claude.ai" target="_blank" class="listing-btn listing-btn-primary">Check on Claude</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#1da1f222"><i class="fab fa-twitter" style="color:#1da1f2;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">Grok AI (xAI / X)</div>
          <div style="font-size:.8rem;color:#6b7280">X/Twitter AI – create a business page on X</div>
        </div>
        <span class="status-badge status-free">FREE</span>
      </div>
      <div class="listing-card-body">
        <p>Grok AI (by Elon Musk's xAI) sources from X/Twitter posts AND web. Create an <strong>X (Twitter) business profile</strong> for NetsDial and post regularly about your services. Grokbot is already allowed in your robots.txt. Regular posts about your services will be indexed by Grok.</p>
        <a href="https://x.com" target="_blank" class="listing-btn listing-btn-primary"><i class="fab fa-twitter"></i> Create X Profile</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#0582e822"><img src="https://www.deepseek.com/favicon.ico" width="24" alt="DeepSeek" onerror="this.style.display='none'"><i class="fas fa-robot" style="color:#0582e8;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">DeepSeek AI</div>
          <div style="font-size:.8rem;color:#6b7280">Chinese AI – global web indexing</div>
        </div>
        <span class="status-badge status-free">AUTO</span>
      </div>
      <div class="listing-card-body">
        <p>DeepSeek AI crawls the web automatically. Your <code>robots.txt</code> already allows DeepSeek crawlers. Your <code>llms.txt</code> will also help DeepSeek understand NetsDial. No specific submission needed – ensure your site is fast and well-structured.</p>
        <a href="https://chat.deepseek.com" target="_blank" class="listing-btn listing-btn-primary">Check on DeepSeek</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#4f46e522"><i class="fas fa-gem" style="color:#4f46e5;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">Google Gemini AI</div>
          <div style="font-size:.8rem;color:#6b7280">Powered by Google Search + Google Business</div>
        </div>
        <span class="status-badge status-critical">DO FIRST</span>
      </div>
      <div class="listing-card-body">
        <p>Google Gemini's AI answers come from <strong>Google Search results + your Google Business Profile</strong>. The most important step is: (1) verify on Google Search Console, (2) create/optimise Google Business Profile, (3) get 5-star reviews on Google. Google-Extended bot is already allowed.</p>
        <a href="https://gemini.google.com" target="_blank" class="listing-btn listing-btn-primary">Check on Gemini</a>
      </div>
    </div>

    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:#f97f1b22"><i class="fas fa-search" style="color:#f97f1b;font-size:1.3rem"></i></div>
        <div>
          <div style="font-weight:700">You.com AI</div>
          <div style="font-size:.8rem;color:#6b7280">AI search engine with web results</div>
        </div>
        <span class="status-badge status-free">AUTO</span>
      </div>
      <div class="listing-card-body">
        <p>You.com is an AI search engine that crawls the web (YouBot allowed in robots.txt). No special submission required. Ensure your pages load fast and have clear, structured content.</p>
        <a href="https://you.com" target="_blank" class="listing-btn listing-btn-primary">Check on You.com</a>
      </div>
    </div>

  </div>

  <!-- BUSINESS DIRECTORIES -->
  <div class="section-header" style="margin-top:40px">
    <i class="fas fa-th-list" style="color:#059669"></i>
    <h2 style="margin:0;font-size:1.2rem">Indian Business Directories (NAP Citations)</h2>
  </div>
  <p style="color:#6b7280;font-size:.9rem;margin-bottom:4px">Consistent Name, Address, Phone (NAP) across directories builds trust with Google and AI. Use EXACTLY the same details everywhere.</p>
  <div class="copy-box" style="margin-bottom:24px">Business Name: NetsDial (GCM Enterprises)
Phone: +91 9966499144
Email: contact@netsdial.com
Address: Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar – 500035, Hyderabad, Telangana, India
Website: https://netsdial.com
Category: Safety Net Suppliers / Sports Net Dealers / Bird Control Services<button class="copy-btn" onclick="navigator.clipboard.writeText('NetsDial (GCM Enterprises)\n+91 9966499144\ncontact@netsdial.com\nPlot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar – 500035, Hyderabad, Telangana\nhttps://netsdial.com')">Copy</button></div>

  <div class="listing-grid">
    <?php
    $directories = [
      ['Justdial', 'fab fa-j', '#e84118', 'India\'s largest local search. Creates a business listing page that ranks on Google. FREE listing available.', 'https://business.justdial.com', 'FREE', 'free'],
      ['Sulekha', 'fas fa-bullseye', '#ff4500', 'Local services marketplace in India. Creates a profile page that AI platforms can reference.', 'https://www.sulekha.com/post-business', 'FREE', 'free'],
      ['IndiaMART', 'fas fa-industry', '#1abc9c', 'B2B marketplace – perfect for wholesale net business. Creates a detailed product catalog page.', 'https://seller.indiamart.com', 'FREE', 'free'],
      ['TradeIndia', 'fas fa-handshake', '#2980b9', 'B2B trade directory. Good for wholesale buyers finding NetsDial for bulk orders.', 'https://www.tradeindia.com/seller-registration', 'FREE', 'free'],
      ['ExportersIndia', 'fas fa-globe', '#8e44ad', 'Wholesale supplier directory. Great for appearing when businesses search for net suppliers.', 'https://www.exportersindia.com/register.htm', 'FREE', 'free'],
      ['Yellow Pages India', 'fas fa-book', '#f39c12', 'Classic business directory still referenced by AI knowledge graphs.', 'https://www.yellowpages.in', 'FREE', 'free'],
      ['Shopify / Google Merchant', 'fas fa-shopping-cart', '#96bf48', 'Add products to Google Merchant Center for Shopping results.', 'https://merchants.google.com', 'FREE', 'free'],
      ['Apple Maps Connect', 'fab fa-apple', '#000000', 'Powers Siri and Apple devices. Create your listing to appear in Siri searches.', 'https://mapsconnect.apple.com', 'FREE', 'free'],
      ['Facebook Business', 'fab fa-facebook', '#1877f2', 'Facebook Business Page – also feeds Meta AI. Add all services, photos, reviews.', 'https://www.facebook.com/pages/create', 'FREE', 'free'],
      ['Instagram Business', 'fab fa-instagram', '#e1306c', 'Instagram Business profile – linked to Facebook, feeds Meta AI.', 'https://www.instagram.com/accounts/convert_to_business', 'FREE', 'free'],
      ['LinkedIn Company', 'fab fa-linkedin', '#0a66c2', 'Professional business profile. Adds credibility and referenced by AI knowledge graphs.', 'https://www.linkedin.com/company/setup/new/', 'FREE', 'free'],
      ['YouTube Channel', 'fab fa-youtube', '#ff0000', 'Video content is heavily used by Google AI Overviews. Post installation videos, customer reviews.', 'https://www.youtube.com/create_channel', 'FREE', 'free'],
      ['Wikidata', 'fas fa-database', '#339966', 'Wikipedia\'s structured data – the primary source for AI knowledge graphs. Create a Wikidata entity for NetsDial.', 'https://www.wikidata.org/wiki/Special:NewItem', 'FREE', 'free'],
      ['Yelp India', 'fab fa-yelp', '#c41200', 'Review site referenced by many AI platforms for business reputation.', 'https://biz.yelp.com', 'FREE', 'free'],
      ['Foursquare', 'fas fa-map-pin', '#f94877', 'Location data used by many AI and mapping platforms.', 'https://foursquare.com/add-place', 'FREE', 'free'],
      ['Zomato / Swiggy', 'fas fa-utensils', '#cb202d', 'Not food – but listing creates a web presence. Skip this one.', '#', 'N/A', 'paid'],
      ['Urban Company (UrbanClap)', 'fas fa-tools', '#7c3aed', 'Home services platform. List as a service provider for safety nets and installation.', 'https://www.urbancompany.com/professional-registration', 'FREE', 'free'],
      ['NoBroker', 'fas fa-home', '#e74c3c', 'Home services marketplace. List for pigeon net and safety net installation services.', 'https://www.nobroker.in/home-services', 'FREE', 'free'],
    ];
    foreach ($directories as $d): ?>
    <div class="listing-card">
      <div class="listing-card-header">
        <div class="listing-icon" style="background:<?php echo $d[2]; ?>22">
          <i class="<?php echo $d[1]; ?>" style="color:<?php echo $d[2]; ?>;font-size:1.2rem"></i>
        </div>
        <div>
          <div style="font-weight:700"><?php echo $d[0]; ?></div>
        </div>
        <span class="status-badge status-<?php echo $d[6]; ?>"><?php echo $d[4]; ?></span>
      </div>
      <div class="listing-card-body">
        <p><?php echo $d[3]; ?></p>
        <?php if ($d[5] !== '#'): ?>
        <a href="<?php echo $d[5]; ?>" target="_blank" rel="noopener" class="listing-btn listing-btn-primary"><i class="fas fa-external-link-alt"></i> Open & Register</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- SEO Checklist -->
  <div class="section-header" style="margin-top:40px">
    <i class="fas fa-tasks" style="color:#d97706"></i>
    <h2 style="margin:0;font-size:1.2rem">Google Indexing Checklist</h2>
  </div>
  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:28px;margin-bottom:40px">
    <ol class="step-list">
      <li>
        <div>
          <strong>Submit sitemap to Google Search Console</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Go to <a href="https://search.google.com/search-console" target="_blank">search.google.com/search-console</a> → Sitemaps → Add: <code>https://netsdial.com/sitemap.php</code></span>
        </div>
      </li>
      <li>
        <div>
          <strong>Verify your site in Google Search Console</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Add the HTML meta verification tag from <a href="/admin/settings.php">Admin → Settings → SEO</a> (Google Search Console verification field)</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Create/optimise Google Business Profile</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Add all photos (use the 25 service images just created), hours, description, services list. This feeds Gemini AI.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Submit sitemap to Bing Webmaster Tools</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Go to <a href="https://www.bing.com/webmasters" target="_blank">bing.com/webmasters</a> → Submit sitemap. This feeds Bing + Microsoft Copilot + ChatGPT browsing.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Request indexing for key pages in GSC</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Use URL Inspection in Google Search Console to manually request indexing for: home, about, estimation, contact, and 10–20 top service pages.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Create Wikidata entity for NetsDial</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Go to <a href="https://www.wikidata.org/wiki/Special:NewItem" target="_blank">wikidata.org</a> → Create a new item for "NetsDial" (GCM Enterprises) with all business properties. This is a top signal for AI knowledge graphs.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>List on Justdial, Sulekha, IndiaMART</strong><br>
          <span style="font-size:.85rem;color:#6b7280">These Indian directories rank on Google and their data is scraped by AI systems. Use exact same NAP everywhere.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Get Google reviews from customers</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Share your Google Business review link with customers. 50+ genuine reviews dramatically increase trust signals for all AI platforms.</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Verify llms.txt is accessible</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Open <a href="https://netsdial.com/llms.txt" target="_blank">netsdial.com/llms.txt</a> in browser – if it shows content, AI crawlers can read it. This is already done ✅</span>
        </div>
      </li>
      <li>
        <div>
          <strong>Check robots.txt allows all AI crawlers</strong><br>
          <span style="font-size:.85rem;color:#6b7280">Open <a href="https://netsdial.com/robots.txt" target="_blank">netsdial.com/robots.txt</a> – it should show GPTBot, ClaudeBot, PerplexityBot, etc. all allowed. Already done ✅</span>
        </div>
      </li>
    </ol>
  </div>

</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
</body>
</html>
