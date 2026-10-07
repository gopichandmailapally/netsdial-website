<?php
/**
 * ============================================================================
 * FEASIBLE LOCATION SERVICE SYSTEM (Version 1.0 — 5 Million+ Dynamic Matrix)
 * ============================================================================
 * Strictly enforces geo-fencing business rules:
 * 1. Cloth Hangers & Residential Balcony Nets => Hyderabad City & Micro-areas ONLY.
 * 2. Invisible Grills => Entire Telangana & Entire Andhra Pradesh (100% locations).
 * 3. Box Cricket Setup, Turf & High-Rise Building Nets => 500 KM Radius from Hyderabad.
 * 4. Construction Safety Nets, Spikes & Wholesale HDPE Material => Entire India (PAN India).
 * ============================================================================
 */

defined("NETSDIAL") or define("NETSDIAL", true);

class FeasibleLocationServiceSystem {

    const SCOPE_HYDERABAD_ONLY = "HYDERABAD_ONLY";
    const SCOPE_TS_AP_ONLY     = "TS_AP_ONLY";
    const SCOPE_RADIUS_500KM   = "RADIUS_500KM";
    const SCOPE_PAN_INDIA      = "PAN_INDIA";

    // 1. Service Definitions & Scope Mapping
    public static $SERVICES = [
        // --- HYDERABAD ONLY (Cloth Hangers & Residential Balcony) ---
        "cloth-hangers-installation"       => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Cloth Hangers Installation", "cat" => "Home Utility", "install" => true],
        "ss-cloth-hangers"                 => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "SS Cloth Drying Hangers", "cat" => "Home Utility", "install" => true],
        "ceiling-cloth-drying-hangers"     => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Ceiling Cloth Drying Hangers", "cat" => "Home Utility", "install" => true],
        "wall-mounted-cloth-hangers"       => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Wall Mounted Cloth Hangers", "cat" => "Home Utility", "install" => true],
        "pull-and-dry-cloth-hangers"       => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Pull and Dry Cloth Hangers", "cat" => "Home Utility", "install" => true],
        "balcony-safety-nets"              => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Balcony Safety Nets", "cat" => "Residential Netting", "install" => true],
        "pigeon-balcony-nets"              => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Pigeon Balcony Nets", "cat" => "Residential Netting", "install" => true],
        "pigeon-netting"                   => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Pigeon Netting", "cat" => "Residential Netting", "install" => true],
        "bird-netting"                     => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Bird Netting", "cat" => "Residential Netting", "install" => true],
        "anti-bird-nets"                   => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Anti Bird Nets", "cat" => "Residential Netting", "install" => true],
        "children-safety-nets"             => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Children Safety Nets", "cat" => "Residential Netting", "install" => true],
        "cat-safety-nets"                  => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Cat Safety Nets", "cat" => "Residential Netting", "install" => true],
        "pet-safety-nets"                  => ["scope" => self::SCOPE_HYDERABAD_ONLY, "name" => "Pet Safety Nets", "cat" => "Residential Netting", "install" => true],

        // --- TS & AP ONLY (Invisible Grills) ---
        "invisible-grills"                 => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "ss-invisible-grills"              => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "SS Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "balcony-invisible-grill"          => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Balcony Invisible Grill", "cat" => "Invisible Grills", "install" => true],
        "window-invisible-grill"           => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Window Invisible Grill", "cat" => "Invisible Grills", "install" => true],
        "frameless-invisible-grills"       => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Frameless Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "316-grade-invisible-grills"       => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "316 Marine Grade Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "staircase-invisible-grills"       => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Staircase Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "terrace-invisible-grills"         => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Terrace Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "open-area-invisible-grills"       => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Open Area Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "duct-area-invisible-grills"       => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Duct Area Invisible Grills", "cat" => "Invisible Grills", "install" => true],
        "transparent-safety-grill"         => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Transparent Safety Grill", "cat" => "Invisible Grills", "install" => true],
        "modern-invisible-grill"           => ["scope" => self::SCOPE_TS_AP_ONLY, "name" => "Modern Invisible Grill", "cat" => "Invisible Grills", "install" => true],

        // --- 500 KM RADIUS (Box Cricket & Large Commercial Building Works) ---
        "box-cricket-nets"                 => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Box Cricket Nets", "cat" => "Sports Setup", "install" => true],
        "box-cricket-setup"                => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Box Cricket Setup & Ground Planning", "cat" => "Sports Setup", "install" => true],
        "cricket-ground-pitch-turf"        => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Cricket Pitch Turf Setup", "cat" => "Sports Setup", "install" => true],
        "sports-practice-nets"             => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Sports Practice Nets", "cat" => "Sports Setup", "install" => true],
        "artificial-grass"                 => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Artificial Grass Installation", "cat" => "Turf & Flooring", "install" => true],
        "artificial-turf"                  => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Artificial Turf Setup", "cat" => "Turf & Flooring", "install" => true],
        "balcony-nets-for-building"        => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Balcony Nets for Commercial Building", "cat" => "Commercial Projects", "install" => true],
        "pigeon-nets-for-building"         => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Pigeon Nets for High-Rise Building", "cat" => "Commercial Projects", "install" => true],
        "duct-area-nets"                   => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Duct Area Safety Nets", "cat" => "Commercial Projects", "install" => true],
        "open-area-nets"                   => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Open Area Fall Protection Nets", "cat" => "Commercial Projects", "install" => true],
        "high-rise-building-safety-nets"   => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "High Rise Building Safety Nets", "cat" => "Commercial Projects", "install" => true],
        "industrial-bird-netting"          => ["scope" => self::SCOPE_RADIUS_500KM, "name" => "Industrial Bird Netting", "cat" => "Commercial Projects", "install" => true],

        // --- PAN INDIA (Construction Safety Nets, Spikes & Wholesale Material Supply) ---
        "construction-safety-nets"         => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Construction Safety Nets", "cat" => "Construction & Wholesale", "install" => false],
        "debris-safety-nets"               => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Debris Containment Safety Nets", "cat" => "Construction & Wholesale", "install" => false],
        "building-construction-nets"       => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Building Construction Nets", "cat" => "Construction & Wholesale", "install" => false],
        "scaffolding-safety-nets"          => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Scaffolding Safety Nets", "cat" => "Construction & Wholesale", "install" => false],
        "fall-protection-nets"             => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Fall Protection Safety Nets", "cat" => "Construction & Wholesale", "install" => false],
        "anti-fall-construction-nets"      => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Anti-Fall Construction Nets", "cat" => "Construction & Wholesale", "install" => false],
        "russea-hdpe-nets-wholesale"       => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Russea™ HDPE Nets Wholesale", "cat" => "Wholesale Supply", "install" => false],
        "hdpe-braided-nets-supply"         => ["scope" => self::SCOPE_PAN_INDIA, "name" => "HDPE Braided Nets Supply", "cat" => "Wholesale Supply", "install" => false],
        "hdpe-twisted-nets-supply"         => ["scope" => self::SCOPE_PAN_INDIA, "name" => "HDPE Twisted Nets Supply", "cat" => "Wholesale Supply", "install" => false],
        "nylon-safety-nets-supply"         => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Nylon Safety Nets Supply", "cat" => "Wholesale Supply", "install" => false],
        "pigeon-spikes"                    => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Pigeon Spikes Wholesale Supply", "cat" => "Bird Spikes", "install" => false],
        "anti-bird-spikes"                 => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Anti Bird Spikes Wholesale Supply", "cat" => "Bird Spikes", "install" => false],
        "polycarbonate-spikes"             => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Polycarbonate Bird Spikes Supply", "cat" => "Bird Spikes", "install" => false],
        "ss-bird-spikes"                   => ["scope" => self::SCOPE_PAN_INDIA, "name" => "SS Bird Spikes Wholesale Supply", "cat" => "Bird Spikes", "install" => false],
        "bird-spikes-wholesale"            => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Bird Spikes Wholesale Dealers", "cat" => "Bird Spikes", "install" => false],
        "safety-nets-materials-supply"     => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Safety Nets Materials Supply", "cat" => "Wholesale Supply", "install" => false],
        "cricket-nets-material-wholesale"  => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Cricket Nets Material Wholesale", "cat" => "Wholesale Supply", "install" => false],
        "cargo-safety-nets"                => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Cargo Safety Nets", "cat" => "Industrial Nets", "install" => false],
        "industrial-safety-nets"           => ["scope" => self::SCOPE_PAN_INDIA, "name" => "Industrial Safety Nets", "cat" => "Industrial Nets", "install" => false]
    ];

    // 2. High Value Search Intents Mapped by Scope
    public static $INTENTS_PAN_INDIA = [
        "wholesale", "suppliers", "manufacturers", "dealers", "distributors", "wholesalers",
        "price-per-sqft", "price-per-kg", "cost", "rate", "near-me", "bulk-supply", "factory-rates",
        "material-supply", "direct-factory", "heavy-duty", "isi-certified", "anti-uv", "high-tensile",
        "roll-price", "green-mesh", "white-mesh", "nylon-mesh", "safety-mesh", "barrier-mesh",
        "scaffolding-mesh", "containment-mesh", "fast-shipping", "transport-delivery", "hyderabad-dispatch",
        "dealer-price", "pan-india-delivery", "trade-price", "quote", "estimate", "contractors",
        "wholesale-dealers", "authorised-dealers", "bulk-suppliers", "factory-direct",
        "per-meter-price", "fast-dispatch", "certified-suppliers", "heavy-mesh-price",
        "green-safety-nets", "white-safety-nets", "nylon-ropes-supply", "border-rope-nets"
    ];

    public static $INTENTS_500KM = [
        "supply-and-installation", "setup-cost", "contractors", "installation-services", "near-me",
        "ground-planning", "commercial-contractors", "high-rise-installation", "rates", "dealers",
        "manufacturers", "suppliers", "wholesalers", "cost", "price", "fitting-services", "custom-setup",
        "turf-fitting", "box-cricket-cost", "quote", "estimate", "sports-contractors",
        "ground-setup-cost", "turf-installation-cost", "sports-arena-setup", "cage-cricket-setup",
        "commercial-building-nets", "duct-safety-contractors", "terrace-safety-nets", "boundary-nets-setup"
    ];

    public static $INTENTS_TS_AP = [
        "dealers", "manufacturers", "suppliers", "wholesalers", "distributors", "contractors",
        "installation", "fitting", "repair", "maintenance", "price", "cost", "rate", "near-me",
        "custom-fit", "quote", "estimate", "high-rise", "apartment", "villa", "duplex", "commercial",
        "child-safety", "pet-safety", "fall-protection", "316-grade", "marine-grade", "anti-rust",
        "stainless-steel", "ss-316", "rust-proof", "corrosion-resistant", "high-tensile", "fixing-services"
    ];

    public static $INTENTS_HYDERABAD = [
        "installation", "dealers", "price", "cost", "fitting", "near-me", "fixing-near-me",
        "same-day-service", "technicians", "suppliers", "manufacturers", "wholesalers", "balcony-fitting",
        "ceiling-hangers-cost", "wall-hangers-price", "quote", "estimate", "home-service"
    ];

    public static function evaluateServiceLocation($serviceSlug, $locationName, $districtName = "", $stateName = "") {
        $svc = self::$SERVICES[$serviceSlug] ?? null;
        if (!$svc) {
            return ["allowed" => false, "reason" => "Unknown service slug"];
        }

        $serviceName = $svc["name"];
        $fullGeo = strtolower($locationName . " " . $districtName . " " . $stateName);

        $isHyd = (
            stripos($fullGeo, "hyderabad") !== false || 
            stripos($fullGeo, "secunderabad") !== false || 
            stripos($fullGeo, "ranga reddy") !== false || 
            stripos($fullGeo, "rangareddy") !== false || 
            stripos($fullGeo, "medchal") !== false || 
            stripos($fullGeo, "kukatpally") !== false || 
            stripos($fullGeo, "gachibowli") !== false || 
            stripos($fullGeo, "madhapur") !== false || 
            stripos($fullGeo, "miyapur") !== false || 
            stripos($fullGeo, "kondapur") !== false || 
            stripos($fullGeo, "hitec city") !== false || 
            stripos($fullGeo, "dilsukhnagar") !== false || 
            stripos($fullGeo, "lb nagar") !== false || 
            stripos($fullGeo, "banjara hills") !== false || 
            stripos($fullGeo, "jubilee hills") !== false
        );

        $isTS_AP = (
            $isHyd ||
            stripos($fullGeo, "telangana") !== false ||
            stripos($fullGeo, "andhra pradesh") !== false ||
            stripos($fullGeo, "visakhapatnam") !== false ||
            stripos($fullGeo, "vijayawada") !== false ||
            stripos($fullGeo, "guntur") !== false ||
            stripos($fullGeo, "warangal") !== false ||
            stripos($fullGeo, "karimnagar") !== false ||
            stripos($fullGeo, "tirupati") !== false ||
            stripos($fullGeo, "kurnool") !== false ||
            stripos($fullGeo, "nellore") !== false ||
            stripos($fullGeo, "kakinada") !== false ||
            stripos($fullGeo, "rajahmundry") !== false ||
            stripos($fullGeo, "nalgonda") !== false ||
            stripos($fullGeo, "khammam") !== false ||
            stripos($fullGeo, "nizamabad") !== false ||
            stripos($fullGeo, "adilabad") !== false ||
            stripos($fullGeo, "anantapur") !== false ||
            stripos($fullGeo, "kadapa") !== false
        );

        $is500km = (
            $isTS_AP ||
            stripos($fullGeo, "bengaluru") !== false ||
            stripos($fullGeo, "bangalore") !== false ||
            stripos($fullGeo, "bidar") !== false ||
            stripos($fullGeo, "gulbarga") !== false ||
            stripos($fullGeo, "kalaburagi") !== false ||
            stripos($fullGeo, "raichur") !== false ||
            stripos($fullGeo, "bellary") !== false ||
            stripos($fullGeo, "ballari") !== false ||
            stripos($fullGeo, "yadgir") !== false ||
            stripos($fullGeo, "koppal") !== false ||
            stripos($fullGeo, "solapur") !== false ||
            stripos($fullGeo, "nanded") !== false ||
            stripos($fullGeo, "latur") !== false ||
            stripos($fullGeo, "osmanabad") !== false ||
            stripos($fullGeo, "chandrapur") !== false ||
            stripos($fullGeo, "yavatmal") !== false
        );

        switch ($svc["scope"]) {
            case self::SCOPE_HYDERABAD_ONLY:
                if (!$isHyd) {
                    return [
                        "allowed" => false, 
                        "reason"  => "Service '" . $serviceName . "' is exclusively available for supply & installation within Hyderabad City only."
                    ];
                }
                return [
                    "allowed"       => true,
                    "scope"         => self::SCOPE_HYDERABAD_ONLY,
                    "service_name"  => $serviceName,
                    "delivery_mode" => "Supply + Free Doorstep Installation in Hyderabad (Within 24 Hours)",
                    "badge"         => "Hyderabad Local Installation Crew",
                    "dispatch_note" => "Our trained local technicians visit your site in " . $locationName . " for free measurement & instant installation.",
                    "phone"         => "9966499144"
                ];

            case self::SCOPE_TS_AP_ONLY:
                if (!$isTS_AP) {
                    return [
                        "allowed" => false, 
                        "reason"  => "Invisible Grills installation is strictly available across Telangana & Andhra Pradesh."
                    ];
                }
                return [
                    "allowed"       => true,
                    "scope"         => self::SCOPE_TS_AP_ONLY,
                    "service_name"  => $serviceName,
                    "delivery_mode" => "Certified 316 Marine Grade SS — Full Supply & Expert Installation across TS & AP",
                    "badge"         => "Telangana & Andhra Pradesh Authorised",
                    "dispatch_note" => "Direct factory installation team covers " . $locationName . " with certified 316 SS cables and 10-year warranty.",
                    "phone"         => "9912399224"
                ];

            case self::SCOPE_RADIUS_500KM:
                if (!$is500km) {
                    return [
                        "allowed" => false, 
                        "reason"  => "Service '" . $serviceName . "' is provided within 500 KM radius from Hyderabad."
                    ];
                }
                return [
                    "allowed"       => true,
                    "scope"         => self::SCOPE_RADIUS_500KM,
                    "service_name"  => $serviceName,
                    "delivery_mode" => "Material Supply + Complete Setup & Professional Installation (500 KM Radius)",
                    "badge"         => "500 KM Radius Project Crew",
                    "dispatch_note" => "Turnkey project supply and expert installation crew dispatched directly from Hyderabad to " . $locationName . ".",
                    "phone"         => "9966499144"
                ];

            case self::SCOPE_PAN_INDIA:
            default:
                return [
                    "allowed"       => true,
                    "scope"         => self::SCOPE_PAN_INDIA,
                    "service_name"  => $serviceName,
                    "delivery_mode" => "PAN-India Wholesale Material Supply Direct from Hyderabad Factory",
                    "badge"         => "India-Wide Factory Direct Supply",
                    "dispatch_note" => "Dispatched directly from GCM Hyderabad Central Warehouse. Fast transport delivery across all 28 states & " . $locationName . ".",
                    "phone"         => "9966499144"
                ];
        }
    }
}
