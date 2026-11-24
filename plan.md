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