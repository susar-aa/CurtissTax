# **CurtissTax – Development Plan**



New Curtiss Product

Sri Lanka



I recommend developing **CurtissTax** as a complete cloud-based tax invoicing and business management platform, inspired by TaxInvoice.lk, but with its own identity, interface and architecture.

The main purpose should be:

**Allow Sri Lankan businesses to register, manage their customers, create legally compliant tax invoices, manage VAT, track payments and download or share professional invoices.**

I would build it as a SaaS platform, meaning multiple businesses can register and use the same website while keeping their data completely separated.

# **CurtissTax**

Smart Tax Invoicing for Sri Lankan Businesses

[Invoice Dashboard - Subscription management by Nasir Uddin  on Dribbble](https://images.openai.com/static-rsc-4/5Sq1L88gZiZ13uTLsO-wFg2W1cKC4LIet9qwddR9p6lJYCanOKH_17LqwnCNaxjDLjet8BObB76xD3-y_Evtj7sDh9ORX8LBAvcBxJ3A7f76UPxa9xvTYU4mbFn6s_LmGLIH2_rXLLn8jMIjzJ7g0q_cIbW-vcZW7cDLC19U17Q?purpose=inline)

[dribbble.com](https://dribbble.com/shots/20606044-Invoice-Dashboard-Subscription-management?utm_source=chatgpt.com)

## **1. Overall system structure**

The platform should have three major sections.

**01. Public Website**

- Landing page
- Features and pricing
- About CurtissTax
- Contact page
- Login and signup
- Terms and privacy policy

  **02. Business Application**
- Business dashboard
- Tax invoices
- Customers
- Products and services
- VAT management
- Quotations
- Delivery notes
- Payments and receipts
- Expenses
- Reports
- Settings

  **03. CurtissTax Super Admin**
- Registered businesses
- Subscription management
- User management
- System-wide analytics
- Subscription plans
- Account activation and suspension
- Audit logs
- System settings

## **2. Complete application feature plan**

I recommend the following modules.

### **A. Business setup**

Every registered user should be able to create and manage a business profile.

- Business name and registered name
- Business registration number
- TIN
- VAT registration number
- Registered business address
- Telephone, email and website
- Business logo
- VAT registration certificate upload
- Financial year
- Default currency (LKR)
- Invoice numbering configuration
- Multiple branches
- Multiple business profiles under one account (future subscription feature)

### **B. Tax invoicing – most important module**

Core module – Priority 1

[Modern Invoice Template | Editable Canva Design, A4 (digital Download) - Etsy Israel](https://images.openai.com/static-rsc-4/YyTirxbLLoAe0sZ5mA8mthdEV7MDxfxEGm0v9CVZZh1ga1SCBP6Ds7jkQaaf8czLqxg06cpcOa_Arez_ZM6zXEWWg6782AmY7ToqKnuQ9DKujEMzgfLCa7pZrGXB8OJ2KbUSB-dTOKqV7bC-fFi1YyIIUEI13g4azIC1hwM10ik?purpose=inline)

[etsy.com](https://www.etsy.com/listing/1605305951/modern-invoice-template-design?utm_source=chatgpt.com)

Features:

1. Create new tax invoices.
2. Create normal/non-tax invoices.
3. Automatic sequential invoice numbers.
4. Customer selection and management.
5. Add products or services.
6. Quantity, unit price and discounts.
7. VAT calculations.
8. Multiple VAT treatment categories.
9. Invoice-level discounts.
10. Taxable and non-taxable items.
11. Invoice preview before saving.
12. A4 PDF generation.
13. Print invoices.
14. Download invoices.
15. Share invoices through WhatsApp and email.
16. Duplicate an existing invoice.
17. Convert quotations and delivery notes into invoices.
18. Cancel/void invoices with reasons and audit records.
19. Credit notes and debit notes.
20. Search, filter, pagination and export to Excel.

**Important:** Do not treat a normal invoice and a tax invoice as the same document. The application must enforce the applicable VAT requirements before issuing a tax invoice.

### **C. Customers**

- Customer registration
- Individual and business customers
- Customer TIN
- VAT registration number
- Customer address
- Contact number
- Email
- Credit limit
- Opening balance
- Customer outstanding balance
- Customer statements
- Transaction history

### **D. Products and services**

- Product/service registration
- Product code
- Description
- Unit of measurement
- Selling price
- Cost price (optional)
- VAT category
- Active/inactive status
- Product search
- Excel import/export

### **E. Quotations and delivery notes**

- Create quotations
- Tax and non-tax quotations
- Quotation approval
- Quotation expiry
- Convert quotation to invoice
- Create delivery notes
- Convert delivery notes into invoices
- Print and PDF downloads
- Track document status

### **F. Payments and receipts**

- Record customer payments
- Cash, bank transfer, cheque and card
- Partial payments
- Multiple payment allocations
- Unallocated customer payments
- Payment receipts
- Customer outstanding reports
- Refunds and adjustments

### **G. Expenses and supplier management**

- Supplier registration
- Supplier invoices
- Expense categories
- Record business expenses
- Supplier payments
- Payment vouchers
- Expense reports
- Attach supporting documents

### **H. VAT and financial reports**

This is an important selling point for CurtissTax.

- Sales summary
- Taxable sales
- Zero-rated sales
- Exempt sales
- VAT collected
- VAT by rate
- Customer-wise tax invoices
- VAT period summaries
- Credit note reports
- Invoice cancellation reports
- Customer outstanding reports
- Payment reports
- Expense reports
- Excel and PDF exports

Do not advertise automated VAT return filing or direct IRD submission unless an official integration is available and verified.

### **I. Users and permissions**

- Business owner
- Administrator
- Accountant
- Invoice operator
- Viewer
- Custom permissions
- User activity logs
- Login history
- Branch-specific permissions

### **J. Subscription management**

- Free trial
- Monthly subscriptions
- Annual subscriptions
- Subscription expiry
- Payment history
- Plan limits
- Upgrade/downgrade
- Automatic renewal (if supported)
- Subscription reminders

## **3. Sri Lankan VAT compliance – critical**

This is the part I would pay the most attention to before implementing the invoice generator.

Sri Lanka's VAT invoice format has undergone changes during 2026. The IRD published a revised format in Gazette 2481/22, followed by Circular SEC/2026/E/03. There is also a later Gazette 2500/106 dated 6 August 2026. Therefore, do not simply copy an older TaxInvoice.lk invoice template.&#x20;

[image](https://www.google.com/s2/favicons?domain=https://www.ird.gov.lk\&sz=32)

Inland Revenue Department+2



Official references:

- [IRD Gazette notifications](https://www.ird.gov.lk/en/publications/sitepages/Gazette.aspx?menuid=1602\&utm_source=chatgpt.com)
- [IRD Circular SEC/2026/E/03](https://www.ird.gov.lk/en/publications/Circulars_Circulars/SEC_2026_E_03_E.pdf?utm_source=chatgpt.com)
- [VAT Act – consolidated version](https://www.ird.gov.lk/ta/publications/Value%20Added%20Tax_Acts/VAT_Act_No_14%5BE%5D_2002_%28Consolidation_2025%29.pdf?utm_source=chatgpt.com)

The system should have a dedicated, version-controlled tax compliance engine.

**My recommendation:** Keep tax rules, invoice formats, serial-number rules and effective dates configurable, rather than hardcoding them into the invoice screen.

**Mandatory compliance rules to implement:**

| Requirement       | Implementation                            |
| ----------------- | ----------------------------------------- |
| Supplier TIN      | 9-digit TIN                               |
| Supplier details  | Registered name and address               |
| Purchaser details | TIN, name and address when VAT registered |
| Invoice number    | `YYMMM_QQQQ_XXXXX`                        |
| Invoice date      | MM/DD/YYYY                                |
| Date of supply    | MM/DD/YYYY                                |
| Description       | Specific goods or services                |
| Quantity          | Measurable quantity                       |
| Value             | Amount excluding VAT                      |
| VAT               | Separately displayed                      |
| Total             | Amount including VAT                      |
| Currency          | LKR, two decimal places                   |

The revised format became effective on **1 October 2026**, following Gazette 2500/106. The original July date in the May circular was subsequently postponed.&#x20;

[image](https://www.google.com/s2/favicons?domain=https://kpmg.com\&sz=32)

KPMG+2



For example, an invoice could have the number:

`26NOV_MAIN_00001`

The invoice generator must also:

- Maintain sequential numbering without duplicate numbers.
- Prevent users from editing issued invoice numbers.
- Keep cancelled invoice numbers in the audit trail.
- Generate the correct invoice layout.
- Allow the QQQQ classification to be configured for each business/branch.
- Keep tax rules effective-dated and updateable.

**Important design decision:** A tax invoice should contain VAT-taxable supplies. Exempt and out-of-scope supplies should normally be handled separately, subject to the applicable exception for supplies integral to taxable supplies.&#x20;

[image](https://www.google.com/s2/favicons?domain=https://www.ird.gov.lk\&sz=32)

Inland Revenue Department



## **4. Application dashboard design**

I recommend a clean, modern black-and-white interface, similar to a professional accounting SaaS application.

[Invoice Dashboard designs, themes, templates and downloadable graphic elements on Dribbble](https://images.openai.com/static-rsc-4/-R9D15DtfvVvDBxmI6He0T0aRkix6xGRJ-Vj_qfOrPiVvemvvuJV5kpfurgYxAK2FUETNrUS2FiwR5nsQsNFvCX8xAXJMKRBjCuxUnEl275_E-Us66WDOAh0q9d0k3BGKIEe483piGy4QpFRbNJ0blmPYi8LHCnn1YqUSebyXa0?purpose=inline)

[Create Invoice Experience — Minimal Finance SaaS by Miawmiaw on Dribbble](https://images.openai.com/static-rsc-4/RVlKQ_AS0oBbqiThYnAhtnqgFSFahIJDJA8s_TW8BqIduuGIwW-RKchE-H-Wzxluz7ttoNTebvKqm4bA4gt1oZ_Jzx0uC4d0hhdzcDlghnDGU0om3YeeaVwHP_U2rvA8BXjr3KWkSUCybb0ERcEEGDPVpAp5Qeyc6Jf7kM5RJgc?purpose=inline)

[Create Invoice UI | SaaS, CRM by Muhammad Salim on Dribbble](https://images.openai.com/static-rsc-4/m2iTDCMTjDjdsLBLs-1g7BoybWIR6vS9n4dh9ShKnerL0hV0Zmo7nE7iM7ZQA8r8PdcjG6Jdt5NfiIs1kwuAhVaI68it_USTYNOtKhPhiK1j4_wdpq0SN6v6ZeFCQsjNmkhP02wETjwZI6md9mZdWqnnW9jR5NPKmJ7rhRDfSSk?purpose=inline)

15

### **Sidebar structure**

| Menu           | Submenus                                                     |
| -------------- | ------------------------------------------------------------ |
| Dashboard      | Overview                                                     |
| Invoicing      | Tax Invoices, Commercial Invoices, Credit Notes, Debit Notes |
| Quotations     | All Quotations, New Quotation                                |
| Delivery Notes | All Delivery Notes, New Delivery Note                        |
| Customers      | Customer List, Customer Statements                           |
| Products       | Products, Services, Categories                               |
| Payments       | Customer Payments, Receipts                                  |
| Suppliers      | Supplier List, Supplier Invoices                             |
| Expenses       | Expense Records, Categories                                  |
| Reports        | Sales, VAT, Payments, Outstanding, Expenses                  |
| Users          | User Management, Roles                                       |
| Settings       | Business, Branches, Tax, Invoice Templates, Subscription     |

### **Dashboard widgets**

- Total sales this month
- Total VAT collected
- Number of tax invoices
- Outstanding customer balances
- Payments received
- Recent invoices
- Monthly sales chart
- Sales by customer
- Invoice payment status
- VAT period summary

### **Invoice creation screen**

This should be one of the best-designed parts of the application.

[Create Invoice UI | SaaS, CRM by Muhammad Salim on Dribbble](https://images.openai.com/static-rsc-4/m2iTDCMTjDjdsLBLs-1g7BoybWIR6vS9n4dh9ShKnerL0hV0Zmo7nE7iM7ZQA8r8PdcjG6Jdt5NfiIs1kwuAhVaI68it_USTYNOtKhPhiK1j4_wdpq0SN6v6ZeFCQsjNmkhP02wETjwZI6md9mZdWqnnW9jR5NPKmJ7rhRDfSSk?purpose=inline)

[dribbble.com](https://dribbble.com/shots/20506005-Create-Invoice-UI-SaaS-CRM?utm_source=chatgpt.com)

Suggested workflow:

1. Select document type.
2. Select customer.
3. Automatically load customer information.
4. Enter invoice date and date of supply.
5. Add products or services.
6. Automatically calculate amounts.
7. Apply relevant VAT treatment.
8. Display totals and VAT breakdown.
9. Preview the official tax invoice layout.
10. Save and issue.
11. Print, download PDF or share.

## **5. Technology stack**

Since you already work with PHP and MySQL, I recommend keeping CurtissTax within that ecosystem.

| Component      | Technology                                |
| -------------- | ----------------------------------------- |
| Backend        | PHP 8.3+ / Laravel                        |
| Database       | MySQL 8                                   |
| Frontend       | Blade + Livewire                          |
| UI             | Tailwind CSS                              |
| Interactions   | Alpine.js                                 |
| PDF            | Dompdf or a suitable HTML-to-PDF renderer |
| Authentication | Laravel authentication                    |
| Charts         | Chart.js                                  |
| Excel          | Laravel Excel                             |
| Hosting        | Linux VPS / Plesk                         |
| Source control | GitHub                                    |

I recommend a modular Laravel application rather than building a large collection of disconnected PHP pages.

### **Database architecture**

The application should have separate modules for:

- Users and authentication
- Businesses and branches
- Customers
- Products and services
- Tax configurations
- Invoices and invoice items
- Quotations
- Delivery notes
- Payments and allocations
- Suppliers
- Expenses
- Subscriptions
- Audit logs
- Notifications

**Critical:** This is a multi-tenant SaaS application. Every business transaction must belong to the correct business, and every query must enforce tenant isolation. One business must never be able to access another business's information.

## **6. Development stages**

I recommend building this in stages rather than asking Antigravity to develop the entire system in one attempt.

## **CurtissTax development roadmap**

1. **Stage 1 – Project foundation**

   Architecture, Laravel setup, database, authentication, multi-tenancy and basic application structure.
2. **Stage 2 – Public website**

   Landing page, pricing, features, contact, login, registration and responsive design.
3. **Stage 3 – Business onboarding**

   Business registration, profile, TIN, VAT details, branches and settings.
4. **Stage 4 – Customers and products**

   Customer management, supplier management, product/service management and imports.
5. **Stage 5 – Tax compliance engine**

   VAT rules, effective dates, serial numbering, tax validation and IRD-compliant invoice template.
6. **Stage 6 – Invoice management**

   Tax invoices, commercial invoices, invoice listing, PDF, printing and sharing.
7. **Stage 7 – Quotations and delivery notes**

   Document management and conversion workflows.
8. **Stage 8 – Payments and receipts**

   Collections, allocations, partial payments and outstanding balances.
9. **Stage 9 – Expenses and suppliers**

   Supplier invoices, expenses and payment vouchers.
10. **Stage 10 – Reports**

    VAT reports, sales reports, customer statements and financial summaries.
11. **Stage 11 – Subscription system**

    Plans, trials, renewals, billing and restrictions.
12. **Stage 12 – Super Admin**

    Platform administration, business accounts, subscription control and analytics.
13. **Stage 13 – Security and testing**

    Tenant isolation, authorization, financial calculations, performance, pagination, audit and regression testing.
14. **Stage 14 – Production deployment**

    Server configuration, domain, SSL, backups, monitoring and launch.

## **7. Antigravity master development prompt**

First, give Antigravity this project-level instruction. This establishes the overall product requirements and prevents it from trying to build everything at once.

# PROJECT: CURTISSTAX

Develop a professional, cloud-based SaaS tax invoicing and business management platform for Sri Lankan businesses under the brand name **CurtissTax**.

## Product Objective

Build a platform inspired by TaxInvoice.lk, providing Sri Lankan businesses with tax-compliant invoicing, customer management, quotations, delivery notes, payments, VAT reporting and business administration.

## Technology

- PHP 8.3+ with Laravel
- MySQL 8
- Blade + Livewire
- Tailwind CSS
- Alpine.js
- Responsive desktop, tablet and mobile interfaces

## Product Structure

1. Public marketing website
2. Business application
3. CurtissTax Super Admin application

## Core Requirements

- Multi-tenant SaaS architecture.
- Strict business data isolation.
- Multiple users and role permissions.
- Multiple branches.
- Multiple businesses where subscription plans permit.
- Sri Lankan VAT and tax invoice compliance.
- Configurable, effective-dated tax rules.
- Unique sequential invoice numbering.
- PDF generation and professional printing.
- Customer and supplier management.
- Products and services.
- Quotations and delivery notes.
- Payments, receipts and allocations.
- Expenses and supplier payments.
- VAT and business reports.
- Subscription and billing management.
- Complete audit trails.

## Design Requirements

Create a premium, modern accounting SaaS interface.

- Black and white visual identity.
- Minimalist professional design.
- Clean sidebar navigation.
- Compact data tables.
- Consistent spacing.
- Professional typography.
- Responsive layouts.
- Real Lucide icons, no emoji icons.
- Clear forms and dialogs.
- Fast navigation.
- Avoid unnecessary animations and excessive whitespace.

## Development Rules

1. Work stage by stage.
2. Never attempt to implement the entire application in one stage.
3. Inspect existing code before making changes.
4. Use clean, modular and maintainable architecture.
5. Create database migrations and appropriate indexes.
6. Validate all financial calculations on the server.
7. Use database transactions for financial operations.
8. Enforce tenant isolation at database/query and authorization levels.
9. Never allow users to modify issued invoice numbers.
10. Maintain immutable issued-document records and audit trails.
11. Never hardcode VAT rules or assume tax rates will remain unchanged.
12. Follow the applicable Sri Lankan IRD Gazette and circular requirements, including Gazette 2481/22 as amended by Gazette 2500/106.
13. Do not claim IRD integration or official approval without verified authorization.
14. Implement proper pagination, search, filtering and export functionality.
15. Test every implemented module before declaring it complete.

## Important

Preserve existing working functionality. Never remove or modify unrelated modules.

For every development stage:

- Analyze requirements.
- Inspect relevant files.
- Prepare an implementation plan.
- Implement only the requested stage.
- Run migrations.
- Execute relevant tests.
- Fix discovered issues.
- Provide a detailed walkthrough.
- Report modified files and test results.

Do not proceed to the next stage until the current stage has been reviewed and approved.

## **8. First Antigravity implementation prompt – Stage 1**

Once the master instructions are established, use this prompt.

Start here

# CURTISSTAX – STAGE 1: PROJECT FOUNDATION

Analyze the current workspace and establish the technical foundation for CurtissTax.

### 1. Project Setup

- Initialize the Laravel application.
- Configure MySQL database connectivity.
- Configure environment variables.
- Establish the project directory structure.
- Configure Git and development environment.

### 2. Database Architecture

Design migrations for:

- Users
- Businesses
- Business memberships
- Branches
- Roles and permissions
- Business settings
- Audit logs
- Subscription foundation

Every business-related record must support strict multi-tenant isolation.

### 3. Authentication Foundation

Prepare:

- User registration foundation
- Login
- Logout
- Password hashing
- Password reset foundation
- Session security
- User account status

### 4. Multi-Tenant Architecture

Implement the foundation to ensure:

- Each business has isolated data.
- Users can access only their authorized businesses.
- Business switching is supported where applicable.
- Branch permissions can be enforced.
- Super Admin access is separated from business accounts.

### 5. Application Structure

Establish separate layouts and route groups for:

- Public website
- Business application
- Super Admin application

Create reusable components for navigation, forms, tables, modals and notifications.

### 6. Security

Implement authentication middleware, authorization policies, CSRF protection, input validation and secure database access.

### 7. Testing

Test:

- Database migrations
- Authentication
- Business creation
- Tenant isolation
- Unauthorized access attempts
- User permissions

### Restrictions

Do not implement invoicing, VAT calculations, payments or other business modules in this stage.

Do not create unnecessary placeholder functionality.

### Deliverables

Provide:

1. Architecture overview.
2. Database relationship overview.
3. Directory structure.
4. Implemented features.
5. Migration and test results.
6. Issues requiring attention.
7. Walkthrough of the completed stage.

Complete Stage 1 only and wait for approval.

## **9. Important decisions before development**

There are a few decisions that will affect the entire architecture.

**1. Who can use CurtissTax?**

Only VAT-registered businesses

VAT-registered and non-VAT businesses

**2. Business accounts**

One business per account

Multiple businesses per account

**3. Free trial**

14 days

30 days

No free trial

**4. Application language**

English initially

English, Sinhala and Tamil

**5. Hosting**

Linux VPS / Plesk

Shared hosting

Local development first, hosting later

Submit decisions

**My biggest recommendation:** Make the Sri Lankan IRD-compliant tax invoice generator the strongest part of CurtissTax. Build the tax engine independently from the invoice UI, so future IRD changes can be implemented without rebuilding the entire application.

Also, don't copy TaxInvoice.lk's source code or branding. Use it as a functional reference and build CurtissTax as an independent product.

Let's build it one stage at a time, test each stage, and make it production-ready.