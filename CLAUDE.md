# CLAUDE.md — CLEAN ERP Backend (cleanerp-suite-backend)

This file is the persistent briefing for Claude Code. Read it fully at the start of
every session before writing any code. The frontend source has been inspected directly
and this file reflects the actual code, not specs.

---

## 0. Workspace Orientation (Read First)

This workspace contains two repositories:

```
mpromo/
  ├── clean-erp-suite/       ← Frontend (React/TypeScript) — READ ONLY
  └── clean-erp-backend/     ← Backend (Laravel) — YOUR WORKING DIRECTORY
```

**Rules:**
- Your working directory for ALL file creation, editing, and terminal commands
  is `clean-erp-backend/`. Always `cd clean-erp-backend` before running any
  artisan, composer, or shell commands.
- `clean-erp-suite/` is **read-only reference**. You may read files in it to
  understand API contracts, field names, and endpoint shapes, but you must
  never create, edit, or delete anything inside it.
- If you are ever unsure which directory you are in, run `pwd` before acting.

---

## 1. Who I Am and What This Project Is

I am the developer and business owner of **Magvlyn Industries Ltd.**, a Ghanaian
packaged drinking water company. Our flagship product is **Mobile Water** — Ghana's
original pioneer sachet water brand (500ml sachets, 20L jars, 500ml PET bottles). We
also produce **Vaettel Natural Mineral Water** (500ml PET). 2026 is Mobile Water's
30th anniversary.

This codebase is the **Laravel backend** for **CLEAN ERP** — an enterprise platform
managing Magvlyn's operations and its national sachet water franchise network.

**Frontend repo (read-only reference):** https://github.com/bodstar/cleanerp-suite
**Backend repo (this project):** https://github.com/bodstar/cleanerp-suite-backend

The frontend is a **Vite + React + TypeScript + shadcn/ui + React Query** app built
primarily with Lovable AI. I develop the backend in Laravel and use Claude Code to
help write and extend it.

---

## 2. Business Context

### The Franchise Model
Magvlyn operates a sachet water franchise network. Entrepreneurs license the
**Mobile Water** brand, produce water at their own factories, and sell in assigned
territories. Currently Magvlyn earns franchise revenue by selling raw plastic packaging
materials (rolls and sachet bags) to franchisees at a markup. The long-term vision is
a full franchise platform (eventually SaaS).

Key terminology:
- **HQ** = Magvlyn Industries Ltd. (the franchisor)
- **Franchisee / Tenant** = independent sachet water producer under Mobile Water brand
- **Team** = the database concept for a tenant (HQ is Team 1; each franchisee is a team)
- **Roll** = polyethylene plastic rolls (LDPE/LLDPE/HDPE/Metallocene) sold by KG
- **Sachet bag** = packaging bag holding 30 finished sachet pieces
- **Cross-carpeting** = a franchisee selling into another franchisee's territory

### The Value Chain (Critical for M-Promo)
```
Magvlyn / Franchisee (Producer)
    ↓
Distributor (sometimes skipped)
    ↓
Chiller / Retailer (has a fridge, chills water)
    ↓
Ice Water Girl / Street Vendor (buys chilled sachets, sells to end consumers)
    ↓
Final Consumer
```

Chillers and ice water sellers are the **strategic leverage points**. Mobile Water's
competitive advantage was built by targeting these two groups directly with the
M-Promo system — loyalty rewards, mystery shopper codes, and mobile money payouts.

---

## 3. Technical Architecture

### Stack
- **Framework:** Laravel 12
- **Auth:** Laravel Sanctum (token-based, stateless API)
- **Roles & Permissions:** Laratrust (with Teams support)
- **Database:** MySQL
- **API style:** REST, JSON
- **Payments/Payouts:** Paystack (Ghana mobile money)

### Multi-Tenancy
Single-database multi-tenant architecture using Laravel Teams (via Laratrust).

- Every user belongs to one or more **Teams**
- A Team = a tenant (Magvlyn HQ or a franchisee)
- Every protected API request requires header `X-Team-ID: {team_id}`
- Users who are members of **Team 1 (Magvlyn HQ)** AND have the
  `mpromo.hq.global_view` permission can switch teams and view across all teams
- Both conditions must be true — Team 1 membership alone is not sufficient,
  and the permission alone (without Team 1 membership) is not sufficient
- All other users are locked to their own team only

### Auth Layer (Already Working)
| Endpoint | Description |
|---|---|
| `POST /api/auth/login` | Returns `{ token, user, teams[], current_team_id }` |
| `GET /api/auth/me` | Session bootstrap — returns same shape as login |
| `POST /api/auth/switch-team` | Body: `{ team_id }` → returns `{ current_team_id, permissions[] }` |
| `POST /api/auth/logout` | Revokes token |

**Login response shape the frontend expects** (from `src/types/auth.ts`):
```json
{
  "token": "string",
  "user": { "id": 1, "name": "string", "email": "string" },
  "teams": [
    {
      "id": 1,
      "name": "Magvlyn HQ",
      "role": "admin",
      "permissions": ["mpromo.view", "mpromo.hq.global_view", "..."]
    }
  ],
  "current_team_id": 1
}
```

Note: `permissions` is nested inside each team object. The frontend reads the
permissions of the `current_team_id` team to determine what the user can do.

### Roles (Laratrust)
```
HQ_ADMIN          — full system access, manages all tenants
HQ_STAFF          — HQ operational staff
SUPPORT_AGENT     — can assist/impersonate franchisee tenants
FRANCHISE_ADMIN   — full access within their own team only
FRANCHISE_MANAGER — operational manager within their team
FRANCHISE_STAFF   — limited staff within their team
```

### Pivot Table Note
The `team_user` pivot uses a **composite primary key** (`team_id` + `user_id`) with
no standalone `id` column. This was deliberately chosen. Eloquent `belongsToMany()`
works fine without a pivot `id`.

---

## 4. M-Promo Module — Exact Data Shapes

These are derived directly from `src/types/mpromo.ts` in the frontend. These are
the canonical field names the frontend expects. Do not deviate from them.

### Enums / String Literals
```
PartnerType:    "CHILLER" | "ICE_WATER_SELLER"
PartnerStatus:  "active" | "suspended"              // lowercase in DB + API
CampaignType:   "VOLUME_REBATE" | "MYSTERY_SHOPPER"
CampaignStatus: "draft" | "active" | "paused" | "ended"  // lowercase
CodeStatus:     "active" | "redeemed" | "expired" | "cancelled"
PayoutStatus:   "pending" | "paid" | "failed"
OrderStatus:    "pending" | "confirmed" | "delivered" | "cancelled"
OrderSource:    "MPROMO"  // orders from this module always carry this source tag
```

### Partner
```json
{
  "id": 1,
  "name": "Ama's Chiller Spot",
  "phone": "+233241234567",
  "type": "CHILLER",
  "location": "Kumasi, Adum Market",
  "status": "active",
  "last_activity": "2026-01-15T10:00:00Z",
  "latitude": 6.6885,
  "longitude": -1.6244,
  "geolocation_captured_at": "2026-01-10T09:00:00Z",
  "loyalty_points": 120,
  "team_id": 2,
  "team_name": "Franchise – Kumasi",
  "created_at": "2026-01-01T00:00:00Z",
  "updated_at": "2026-01-15T10:00:00Z"
}
```
Nullable fields: `last_activity`, `latitude`, `longitude`, `geolocation_captured_at`, `team_name`.

### Campaign
```json
{
  "id": 1,
  "name": "Q1 Volume Rebate",
  "type": "VOLUME_REBATE",
  "status": "active",
  "start_date": "2026-01-01",
  "end_date": "2026-03-31",
  "tiers": [
    { "threshold": 100, "reward_amount": 500.00, "loyalty_points": 10 }
  ],
  "reward_amount": null,
  "loyalty_points": null,
  "total_redemptions": 45,
  "total_spend": 22500.00,
  "team_id": 1,
  "team_name": "Magvlyn HQ",
  "created_at": "2026-01-01T00:00:00Z"
}
```
`tiers` is present for `VOLUME_REBATE`. `reward_amount` and `loyalty_points` (flat
fields) are present for `MYSTERY_SHOPPER`. Null the irrelevant ones.

### PromoCode
```json
{
  "id": 1,
  "code": "MW-ABC123",
  "campaign_id": 1,
  "campaign_name": "Q1 Volume Rebate",
  "issued_to": "Ama's Chiller Spot",
  "status": "active",
  "expires_at": "2026-03-31",
  "redeemed_at": null,
  "redemption_amount": 500.00,
  "team_id": 1,
  "team_name": "Magvlyn HQ"
}
```

### Redemption
```json
{
  "id": 1,
  "date": "2026-02-10T14:22:00Z",
  "code_id": 12,
  "code": "MW-ABC123",
  "partner_id": 5,
  "partner_name": "Ama's Chiller Spot",
  "partner_type": "CHILLER",
  "campaign_id": 1,
  "campaign_name": "Q1 Volume Rebate",
  "amount": 500.00,
  "payout_status": "paid",
  "reference": "PST-REF-XYZ789",
  "team_id": 1,
  "team_name": "Magvlyn HQ"
}
```

### Payout
```json
{
  "id": 1,
  "partner_id": 5,
  "partner_name": "Ama's Chiller Spot",
  "phone": "+233241234567",
  "amount": 500.00,
  "status": "pending",
  "paystack_reference": null,
  "paid_at": null,
  "created_at": "2026-02-10T14:22:00Z",
  "team_id": 1,
  "team_name": "Magvlyn HQ"
}
```

### MPromoOrder
```json
{
  "id": 1,
  "order_no": "ORD-2026-001",
  "partner_id": 5,
  "partner_name": "Ama's Chiller Spot",
  "date": "2026-02-10T08:00:00Z",
  "total": 1200.00,
  "status": "pending",
  "source": "MPROMO",
  "team_id": 2,
  "team_name": "Franchise – Kumasi"
}
```

### MPromoOverview
```json
{
  "active_campaigns": 3,
  "today_redemptions_count": 12,
  "today_redemptions_amount": 6000.00,
  "pending_payouts_count": 8,
  "pending_payouts_amount": 4000.00,
  "orders_today": 5,
  "top_chillers": [
    { "id": 1, "name": "Ama's Chiller Spot", "value": 15000.00, "team_name": "Franchise – Kumasi" }
  ],
  "top_ice_water_sellers": [
    { "id": 2, "name": "Akua Ice Water", "value": 8000.00, "team_name": "Franchise – Accra Central" }
  ],
  "top_loyalty": [
    { "id": 1, "name": "Ama's Chiller Spot", "type": "CHILLER", "points": 350, "team_name": "Franchise – Kumasi" }
  ],
  "recent_activity": [
    {
      "id": 1,
      "type": "redemption",
      "description": "Ama's Chiller Spot redeemed GH₵500 from Q1 Volume Rebate",
      "time": "2026-02-10T14:22:00Z",
      "partner_id": 5,
      "partner_name": "Ama's Chiller Spot",
      "team_name": "Franchise – Kumasi"
    }
  ]
}
```

### MapPartner (richer than Partner — for map view only)
```json
{
  "id": 1,
  "name": "Ama's Chiller Spot",
  "type": "CHILLER",
  "status": "active",
  "phone": "+233241234567",
  "location": "Kumasi, Adum",
  "latitude": 6.6885,
  "longitude": -1.6244,
  "last_activity": "2026-02-10T14:22:00Z",
  "redemptions_count": 12,
  "redemptions_amount": 6000.00,
  "orders_count": 8,
  "orders_amount": 9600.00,
  "pending_payouts_count": 2,
  "pending_payouts_amount": 1000.00,
  "loyalty_points": 350,
  "team_id": 2,
  "team_name": "Franchise – Kumasi",
  "form_data": {
    "form-1": { "field-sales-vol": 240, "field-competitors": 3 }
  }
}
```
`form_data` is a nested map: `formId → fieldId → aggregated numeric value`. It is
populated when the map view has an active Market Data heatmap metric selected. Can
be `null` or omitted when no heatmap metric is active.

### PointsHistoryEntry
```json
{
  "id": 1,
  "date": "2026-02-10T14:22:00Z",
  "points": 10,
  "campaign_id": 1,
  "campaign_name": "Q1 Volume Rebate",
  "redemption_id": 7,
  "description": "Earned from Q1 Volume Rebate redemption"
}
```

### FormDefinition (Market Data module)
```json
{
  "id": "form-1",
  "name": "Chiller Stock Survey",
  "description": "Weekly stock and competitor tracking",
  "status": "active",
  "fields": [
    {
      "id": "field-1",
      "label": "Mobile Water bags in stock",
      "type": "number",
      "required": true,
      "order": 1
    },
    {
      "id": "field-2",
      "label": "Competitor brand stocked",
      "type": "select",
      "required": false,
      "options": ["Cool Pac", "Special Ice", "Everpure"],
      "allowCustomOption": true,
      "allowMultiSelect": true,
      "order": 2
    }
  ],
  "heatmapMetrics": [
    {
      "id": "metric-1",
      "name": "Stock Volume",
      "valueFieldId": "field-1",
      "aggregation": "latest",
      "groupByFieldId": null
    }
  ],
  "created_at": "2026-01-01T00:00:00Z",
  "updated_at": "2026-01-10T00:00:00Z",
  "team_id": 1,
  "team_name": "Magvlyn HQ"
}
```

Field types: `"text" | "number" | "select" | "checkbox" | "date" | "textarea"`
Form statuses: `"draft" | "active" | "archived"`
Heatmap aggregations: `"latest" | "sum" | "average" | "min" | "max" | "count" | "count_distinct"`

### FormSubmission (Market Data module)
```json
{
  "id": "sub-1",
  "form_id": "form-1",
  "partner_id": 5,
  "partner_name": "Ama's Chiller Spot",
  "submitted_at": "2026-02-10T10:00:00Z",
  "submitted_by": "Agent Kofi",
  "values": {
    "field-1": 48,
    "field-2": ["Cool Pac", "Everpure"]
  }
}
```

---

## 5. Complete API Endpoint Reference

All routes prefixed `/api/`. All protected routes require:
- `Authorization: Bearer {token}`
- `X-Team-ID: {team_id}`

### Scope Query Parameters (M-Promo)
| Param | Meaning |
|---|---|
| `scope=all` | HQ only: return data across all teams |
| `target_team_id=3` | HQ only: return data for a specific team |
| *(no param)* | Default: scope to current team from `X-Team-ID` |

Non-HQ users: scope params are **ignored** — always forced to their own team.

### Partners
```
GET    /mpromo/partners
       Query: type, status, geo_missing (bool), search, page, page_size, scope, target_team_id
       → { data: Partner[], total }

POST   /mpromo/partners
       Body: { name, phone, type, location, latitude?, longitude? }
       Query: scope, target_team_id
       → Partner

GET    /mpromo/partners/{id}              → Partner
PUT    /mpromo/partners/{id}              Body: partial partner fields → Partner
POST   /mpromo/partners/{id}/suspend      → 204
POST   /mpromo/partners/{id}/activate     → 204

PUT    /mpromo/partners/{id}/geolocation
       Body: { latitude: float, longitude: float } → 204

POST   /mpromo/partners/{id}/adjust-points
       Body: { type: "add"|"deduct", amount: int, reason: string }
       → { new_balance: int }

GET    /mpromo/partners/{id}/redemptions  → { data: Redemption[], total }
GET    /mpromo/partners/{id}/orders       → { data: MPromoOrder[], total }
GET    /mpromo/partners/{id}/points-history → PointsHistoryEntry[]
```

### Campaigns
```
GET    /mpromo/campaigns
       Query: status, search, page, page_size, scope, target_team_id
       → { data: Campaign[], total }

POST   /mpromo/campaigns
       Body: {
         name, type, start_date, end_date,
         tiers?: [{threshold, reward_amount, loyalty_points}],  // VOLUME_REBATE
         reward_amount?: float,   // MYSTERY_SHOPPER
         loyalty_points?: int     // MYSTERY_SHOPPER
       }
       Query: scope, target_team_id
       → Campaign

GET    /mpromo/campaigns/{id}           → Campaign
POST   /mpromo/campaigns/{id}/activate  → 204
POST   /mpromo/campaigns/{id}/pause     → 204
POST   /mpromo/campaigns/{id}/end       → 204

GET    /mpromo/campaigns/{id}/codes       → { data: PromoCode[], total }
GET    /mpromo/campaigns/{id}/redemptions → { data: Redemption[], total }
```

### Promo Codes
```
GET    /mpromo/codes
       Query: search, page, page_size, scope, target_team_id
       → { data: PromoCode[], total }

POST   /mpromo/codes/generate
       Body: { campaign_id, quantity, expires_at }
       Query: scope, target_team_id
       → { count: int }
```

### Redemptions
```
GET    /mpromo/redemptions
       Query: search, page, page_size, scope, target_team_id
       → { data: Redemption[], total }
```

### Payouts
```
GET    /mpromo/payouts
       Query: search, page, page_size, scope, target_team_id
       → { data: Payout[], total }

POST   /mpromo/payouts/{id}/pay
       Query: scope, target_team_id
       → 204  (triggers Paystack mobile money payout)
```

### Orders (Live in Sales module — tagged with source=MPROMO)
```
GET    /sales/orders?source=MPROMO
       Query: source (always "MPROMO"), search, page, page_size, scope, target_team_id
       → { data: MPromoOrder[], total }

POST   /sales/orders
       Body: { partner_id, items: [{product_name, quantity, unit_price}], source: "MPROMO", notes? }
       → MPromoOrder
```

### Map
```
GET    /mpromo/map/partners
       Query: type, status, search, scope, target_team_id
       → MapPartner[]   (no pagination — returns all geo-tagged partners)
```

### Market Data (Forms & Submissions) — NEW MODULE
```
GET    /mpromo/market-data/forms
       → FormDefinition[]

POST   /mpromo/market-data/forms
       Body: { name, description, status, fields[], heatmapMetrics? }
       → FormDefinition

GET    /mpromo/market-data/forms/{id}         → FormDefinition
PUT    /mpromo/market-data/forms/{id}
       Body: Partial<FormDefinition fields>   → FormDefinition
DELETE /mpromo/market-data/forms/{id}         → 204

GET    /mpromo/market-data/submissions
       Query: form_id?, partner_id?
       → FormSubmission[]

POST   /mpromo/market-data/submissions
       Body: { form_id, partner_id, values: Record<string, any>, submitted_by }
       → FormSubmission
```

---

## 6. Standard Response Envelope

**Paginated list:**
```json
{
  "data": [...],
  "total": 55,
  "current_page": 1,
  "last_page": 6,
  "per_page": 10
}
```
Default and frontend page size is **10**.

**Single resource:** return the object directly (no wrapper).

**Validation error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": { "field_name": ["Validation message"] }
}
```

**Other errors:** standard Laravel JSON error responses are fine.

---

## 7. Tenancy Enforcement Rules

Enforce in a middleware or base controller method — not per-controller:

```
1. Resolve current team from X-Team-ID header
2. Verify user is a member of that team (or return 403)
3. Check if user is a member of Team 1 (Magvlyn HQ) AND has mpromo.hq.global_view:
   - If BOTH true → honour scope params:
       scope=all          → no team filter on queries
       target_team_id=X   → filter queries to that team_id
       (no param)         → filter queries to X-Team-ID value
   - If EITHER condition is false → ignore all scope params,
     always filter to X-Team-ID value
```

---

## 8. Permissions Reference (M-Promo)

```
mpromo.view                       — access M-Promo module at all
mpromo.partners.manage            — create/edit/suspend partners + adjust points
mpromo.campaign.manage            — create/edit/activate/pause/end campaigns
mpromo.codes.manage               — generate codes
mpromo.redemptions.view           — view redemption records
mpromo.payouts.manage             — trigger payouts + view payout list
mpromo.orders.view                — view M-Promo sourced orders
mpromo.hq.global_view             — HQ only: see all teams' M-Promo data
mpromo.hq.run_campaigns_any_team  — HQ only: create campaigns for any team
```

**Seeder must create these 3 teams with these exact permissions** (matches frontend demo data):

| Team | ID | Permissions |
|---|---|---|
| Magvlyn HQ | 1 | All permissions above |
| Franchise – Accra Central | 2 | `mpromo.view`, `mpromo.redemptions.view`, `mpromo.orders.view` |
| Franchise – Kumasi | 3 | `mpromo.view`, `mpromo.partners.manage`, `mpromo.redemptions.view`, `mpromo.orders.view` |

---

## 9. Database Tables

| Table | Purpose |
|---|---|
| `mpromo_partners` | Chillers and ice water sellers |
| `mpromo_campaigns` | Loyalty/incentive campaigns |
| `mpromo_campaign_tiers` | Volume rebate tiers (FK → campaigns) |
| `mpromo_promo_codes` | Individual promo codes |
| `mpromo_redemptions` | Code redemption records |
| `mpromo_payouts` | Payout records (linked to redemptions) |
| `mpromo_partner_points_history` | Loyalty point change log |
| `mpromo_forms` | Market Data form definitions (JSON fields + heatmapMetrics) |
| `mpromo_form_submissions` | Field agent submissions per partner |
| `sales_orders` | Shared with Sales module — add `source` and `partner_id` columns |
| `sales_order_items` | Line items for sales orders |

---

## 10. Campaign Type Behaviour

### VOLUME_REBATE
- Tiers stored in `mpromo_campaign_tiers`
- Each tier: `threshold` (units), `reward_amount` (GHS), `loyalty_points`
- Redemption amount determined by which tier the partner qualifies for
- `reward_amount` and `loyalty_points` columns on the campaign itself are null

### MYSTERY_SHOPPER
- Flat `reward_amount` (GHS) and `loyalty_points` per code redemption on the campaign
- `tiers` relationship is empty / not used
- Agents issue codes in the field after verifying the partner is selling only Mobile Water
- Partner redeems via USSD → triggers Paystack mobile money payout automatically

---

## 11. File / Namespace Conventions

```
app/Http/Controllers/MPromo/     — Controllers (thin, delegate to Services)
app/Http/Requests/MPromo/        — Form Request validation classes
app/Http/Resources/MPromo/       — API Resource transformers (JSON shape)
app/Models/MPromo/               — Eloquent models (check if top-level Models/ is used first)
app/Services/MPromo/             — Business logic layer
database/factories/MPromo/       — Model factories (realistic Ghanaian dummy data)
database/seeders/MPromo/         — M-Promo specific seeders
routes/api/mpromo.php            — M-Promo routes (included from routes/api.php)
database/migrations/             — Standard location
```

Coding standards:
- All queries must be scoped to `team_id` (resolved from request context)
- Use `DB::transaction()` for any write touching multiple tables
- Use Form Requests for all input validation — never validate in controllers
- Paginate all list endpoints: `->paginate(10)`
- Keep controllers thin — business logic lives in Services
- Paystack secret: `config('services.paystack.secret')` from `.env` `PAYSTACK_SECRET_KEY`
- All amounts are **GHS (Ghanaian Cedi)**

---

## 12. What Is Already Built

- Laravel 12 scaffolded ✅
- Sanctum installed and configured ✅
- Laratrust with Teams support installed ✅
- `team_user` composite primary key pivot (no `id` column) ✅
- Auth endpoints (login, me, switch-team, logout) working ✅
- Tenant middleware (`X-Team-ID` enforcement) working ✅
- HQ superadmin seeder (`hq@clean.local`, team: `magvlyn_hq`) ✅
- Login response confirmed working in Postman ✅

---

## 13. Recommended Build Sequence for M-Promo

1. **Migrations** — all `mpromo_*` tables + `sales_orders` columns if not present
2. **Models** — with relationships, fillable, casts, scopes
3. **API Resources** — one per type, matching exact JSON shapes in Section 4
4. **Form Requests** — Partner create/update, Campaign create, Code generate,
   Form create/update, Submission create
5. **Services** — `PartnerService`, `CampaignService`, `PromoCodeService`,
   `RedemptionService`, `PayoutService` (Paystack here), `OverviewService`,
   `MarketDataService`
6. **Controllers** — thin wrappers calling services
7. **Routes** — `routes/api/mpromo.php` included from `routes/api.php`
8. **Factories & Seeders** — one factory per model using realistic Ghanaian names,
   phone numbers, and locations; seeders wire them together matching the 3-team
   structure in Section 8. Factories should be usable independently for future
   feature development and testing.

---

## 14. Start of Every Session Checklist

Before writing any code, run these to understand current state:

```bash
php artisan route:list --path=mpromo
php artisan route:list --path=sales
ls app/Models/
ls app/Models/MPromo/ 2>/dev/null
ls database/migrations/ | grep mpromo
```

Also check if a `BaseApiController` or response formatting helper already exists
before creating one. This prevents duplicating work from previous sessions.
